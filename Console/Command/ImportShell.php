<?php

class ImportShell extends AppShell {

    public $uses = array('License');
    public $dataPath = '/home/kiang/public_html/data.fda.gov.tw-list';
    public $mysqli = false;
    public $key2id = array();
    public $key2code = array();

    public function main() {
        $this->dumpDbKeys();
        exit();
        /*
         * Execute before importing:
         * TRUNCATE `drugs`;
          TRUNCATE `ingredients`;
          TRUNCATE `ingredients_licenses`;
          TRUNCATE `licenses`;
          TRUNCATE `links`;
          TRUNCATE `prices`;
          TRUNCATE `vendors`;
         * 
         * and remember to execute mohw to import another part of drugs
         * 
         * and dump generated data using another one:
         * 
         * mysqldump -uroot -p kiang_drug drugs ingredients ingredients_licenses licenses prices vendors > db.sql
         */
        $this->importDrug();
        $this->importPrice();
        $this->importImage();
        $this->importBox();
        $this->importIngredients();
        $this->importATC();
        //$this->importPoints();
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

    public function renameDrugImages() {
        $fh = fopen(__DIR__ . '/data/oldDrugId.csv', 'r');
        $map = array();
        while ($line = fgetcsv($fh, 512)) {
            $map[$line[0]] = $line[1];
        }
        $list = $this->License->find('list', array(
            'fields' => array('license_id', 'id'),
        ));
        foreach (glob(WWW_ROOT . 'img/drugs/*/*.jpg') AS $img) {
            $p = pathinfo($img);
            $uuid = $list[$map[$p['filename']]];
            $targetFile = WWW_ROOT . 'img/drugs/' . substr($uuid, 0, 8);
            if (!file_exists($targetFile)) {
                mkdir($targetFile, 0777, true);
            }
            exec("git mv {$img} {$targetFile}/{$uuid}.jpg");
        }
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
        if (file_exists(__DIR__ . '/data/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/licenses.csv', 'r');
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
        while ($line = fgetcsv($fh, 2048, "\t")) {
            foreach ($line AS $k => $v) {
                $line[$k] = trim($v);
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
            if (isset($dbKeys[$line[0]])) {
                $currentId = String::uuid();
                $valueStack[] = implode(',', array(
                    "('{$currentId}'", //id
                    $this->key2id[implode('', $tree)], //category_id
                    "'{$dbKeys[$line[0]]}'", //license_id
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

        if (file_exists(__DIR__ . '/data/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $dbKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/ingredients.csv')) {
            $ingredientKeysFh = fopen(__DIR__ . '/data/ingredients.csv', 'r');
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
        while ($line = fgetcsv($fh, 2048, "\t")) {
            if (substr($line[4], 0, 1) === '-') {
                $line[4] = substr($line[4], 1);
            }
            if (!isset($dbKeys[$line[0]])) {
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
                "'{$dbKeys[$line[0]]}'", //license_id
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

        if (file_exists(__DIR__ . '/data/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/licenses.csv', 'r');
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
        $imagick = new Imagick();
        $sn = 0;
        /*
         * get longest line lenth using command `wc -L filename`
         */
        while ($line = fgetcsv($fh, 10770, "\t")) {
            if (!isset($dbKeys[$line[0]])) {
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
                        "'{$dbKeys[$line[0]]}'", //license_id
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
                        "'{$dbKeys[$line[0]]}'", //license_id
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
        if (file_exists(__DIR__ . '/data/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/licenses.csv', 'r');
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
            $dataFound = false;
            for ($k = 3; $k <= 11; $k++) {
                if (!empty($line[$k])) {
                    $dataFound = true;
                }
            }
            if (true === $dataFound && isset($dbKeys[$line[0]])) {
                echo "processing {$dbKeys[$line[0]]}\n";
                if (!empty($line[11])) {
                    $imgs = explode(';;', $line[11]);
                    $line[11] = $imgs[0];
                    $targetFile = WWW_ROOT . 'img/drugs/' . substr($dbKeys[$line[0]], 0, 8) . '/' . $dbKeys[$line[0]] . '.jpg';
                    if (!file_exists($targetFile)) {
                        $imageFile = $imagePath . '/' . $dbKeys[$line[0]];
                        file_put_contents($imageFile, file_get_contents($line[11]));
                        $line[11] = '';
                        if (file_exists($imageFile)) {
                            if (filesize($imageFile) > 0) {
                                if (in_array(mime_content_type($imageFile), array(
                                            'application/vnd.ms-powerpoint',
                                            'application/msword', 'text/html'
                                        ))) {
                                    unlink($imageFile);
                                } else {
                                    $targetFile = WWW_ROOT . 'img/drugs/' . substr($dbKeys[$line[0]], 0, 8);
                                    if (!file_exists($targetFile)) {
                                        mkdir($targetFile, 0777, true);
                                    }
                                    $targetFile .= '/' . $dbKeys[$line[0]] . '.jpg';
                                    $line[11] = substr($targetFile, $wLength);
                                    if (!file_exists($targetFile)) {
                                        $imagick->readimage($imageFile);
                                        $imagick->thumbnailimage(512, 512, true, true);
                                        $imagick->writeImage($targetFile);
                                        $imagick->clear();
                                    }
                                }
                            }
                            //unlink($imageFile);
                        }
                    } else {
                        $line[11] = substr($targetFile, $wLength);
                    }
                }
                $this->dbQuery("UPDATE licenses SET shape = '{$line[3]}', s_type = '{$line[4]}', color = '{$line[5]}', odor = '{$line[6]}', abrasion = '{$line[7]}', size = '{$line[8]}', note_1 = '{$line[9]}', note_2 = '{$line[10]}', image = '{$line[11]}' WHERE id = '{$dbKeys[$line[0]]}'");
            }
        }
    }

    public function importPrice() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $fields = array('許可證字號', '健保代碼', '規格量', '規格單位', '起期', '終期', '參考價', '-');
        $dbKeys = array();
        if (file_exists(__DIR__ . '/data/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/licenses.csv', 'r');
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
        while ($line = fgetcsv($fh, 2048, "\t")) {
            if (isset($dbKeys[$line[0]])) {
                $currentId = String::uuid();
                $line[7] = $dbKeys[$line[0]];
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
            'fields' => array('id', 'license_uuid', 'license_id', 'manufacturer_description'),
            'order' => array('Drug.license_id' => 'ASC'),
            'contain' => array(
                'Vendor' => array(
                    'fields' => array('name', 'address'),
                ),
            ),
        ));
        $fh = fopen(__DIR__ . '/data/drugs.csv', 'w');
        $fhL = fopen(__DIR__ . '/data/licenses.csv', 'w');
        $stack = array();
        foreach ($drugs AS $drug) {
            $vendorKey2 = trim(strtolower($drug['Vendor']['name']), '.');
            $key = $drug['Drug']['license_id'] . md5($vendorKey2 . $drug['Vendor']['address'] . $drug['Drug']['manufacturer_description']);
            fputcsv($fh, array(
                $key,
                $drug['Drug']['id'],
            ));
            if (!isset($stack[$drug['Drug']['license_uuid']])) {
                fputcsv($fhL, array(
                    $drug['Drug']['license_id'],
                    $drug['Drug']['license_uuid'],
                ));
                $stack[$drug['Drug']['license_uuid']] = true;
            }
        }
        fclose($fh);
        fclose($fhL);
        $ingredients = $this->License->Ingredient->find('all', array(
            'fields' => array('id', 'name'),
            'order' => array('Ingredient.name' => 'ASC'),
        ));
        $fh = fopen(__DIR__ . '/data/ingredients.csv', 'w');
        foreach ($ingredients AS $ingredient) {
            fputcsv($fh, array(
                $ingredient['Ingredient']['name'],
                $ingredient['Ingredient']['id'],
            ));
        }
        fclose($fh);
        $fh = fopen(__DIR__ . '/data/points.csv', 'w');
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
        $fh = fopen(__DIR__ . '/data/vendors.csv', 'w');
        $vendors = $this->License->Vendor->find('list', array(
            'fields' => array('id', 'name'),
            'order' => array('name' => 'ASC'),
        ));
        foreach ($vendors AS $vendorId => $vendorName) {
            fputcsv($fh, array(
                $vendorId,
                $vendorName,
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
        $stack = $urlKeys = $valueStack = $licenseId = $licenseStack = $vendorKeys = $vendorStack = array();
        if (file_exists(__DIR__ . '/data/drugs.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/drugs.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $stack[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $licenseId[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/vendors.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/vendors.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $vendorKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
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
        while ($line = fgets($fh, 5000)) {
            $cols = explode("\t", $line);
            if (count($cols) !== 29) {
                print_r($cols);
                exit();
            }
            foreach ($cols AS $k => $v) {
                $cols[$k] = trim($v);
            }
            if (!isset($licenseId[$cols[0]])) {
                $licenseId[$cols[0]] = String::uuid();
            }
            $vendorKey1 = trim(strtolower($cols[17]), '.');
            $vendorKey2 = trim(strtolower($cols[20]), '.');
            $key = $cols[0] . md5($vendorKey2 . $cols[21] . $cols[24]);
            foreach ($escapesKeys AS $escapesKey) {
                $cols[$escapesKey] = str_replace(array('　'), array(''), $cols[$escapesKey]);
                $cols[$escapesKey] = $this->mysqli->real_escape_string($cols[$escapesKey]);
            }
            if (!isset($stack[$key])) {
                $stack[$key] = String::uuid();
            }
            if (!isset($vendorKeys[$vendorKey1])) {
                $vendorKeys[$vendorKey1] = String::uuid();
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
            if (!isset($vendorKeys[$vendorKey2])) {
                $vendorKeys[$vendorKey2] = String::uuid();
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
                "'{$licenseId[$cols[0]]}'", //license_uuid
                "'{$cols[0]}'", //license_id
                "'{$vendorKeys[$vendorKey2]}'", //vendor_id
                "'{$cols[24]}'", //manufacturer_description
            );
            if (!isset($licenseData[$licenseId[$cols[0]]])) {
                $licenseData[$licenseId[$cols[0]]] = array(
                    "('{$licenseId[$cols[0]]}'", //id
                    "'{$cols[0]}'", //license_id
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
            $valueStack[] = implode(',', $dbCols) . ')';
            ++$sn;
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
            $dateParts[0] = date('Y');
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
