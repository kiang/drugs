<?php

class PointShell extends AppShell {

    public $uses = array('Point');
    public $mysqli = false;

    public function main() {
        $this->nhi();
        //$this->geocode();
    }

    public function geocode() {
        $addressMap = array();
        $fh = fopen(__DIR__ . '/data/nhi/points_address.csv', 'r');
        while ($line = fgetcsv($fh, 2048)) {
            $addressMap[$line[0]] = array(
                $line[1], $line[2]
            );
        }
        fclose($fh);
        $fh = fopen(__DIR__ . '/data/nhi/points_address.csv', 'w');
        $points = $this->Point->find('all', array(
            'fields' => array('city', 'town', 'address', 'latitude', 'longitude'),
        ));
        $notFoundLoopCount = 0;
        foreach ($points AS $point) {
            $address = "{$point['Point']['city']}{$point['Point']['town']}{$point['Point']['address']}";
            $pos = strpos($address, '號');
            if (false !== $pos) {
                $address = substr($address, 0, $pos) . '號';
            }
            $this->out($address);
            if (!isset($addressMap[$address])) {
                $addressMap[$address] = $this->Point->geocode($address);
            }
            if (!empty($addressMap[$address])) {
                $this->out("=> {$addressMap[$address][0]}, {$addressMap[$address][1]}");
                fputcsv($fh, array($address, $addressMap[$address][0], $addressMap[$address][1]));
                $notFoundLoopCount = 0;
            } else {
                ++$notFoundLoopCount;
                $this->out('找不到');
                if ($notFoundLoopCount > 10) {
                    $this->out('太多找不到，中止');
                    exit();
                }
            }
        }
        fclose($fh);
    }

    public function nhi() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $this->dbQuery('SET NAMES utf8mb4;');
        $this->dbQuery('TRUNCATE `points`;');

        $valueStack = $codes = array();

        $fh = fopen(__DIR__ . '/data/keys/points.csv', 'r');
        while ($line = fgetcsv($fh, 512)) {
            $codes[$line[0]] = $line[1];
        }
        fclose($fh);

        $addressMap = array();
        $fh = fopen(__DIR__ . '/data/nhi/points_address.csv', 'r');
        while ($line = fgetcsv($fh, 2048)) {
            $addressMap[$line[0]] = array(
                $line[1], $line[2]
            );
        }
        fclose($fh);

