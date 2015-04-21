<?php

App::uses('HttpSocket', 'Network/Http');

class MohwShell extends AppShell {

    public $uses = array('License');
    public $mysqli = false;
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
        $this->getLicenseHtml();
        $this->extractLicenseHtml();
        //$this->importDrug();
        //$this->importIngredients();
        //$this->importNhiCodes();
    }

    public function importNhiCodes() {
        $tmpPath = TMP . 'mohw/nhi';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/mohw/nhi';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $listUrl = 'http://www.nhi.gov.tw/webdata/webdata.aspx?menu=21&menu_id=713&WD_ID=849&webdata_id=932';
        $listFile = $tmpPath . '/list';
        if (!file_exists($listFile)) {
            file_put_contents($listFile, file_get_contents($listUrl));
        }

        $licenses = $this->License->find('list', array(
            'fields' => array('License.id', 'License.name'),
            'conditions' => array(
                "License.package_note NOT LIKE '%外銷%'",
                'OR' => array(
                    'License.nhi_id IS NULL',
                    'License.nhi_id' => '',
                )),
        ));

        $list = file_get_contents($listFile);
        $pos = strpos($list, '/Resource/webdata/');
        $toReplace = array('〞', '“', '”', '〝', '『', '』', '\'', '(', ')', '（', '）');
        while (false !== $pos) {
            $posEnd = strpos($list, '"', $pos);
            $fileUrl = 'http://www.nhi.gov.tw' . substr($list, $pos, $posEnd - $pos);
            if (substr($fileUrl, -3) === 'xls') {
                $csvFile = $targetPath . '/' . md5($fileUrl) . '.csv';
                if (!file_exists($csvFile)) {
                    $filePath = $tmpPath . '/' . md5($fileUrl) . '.xls';
                    if (!file_exists($filePath)) {
                        $fileUrlParts = explode('/', $fileUrl);
                        end($fileUrlParts);
                        $endKey = key($fileUrlParts);
                        $fileUrlParts[$endKey] = urlencode($fileUrlParts[$endKey]);
                        file_put_contents($filePath, file_get_contents(implode('/', $fileUrlParts)));
                    }
                    exec("/usr/bin/libreoffice --headless --convert-to csv --infilter=CSV:44,34,big5 $filePath --outdir $targetPath");
                }
                $fh = fopen($csvFile, 'r');
                fgetcsv($fh, 2048);
                /*
                 * (
                  [0] => 藥品代碼
                  [1] => 中文名稱
                  [2] => 劑型
                  [3] => 製造廠名稱
                  [4] => 發證日期
                  [5] => 有效期間
                  [6] => 收載日
                  [7] => 不再收載日
                  [8] => 備註
                  )
                 */
                while ($line = fgetcsv($fh, 2048)) {
                    $line[1] = str_replace($toReplace, '"', $line[1]);
                    $keywords = preg_split('/["]+/', $line[1]);
                    if (count($keywords) === 1) {
                        $prefix = mb_substr($keywords[0], 0, 2, 'utf-8');
                        switch ($prefix) {
                            case '順然':
                            case '壽美':
                            case '富田':
                            case '三帆':
                            case '華昌':
                                $keywords = array(
                                    mb_substr($keywords[0], 0, 2, 'utf-8'),
                                    mb_substr($keywords[0], 2, null, 'utf-8')
                                );
                                break;
                            case '順天':
                            case '香生':
                                $keywords = array(
                                    mb_substr($keywords[0], 0, 3, 'utf-8'),
                                    mb_substr($keywords[0], 3, null, 'utf-8')
                                );
                                break;
                        }
                    }
                    $matches = false;
                    foreach ($keywords AS $keyword) {
                        if (!empty($keyword)) {
                            if (false === $matches) {
                                $matches = array();
                                foreach ($licenses AS $licenseId => $name) {
                                    if (false !== strpos($name, $keyword)) {
                                        $matches[$licenseId] = $name;
                                    }
                                }
                            } elseif (!empty($matches)) {
                                foreach ($matches AS $licenseId => $name) {
                                    if (false === strpos($name, $keyword)) {
                                        unset($matches[$licenseId]);
                                    }
                                }
                            }
                        }
                    }
                    if (count($matches) === 1) {
                        $this->License->id = key($matches);
                        echo "{$this->License->id} => {$line[0]}\n";
                        $this->License->saveField('nhi_id', $line[0]);
                    }
                }
                fclose($fh);
            }
            $pos = strpos($list, '/Resource/webdata/', $posEnd);
        }
    }

    public function importIngredients() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $valueStack = $ingredientKeys = $newIngredients = array();

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
        $sn = 1;
        foreach (glob(__DIR__ . '/data/mohw/license/*/*.json') AS $jsonFile) {
            $p = pathinfo($jsonFile);
            $json = json_decode(file_get_contents($jsonFile), true);
            foreach ($json['ingredients'] AS $ingredient) {
                foreach ($ingredient AS $k => $v) {
                    $ingredient[$k] = trim(str_replace('&nbsp;', '', $v));
                }
                if (!empty($ingredient[1])) {
                    $ingredientKey = $ingredient[0];
                    if (!isset($ingredientKeys[$ingredientKey])) {
                        $ingredientKeys[$ingredientKey] = array(
                            'id' => String::uuid(),
                            'count_licenses' => 0,
                        );
                        $newIngredients[] = $ingredientKey;
                    }
                    $ingredientKeys[$ingredientKey]['count_licenses'] += 1;

                    $currentId = String::uuid();
                    $valueStack[] = implode(',', array(
                        "('{$currentId}'", //id
                        "'{$p['filename']}'", //license_id
                        "'{$ingredientKeys[$ingredientKey]['id']}'", //ingredient_id
                        "NULL", //remark
                        "'{$ingredient[0]}'", //name
                        "'{$ingredient[1]}'", //dosage_text
                        "'{$ingredient[1]}'", //dosage
                        "'{$ingredient[2]}')", //unit
                    ));
                    ++$sn;
                    if ($sn > 50) {
                        $sn = 1;
                        $this->dbQuery('INSERT INTO `ingredients_licenses` VALUES ' . implode(',', $valueStack) . ';');
                        $valueStack = array();
                    }
                }
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `ingredients_licenses` VALUES ' . implode(',', $valueStack) . ';');
        }
        $valueStack = array();
        $sn = 1;
        foreach ($newIngredients AS $newIngredient) {
            $name = $this->mysqli->real_escape_string($newIngredient);
            $valueStack[] = implode(',', array(
                "('{$ingredientKeys[$newIngredient]['id']}'", //ingredient_id
                "'{$name}'", //name
                "'{$ingredientKeys[$newIngredient]['count_licenses']}'", //count_licenses
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

    public function importDrug() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $valueStack = $licenseData = $vendorKeys = $vendorStack = array();
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
        $sn = 1;
        foreach (glob(__DIR__ . '/data/mohw/license/*/*.json') AS $jsonFile) {
            $p = pathinfo($jsonFile);
            $json = json_decode(file_get_contents($jsonFile), true);
            if (empty($json['license']['許可證字號'])) {
                continue;
            }
            $json['license']['發證日期'] = date('Y-m-d', strtotime($json['license']['發證日期']));
            $json['license']['有效日期'] = date('Y-m-d', strtotime($json['license']['有效日期']));

            $vendorKey1 = $json['license']['申請商名稱'];
            $vendorKey2 = $json['license']['製造廠名稱'];
            if (!isset($vendorKeys[$vendorKey1])) {
                $vendorKeys[$vendorKey1] = String::uuid();
            }
            if (!isset($vendorKeys[$vendorKey2])) {
                $vendorKeys[$vendorKey2] = String::uuid();
            }

            foreach ($json['license'] AS $k => $v) {
                $json['license'][$k] = $this->mysqli->real_escape_string($v);
            }

            if (!isset($dbVendorKeys[$vendorKeys[$vendorKey2]]) && !isset($vendorStack[$vendorKey2])) {
                $vendorStack[$vendorKey2] = array(
                    'id' => $vendorKeys[$vendorKey2],
                    'tax_id' => '',
                    'name' => $json['license']['製造廠名稱'],
                    'address' => $json['license']['製造廠地址'],
                    'address_office' => '',
                    'country' => '',
                    'count_daily' => 0,
                    'count_all' => 0,
                );
            }
            if (!isset($dbVendorKeys[$vendorKeys[$vendorKey1]]) && !isset($vendorStack[$vendorKey1])) {
                $vendorStack[$vendorKey1] = array(
                    'id' => $vendorKeys[$vendorKey1],
                    'tax_id' => '',
                    'name' => $json['license']['申請商名稱'],
                    'address' => $json['license']['申請商地址'],
                    'address_office' => '',
                    'country' => '',
                    'count_daily' => 0,
                    'count_all' => 0,
                );
            }

            $dbCols = array(
                "('{$p['filename']}'", //id
                "'{$p['filename']}'", //license_id
                "'{$vendorKeys[$vendorKey2]}'", //vendor_id
                "NULL", //manufacturer_description
            );
            $disease = trim("{$json['license']['適應症']}\n{$json['license']['效能']}");

            $prefixCode = false;
            foreach ($this->prefixCodes AS $code => $prefix) {
                if (false === $prefixCode && false !== strpos($json['license']['許可證字號'], $prefix)) {
                    $prefixCode = $code;
                }
            }
            if (false !== $prefixCode) {
                preg_match('/[0-9]+/', $json['license']['許可證字號'], $match);
                $licenseCode = "{$prefixCode}{$match[0]}";
            } else {
                $licenseCode = '';
                echo "{$json['license']['許可證字號']} can't find prefix\n";
            }
            $nhiId = '';
            if (false !== strpos($json['license']['許可證字號'], '衛署藥製') || false !== strpos($json['license']['許可證字號'], '衛部藥製')) {
                $nhiId = 'A' . substr($licenseCode, 2);
            }
            $licenseData[] = array(
                "('{$p['filename']}'", //id
                "'{$json['license']['許可證字號']}'", //license_id
                "'{$licenseCode}'", //code
                "'mohw'", //source
                "'{$nhiId}'", //nhi_id
                "NULL", //shape
                "NULL", //s_type
                "NULL", //color
                "NULL", //odor
                "NULL", //abrasion
                "NULL", //size
                "NULL", //note_1
                "NULL", //note_2
                "NULL", //image
                "NULL", //cancel_status
                "NULL", //cancel_date
                "NULL", //cancel_reason
                "'{$json['license']['有效日期']}'", //expired_date
                "'{$json['license']['發證日期']}'", //license_date
                "'{$json['license']['類別']}'", //license_type
                "NULL", //old_id
                "NULL", //document_id
                "'{$json['license']['中文品名']}'", //name
                "'{$json['license']['英文品名']}'", //name_english
                "'{$disease}'", //disease
                "'{$json['license']['劑型']}'", //formulation
                "'{$json['license']['包裝']}'", //package
                "'{$json['license']['單複方']}'", //type
                "NULL", //class
                "NULL", //ingredient
                "'{$vendorKeys[$vendorKey1]}'", //vendor_id
                "'{$json['license']['發證日期']}'", //submitted
                "NULL", //usage
                "'{$json['license']['限制項目']}'", //package_note
                "NULL", //barcode
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

    public function extractLicenseHtml() {
        $targetPath = __DIR__ . '/data/mohw/license';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $mohwKeyFile = __DIR__ . '/data/keys/mohw_licenses.csv';
        $mohwKeys = array();
        if (file_exists($mohwKeyFile)) {
            $kFh = fopen($mohwKeyFile, 'r');
            while ($line = fgetcsv($kFh, 1024)) {
                $mohwKeys[$line[0]] = $line[1];
            }
            fclose($kFh);
        }
        $fh = fopen($targetPath . '_list.csv', 'w');
        fputcsv($fh, array(
            '許可證字號',
            '中文品名',
            '有效日期',
            '製造廠名稱',
            '檔案位置',
        ));
        foreach (glob(TMP . 'mohw/licenses/item*') AS $itemFile) {
            $data = array(
                'license' => array(),
                'ingredients' => array(),
            );
            $item = file_get_contents($itemFile);
            $pos = strpos($item, '<table');
            $posEnd = strrpos($item, '</table>');
            $tables = explode('<table', substr($item, $pos, $posEnd - $pos));
            /*
             * $tables[3] = detail
             * $tables[4] = ingredients
             */
            $details = explode('</tr>', $tables[3]);
            foreach ($details AS $line) {
                $cells = explode('</t', $line);
                if (count($cells) === 3) {
                    $cellKey = trim(str_replace('：', '', strip_tags(substr($cells[0], strpos($cells[0], '<')))));
                    $cellValue = trim(strip_tags(substr($cells[1], strpos($cells[1], '<'))));
                    $data['license'][$cellKey] = $cellValue;
                }
            }
            $ingredients = explode('</tr>', $tables[4]);
            foreach ($ingredients AS $line) {
                $cells = explode('</td>', $line);
                if (count($cells) === 4) {
                    foreach ($cells AS $k => $v) {
                        $cells[$k] = trim(strip_tags($v));
                    }
                    unset($cells[3]);
                    $data['ingredients'][] = $cells;
                }
            }
            $data['license']['許可證字號'] = $licenseId = str_replace(' ', '', $data['license']['許可證字號']);
            if (!isset($mohwKeys[$licenseId])) {
                $mohwKeys[$licenseId] = String::uuid();
            }
            $prefix = substr($mohwKeys[$licenseId], 14, 4);
            $jsonFile = "{$prefix}/{$mohwKeys[$licenseId]}.json";
            if (!file_exists($targetPath . '/' . $prefix)) {
                mkdir($targetPath . '/' . $prefix, 0777);
            }
            file_put_contents("{$targetPath}/{$jsonFile}", json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            fputcsv($fh, array(
                $data['license']['許可證字號'],
                $data['license']['中文品名'],
                $data['license']['有效日期'],
                $data['license']['製造廠名稱'],
                $jsonFile,
            ));
        }
        $kFh = fopen($mohwKeyFile, 'w');
        foreach ($mohwKeys AS $k => $v) {
            fputcsv($kFh, array($k, $v));
        }
        fclose($kFh);
    }

    public function getLicenseHtml() {
        $tmpPath = TMP . 'mohw/licenses';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $http = new HttpSocket();

        /*
         * Get the session keys
         */
        $formUrl = 'http://www.mohw.gov.tw/CHT/DOCMAP/query_liense.aspx?mode=1';

        //$form = file_get_contents($tmpPath . '/form.html');
        $form = $http->get($formUrl);
        file_put_contents($tmpPath . '/form.html', $form);
        $formValues = $this->getFormValues($form);

        /*
         * begin the search
         */
        $currentPage = $http->post($formUrl, $formValues);
        $pos = strpos($currentPage, '<span id="Paging1_lblTotalPage">') + 32;
        $pageCount = substr($currentPage, $pos, strpos($currentPage, '<', $pos) - $pos);
        for ($i = 1; $i <= $pageCount; $i++) {
            echo "processing page {$i} / {$pageCount}\n";
            $pageValues = $this->getFormValues($currentPage);
            unset($pageValues['btnBackQuery']);
            $pageValues['Paging1$ddlCurrentPage'] = $i;
            $pageValues['__EVENTTARGET'] = 'Paging1$ddlCurrentPage';
            $currentPage = $http->post($formUrl, $pageValues);
            file_put_contents($tmpPath . "/page{$i}.html", $currentPage);
            $baseItemValues = $this->getFormValues($currentPage);
            unset($baseItemValues['btnBackQuery']);
            $pos = strpos($currentPage, 'gv1$ctl');
            $itemCount = 0;
            while (false !== $pos) {
                ++$itemCount;
                $posEnd = strpos($currentPage, '\'', $pos);
                $newPageValues = $baseItemValues;
                $newPageValues['Paging1$ddlCurrentPage'] = $i;
                $newPageValues['__EVENTTARGET'] = substr($currentPage, $pos, $posEnd - $pos);

                $item = $http->post($formUrl, $newPageValues);
                file_put_contents($tmpPath . "/item{$i}-{$itemCount}.html", $item);

                $pos = strpos($currentPage, 'gv1$ctl', $posEnd);
            }
        }
    }

    public function getFormValues($form) {
        $formValues = array();
        $inputPos = strpos($form, '<input');
        while (false !== $inputPos) {
            $inputPos = strpos($form, 'name=', $inputPos) + 5;
            $inputPosEnd = strpos($form, ' ', $inputPos);
            $name = trim(substr($form, $inputPos, $inputPosEnd - $inputPos), '"');
            $inputPos = strpos($form, 'value=', $inputPos) + 6;
            $inputPosEnd = strpos($form, ' ', $inputPos);
            $formValues[$name] = trim(substr($form, $inputPos, $inputPosEnd - $inputPos), '"');
            $inputPos = strpos($form, '<input', $inputPosEnd);
        }
        $selectPos = strpos($form, '<select');
        while (false !== $selectPos) {
            $selectPos = strpos($form, 'name=', $selectPos) + 5;
            $selectPosEnd = strpos($form, ' ', $selectPos);
            $name = trim(substr($form, $selectPos, $selectPosEnd - $selectPos), '"');
            $formValues[$name] = '';
            $selectPos = strpos($form, '<select', $selectPosEnd);
        }
        return $formValues;
    }

    public function dbQuery($sql) {
        if (!$this->mysqli->query($sql)) {
            printf("Error: %s\n", $this->mysqli->error);
            echo $sql;
            exit();
        }
    }

}
