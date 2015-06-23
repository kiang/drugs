<?php

class ArticleShell extends AppShell {

    public $uses = array('Article');
    public $dataPath = '/home/kiang/github/data.fda.gov.tw-list';

    public function main() {
        $this->fixLinks();
    }

    public function fixLinks() {
        $articles = $this->Article->find('all', array(
            'fields' => array('Article.id'),
            'contain' => array('ArticlesLink'),
        ));
        foreach ($articles AS $article) {
            $vendors = $licenses = array();
            foreach ($article['ArticlesLink'] AS $link) {
                switch ($link['model']) {
                    case 'License':
                        $licenses[$link['foreign_id']] = $link['foreign_id'];
                        break;
                    case 'Vendor':
                        $vendors[$link['foreign_id']] = $link['foreign_id'];
                        break;
                }
            }
            if (!empty($licenses)) {
                $licenseVendors = $this->Article->License->find('all', array(
                    'conditions' => array('License.id' => $licenses),
                    'fields' => array('License.vendor_id'),
                    'contain' => array(
                        'Drug' => array(
                            'fields' => array('Drug.vendor_id'),
                        ),
                    ),
                ));
                $newVendors = array();
                foreach ($licenseVendors AS $licenseVendor) {
                    if (!isset($vendors[$licenseVendor['License']['vendor_id']])) {
                        $newVendors[$licenseVendor['License']['vendor_id']] = $licenseVendor['License']['vendor_id'];
                    }
                    foreach ($licenseVendor['Drug'] AS $drug) {
                        if (!isset($vendors[$drug['vendor_id']])) {
                            $newVendors[$drug['vendor_id']] = $drug['vendor_id'];
                        }
                    }
                }
                if (!empty($newVendors)) {
                    foreach ($newVendors AS $newVendor) {
                        $this->Article->ArticlesLink->create();
                        $this->Article->ArticlesLink->save(array('ArticlesLink' => array(
                                'article_id' => $article['Article']['id'],
                                'model' => 'Vendor',
                                'foreign_id' => $newVendor,
                        )));
                    }
                }
            }
        }
    }

    public function data31() {
        $fh = fopen($this->dataPath . '/dataset/31.csv', 'r');
        $records = array();
        $previousKey = 0;
        //類別、藥品製造許可編號、藥品製造許可有效期限、名稱、地址、電話、核准劑型、備註
        while ($line = fgetcsv($fh, 4096, "\t")) {
            if (isset($line[1]) && substr($line[1], 0, 1) === '(') {
                ++$previousKey;
                $records[$previousKey] = $line;
            } else {
                foreach ($line AS $p) {
                    $p = trim($p);
                    if (!empty($p)) {
                        $records[$previousKey][6] .= "\n{$p}";
                    }
                }
            }
        }
        foreach ($records AS $record) {
            $dateParts = preg_split('/(年|月|日)/', $record[2]);
            $recordTime = mktime(0, 0, 0, $dateParts[1], $dateParts[2], $dateParts[0] + 1911);
            if (!isset($record[7])) {
                $record[7] = '';
            }
            $body = implode("\n", array(
                "類別： {$record[0]}",
                "藥品製造許可編號： {$record[1]}",
                "藥品製造許可有效期限： {$record[2]}",
                "名稱： {$record[3]}",
                "地址： {$record[4]}",
                "電話： {$record[5]}",
                "核准劑型： \n{$record[6]}\n",
                "備註： {$record[7]}"
            ));
            switch ($record[3]) {
                case '台灣大塚製藥股份有限公司中壢工廠':
                    $record[3] = '臺灣大塚製藥股份有限公司中壢工廠';
                    break;
                case '台灣田邊製藥股份有限公司新竹廠':
                    $record[3] = '臺灣田邊製藥股份有限公司新竹廠';
                    break;
                case '台灣東洋藥品工業股份有限公司六堵廠':
                    $record[3] = '臺灣東洋藥品工業股份有限公司六堵廠';
                    break;
                case '高氧實業有限公司岡山本洲廠':
                    $record[3] = '高氧實業有限公司';
                    break;
                case '聯華氣體工業股份有限公司高雄廠':
                    $record[3] = '聯華氣體工業股份有限公司高雄工廠';
                    break;
                case '臺北氧氣股份有限公司大肚廠':
                    $record[3] = '台北氧氣股份有限公司大肚廠';
                    break;
                case '藍海氣體工業股份有限公司台中廠':
                    $record[3] = '藍海氣體工業股份有限公司 台中廠';
                    break;
            }
            $this->Article->create();
            if ($this->Article->save(array('Article' => array(
                            'title' => "{$record[0]}許可編號{$record[1]}",
                            'body' => $body,
                            'date_published' => date('Y-m-d', $recordTime),
                )))) {
                $articleId = $this->Article->getInsertID();
                $vendors = $this->Article->Vendor->find('list', array(
                    'fields' => array('Vendor.id', 'Vendor.id'),
                    'conditions' => array(
                        'Vendor.name' => $record[3],
                    ),
                ));
                if (count($vendors) > 0) {
                    foreach ($vendors AS $vendorId) {
                        $this->Article->ArticlesLink->create();
                        $this->Article->ArticlesLink->save(array('ArticlesLink' => array(
                                'article_id' => $articleId,
                                'model' => 'Vendor',
                                'foreign_id' => $vendorId,
                        )));
                    }
                }
            }
        }
    }

