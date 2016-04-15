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
                return '<img src="http://www.geonames.org/flags/x/' . strtolower($this->countries[$countryText][1]) . '.gif" class="img-flag" alt="' . $this->countries[$countryText][0] . '" title="' . $this->countries[$countryText][0] . '">';
            } else {
                return $countryText;
            }
        } else {
            return '<span title="無國家紀錄" class="fui-question-circle text-muted"></span>';
        }
    }

    public function parsePrice($data) {
        $result = array();
        foreach($data AS $price) {
            if(!isset($result[$price['Price']['nhi_id']])) {
                $result[$price['Price']['nhi_id']] = array(
                    'date' => array(),
                    'price' => array(),
                );
            }
            array_push($result[$price['Price']['nhi_id']]['date'], $price['Price']['date_begin']);
            array_push($result[$price['Price']['nhi_id']]['price'], floatval($price['Price']['nhi_price']));
        }
        return $result;
    }

}
