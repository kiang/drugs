<?php

class CronShell extends AppShell {

    public $uses = array('License');
    public $mysqli = false;

    public function main() {
        $this->updateCounter();
    }

    public function updateCounter() {
        $db = ConnectionManager::getDataSource('default');
        $this->mysqli = new mysqli($db->config['host'], $db->config['login'], $db->config['password'], $db->config['database']);
        $theDay = strtotime('-1 day');
        $theDay = time();
        $basePath = TMP . 'counters/' . date('Ymd', $theDay);
        if (!file_exists("{$basePath}/License/run_check")) {
            file_put_contents("{$basePath}/License/run_check", '0');
            foreach (glob("{$basePath}/License/*/*/*/*/*") AS $counterFile) {
                $pathParts = explode('/', $counterFile);
                $idParts = array();
                for ($i = 5; $i > 0; $i--) {
                    $idParts[$i] = array_pop($pathParts);
                }
                ksort($idParts);
                $id = implode('-', $idParts);
                $counter = filesize($counterFile);
                $this->mysqli->query("UPDATE licenses SET count_daily = count_daily + {$counter}, count_all = count_all + {$counter} WHERE id = '{$id}'");
            }
        }
        if (!file_exists("{$basePath}/Ingredient/run_check")) {
            file_put_contents("{$basePath}/Ingredient/run_check", '0');
            foreach (glob("{$basePath}/Ingredient/*/*/*/*/*") AS $counterFile) {
                $pathParts = explode('/', $counterFile);
                $idParts = array();
                for ($i = 5; $i > 0; $i--) {
                    $idParts[$i] = array_pop($pathParts);
                }
                ksort($idParts);
                $id = implode('-', $idParts);
                $counter = filesize($counterFile);
                $this->mysqli->query("UPDATE ingredients SET count_daily = count_daily + {$counter}, count_all = count_all + {$counter} WHERE id = '{$id}'");
            }
        }
        if (!file_exists("{$basePath}/Category/run_check")) {
            file_put_contents("{$basePath}/Category/run_check", '0');
            foreach (glob("{$basePath}/Category/*") AS $counterFile) {
                $pathParts = explode('/', $counterFile);
                $id = array_pop($pathParts);
                $counter = filesize($counterFile);
                $this->mysqli->query("UPDATE categories SET count_daily = count_daily + {$counter}, count_all = count_all + {$counter} WHERE id = '{$id}'");
            }
        }
    }

}
