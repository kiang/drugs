<?php

App::uses('HttpSocket', 'Network/Http');

class NhiShell extends AppShell {

    public $uses = array('License');
    public $prefixCodes = array(
        'A' => '01', //衛署藥製
        'B' => '02', //衛署藥輸
        'N' => '12', //內衛藥製
        'P' => '13', //內衛藥輸
        'J' => '09', //衛署菌疫製
        'K' => '10', //衛署菌疫輸
        'V' => '20', //衛署罕藥輸
        'W' => '21', //衛署罕藥製
        'R' => '15', //內衛菌疫製
        'S' => '16', //內衛菌疫輸
        'Y' => '22', //罕菌疫輸
        'Z' => '23', //罕菌疫製
        'X' => '00', //經我國主管機關核准專案進口而未領有藥品許可證者
    );

    public function main() {
        //$this->hospitals();
        $this->codes();
    }

    public function newCodes() {
        $tmpPath = TMP . 'nhi/codes';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/nhi/codes';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $csvTmpFile = $tmpPath . '/all_' . date('Ymd');
        if (!file_exists($csvTmpFile)) {
            file_put_contents($csvTmpFile, file_get_contents('http://www.nhi.gov.tw/Resource/webdata/%E5%81%A5%E4%BF%9D%E7%94%A8%E8%97%A5%E5%93%81%E9%A0%85.csv'));
            copy($csvTmpFile, $targetPath . '/all.csv');
        }
        $fh = fopen($csvTmpFile, 'r');
        fgets($fh, 2048);
        /*
         * Array
          (
          [0] => 異動
          [1] => 藥品代碼
          [2] => 藥品英文名稱
          [3] => 藥品中文名稱
          [4] => 規格量
          [5] => 規格單位
          [6] => 單複方
          [7] => 參考價
          [8] => 有效起日
          [9] => 有效迄日
          [10] => 製造廠名稱
          [11] => 劑型
          [12] => 成份
          )
         */
        $tree = array();
        while ($line = fgetcsv($fh, 2048)) {
            $firstChar = substr($line[1], 0, 1);
            if (!isset($this->prefixCodes[$firstChar])) {
                continue;
            }
            $licenseCode = $this->prefixCodes[$firstChar] . '0' . substr($line[1], 2, 5);
            if (!isset($tree[$licenseCode])) {
                $tree[$licenseCode] = array();
            }
            if (!isset($tree[$licenseCode][$line[1]])) {
                $tree[$licenseCode][$line[1]] = array();
            }
            $tree[$licenseCode][$line[1]][] = $line;
        }
        fclose($fh);
        print_r($tree);
    }

    public function codes() {
        $tmpPath = TMP . 'nhi/codes';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/nhi/codes';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $pool = date('Ymd');
        // download from http://www.nhi.gov.tw/Content_List.aspx?n=238507DCFE832EAE&topn=3FC7D09599D25979
        $zipFile = $targetPath . '/' . date('Ymd') . '.zip';
        if (file_exists($zipFile)) {
            if (!file_exists("{$tmpPath}/{$pool}")) {
                mkdir("{$tmpPath}/{$pool}", 0777, true);
                $zip = new ZipArchive;
                $res = $zip->open($zipFile);
                $zip->extractTo("{$tmpPath}/{$pool}");
                $zip->close();
            }
            foreach (glob("{$tmpPath}/{$pool}/*") AS $b5) {
                $fh = fopen($b5, 'r');
                $len = array();
                fgets($fh, 2048);
                while ($line = fgets($fh, 2048)) {
                    if (substr($line, 17, 1) === 'X' || !isset($this->prefixCodes[substr($line, 17, 1)])) {
                        continue;
                    }
                    $item = array(
                        0 => substr($line, 0, 2), //新
                        1 => substr($line, 3, 10), //口服錠註記
                        2 => substr($line, 14, 2), //複
                        3 => substr($line, 17, 10), //藥品代碼
                        4 => substr($line, 28, 9), //參考價
                        5 => substr($line, 38, 7), //有效期
                        6 => substr($line, 46, 7),
                        7 => substr($line, 54, 120), //英文名稱
                        8 => substr($line, 175, 17), //規格量 規格單位
                        9 => substr($line, 183, 11), //規格單位
                        10 => substr($line, 195, 55), //成份名稱
                        11 => substr($line, 251, 12), //成份含量
                        12 => substr($line, 264, 10), //成份單位
                        13 => substr($line, 275, 12), //劑型
                        14 => substr($line, 290, 12), //理分類代碼
                        15 => substr($line, 301, 42), //製造廠名稱
                        16 => substr($line, 344, 8), //ATC CODE
                    );

                    foreach ($item AS $k => $v) {
                        $item[$k] = trim(mb_convert_encoding($v, 'utf-8', 'big5'));
                    }
                    $licenseCode = $this->prefixCodes[substr($item[3], 0, 1)] . '0' . substr($item[3], 2, 5);
                    $suffix = substr($item[3], -3);

                    if (!isset($result[$licenseCode])) {
                        $result[$licenseCode] = array();
                    }
                    if (!isset($result[$licenseCode][$suffix])) {
                        $result[$licenseCode][$suffix] = array();
                    }
                    $result[$licenseCode][$suffix][$item[6]] = $item;
                }
                fclose($fh);
            }
            foreach ($result AS $licenseCode => $suffixes) {
                foreach ($suffixes AS $suffix => $items) {
                    ksort($result[$licenseCode][$suffix]);
                }
                ksort($result[$licenseCode]);
            }
            ksort($result);
            $fh = fopen("{$targetPath}/licenses.csv", 'w');
            foreach ($result AS $licenseCode => $suffixes) {
                foreach ($suffixes AS $suffix => $items) {
                    foreach ($items AS $item) {
                        fputcsv($fh, array_merge(array($licenseCode, $suffix), $item));
                    }
                }
            }
            fclose($fh);
        }
    }

