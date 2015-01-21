<?php

class NhiShell extends AppShell {

    public $uses = array('License');

    public function main() {
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