    public function data45() {
        $dateLatestFile = __DIR__ . '/data/keys/articles_45_latest.txt';
        $dateLatest = false;
        if (file_exists($dateLatestFile)) {
            $dateLatest = strtotime(trim(file_get_contents($dateLatestFile)));
        }

        $currentLatest = 0;
        $fh = fopen($this->dataPath . '/dataset/45.csv', 'r');
        //廠名、地址、查廠日期、發佈日期、類別
        while ($line = fgetcsv($fh, 2048, "\t")) {
            foreach ($line AS $k => $v) {
                $line[$k] = trim($v);
            }
            $recordTime = strtotime(implode('-', array(
                substr($line[3], 0, 3) + 1911,
                substr($line[3], 3, 2),
                substr($line[3], 5, 2)
            )));
            if (false === $dateLatest || $recordTime > $dateLatest) {
                if ($recordTime > $currentLatest) {
                    $currentLatest = $recordTime;
                }
                switch ($line[0]) {
                    case '聯華氣體工業股份有限公司高雄廠':
                        $line[0] = '聯華氣體工業股份有限公司高雄工廠';
                        break;
                    case 'Teika Pharmaceutical. Co., Ltd.':
                        $line[0] = 'TEIKA PHARMACEUTICAL CO.,LTD.';
                        break;
                }
                $body = implode("\n", array(
                    "廠名： {$line[0]}",
                    "地址： {$line[1]}",
                    "查廠日期： {$line[2]}",
                    "發佈日期： {$line[3]}",
                    "類別： {$line[4]}"
                ));
                $this->Article->create();
                if ($this->Article->save(array('Article' => array(
                                'title' => '嚴重違反GMP藥廠公告',
                                'body' => $body,
                                'date_published' => date('Y-m-d', $recordTime),
                    )))) {
                    $articleId = $this->Article->getInsertID();
                    $vendors = $this->Article->Vendor->find('list', array(
                        'fields' => array('Vendor.id', 'Vendor.id'),
                        'conditions' => array(
                            'Vendor.name' => $line[0],
                        ),
                    ));
                    if (count($vendors) > 0) {
                        foreach ($vendors AS $vendorId) {
                            $this->Article->ArticlesLink->create();
                            $this->Article->ArticlesLink->save(array('ArticlesLink' => array(
                                    'article_id' => $articleId,
                                    'model' => 'Vendor',
                                    'foreign_id' => $vendorId,
                            )));
                        }
                    }
                }
            }
        }
        if ($currentLatest > 0) {
            file_put_contents($dateLatestFile, date('Y-m-d', $currentLatest));
        }
    }

