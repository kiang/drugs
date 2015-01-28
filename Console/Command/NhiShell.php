<?php

App::uses('HttpSocket', 'Network/Http');

class NhiShell extends AppShell {

    public $uses = array('License');

    public function main() {
        $this->hospitals();
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
        $listUrl = 'http://www.nhi.gov.tw/Query/query3_list.aspx?&PageNum=30200';
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
