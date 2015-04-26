<?php

App::uses('HttpSocket', 'Network/Http');

class AmShell extends AppShell {

    public $uses = array();

    public function main() {
        $this->searchDrug();
        $this->extractDrug();
    }

    public function extractDrug() {
        $tmpPath = TMP . 'am/p';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/am/drug';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $colKeys = array(
            '許可證字號:' => '許可證字號',
            '動物用藥品名稱:' => '動物用藥品名稱',
            '英文名稱:' => '英文名稱',
            '業者名稱:' => '業者名稱',
            '地址:' => '地址',
            '製造廠名稱:' => '製造廠名稱',
            '地址:' => '地址',
            '劑型:' => '劑型',
            '包裝:' => '包裝',
            '效能(適應症):' => '效能(適應症)',
            '成分:' => '成分',
            '核發日期:' => '核發日期',
            '有效期間:' => '有效期間',
            '外銷專用:' => '外銷專用',
        );
        $fh = fopen($targetPath . '.csv', 'w');
        fputcsv($fh, array(
            'id',
            '許可證字號',
            '動物用藥品名稱',
            '英文名稱',
            '業者名稱',
            '有效期間',
            '官方網址',
        ));
        foreach (glob(TMP . 'am/doc/page_*') AS $pageFile) {
            if (filesize($pageFile) < 500) {
                unlink($pageFile);
                continue;
            }
            $page = file_get_contents($pageFile);
            $page = substr($page, strpos($page, '<table cellspacing="0" cellpadding="4" border="0" id="ctl00_ContentPlaceHolder1_GridView1"'));
            $lines = explode('</tr>', $page);
            foreach ($lines AS $line) {
                $cols = explode('</td>', $line);
                if (isset($cols[1]) && false !== strpos($cols[0], 'MedLicContent.aspx?')) {
                    $cols[5] = explode('MedLicContent.aspx?', $cols[0])[1];
                    $cols[5] = str_replace('&amp;', '&', substr($cols[5], 0, strpos($cols[5], '&quot;')));
                    list($cols[1], $cols[4]) = explode('<br />', $cols[1]);
                    foreach ($cols AS $k => $v) {
                        $cols[$k] = trim(strip_tags($v));
                    }
                    $tmpFile = "{$tmpPath}/" . md5($cols[5]);
                    if (!file_exists($tmpFile)) {
                        file_put_contents($tmpFile, file_get_contents('http://amdrug.baphiq.gov.tw/Animal/MedLicContent.aspx?' . $cols[5]));
                        $this->out("got {$cols[5]}");
                    }
                    $doc = file_get_contents($tmpFile);
                    $doc = substr($doc, strpos($doc, '<table cellpadding="0" cellspacing="0" class="tblContent" width="100%" align="center">'));
                    $drugLines = explode('</tr>', $doc);
                    $drugData = array();
                    foreach ($drugLines AS $drugLine) {
                        $docCols = explode('</td>', $drugLine);
                        foreach ($docCols AS $docK => $docCol) {
                            $docCols[$docK] = trim(strip_tags($docCol));
                        }
                        if (count($docCols) > 1 && !empty($docCols[0])) {
                            if ($docCols[0] === '成分:') {
                                $drugData['ingredients'] = array();
                                $containPos = strpos($docCols[1], 'CONTAIN');
                                if (false !== $containPos) {
                                    $containPos = strpos($docCols[1], ':', $containPos);
                                    $containPos += 1;
                                    $drugData[$colKeys[$docCols[0]]] = trim(substr($docCols[1], 0, $containPos));
                                    $drugData['ingredients'][] = array(
                                        trim(substr($docCols[1], $containPos)), $docCols[2]
                                    );
                                } else {
                                    $drugData[$colKeys[$docCols[0]]] = $docCols[1];
                                }
                            } elseif (!isset($colKeys[$docCols[0]])) {
                                $drugData['ingredients'][] = array(
                                    $docCols[0], $docCols[1]
                                );
                            } else {
                                $drugData[$colKeys[$docCols[0]]] = $docCols[1];
                            }
                        }
                    }
                    $drugData['url'] = 'http://amdrug.baphiq.gov.tw/Animal/MedLicContent.aspx?' . $cols[5];
                    parse_str($cols[5], $params);
                    fputcsv($fh, array(
                        implode('', $params),
                        $drugData['許可證字號'],
                        $drugData['動物用藥品名稱'],
                        $drugData['英文名稱'],
                        $drugData['業者名稱'],
                        $drugData['有效期間'],
                        $drugData['url'],
                    ));
                    file_put_contents($targetPath . '/' . implode('', $params) . '.json', json_encode($drugData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                }
            }
        }
        fclose($fh);
    }

    public function searchDrug() {
        $tmpPath = TMP . 'am/doc';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $query = array(
            '__EVENTTARGET' => 'ctl00$ContentPlaceHolder1$GridView1',
            '__EVENTARGUMENT' => 'Page$1',
            '__VIEWSTATE' => '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',
            '__VIEWSTATEGENERATOR' => '7B80D469',
            '__EVENTVALIDATION' => '/wEWJALh04u/BAKtyPvgBAKip9GOCAKjp9GOCAKI+rnuBwLm842OCQL/4vezAwLp9NXBAQLn9Pn1DwKR5ZjzCQLMl5ybAwLOl7CbAwLCl4ibAwLDl4ibAwLBl7ibAwLm8ImPCwKRg4GOCwLojoGSCwKLzr7SCwKKzv7SCwLF6dHUCwK8zpLVCwK/zdLVCwL+qfiIAQKhsbiJAQLNq9nVCALNq9HVCALNq8XVCALNq8nVCALNq93VCALNq8HVCALNq/XVCALNq/nVCAKjoZ3lCQLIiL+YDALRssiQDkaRUhtgyT4rdmpk5S4quBmjvNPP',
            'ctl00$ContentPlaceHolder1$dplLicType' => '',
            'ctl00$ContentPlaceHolder1$txtLicID' => '',
            'ctl00$ContentPlaceHolder1$tbxPRO21' => '',
            'ctl00$ContentPlaceHolder1$txtCname' => '',
            'ctl00$ContentPlaceHolder1$txtPRO35' => '',
            'ctl00$ContentPlaceHolder1$txtPRV11' => '',
        );
        for ($i = 1; $i <= 1220; $i ++) {
            if (file_exists("{$tmpPath}/page_{$i}") && filesize("{$tmpPath}/page_{$i}") > 1000) {
                continue;
            }
            $query['__EVENTTARGET'] = 'ctl00$ContentPlaceHolder1$GridView1';
            $query['__EVENTARGUMENT'] = 'Page$' . $i;

            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n"
                    . "Cookie: __utma=117274262.69300138.1430066521.1430066521.1430066521.1; __utmb=117274262.18.10.1430066521; __utmc=117274262; __utmz=117274262.1430066521.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none); __utmt=1\r\n"
                    . "Referer: http://amdrug.baphiq.gov.tw/Animal/AMItem4.aspx\r\n"
                    . "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8\r\n"
                    . "Accept-Language: en-US,en;q=0.5\r\n"
                    . "User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:37.0) Gecko/20100101 Firefox/37.0\r\n",
                    'content' => http_build_query($query),
                )
            );

            $context = stream_context_create($opts);

            $result = file_get_contents('http://amdrug.baphiq.gov.tw/Animal/AMItem4.aspx', false, $context);

            file_put_contents("{$tmpPath}/page_{$i}", $result);

            $pos = strpos($result, 'type="hidden"');
            while (false !== $pos) {
                $posEnd = strpos($result, '/>', $pos);
                $parts = preg_split('/ +/', substr($result, $pos, $posEnd - $pos));
                $currentName = $currentValue = '';
                foreach ($parts AS $part) {
                    $pair = array();
                    $pair[0] = substr($part, 0, strpos($part, '='));
                    $pair[1] = substr($part, strpos($part, '=') + 1);
                    switch ($pair[0]) {
                        case 'name':
                            $currentName = substr($pair[1], 1, -1);
                            break;
                        case 'value':
                            $currentValue = substr($pair[1], 1, -1);
                            break;
                    }
                }
                if (!empty($currentName) && isset($query[$currentName])) {
                    $query[$currentName] = $currentValue;
                }
                $pos = strpos($result, 'type="hidden"', $posEnd);
            }

            $this->out("got page {$i}");
        }
    }

}
