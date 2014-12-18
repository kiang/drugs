<?php

class ImportShell extends AppShell {

    public $uses = array('Drug');
    public $dataPath = '/home/kiang/public_html/data.fda.gov.tw';
    public $mysqli = false;

    public function main() {
        $this->dumpDbKeys();
    }

    public function importPrice() {
        $fields = array('許可證字號', '健保代碼', '規格量', '規格單位', '起期', '終期', '參考價', '-');
        print_r($fields);
        $fh = fopen($this->dataPath . '/dataset/74.csv', 'r');
        /*
         * Array
          (
          [0] => 許可證字號
          [1] => 健保代碼
          [2] => 規格量
          [3] => 規格單位
          [4] => 起期
          [5] => 終期
          [6] => 參考價
          [7] => -
          )
         */
        while ($line = fgetcsv($fh, 2048, "\t")) {
            print_r(array_combine($fields, $line));
            exit();
            //nhi_id
        }
    }

    public function dumpDbKeys() {
        $drugs = $this->Drug->find('all', array(
            'conditions' => array(
                'Drug.active_id IS NULL',
            ),
            'fields' => array('id', 'license_id'),
            'order' => array('Drug.submitted' => 'ASC'),
        ));
        $fh = fopen(__DIR__ . '/data/dbKeys.csv', 'w');
        foreach ($drugs AS $drug) {
            fputcsv($fh, array(
                $drug['Drug']['license_id'],
                $drug['Drug']['id'],
            ));
        }
        fclose($fh);
    }

    public function batchImport() {
        $fields = array('許可證字號', '註銷狀態', '註銷日期', '註銷理由', '有效日期',
            '發證日期', '許可證種類', '舊證字號', '通關簽審文件編號', '中文品名',
            '英文品名', '適應症', '劑型', '包裝', '藥品類別', '管制藥品分類級別',
            '主成分略述', '申請商名稱', '申請商地址', '申請商統一編號', '製造商名稱',
            '製造廠廠址', '製造廠公司地址', '製造廠國別', '製程', '異動日期',
            '用法用量', '包裝', '國際條碼');
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        if (file_exists(__DIR__ . '/data/dbKeys.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/dbKeys.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $stack[$line[0]] = array(
                    'id' => $line[1],
                    'is_new' => false,
                    'linked_id' => '',
                    'linked_date' => 0,
                    'line' => array(),
                );
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/urlKeys.csv')) {
            $urlKeysFh = fopen(__DIR__ . '/data/urlKeys.csv', 'r');
            while ($line = fgets($urlKeysFh, 512)) {
                $line = trim($line);
                $urlKeys[$line] = true;
            }
            fclose($urlKeysFh);
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
         * [29] => md5 checksum
          )
         */
        $escapesKeys = array(1, 3, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16, 17, 18, 20, 21, 22, 24, 26, 27, 28);
        $sn = 1;
        $stack = $urlKeys = $valueStack = array();
        while ($line = fgets($fh, 5000)) {
            $cols = explode("\t", $line);
            foreach ($escapesKeys AS $escapesKey) {
                $cols[$escapesKey] = str_replace(array('　'), array(''), trim($cols[$escapesKey]));
                $cols[$escapesKey] = $this->mysqli->real_escape_string($cols[$escapesKey]);
            }
            /*
             * use md5 to check if the line chanded
             */
            $cols[] = md5($line);
            if (!isset($urlKeys[$cols[0]])) {
                $urlKeys[$cols[0]] = String::uuid();
                $stack[$cols[0]] = array(
                    'id' => $urlKeys[$cols[0]],
                    'is_new' => true,
                    'linked_id' => '',
                    'linked_date' => 0,
                    'line' => array(),
                );
            }
            $currentId = String::uuid();
            $modified = strtotime($cols[25]);
            if ($modified > $stack[$cols[0]]['linked_date']) {
                $stack[$cols[0]]['linked_id'] = $currentId;
                $stack[$cols[0]]['linked_date'] = $modified;
                $stack[$cols[0]]['line'] = $cols;
            }
            $dbCols = array(
                "('{$currentId}'", //id
                "'{$stack[$cols[0]]['id']}'", //active_id
                'NULL', //linked_id
            );
            foreach ($cols AS $col) {
                $dbCols[] = "'{$col}'";
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
            $sn = 1;
            $this->dbQuery('INSERT INTO `drugs` VALUES ' . implode(',', $valueStack) . ';');
            $valueStack = array();
        }
        foreach ($stack AS $item) {
            if (empty($item['linked_id'])) {
                continue;
            }
            if ($item['is_new']) {
                $dbCols = array(
                    "('{$item['id']}'", //id
                    "NULL", //active_id
                    "'{$item['linked_id']}'", //linked_id
                );
                foreach ($item['line'] AS $col) {
                    $dbCols[] = "'{$col}'";
                }
                $valueStack[] = implode(',', $dbCols) . ')';

                ++$sn;
                if ($sn > 50) {
                    $sn = 1;
                    $this->dbQuery('INSERT INTO `drugs` VALUES ' . implode(',', $valueStack) . ';');
                    $valueStack = array();
                }
            }
        }
        if (!empty($valueStack)) {
            $sn = 1;
            $this->dbQuery('INSERT INTO `drugs` VALUES ' . implode(',', $valueStack) . ';');
            $valueStack = array();
        }
    }

    public function dbQuery($sql) {
        if (!$this->mysqli->query($sql)) {
            printf("Error: %s\n", $this->mysqli->error);
            echo $sql;
            exit();
        }
    }

}
