<?php

class CronShell extends AppShell {

    public $uses = array('License');
    public $mysqli = false;

    public function main() {
        $this->updateCounter();
    }

    public function updateCounter() {
        $this->License->query("UPDATE licenses SET count_daily = 0");
        $this->License->query("UPDATE ingredients SET count_daily = 0");
        $this->License->query("UPDATE categories SET count_daily = 0");
    }

}
