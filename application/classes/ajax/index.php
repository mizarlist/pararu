<?php

class Ajax_Index {

    public static function get_arials($data) {
        if(!isset($data['arial_class']) || !isset($data['conditions'])){
            return array();
        }
        if(!in_array($data['arial_class'], array('city', 'country', 'region'))) {
            return array();
        }
        if(!isset($data['conditions']['str']) || !Plussia_Help::is_text_only($data['conditions']['str'])) {
            return array();
        }

        $id_country = (isset($data['conditions']['country_id']) && Plussia_Help::is_digit_only($data['conditions']['country_id'])) ?
                $data['conditions']['country_id'] : null;
        $id_region = (isset($data['conditions']['region_id']) && Plussia_Help::is_digit_only($data['conditions']['region_id'])) ?
                $data['conditions']['region_id'] : null;

        $class = 'Model_'.ucwords(strtolower($data['arial_class']));
        $result = $class::getAssoc($data['conditions']['str'], $id_region, $id_country);

        return $result;
    }
}