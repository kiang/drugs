<?php

class TfdaShell extends AppShell {

    public $uses = array('License');
    public $dataPath = '/home/kiang/github/tfda_license';
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
        $this->poolPath = __DIR__ . '/data/tfda';
        $this->import();
    }

    public function import() {
        $this->getTasks();
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $stack = $licenseId = $vendorKeys = $vendorStack = $licenseData = $valueStack = array();

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
        $escapesKeys = array('註銷理由', '中文品名', '英文品名', '適應症', '主成分略述');
        $sn = 0;

        $fh = fopen($this->poolPath . '/tasks.csv', 'r');
        while ($task = fgetcsv($fh, 2048)) {
            $json = json_decode(file_get_contents($this->dataPath . '/' . $task[1]), true);
            if (empty($json['許可證字號'])) {
                continue;
            }

            if (!isset($json['管制藥品分類級別']) && isset($json['醫療器材級數'])) {
                $json['管制藥品分類級別'] = $json['醫療器材級數'];
            }
            if (!isset($json['藥品類別']) && isset($json['醫器主類別一'])) {
                $json['藥品類別'] = $json['醫器主類別一'];
            }
            if (!isset($json['藥品類別']) && isset($json['化粧品類別'])) {
                $json['藥品類別'] = $json['化粧品類別'];
            }
            if (!isset($json['適應症']) && isset($json['醫器規格'])) {
                $json['適應症'] = $json['醫器規格'];
            }
            if (!isset($json['適應症']) && isset($json['用途'])) {
                $json['適應症'] = $json['用途'];
            }
            if (!isset($json['註銷狀態']) && isset($json['廢止狀態'])) {
                $json['註銷狀態'] = $json['廢止狀態'];
            }
            if (!isset($json['註銷日期']) && isset($json['廢止日期'])) {
                $json['註銷日期'] = $json['廢止日期'];
            }
            if (!isset($json['註銷理由']) && isset($json['廢止理由'])) {
                $json['註銷理由'] = $json['廢止理由'];
            }
            if (!isset($json['主製造廠']['製程'])) {
                $json['主製造廠']['製程'] = '';
            }
            $vendorKey1 = $json['申請商名稱'] = $this->getCleanString($json['申請商名稱']);
            $vendorKey2 = $json['主製造廠']['製造廠名稱'] = $this->getCleanString($json['主製造廠']['製造廠名稱']);
            if (!isset($vendorKeys[$vendorKey1])) {
                $vendorKeys[$vendorKey1] = CakeText::uuid();
            }
            if (!isset($vendorKeys[$vendorKey2])) {
                $vendorKeys[$vendorKey2] = CakeText::uuid();
            }

            $licenseCode = 'fda' . $json['code'];
            if (!isset($licenseId[$licenseCode])) {
                $licenseId[$licenseCode] = CakeText::uuid();
            }
            $id = $licenseId[$licenseCode]; //license id

            $key = "{$licenseId[$licenseCode]}{$vendorKeys[$vendorKey2]}";

            $vendorKey1 = $json['申請商名稱'];
            $vendorKey2 = $json['主製造廠']['製造廠名稱'];
            if (!isset($vendorKeys[$vendorKey1])) {
                $vendorKeys[$vendorKey1] = CakeText::uuid();
            }
            if (!isset($vendorKeys[$vendorKey2])) {
                $vendorKeys[$vendorKey2] = CakeText::uuid();
            }

            if (!isset($stack[$key])) {
                $stack[$key] = CakeText::uuid();
            }
            $drugId = $stack[$key];

            if (!isset($dbVendorKeys[$vendorKeys[$vendorKey1]])) {
                if (!isset($vendorStack[$vendorKey1])) {
                    $vendorStack[$vendorKey1] = array(
                        'id' => $vendorKeys[$vendorKey1],
                        'tax_id' => '',
                        'name' => $json['申請商名稱'],
                        'address' => isset($json['申請商地址']) ? $json['申請商地址'] : '',
                        'address_office' => '',
                        'country' => 'TAIWAN',
                        'count_daily' => 0,
                        'count_all' => 0,
                    );
                }
            }

            if (!isset($dbVendorKeys[$vendorKeys[$vendorKey2]]) && !isset($vendorStack[$vendorKey2])) {
                $vendorStack[$vendorKey2] = array(
                    'id' => $vendorKeys[$vendorKey2],
                    'tax_id' => '',
                    'name' => $json['主製造廠']['製造廠名稱'],
                    'address' => $json['主製造廠']['製造廠廠址'],
                    'address_office' => $json['主製造廠']['製造廠公司地址'],
                    'country' => isset($json['主製造廠']['製造廠國別']) ? $json['主製造廠']['製造廠國別'] : '',
                    'count_daily' => 0,
                    'count_all' => 0,
                );
            }

            $dbCols = array(
                "('{$drugId}'", //id
                "'{$id}'", //license_id
                "'{$vendorKeys[$vendorKey2]}'", //vendor_id
                "'{$json['主製造廠']['製程']}'", //manufacturer_description
            );
            $json['註銷日期'] = $this->getTwDate($json['註銷日期']);
            $json['有效日期'] = $this->getTwDate($json['有效日期']);
            $json['發證日期'] = $this->getTwDate($json['發證日期']);
            foreach ($escapesKeys AS $escapesKey) {
                if (is_array($json[$escapesKey])) {
                    $json[$escapesKey] = implode('', $json[$escapesKey]);
                }
                $json[$escapesKey] = $this->mysqli->real_escape_string($json[$escapesKey]);
            }
            $licenseData[$id] = array(
                "('{$id}'", //id
                "'{$json['許可證字號']}'", //license_id
                "'{$json['code']}'", //code
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
                "'{$json['註銷狀態']}'", //cancel_status
                "'{$json['註銷日期']}'", //cancel_date
                "'{$json['註銷理由']}'", //cancel_reason
                "'{$json['有效日期']}'", //expired_date
                "'{$json['發證日期']}'", //license_date
                "'{$json['許可證種類']}'", //license_type
                "'{$json['舊證字號']}'", //old_id
                "'{$json['通關簽審文件編號']}'", //document_id
                "'{$json['中文品名']}'", //name
                "'{$json['英文品名']}'", //name_english
                "'{$json['適應症']}'", //disease
                "'{$json['劑型']}'", //formulation
                "'{$json['包裝']}'", //package
                "'{$json['藥品類別']}'", //type
                "'{$json['管制藥品分類級別']}'", //class
                "'{$json['主成分略述']}'", //ingredient
                "'{$vendorKeys[$vendorKey1]}'", //vendor_id
                "''", //submitted
                "''", //usage
                "''", //package_note
                "''", //barcode
                "0", //count_daily
                "0)", //count_all
            );
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
            foreach ($vendor AS $k => $v) {
                $vendor[$k] = $this->mysqli->real_escape_string($v);
            }
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

    public function getTasks() {
        if (!file_exists($this->poolPath)) {
            mkdir($this->poolPath, 0777, true);
        }
        $licenseId = $this->License->find('list', array(
            'conditions' => array('License.source' => 'fda'),
            'fields' => array('License.code', 'License.code'),
        ));

        $fh = fopen($this->poolPath . '/tasks.csv', 'w');
        foreach (glob($this->dataPath . '/licenses/*/*.json') AS $jsonFile) {
            $pathInfo = pathinfo($jsonFile);
            if (!isset($licenseId[$pathInfo['filename']])) {
                fputcsv($fh, array($pathInfo['filename'], substr($jsonFile, strrpos($jsonFile, '/', -20) + 1)));
            }
        }
        fclose($fh);
    }

    public function getTwDate($str) {
        $str = trim($str);
        if (empty($str)) {
            return '';
        }
        $dateParts = explode('/', $str);
        $dateParts[0] = intval($dateParts[0]) + 1911;
        return implode('-', $dateParts);
    }

    public function dbQuery($sql) {
        if (!$this->mysqli->query($sql)) {
            printf("Error: %s\n", $this->mysqli->error);
            echo $sql;
            exit();
        }
    }

    public function getCleanString($input) {
        preg_match('/ +/', $input, $matches, PREG_OFFSET_CAPTURE);
        if (!empty($matches[0][1])) {
            $input = substr($input, $matches[0][1] + strlen($matches[0][0]));
        }
        return trim($input);
    }

}
