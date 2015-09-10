<?php

class OlcHelper extends AppHelper {

    public $countries = array();

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->countries = json_decode(file_get_contents(__DIR__ . '/country.json'), true);
    }

    public function showCountry($countryText = '') {
        if (!empty($countryText)) {
            if (isset($this->countries[$countryText])) {
                return '<img src="http://api.hostip.info/images/flags/' . strtolower($this->countries[$countryText][1]) . '.gif" class="img-flag" alt="' . $this->countries[$countryText][0] . '" title="' . $this->countries[$countryText][0] . '">';
            } else {
                return $countryText;
            }
        } else {
            return '<span title="無紀錄" class="fui-question-circle text-muted"></span>';
        }
    }

}
