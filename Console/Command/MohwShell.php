<?php

App::uses('HttpSocket', 'Network/Http');

class MohwShell extends AppShell {

    public $uses = array('License');

    public function main() {
        $this->getLicenseHtml();
    }

    public function getLicenseHtml() {
        $tmpPath = TMP . 'mohw/licenses';
        if (!file_exists($tmpPath)) {
            mkdir($tmpPath, 0777, true);
        }
        $targetPath = __DIR__ . '/data/mohw/license';
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
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
                
                $newPageValues = $this->getFormValues($item);
                
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
