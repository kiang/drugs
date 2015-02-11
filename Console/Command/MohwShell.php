<?php

App::uses('HttpSocket', 'Network/Http');

class MohwShell extends AppShell {

    public $uses = array('License');

    public function main() {
        $this->extractLicenseHtml();
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

}
