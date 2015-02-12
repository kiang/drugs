<?php

App::uses('HttpSocket', 'Network/Http');

class MohwShell extends AppShell {

    public $uses = array('License');
    public $mysqli = false;

    public function main() {
        //$this->importDrug();
        $this->importIngredients();
    }

    public function importIngredients() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $valueStack = $ingredientKeys = array();

        if (file_exists(__DIR__ . '/data/mohw_ingredients.csv')) {
            $ingredientKeysFh = fopen(__DIR__ . '/data/mohw_ingredients.csv', 'r');
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
        $fh = fopen(__DIR__ . '/data/mohw_ingredients.csv', 'w');
        foreach ($ingredientKeys AS $name => $ingredient) {
            $name = $this->mysqli->real_escape_string($name);
            $valueStack[] = implode(',', array(
                "('{$ingredient['id']}'", //ingredient_id
                "'{$name}'", //name
                "'{$ingredient['count_licenses']}'", //count_licenses
                "0", //count_daily
                "0)", //count_all
            ));
            fputcsv($fh, array($name, $ingredient['id']));
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `ingredients` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        fclose($fh);
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `ingredients` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function importDrug() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $valueStack = $licenseData = array();
        $sn = 1;
        foreach (glob(__DIR__ . '/data/mohw/license/*/*.json') AS $jsonFile) {
            $p = pathinfo($jsonFile);
            $json = json_decode(file_get_contents($jsonFile), true);
            $json['license']['發證日期'] = date('Y-m-d', strtotime($json['license']['發證日期']));
            $json['license']['有效日期'] = date('Y-m-d', strtotime($json['license']['有效日期']));
            foreach ($json['license'] AS $k => $v) {
                $json['license'][$k] = $this->mysqli->real_escape_string($v);
            }

            $dbCols = array(
                "('{$p['filename']}'", //id
                "'{$p['filename']}'", //license_uuid
                "'{$json['license']['許可證字號']}'", //license_id
                "'{$json['license']['製造廠名稱']}'", //manufacturer
                "'{$json['license']['製造廠地址']}'", //manufacturer_address
                "NULL", //manufacturer_office
                "NULL", //manufacturer_country
                "NULL", //manufacturer_description
            );
            $disease = trim("{$json['license']['適應症']}\n{$json['license']['效能']}");
            $licenseData[] = array(
                "('{$p['filename']}'", //id
                "'{$json['license']['許可證字號']}'", //license_id
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
                "'{$json['license']['申請商名稱']}'", //vendor
                "'{$json['license']['申請商地址']}'", //vendor_address
                "NULL", //vendor_id
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
    }

    public function extractLicenseHtml() {
        $targetPath = __DIR__ . '/data/mohw/license';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        $mohwKeyFile = __DIR__ . '/data/mohw_licenses.csv';
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
            echo "processing page {$i}\n";
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