        /*
         * max length
         * Array
          (
          [nhi_id] => 10
          [url] => 64
          [type] => 24 (診所, 區域醫院, 地區醫院, 醫學中心, , 藥局, 居家護理, 助產所, 康復之家, 檢驗所, 特約醫事放射機構, 物理治療所)
          [name] => 90
          [category] => 426 (家醫科, 內科, 外科, 兒科, 婦產科, 骨科, 神經外科, 泌尿科, 耳鼻喉科, 眼科, 皮膚科, 神經科, 精神科, 復健科, 整形外科, 職業醫學科, 急診醫學科, 牙科, 口腔顎面外科, 中醫科, 麻醉科, 核子醫學科, 放射腫瘤科, 放射診斷科, 解剖病理科, 臨床病理科, 放射線科, 病理科, 不分科, 齒顎矯正科, 口腔病理科, 洗腎科, 口腔診斷科)
          [biz_type] => 27 (綜合醫院, 精神科醫院, 醫院, 中醫醫院, 專科醫院, 慢性醫院, , 一般診所（醫務室）, 中醫一般診所, 專科診所, 牙醫一般診所, 牙醫專科診所, 中醫專科診所, 病理中心, 私立居家呼吸照護所, 藥師自營, 藥劑生自營, 居家護理機構, 一般護理之家, 其他, 助產所, 社區復健中心, 康復之家, 醫事檢驗所, 醫事放射所, 物理治療所, 職能治療所)
          [service] => 501 (口腔黏膜檢查, 定量免疫法糞便潛血檢查, 復健－物理治療業務, 復健－職能治療業務, 住院安寧療護, 安寧居家療護, 復健－語言治療業務, 門診診療, 住院診療, 血液透析, 兒童預防保健, 成人預防保健, 婦女子宮頸抹片檢查, 孕婦產檢, 分娩, 精神病患者居家照護, 兒童牙齒預防保健, 結核病, 義肢業務, 婦女乳房檢查, 精神科日間住院治療, 腹膜透析業務, 復健－聽力檢查業務, , 居家照護, 復健－聽力語言治療業務, 社區安寧照護, 醫事放射業務, 醫事檢驗業務, 婦產科C表手術項目, 精神復健日間型機構, 精神復健住宿型機構)
          [phone] => 14
          [address] => 90
          [latitude] => 9
          [longitude] => 10
          [nhi_admin] => 15 (臺北業務組, 高屏業務組, 中區業務組, 南區業務組, 北區業務組, 東區業務組)
          [nhi_end] => 10
          )
         */
        $sn = 1;
        foreach (glob(__DIR__ . '/data/nhi/points/*.json') AS $jsonFile) {
            $point = json_decode(file_get_contents($jsonFile), true);
            if (empty($point['name'])) {
                continue;
            }
            $point['address'] = strtr($point['address'], array(
                '巿' => '市',
                '０' => '0', '１' => '1', '２' => '2', '３' => '3', '４' => '4', '５' => '5', '６' => '6', '７' => '7', '８' => '8', '９' => '9',
                'Ｆ' => 'F', 'Ｂ' => 'B', '－' => '-'
            ));
            $city = $town = '';
            preg_match('(縣|市)', $point['address'], $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0][1])) {
                $city = substr($point['address'], 0, $matches[0][1] + 3);
                $point['address'] = substr($point['address'], $matches[0][1] + 3);
            }
            preg_match('(鄉|鎮|區|市)', $point['address'], $matches, PREG_OFFSET_CAPTURE);
            if (!empty($matches[0][1])) {
                $town = substr($point['address'], 0, $matches[0][1] + 3);
                switch ($town) {
                    default:
                        $point['address'] = substr($point['address'], $matches[0][1] + 3);
                }
            }
            if (isset($codes[$point['nhi_id']])) {
                $currentId = $codes[$point['nhi_id']];
            } else {
                $currentId = CakeText::uuid();
                
            }

            $address = "{$city}{$town}{$point['address']}";
            $pos = strpos($address, '號');
            if (false !== $pos) {
                $address = substr($address, 0, $pos) . '號';
            }
            if (isset($addressMap[$address])) {
                $point['longitude'] = $addressMap[$address][0];
                $point['latitude'] = $addressMap[$address][1];
            }
            if (!empty($point['nhi_end'])) {
                $point['nhi_end'] = '\'' . date('Y-m-d', strtotime($point['nhi_end'])) . '\'';
            } else {
                $point['nhi_end'] = 'NULL';
            }

            $dbCols = array(
                "('{$currentId}'", //id
                "'{$point['nhi_id']}'", // nhi_id 
                $point['nhi_end'], // nhi_end 
                "'{$point['type']}'", // type 
                "'{$point['category']}'", //category
                "'{$point['biz_type']}'", // biz_type 
                "'{$point['service']}'", // service 
                "'{$point['name']}'", // name 
                "'{$city}'", // city
                "'{$town}'", // town 
                "'{$point['address']}'", // address 
                "'{$point['longitude']}'", //longitude
                "'{$point['latitude']}'", //latitude
                "'{$point['phone']}'", //phone 
                "'{$point['url']}')", //url
            );
            $valueStack[] = implode(',', $dbCols);
            ++$sn;
            if ($sn > 50) {
                $sn = 1;
                $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
                $valueStack = array();
            }
        }
        if (!empty($valueStack)) {
            $this->dbQuery('INSERT INTO `points` VALUES ' . implode(',', $valueStack) . ';');
        }
    }

    public function dbQuery($sql) {
        if (!$this->mysqli->query($sql)) {
            printf("Error: %s\n", $this->mysqli->error);
            echo $sql;
            exit();
        }
    }

}