    public function hospitals() {
        $tmpPath = TMP . 'nhi/hospitals';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/nhi/points';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $listUrl = 'http://www.nhi.gov.tw/Query/query3_list.aspx?&PageNum=32557';
        $listFile = $tmpPath . '/list';
        if (!file_exists($listFile)) {
            file_put_contents($listFile, file_get_contents($listUrl));
        }
        $list = file_get_contents($listFile);
        $http = new HttpSocket();
        $fh = fopen(__DIR__ . '/data/nhi/points.csv', 'w');
        fputcsv($fh, array(
            '醫事機構代碼',
            '醫事機構名稱',
            '特約類別',
            '電話',
            '地址',
        ));

        $token = 'Query3_Detail.aspx?HospID=';
        $tokenLength = strlen($token);
        $pos = strpos($list, $token);
        $count = 0;
        while (false !== $pos) {
            $pos += $tokenLength;
            $posEnd = strpos($list, '\'', $pos);
            $nhiId = substr($list, $pos, $posEnd - $pos);
            ++$count;
            echo "processing {$nhiId} [{$count}]\n";
            $hospitalUrl = 'http://www.nhi.gov.tw/Query/Query3_Detail.aspx?HospID=' . $nhiId;
            $hospitalFile = $tmpPath . '/d_' . md5($hospitalUrl);
            if (!file_exists($hospitalFile) || filesize($hospitalFile) === 0) {
                $response = $http->get($hospitalUrl);
                if ($response->isOk()) {
                    file_put_contents($hospitalFile, $response->body);
                }
            }
            if (file_exists($hospitalFile) && filesize($hospitalFile) > 0) {
                $data = array(
                    'nhi_id' => $nhiId,
                    'url' => $hospitalUrl,
                    'type' => '',
                    'name' => '',
                    'category' => '',
                    'biz_type' => '',
                    'service' => '',
                    'phone' => '',
                    'address' => '',
                    'latitude' => '',
                    'longitude' => '',
                    'nhi_admin' => '',
                    'nhi_end' => '',
                );
                $hospital = file_get_contents($hospitalFile);
                $pos = strpos($hospital, 'new google.maps.LatLng(');
                if (false !== $pos) {
                    $pos += 23;
                    list($data['latitude'], $data['longitude']) = explode(', ', substr($hospital, $pos, strpos($hospital, ')', $pos) - $pos));
                }
                $lines = explode('</tr>', $hospital);
                $lineNo = 0;
                foreach ($lines AS $line) {
                    ++$lineNo;
                    $cols = explode('</td>', $line);
                    switch ($lineNo) {
                        case 1:
                            unset($cols[0]);
                            break;
                        case 2:
                            $data['name'] = html_entity_decode(trim(strip_tags($cols[1])));
                            break;
                        case 3:
                            $data['biz_type'] = html_entity_decode(trim(strip_tags($cols[1])));
                            $data['phone'] = html_entity_decode(trim(strip_tags($cols[3])));
                            break;
                        case 4:
                            $data['address'] = html_entity_decode(trim(strip_tags($cols[1])));
                            break;
                        case 5:
                            $data['nhi_admin'] = html_entity_decode(trim(strip_tags($cols[1])));
                            $data['type'] = html_entity_decode(trim(strip_tags($cols[3])));
                            break;
                        case 6:
                            $data['service'] = html_entity_decode(trim(strip_tags($cols[1])));
                            break;
                        case 7:
                            $data['category'] = html_entity_decode(trim(strip_tags($cols[1])));
                            $data['nhi_end'] = html_entity_decode(trim(strip_tags($cols[3])));
                            break;
                        case 9:
                            foreach ($cols AS $k => $v) {
                                $cols[$k] = str_replace('&nbsp;', '', trim(strip_tags($v)));
                            }
                            unset($cols[0]);
                            unset($cols[8]);
                            $data['morning'] = $cols;
                            break;
                        case 10:
                            foreach ($cols AS $k => $v) {
                                $cols[$k] = str_replace('&nbsp;', '', trim(strip_tags($v)));
                            }
                            unset($cols[0]);
                            unset($cols[8]);
                            $data['afternoon'] = $cols;
                            break;
                        case 11:
                            foreach ($cols AS $k => $v) {
                                $cols[$k] = str_replace('&nbsp;', '', trim(strip_tags($v)));
                            }
                            unset($cols[0]);
                            unset($cols[8]);
                            $data['evening'] = $cols;
                            break;
                    }
                }
                fputcsv($fh, array(
                    $data['nhi_id'],
                    $data['name'],
                    $data['type'],
                    $data['phone'],
                    $data['address'],
                ));
                file_put_contents($targetPath . '/' . $data['nhi_id'] . '.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }

            $pos = strpos($list, $token, $posEnd);
        }
    }

    public function drug_rank() {
        $tmpPath = TMP . 'nhi';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/nhi/drug_rank';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $listFile = $tmpPath . '/list';
        if (!file_exists($listFile)) {
            file_put_contents($listFile, file_get_contents('http://www.nhi.gov.tw/webdata/webdata.aspx?menu=21&menu_id=713&webdata_id=2922'));
        }
        $list = file_get_contents($listFile);
        $pos = strpos($list, '/Resource/webdata/');
        while (false !== $pos) {
            $posEnd = strpos($list, '"', $pos);
            $pdfUrl = 'http://www.nhi.gov.tw' . substr($list, $pos, $posEnd - $pos);
            $sPos = strrpos($pdfUrl, '/') + 1;
            $pdfUrl = substr($pdfUrl, 0, $sPos) . urlencode(substr($pdfUrl, strrpos($pdfUrl, '/') + 1));
            $pdfFile = $tmpPath . '/' . md5($pdfUrl) . '.pdf';
            $txtFile = $pdfFile . '.txt';
            if (!file_exists($pdfFile)) {
                file_put_contents($pdfFile, file_get_contents($pdfUrl));
            }
            if (!file_exists($txtFile)) {
                exec("java -cp /usr/share/java/commons-logging.jar:/usr/share/java/fontbox.jar:/usr/share/java/pdfbox.jar org.apache.pdfbox.PDFBox ExtractText {$pdfFile} {$txtFile}");
            }
            $txt = file_get_contents($txtFile);
            $pages = explode('年特約醫療院所申報藥品數量統計', $txt);
            $year = trim(array_shift($pages));
            $fh = fopen($targetPath . '/' . $year . '.csv', 'w');
            fputcsv($fh, array(
                '藥品分類分組名稱',
                '醫令申報數量'
            ));
            foreach ($pages AS $page) {
                $page = substr($page, 0, strrpos($page, '資料來源'));
                $lines = explode("\n{$year}", $page);
                foreach ($lines AS $line) {
                    preg_match_all('/([0-9,]+)/', $line, $matches, PREG_OFFSET_CAPTURE);
                    if (!empty($matches[1])) {
                        $noField = array_pop($matches[1]);
                        $nameField = str_replace("\n", '', trim(substr($line, 0, $noField[1])));
                        $noField = preg_replace('/[^0-9]/', '', $noField[0]);
                        fputcsv($fh, array(
                            $nameField,
                            $noField,
                        ));
                    }
                }
            }

            $pos = strpos($list, '/Resource/webdata/', $posEnd);
        }
    }

}
