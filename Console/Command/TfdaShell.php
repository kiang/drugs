<?php

class TfdaShell extends AppShell {

    public $uses = array('License');
    public $dataPath = '/home/kiang/github/tfda_license';
    public $mysqli = false;
    public $key2id = array();
    public $key2code = array();
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
        $this->import();
    }

    public function import() {

        $licenseId = $vendorKeys = array();
        if (file_exists(__DIR__ . '/data/keys/licenses.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/licenses.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $licenseId[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }
        if (file_exists(__DIR__ . '/data/keys/vendors.csv')) {
            $dbKeysFh = fopen(__DIR__ . '/data/keys/vendors.csv', 'r');
            while ($line = fgetcsv($dbKeysFh, 1024)) {
                $vendorKeys[$line[0]] = $line[1];
            }
            fclose($dbKeysFh);
        }

        foreach (glob($this->dataPath . '/licenses/*/*.json') AS $jsonFile) {
            echo $jsonFile;
            $json = json_decode(file_get_contents($jsonFile), true);
            print_r($json);
            exit();
        }
    }

}
