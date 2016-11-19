<?php

class ImportShell extends AppShell {

    public $uses = array('License');
    public $dataPath = '/home/kiang/github/data.fda.gov.tw-list';
    public $tfdaPath = '/home/kiang/github/tfda_license';
    public $mysqli = false;
    public $key2id = array();
    public $key2code = array();
    public $prefixCodes = array(
        '01' => '衛署藥製',
        '02' => '衛署藥輸',
        '03' => '衛署成製',
        '04' => '衛署中藥輸',
        '05' => '衛署醫器製',
        '06' => '衛署醫器輸',
        '07' => '衛署粧製',
        '08' => '衛署粧輸',
        '09' => '衛署菌疫製',
        '10' => '衛署菌疫輸',
        '11' => '衛署色輸',
        '12' => '內衛藥製',
        '13' => '內衛藥輸',
        '14' => '內衛成製',
        '15' => '內衛菌疫製',
        '16' => '內衛菌疫輸',
        '17' => '內藥登',
        '18' => '署藥兼食製',
        '19' => '衛署成輸',
        '20' => '衛署罕藥輸',
        '21' => '衛署罕藥製',
        '22' => '罕菌疫輸',
        '23' => '罕菌疫製',
        '24' => '罕醫器輸',
        '25' => '罕醫器製',
        '31' => '衛署色製',
        '40' => '衛署粧陸輸',
        '41' => '衛署藥陸輸',
        '42' => '衛署醫器陸輸',
        '43' => '衛署醫器製壹',
        '44' => '衛署醫器輸壹',
        '45' => '衛署醫器外製',
        '46' => '衛署醫器陸輸壹',
        '47' => '衛署醫器外製壹',
        '51' => '衛部藥製',
        '52' => '衛部藥輸',
        '53' => '衛部成製',
        '55' => '衛部醫器製',
        '56' => '衛部醫器輸',
        '57' => '衛部粧製',
        '58' => '衛部粧輸',
        '59' => '衛部菌疫製',
        '60' => '衛部菌疫輸',
        '61' => '衛部色輸',
        '68' => '部藥兼食製',
        '69' => '衛部成輸',
        '70' => '衛部罕藥輸',
        '71' => '衛部罕藥製',
        '72' => '衛部罕菌疫輸',
        '73' => '衛部罕菌疫製',
        '74' => '衛部罕醫器輸',
        '81' => '衛部色製',
        '90' => '衛部粧陸輸',
        '91' => '衛部藥陸輸',
        '92' => '衛部醫器陸輸',
        '93' => '衛部醫器製壹',
        '94' => '衛部醫器輸壹',
        '95' => '衛部醫器外製',
        '96' => '衛部醫器陸輸壹',
        '97' => '衛部醫器外製壹',
        '99' => '衛署菌製',
    );

    public function main() {
//        $this->importNhiPrice();
//        exit();
        if (isset($this->args[0])) {
            switch ($this->args[0]) {
                case 'dump':
                    //$this->updateCode();
                    $this->dumpDbKeys();
                    break;
                default:
                    /*
                     * Execute before importing:
                     * TRUNCATE `drugs`;
                      TRUNCATE `ingredients`;
                      TRUNCATE `ingredients_licenses`;
                      TRUNCATE `licenses`;
                      TRUNCATE `links`;
                      TRUNCATE `prices`;
                      TRUNCATE `vendors`;
                      TRUNCATE `categories_licenses`;
                     *
                     * and remember to execute mohw to import another part of drugs
                     *
                     * and dump generated data using another one:
                     *
                     * mysqldump -uroot -p kiang_drug drugs ingredients ingredients_licenses licenses prices categories_licenses vendors links > db.sql
                     */
                    $this->emptyDrugs();
                    $this->importDrug();
                    $this->importNhiPrice();
                    $this->importImage();
                    $this->importTfdaBox();
                    $this->importIngredients();
                    $this->importATC();
                //$this->importPoints();
            }
        }
    }

    public function updateCode() {
        $licenses = $this->License->find('list', array(
            'fields' => array('id', 'license_id'),
        ));
        $i = 1;
        $c = count($licenses);
        foreach ($licenses AS $id => $str) {
            $code = $this->getLicenseCode($str);
            if (false !== $code) {
                $code = substr($code, 3);
                $this->License->id = $id;
                $this->License->saveField('code', $code);
            }
            if ($i++ % 300 === 0) {
                echo "processing {$i} / {$c}\n";
            }
        }
    }

    public function getLicenseCode($str) {
        $prefixCode = false;
        foreach ($this->prefixCodes AS $code => $prefix) {
            if (false === $prefixCode && false !== strpos($str, $prefix)) {
                $prefixCode = $code;
            }
        }
        if (false !== $prefixCode) {
            preg_match('/[0-9]+/', $str, $match);
            return "fda{$prefixCode}{$match[0]}";
        } else {
            return false;
        }
    }