    public function data65() {
        $dateLatestFile = __DIR__ . '/data/keys/articles_65_latest.txt';
        $dateLatest = false;
        if (file_exists($dateLatestFile)) {
            $dateLatest = strtotime(trim(file_get_contents($dateLatestFile)));
        }

        $fh = fopen($this->dataPath . '/dataset/65.csv', 'r');
        $currentLatest = 0;
        //燈號、標題名稱、內容、附檔、更新日期
        while ($line = fgetcsv($fh, 30000, "\t")) {
            $recordTime = strtotime($line[4]);
            if (false === $dateLatest || $recordTime > $dateLatest) {
                if ($recordTime > $currentLatest) {
                    $currentLatest = $recordTime;
                }
                $this->Article->create();
                $this->Article->save(array('Article' => array(
                        'id' => String::uuid(),
                        'title' => '[國際藥品]' . $line[1],
                        'body' => $line[2],
                        'date_published' => $line[4],
                )));
            }
        }
        if ($currentLatest > 0) {
            file_put_contents($dateLatestFile, date('Y-m-d', $currentLatest));
        }
    }

    public function data34() {
        $keys = array();
        $keysFile = __DIR__ . '/data/keys/articles.csv';
        if (file_exists($keysFile)) {
            $fh = fopen($keysFile, 'r');
            while ($line = fgetcsv($fh, 2048)) {
                $keys[$line[0]] = $line[1];
            }
            fclose($fh);
        }

        $fh = fopen($this->dataPath . '/dataset/34.csv', 'r');
        $max = 0;
        //回收分級、文號、日期、產品、許可證字號、批號、許可證持有者、原因
        $licenseUUID = array();
        while ($line = fgetcsv($fh, 4096, "\t")) {
            if (!isset($keys[$line[1]])) {
                if (empty($line[4])) {
                    continue;
                }
                $licenseId = preg_split('/(；|、|\\.| )/', $line[4]);
                $licenseId = array_combine(array_values($licenseId), array_values($licenseId));
                $licensePk = array();
                foreach ($licenseId AS $k => $v) {
                    if (preg_match('/[0-9]{5,}/', $v, $matches, PREG_OFFSET_CAPTURE)) {
                        if (false === strpos($v, '字')) {
                            $keywords = array(
                                substr($v, 0, $matches[0][1]),
                                $matches[0][0],
                                substr($v, $matches[0][1] + strlen($matches[0][0])),
                            );
                            $conditions = array();
                            foreach ($keywords AS $keyword) {
                                $keyword = trim($keyword);
                                if (!empty($keyword)) {
                                    $conditions[] = "License.license_id LIKE '%{$keyword}%'";
                                }
                            }
                            $pk = $this->Article->License->field('id', $conditions);
                            if (!empty($pk)) {
                                $licensePk[] = $pk;
                            }
                        } else {
                            $pk = $this->Article->License->field('id', array("License.license_id LIKE '%{$v}%'"));
                            if (!empty($pk)) {
                                $licensePk[] = $pk;
                            }
                        }
                    } else {
                        $pos = strpos($v, '全廠所有產品');
                        if (false !== $pos) {
                            $keyword = substr($v, 0, $pos);
                            $licensePk = $this->Article->License->Drug->find('list', array(
                                'fields' => array('license_id', 'license_id'),
                                'conditions' => array('manufacturer LIKE' => "%{$keyword}%"),
                                'group' => array('license_id'),
                            ));
                        }
                    }
                }
                $keys[$line[1]] = String::uuid();
                $body = implode("\n", array(
                    "回收分級：{$line[0]}",
                    "文號：{$line[1]}",
                    "產品：{$line[3]}",
                    "許可證字號：{$line[4]}",
                    "批號：{$line[5]}",
                    "許可證持有者：{$line[6]}",
                    "原因：{$line[7]}",
                ));
                $this->Article->create();
                if ($this->Article->save(array('Article' => array(
                                'id' => $keys[$line[1]],
                                'title' => '[回收藥品]' . $line[7],
                                'body' => $body,
                                'date_published' => $line[2],
                    )))) {
                    if (!empty($licensePk)) {
                        foreach ($licensePk AS $uuid) {
                            $this->Article->ArticlesLink->create();
                            $this->Article->ArticlesLink->save(array('ArticlesLink' => array(
                                    'article_id' => $keys[$line[1]],
                                    'model' => 'License',
                                    'foreign_id' => $uuid,
                            )));
                        }
                    }
                }
            }
        }
        fclose($fh);
        $fh = fopen($keysFile, 'w');
        foreach ($keys AS $k => $v) {
            fputcsv($fh, array($k, $v));
        }
        fclose($fh);
    }

}