    public function emptyDrugs() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('TRUNCATE `drugs`;');
        $this->dbQuery('TRUNCATE `ingredients`;');
        $this->dbQuery('TRUNCATE `ingredients_licenses`;');
        $this->dbQuery('TRUNCATE `licenses`;');
        $this->dbQuery('TRUNCATE `links`;');
        $this->dbQuery('TRUNCATE `prices`;');
        $this->dbQuery('TRUNCATE `vendors`;');
        $this->dbQuery('TRUNCATE `categories_licenses`;');
    }

    public function importPoints() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('機構狀態', '機構名稱', '地址縣市別', '地址鄉鎮市區', '地址街道巷弄號', '負責人姓名', '負責人性別', '電話', '是否為健保特約藥局', '');

        $fh = fopen(__DIR__ . '/data/hospitals/clinic.csv', 'r');
        $sn = 1;
        $valueStack = array();
        fgets($fh, 512);
        while ($line = fgetcsv($fh, 2048)) {
            foreach ($line AS $k => $v) {
                $line[$k] = trim(mb_convert_encoding($v, 'utf-8', 'big5'));
                $line[$k] = $this->mysqli->real_escape_string($line[$k]);
            }
            preg_match('(縣|市)', $line[2], $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0][1])) {
                $city = substr($line[2], 0, $matches[0][1] + 3);
                $line[2] = substr($line[2], $matches[0][1] + 3);
            } else {
                print_r($line);
                exit();
            }
            preg_match('(鄉|鎮|區|市)', $line[2], $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0][1])) {
                $town = substr($line[2], 0, $matches[0][1] + 3);
                switch ($town) {
                    case '前鎮':
                        $town = substr($line[2], 0, $matches[0][1] + 6);
                        $line[2] = substr($line[2], $matches[0][1] + 6);
                        break;
                    case '平鎮':
                        $town = substr($line[2], 0, $matches[0][1] + 6);
                        $line[2] = substr($line[2], $matches[0][1] + 6);
                        break;
                    default:
                        $line[2] = substr($line[2], $matches[0][1] + 3);
                }
            } else {
                if (substr($line[2], 0, 9) === '太麻里') {
                    $town = '太麻里鄉';
                    $line[2] = substr($line[2], 9);
                } else {
                    print_r($line);
                    exit();
                }
            }

            $currentId = String::uuid();
            $valueStack[] = implode(',', array(
                "('{$currentId}'", //id
                "'clinic'", //type
                "'開業'", //status
                "'{$line[0]}'", //name
                "'{$city}'", //city
                "'{$town}'", //town
                "'{$line[2]}'", //address
                "NULL", //longitude
                "NULL", //latitude
                "''", //owner
                "''", //owner_gender
                "'{$line[1]}'", //phone
                "1)", //is_nhc
            ));
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
        }
        fclose($fh);

        $fh = fopen(__DIR__ . '/data/hospitals/hospital.csv', 'r');
        $sn = 1;
        $valueStack = array();
        fgets($fh, 512);
        while ($line = fgetcsv($fh, 2048)) {
            foreach ($line AS $k => $v) {
                $line[$k] = trim(mb_convert_encoding($v, 'utf-8', 'big5'));
                $line[$k] = $this->mysqli->real_escape_string($line[$k]);
            }
            preg_match('(縣|市)', $line[2], $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0][1])) {
                $city = substr($line[2], 0, $matches[0][1] + 3);
                $line[2] = substr($line[2], $matches[0][1] + 3);
            } else {
                print_r($line);
                exit();
            }
            preg_match('(鄉|鎮|區|市)', $line[2], $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0][1])) {
                $town = substr($line[2], 0, $matches[0][1] + 3);
                switch ($town) {
                    case '前鎮':
                        $town = substr($line[2], 0, $matches[0][1] + 6);
                        $line[2] = substr($line[2], $matches[0][1] + 6);
                        break;
                    case '平鎮':
                        $town = substr($line[2], 0, $matches[0][1] + 6);
                        $line[2] = substr($line[2], $matches[0][1] + 6);
                        break;
                    default:
                        $line[2] = substr($line[2], $matches[0][1] + 3);
                }
            } else {
                print_r($line);
                exit();
            }
            $currentId = String::uuid();
            $valueStack[] = implode(',', array(
                "('{$currentId}'", //id
                "'hospital'", //type
                "'開業'", //status
                "'{$line[0]}'", //name
                "'{$city}'", //city
                "'{$town}'", //town
                "'{$line[2]}'", //address
                "NULL", //longitude
                "NULL", //latitude
                "''", //owner
                "''", //owner_gender
                "'{$line[1]}'", //phone
                "'1')", //is_nhc
            ));
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
        }
        fclose($fh);

        $fh = fopen($this->dataPath . '/dataset/35.csv', 'r');
        $sn = 1;
        $valueStack = array();
        while ($line = fgetcsv($fh, 2048, "\t")) {
            foreach ($line AS $k => $v) {
                $line[$k] = trim($v);
            }
            $currentId = String::uuid();
            if ($line[6] === '男') {
                $line[6] = 'm';
            } else {
                $line[6] = 'f';
            }
            if ($line[8] === '是') {
                $line[8] = '1';
            } else {
                $line[8] = '0';
            }
            $valueStack[] = implode(',', array(
                "('{$currentId}'", //id
                "'drug'", //type
                "'{$line[0]}'", //status
                "'{$line[1]}'", //name
                "'{$line[2]}'", //city
                "'{$line[3]}'", //town
                "'{$line[4]}'", //address
                "NULL", //longitude
                "NULL", //latitude
                "'{$line[5]}'", //owner
                "'{$line[6]}'", //owner_gender
                "'{$line[7]}'", //phone
                "'{$line[8]}')", //is_nhc
            ));
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
        }
        fclose($fh);
    }

    public function rKeys($arr = array(), $prefix = '') {
        foreach ($arr AS $category) {
            $newPrefix = $prefix . $category['Category']['name'];
            $this->key2id[$newPrefix] = $category['Category']['id'];
            $this->key2code[$newPrefix] = $category['Category']['code'];
            if (!empty($category['children'])) {
                $this->rKeys($category['children'], $newPrefix);
            }
        }
    }

    public function importATC() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $this->rKeys($this->License->Category->find('threaded', array(
                    'fields' => array('id', 'parent_id', 'name', 'code'),
        )));
        $dbKeys = $valueStack = array();
        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        $fields = array('許可證字號', '主或次項', '代碼', '英文分類名稱', '中文分類名稱', '-');
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 主或次項
          [2] => 代碼
          [3] => 英文分類名稱
          [4] => 中文分類名稱
          [5] => -
          )
         */
        $fh = fopen($this->dataPath . '/dataset/41.csv', 'r');
        $sn = 1;
        echo "categories importing\n";
        while ($line = fgetcsv($fh, 2048, "\t")) {
            foreach ($line AS $k => $v) {
                $line[$k] = trim($v);
            }
            $licenseCode = $this->getLicenseCode($line[0]);
            if (false === $licenseCode) {
                continue;
            }
            $tree = explode(' / ', $line[3]);
            $treeCount = count($tree);
            $currentCount = 0;
            $currentKey = '';
            foreach ($tree AS $item) {
                ++$currentCount;
                $parentKey = $currentKey;
                if (empty($parentKey)) {
                    $parentId = '0';
                } else {
                    $parentId = $this->key2id[$parentKey];
                }
                $currentKey .= $item;
                if (!isset($this->key2id[$currentKey])) {
                    $this->License->Category->create();
                    $code = '';
                    $nameChinese = '';
                    if ($currentCount === $treeCount) {
                        $code = strtoupper($line[2]);
                        $nameChinese = $line[4];
                    }
                    $this->License->Category->save(array('Category' => array(
                            'parent_id' => $parentId,
                            'code' => $code,
                            'name' => $item,
                            'name_chinese' => $nameChinese,
                    )));
                    $this->key2id[$currentKey] = $this->License->Category->getInsertID();
                } elseif ($currentCount === $treeCount && empty($this->key2code[$currentKey])) {
                    $code = strtoupper($line[2]);
                    $this->dbQuery('UPDATE `categories` SET code = \'' . $code . '\' WHERE id = \'' . $this->key2id[$currentKey] . '\';');
                }
            }
            if (isset($dbKeys[$licenseCode])) {
                $currentId = String::uuid();
                $valueStack[] = implode(',', array(
                    "('{$currentId}'", //id
                    $this->key2id[implode('', $tree)], //category_id
                    "'{$dbKeys[$licenseCode]}'", //license_id
                    "'{$line[1]}')", //type
                ));
                ++$sn;
                if ($sn > 50) {
                    $sn = 1;
                    $this->dbQuery('INSERT INTO `categories_licenses` VALUES ' . implode(',', $valueStack) . ';');
                    $valueStack = array();
                }
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `categories_licenses` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function importIngredients() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('許可證字號', '處方標示', '成分名稱', '含量描述', '含量', '含量單位', '-');
        $dbKeys = $valueStack = $ingredientKeys = array();

        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/keys/ingredients.csv')) {
            $ingredientKeysFh = fopen(__DIR__ . '/data/keys/ingredients.csv', 'r');
            while ($line = fgetcsv($ingredientKeysFh, 1024)) {
                $ingredientKeys[$line[0]] = array(
                    'id' => $line[1],
                    'count_licenses' => 0,
                );
            }
            fclose($ingredientKeysFh);
        }
        $fh = fopen($this->dataPath . '/dataset/43.csv', 'r');
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 處方標示
          [2] => 成分名稱
          [3] => 含量描述
          [4] => 含量
          [5] => 含量單位
          )
         */
        $sn = 1;
        echo "ingredients importing\n";
        while ($line = fgetcsv($fh, 2048, "\t")) {
            if (substr($line[4], 0, 1) === '-') {
                $line[4] = substr($line[4], 1);
            }
            $licenseCode = $this->getLicenseCode($line[0]);
            if (false === $licenseCode || !isset($dbKeys[$licenseCode])) {
                continue;
            }
            $ingredientKey = trim($line[2]);
            if (!isset($ingredientKeys[$ingredientKey])) {
                $ingredientKeys[$ingredientKey] = array(
                    'id' => String::uuid(),
                    'count_licenses' => 0,
                );
            }
            $ingredientKeys[$ingredientKey]['count_licenses'] += 1;

            for ($i = 1; $i <= 5; $i++) {
                $line[$i] = $this->mysqli->real_escape_string(trim($line[$i]));
            }
            $currentId = String::uuid();
            $valueStack[] = implode(',', array(
                "('{$currentId}'", //id
                "'{$dbKeys[$licenseCode]}'", //license_id
                "'{$ingredientKeys[$ingredientKey]['id']}'", //ingredient_id
                "'{$line[1]}'", //remark
                "'{$line[2]}'", //name
                "'{$line[3]}'", //dosage_text
                "'{$line[4]}'", //dosage
                "'{$line[5]}')", //unit
            ));
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `ingredients_licenses` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `ingredients_licenses` VALUES ' . implode(',', $valueStack) . ';');
        }
        $valueStack = array();
        $sn = 1;
        foreach ($ingredientKeys AS $name => $ingredient) {
            $name = $this->mysqli->real_escape_string($name);
            $valueStack[] = implode(',', array(
                "('{$ingredient['id']}'", //ingredient_id
                "'{$name}'", //name
                "'{$ingredient['count_licenses']}'", //count_licenses
                "0", //count_daily
                "0)", //count_all
            ));
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `ingredients` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `ingredients` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function importBox() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('許可證字號', '中文品名', '英文品名', '仿單圖檔連結', '外盒圖檔連結', '-');

        $imagePath = __DIR__ . '/data/box';
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }
        $fh = fopen($this->dataPath . '/dataset/39.csv', 'r');

        $dbKeys = $valueStack = array();

        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 中文品名
          [2] => 英文品名
          [3] => 仿單圖檔連結
          [4] => 外盒圖檔連結
          [5] => -
          )
         */
        $wLength = strlen(WWW_ROOT);
        $sn = 0;
        echo "links importing\n";
        /*
         * get longest line lenth using command `wc -L filename`
         */
        while ($line = fgetcsv($fh, 10770, "\t")) {
            $licenseCode = $this->getLicenseCode($line[0]);
            if (false === $licenseCode || !isset($dbKeys[$licenseCode])) {
                continue;
            }
            if (!empty($line[3])) {
                $files = explode(';;', $line[3]);
                foreach ($files AS $k => $v) {
                    $files[$k] = trim($v);
                    if (empty($files[$k])) {
                        unset($files[$k]);
                    }
                }
                $count = 0;
                foreach ($files AS $url) {
                    ++$count;
                    $currentId = String::uuid();
                    $url = $this->mysqli->real_escape_string($url);
                    $valueStack[] = implode(',', array(
                        "('{$currentId}'", //id
                        "'{$dbKeys[$licenseCode]}'", //license_id
                        "'{$url}'", //url
                        "'仿單 - {$count}'", //title
                        "1", //type
                        "{$count})", //sort
                    ));
                    ++$sn;
                    if ($sn > 50) {
                        $sn = 1;
                        $this->dbQuery('INSERT INTO `links` VALUES ' . implode(',', $valueStack) . ';');
                        $valueStack = array();
                    }
                }
            }
            if (!empty($line[4])) {
                $files = explode(';;', $line[4]);
                foreach ($files AS $k => $v) {
                    $files[$k] = trim($v);
                    if (empty($files[$k])) {
                        unset($files[$k]);
                    }
                }
                $count = 0;
                foreach ($files AS $url) {
                    ++$count;
                    $currentId = String::uuid();
                    $url = $this->mysqli->real_escape_string($url);
                    $valueStack[] = implode(',', array(
                        "('{$currentId}'", //id
                        "'{$dbKeys[$licenseCode]}'", //license_id
                        "'{$url}'", //url
                        "'外盒 - {$count}'", //title
                        "2", //type
                        "{$count})", //sort
                    ));
                    ++$sn;
                    if ($sn > 50) {
                        $sn = 1;
                        $this->dbQuery('INSERT INTO `links` VALUES ' . implode(',', $valueStack) . ';');
                        $valueStack = array();
                    }
                }
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `links` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function importTfdaBox() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');

        $dbKeys = $valueStack = array();

        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }

        $sn = 0;
        echo "links importing\n";
        foreach (glob($this->tfdaPath . '/licenses/*/*.json') AS $jsonFile) {
            $json = json_decode(file_get_contents($jsonFile), true);
            $dbKey = 'fda' . $json['code'];
            if (isset($dbKeys[$dbKey]) && !empty($json['仿單外盒'])) {
                $count = 0;
                foreach ($json['仿單外盒'] AS $link) {
                    ++$count;
                    $currentId = String::uuid();
                    $url = $this->mysqli->real_escape_string($link['url']);
                    if (false !== strpos($link['title'], '仿單') || false !== strpos($link['title'], '手冊')) {
                        $currentType = 1;
                    } else {
                        $currentType = 2;
                    }
                    $link['title'] = $this->mysqli->real_escape_string($link['title']);
                    $valueStack[] = implode(',', array(
                        "('{$currentId}'", //id
                        "'{$dbKeys[$dbKey]}'", //license_id
                        "'{$url}'", //url
                        "'{$link['title']}'", //title
                        "{$currentType}", //type
                        "{$count})", //sort
                    ));
                    if (++$sn > 50) {
                        $sn = 0;
                        $this->dbQuery('INSERT INTO `links` VALUES ' . implode(',', $valueStack) . ';');
                        $valueStack = array();
                    }
                }
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `links` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function importImage() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('許可證字號', '中文品名', '英文品名', '形狀', '特殊劑型', '顏色', '特殊氣味', '刻痕', '外觀尺寸', '標註一', '標註二', '外觀圖檔連結', '-');

        $imagePath = TMP . '/drugs/images';
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }
        $fh = fopen($this->dataPath . '/dataset/42.csv', 'r');

        $dbKeys = array();
        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 中文品名
          [2] => 英文品名
          [3] => 形狀 shape
          [4] => 特殊劑型 s_type
          [5] => 顏色 color
          [6] => 特殊氣味 odor
          [7] => 刻痕 abrasion
          [8] => 外觀尺寸 size
          [9] => 標註一 note_1
          [10] => 標註二 note_2
          [11] => 外觀圖檔連結 image
          [12] => -
          )
         */
        $wLength = strlen(WWW_ROOT);
        $imagick = new Imagick();
        while ($line = fgetcsv($fh, 2048, "\t")) {
            $dataFound = $licenseCode = false;
            for ($k = 3; $k <= 11; $k++) {
                if (!empty($line[$k])) {
                    $dataFound = true;
                }
            }
            if ($dataFound) {
                $licenseCode = $this->getLicenseCode($line[0]);
            }

            if (false === $licenseCode || !isset($dbKeys[$licenseCode])) {
                continue;
            } else {
                if (!empty($line[11])) {
                    $imgs = explode(';;', $line[11]);
                    $line[11] = $imgs[0];
                    $targetFile = WWW_ROOT . 'img/drugs/' . substr($dbKeys[$licenseCode], 0, 8) . '/' . $dbKeys[$licenseCode] . '.jpg';
                    if (!file_exists($targetFile)) {
                        $imageFile = $imagePath . '/' . $dbKeys[$licenseCode];
                        file_put_contents($imageFile, file_get_contents($line[11]));
                        $line[11] = '';
                        if (file_exists($imageFile)) {
                            $mime = mime_content_type($imageFile);
                            if (filesize($imageFile) > 0) {
                                if (in_array($mime, array(
                                            'application/vnd.ms-powerpoint',
                                            'application/msword', 'text/html'
                                        ))) {
                                    unlink($imageFile);
                                } else {
                                    $targetFile = WWW_ROOT . 'img/drugs/' . substr($dbKeys[$licenseCode], 0, 8);
                                    if (!file_exists($targetFile)) {
                                        mkdir($targetFile, 0777, true);
                                    }
                                    $targetFile .= '/' . $dbKeys[$licenseCode] . '.jpg';
                                    $line[11] = substr($targetFile, $wLength);
                                    if (!file_exists($targetFile)) {
                                        if (false !== strpos($mime, 'pdf')) {
                                            exec("/usr/bin/convert -resize 512x512 {$imageFile}[0] {$targetFile}");
                                        } else {
                                            exec("/usr/bin/convert -resize 512x512 {$imageFile} {$targetFile}");
                                        }
                                    }
                                }
                            }
                            //unlink($imageFile);
                        }
                    } else {
                        $line[11] = substr($targetFile, $wLength);
                    }
                }
                $this->dbQuery("UPDATE licenses SET shape = '{$line[3]}', s_type = '{$line[4]}', color = '{$line[5]}', odor = '{$line[6]}', abrasion = '{$line[7]}', size = '{$line[8]}', note_1 = '{$line[9]}', note_2 = '{$line[10]}', image = '{$line[11]}' WHERE id = '{$dbKeys[$licenseCode]}'");
            }
        }
    }

    public function importNhiPrice() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('許可證字號', '健保代碼', '規格量', '規格單位', '起期', '終期', '參考價', '-');
        $dbKeys = array();
        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }

        $fh = fopen(__DIR__ . '/data/nhi/codes/licenses.csv', 'r');

        /*
         * Array
          (
          [0] => 01000015 //license code
          [1] => 421 //suffix
          [2] => //新
          [3] => //口服錠註記
          [4] => N //複
          [5] => A000015421 //藥品代碼
          [6] => 10.00 //參考價
          [7] => 0840301 //有效期(begin)
          [8] => 0900331 //有效期(end)
          [9] => YEN KUANG EYE DROPS //英文名稱
          [10] => 5.00 ML //規格量 規格單位
          [11] => ML //規格單位
          [12] => SULFAMETHOXAZOLE SODIUM //成份名稱
          [13] => 20.000 //成份含量
          [14] => MG/ML //成份單位
          [15] => 點眼液劑 //劑型
          [16] => 0408 //理分類代碼
          [17] => 五福化學製藥廠有限公司 //製造廠名稱
          [18] => S01AB91 //ATC CODE
          )
         */
        $valueStack = array();
        $sn = 1;
        error_log('price importing');
        while ($line = fgetcsv($fh, 2048)) {
            $licenseId = '';
            $licenseCode = 'fda' . $line[0];
            $currentId = String::uuid();

            if (isset($dbKeys[$licenseCode])) {
                $licenseId = $dbKeys[$licenseCode];
            } else {
                $linePrefix = substr($line[0], 0, 2);
                switch ($linePrefix) {
                    case '01':
                    case '02':
                    case '09':
                    case '10':
                    case '20':
                    case '21':
                        $anotherCode = 'fda' . (intval($linePrefix) + 50) . substr($line[0], 2);
                        if (isset($dbKeys[$anotherCode])) {
                            $licenseId = $dbKeys[$anotherCode];
                        }
                        break;
                }
            }
            $line[7] = $this->getTwDate($line[7]);
            $line[8] = $this->getTwDate($line[8]);
            $pos = strpos($line[10], ' ');
            $dosage = substr($line[10], 0, $pos);
            $unit = substr($line[10], $pos + 1);
            $dbCols = array(
                "('{$currentId}'", //id
                "'{$licenseId}'", //license_id
                "'{$line[5]}'", //nhi_id
                "'{$dosage}'", //nhi_dosage
                "'{$unit}'", //nhi_unit
                "'{$line[7]}'", //date_begin
                "'{$line[8]}'", //date_end
                "'{$line[6]}'", //nhi_price
            );
            $valueStack[] = implode(',', $dbCols) . ')';
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `prices` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $sn = 1;
            $this->dbQuery('INSERT INTO `prices` VALUES ' . implode(',', $valueStack) . ';');
            $valueStack = array();
        }
        $this->dbQuery('UPDATE licenses SET nhi_id = ( SELECT GROUP_CONCAT( DISTINCT nhi_id SEPARATOR \',\' ) FROM prices WHERE license_id = licenses.id )');
    }

    public function importPrice() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('許可證字號', '健保代碼', '規格量', '規格單位', '起期', '終期', '參考價', '-');
        $dbKeys = array();
        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        $fh = fopen($this->dataPath . '/dataset/74.csv', 'r');
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 健保代碼 nhi_id
          [2] => 規格量 nhi_dosage
          [3] => 規格單位 nhi_unit
          [4] => 起期 date_begin
          [5] => 終期 date_end
          [6] => 參考價 nhi_price
          [7] => drug_id
          )
         */
        $stack = $valueStack = array();
        $sn = 1;
        echo "price importing\n";
        while ($line = fgetcsv($fh, 2048, "\t")) {
            $licenseCode = $this->getLicenseCode($line[0]);
            if (false === $licenseCode || !isset($dbKeys[$licenseCode])) {
                continue;
            }

            $currentId = String::uuid();
            $line[7] = $dbKeys[$licenseCode];
            $line[4] = $this->getTwDate($line[4]);
            $line[5] = $this->getTwDate($line[5]);
            if (!isset($stack[$line[7]])) {
                $stack[$line[7]] = array();
            }
            if (!isset($stack[$line[7]][$line[1]])) {
                $stack[$line[7]][$line[1]] = $line[1];
            }
            $dbCols = array(
                "('{$currentId}'", //id
                "'{$line[7]}'", //license_id
                "'{$line[1]}'", //nhi_id
                "'{$line[2]}'", //nhi_dosage
                "'{$line[3]}'", //nhi_unit
                "'{$line[4]}'", //date_begin
                "'{$line[5]}'", //date_end
                "'{$line[6]}'", //nhi_price
            );
            $valueStack[] = implode(',', $dbCols) . ')';
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `prices` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $sn = 1;
            $this->dbQuery('INSERT INTO `prices` VALUES ' . implode(',', $valueStack) . ';');
            $valueStack = array();
        }
        $this->dbQuery('UPDATE licenses SET nhi_id = ( SELECT GROUP_CONCAT( DISTINCT nhi_id SEPARATOR \',\' ) FROM prices WHERE license_id = licenses.id )');
    }

    public function dumpDbKeys() {
        $drugs = $this->License->Drug->find('all', array(
            'order' => array('License.code' => 'ASC'),
            'contain' => array(
                'License' => array(
                    'fields' => array('code', 'source'),
                ),
            ),
        ));
        $fh = fopen(__DIR__ . '/data/keys/drugs.csv', 'w');
        $fhL = fopen(__DIR__ . '/data/keys/licenses.csv', 'w');
        $stack = array();
        foreach ($drugs AS $drug) {
            fputcsv($fh, array(
                "{$drug['Drug']['license_id']}{$drug['Drug']['vendor_id']}{$drug['Drug']['manufacturer_description']}",
                $drug['Drug']['id'],
            ));
            $key = $drug['License']['source'] . $drug['License']['code'];
            if (!isset($stack[$key])) {
                fputcsv($fhL, array(
                    $key,
                    $drug['Drug']['license_id'],
                ));
                $stack[$key] = true;
            }
        }
        fclose($fh);
        fclose($fhL);
        $ingredients = $this->License->Ingredient->find('all', array(
            'fields' => array('id', 'name'),
            'order' => array('Ingredient.name' => 'ASC'),
        ));
        $fh = fopen(__DIR__ . '/data/keys/ingredients.csv', 'w');
        foreach ($ingredients AS $ingredient) {
            fputcsv($fh, array(
                $ingredient['Ingredient']['name'],
                $ingredient['Ingredient']['id'],
            ));
        }
        fclose($fh);
        $fh = fopen(__DIR__ . '/data/keys/points.csv', 'w');
        $points = $this->License->Article->Point->find('all', array(
            'fields' => array('id', 'nhi_id'),
            'order' => array('nhi_id' => 'ASC'),
        ));
        foreach ($points AS $point) {
            fputcsv($fh, array(
                $point['Point']['nhi_id'],
                $point['Point']['id'],
            ));
        }
        fclose($fh);
        $fh = fopen(__DIR__ . '/data/keys/vendors.csv', 'w');
        $vendors = $this->License->Vendor->find('all', array(
            'fields' => array('id', 'name'),
            'order' => array('name' => 'ASC'),
        ));
        foreach ($vendors AS $vendor) {
            fputcsv($fh, array(
                $vendor['Vendor']['name'],
                $vendor['Vendor']['id'],
            ));
        }
        fclose($fh);
    }

    public function importDrug() {
        $fields = array('許可證字號', '註銷狀態', '註銷日期', '註銷理由', '有效日期',
            '發證日期', '許可證種類', '舊證字號', '通關簽審文件編號', '中文品名',
            '英文品名', '適應症', '劑型', '包裝', '藥品類別', '管制藥品分類級別',
            '主成分略述', '申請商名稱', '申請商地址', '申請商統一編號', '製造商名稱',
            '製造廠廠址', '製造廠公司地址', '製造廠國別', '製程', '異動日期',
            '用法用量', '包裝', '國際條碼');
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $stack = $urlKeys = $valueStack = $licenseId = $licenseStack = $vendorKeys = $vendorStack = $drugsQueued = array();
        if (file_exists(__DIR__ . '/data/keys/drugs.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/drugs.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $stack[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $licenseId[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/keys/vendors.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/vendors.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $vendorKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        $dbVendorKeys = $this->License->Vendor->find('list', array(
            'fields' => array('id', 'id')
        ));
        $fh = fopen($this->dataPath . '/dataset/36.csv', 'r');
        $count = 0;
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 註銷狀態
          [2] => 註銷日期
          [3] => 註銷理由
          [4] => 有效日期
          [5] => 發證日期
          [6] => 許可證種類
          [7] => 舊證字號
          [8] => 通關簽審文件編號
          [9] => 中文品名
          [10] => 英文品名
          [11] => 適應症
          [12] => 劑型
          [13] => 包裝
          [14] => 藥品類別
          [15] => 管制藥品分類級別
          [16] => 主成分略述
         *
          [17] => 申請商名稱
          [18] => 申請商地址
          [19] => 申請商統一編號
         *
          [20] => 製造商名稱
          [21] => 製造廠廠址
          [22] => 製造廠公司地址
          [23] => 製造廠國別
         *
          [24] => 製程
          [25] => 異動日期
          [26] => 用法用量
          [27] => 包裝
          [28] => 國際條碼
          )
         */
        $escapesKeys = array(1, 3, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16, 17, 18, 20, 21, 22, 24, 26, 27, 28);
        $sn = 1;
        echo "drugs importing\n";
        while ($line = fgets($fh, 5000)) {
            $cols = explode("\t", $line);
            if (count($cols) !== 29) {
                print_r($cols);
                exit();
            }
            foreach ($cols AS $k => $v) {
                $cols[$k] = trim($v);
            }

            $licenseCode = $this->getLicenseCode($cols[0]);
            if (false === $licenseCode) {
                continue;
            }

            if (!isset($licenseId[$licenseCode])) {
                $licenseId[$licenseCode] = String::uuid();
            }
            $vendorKey1 = $cols[17];
            $vendorKey2 = $cols[20];
            if (!isset($vendorKeys[$vendorKey1])) {
                $vendorKeys[$vendorKey1] = String::uuid();
            }
            if (!isset($vendorKeys[$vendorKey2])) {
                $vendorKeys[$vendorKey2] = String::uuid();
            }

            foreach ($escapesKeys AS $escapesKey) {
                $cols[$escapesKey] = str_replace(array('　'), array(''), $cols[$escapesKey]);
            }
            $key = "{$licenseId[$licenseCode]}{$vendorKeys[$vendorKey2]}{$cols[24]}";
            foreach ($escapesKeys AS $escapesKey) {
                $cols[$escapesKey] = $this->mysqli->real_escape_string($cols[$escapesKey]);
            }

            if (!isset($stack[$key])) {
                $stack[$key] = String::uuid();
            }

            if (!isset($dbVendorKeys[$vendorKeys[$vendorKey1]])) {
                if (!isset($vendorStack[$vendorKey1])) {
                    $vendorStack[$vendorKey1] = array(
                        'id' => $vendorKeys[$vendorKey1],
                        'tax_id' => $cols[19],
                        'name' => $cols[17],
                        'address' => $cols[18],
                        'address_office' => '',
                        'country' => (!empty($cols[19])) ? 'TAIWAN' : '',
                        'count_daily' => 0,
                        'count_all' => 0,
                    );
                } elseif (empty($vendorStack[$vendorKey1]['tax_id']) && !empty($cols[19])) {
                    $vendorStack[$vendorKey1]['tax_id'] = $cols[19];
                    $vendorStack[$vendorKey1]['country'] = 'TAIWAN';
                }
            }

            if (!isset($dbVendorKeys[$vendorKeys[$vendorKey2]]) && !isset($vendorStack[$vendorKey2])) {
                $vendorStack[$vendorKey2] = array(
                    'id' => $vendorKeys[$vendorKey2],
                    'tax_id' => '',
                    'name' => $cols[20],
                    'address' => $cols[21],
                    'address_office' => $cols[22],
                    'country' => $cols[23],
                    'count_daily' => 0,
                    'count_all' => 0,
                );
            }

            $dbCols = array(
                "('{$stack[$key]}'", //id
                "'{$licenseId[$licenseCode]}'", //license_id
                "'{$vendorKeys[$vendorKey2]}'", //vendor_id
                "'{$cols[24]}'", //manufacturer_description
            );
            if (!isset($licenseData[$licenseId[$licenseCode]])) {
                $dbCode = substr($licenseCode, 3);
                $licenseData[$licenseId[$licenseCode]] = array(
                    "('{$licenseId[$licenseCode]}'", //id
                    "'{$cols[0]}'", //license_id
                    "'{$dbCode}'", //code
                    "'fda'", //source
                    "NULL", //nhi_id
                    "NULL", //shape
                    "NULL", //s_type
                    "NULL", //color
                    "NULL", //odor
                    "NULL", //abrasion
                    "NULL", //size
                    "NULL", //note_1
                    "NULL", //note_2
                    "NULL", //image
                    "'{$cols[1]}'", //cancel_status
                    "'{$cols[2]}'", //cancel_date
                    "'{$cols[3]}'", //cancel_reason
                    "'{$cols[4]}'", //expired_date
                    "'{$cols[5]}'", //license_date
                    "'{$cols[6]}'", //license_type
                    "'{$cols[7]}'", //old_id
                    "'{$cols[8]}'", //document_id
                    "'{$cols[9]}'", //name
                    "'{$cols[10]}'", //name_english
                    "'{$cols[11]}'", //disease
                    "'{$cols[12]}'", //formulation
                    "'{$cols[13]}'", //package
                    "'{$cols[14]}'", //type
                    "'{$cols[15]}'", //class
                    "'{$cols[16]}'", //ingredient
                    "'{$vendorKeys[$vendorKey1]}'", //vendor_id
                    "'{$cols[25]}'", //submitted
                    "'{$cols[26]}'", //usage
                    "'{$cols[27]}'", //package_note
                    "'{$cols[28]}'", //barcode
                    "0", //count_daily
                    "0)", //count_all
                );
            }
            if (!isset($drugsQueued[$stack[$key]])) {
                $drugsQueued[$stack[$key]] = true;
                $valueStack[] = implode(',', $dbCols) . ')';
                ++$sn;
            }

            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `drugs` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `drugs` VALUES ' . implode(',', $valueStack) . ';');
        }
        $sn = 1;
        $valueStack = array();
        echo "licenses importing\n";
        foreach ($licenseData AS $dbCols) {
            $valueStack[] = implode(',', $dbCols);
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `licenses` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `licenses` VALUES ' . implode(',', $valueStack) . ';');
        }
        $sn = 1;
        $valueStack = array();
        echo "vendors importing\n";
        foreach ($vendorStack AS $vendor) {
            $valueStack[] = "('" . implode("', '", $vendor) . "')";
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `vendors` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `vendors` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function getTwDate($str) {
        $str = trim($str);
        if (empty($str) || strlen($str) !== 7) {
            return '';
        }
        $dateParts = array();
        $dateParts[0] = intval(substr($str, 0, 3)) + 1911;
        if ($dateParts[0] > date('Y')) {
            $dateParts[0] = date('Y') + 1;
        }
        $dateParts[1] = substr($str, 3, 2);
        $dateParts[2] = substr($str, 5, 2);
        return implode('-', $dateParts);
    }

    public function dbQuery($sql) {
        if (!$this->mysqli->query($sql)) {
            printf("Error: %s\n", $this->mysqli->error);
            echo $sql;
            exit();
        }
    }

}
