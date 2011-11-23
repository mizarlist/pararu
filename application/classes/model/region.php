<?php defined('SYSPATH') or die('No direct script access.');

class Model_Region extends Model {

    protected $_table_name = 'region_';
    protected $_primary_key = 'region_id';

    public $region_id;          //id региона
    public $country_id;         //id страны
    public $region_name_ru;     //русское название региона
    public $region_name_en;     //английское название региона

    public static function getAssoc($str, $country_id = null) {
        $locate = Plussia_Help::getFirstCharLocate($str);
        $locate = !$locate ? (Plussia_Config::currentLang()=='ru' ? 'ru' : 'en') : $locate;
        if(!$locate) {
            return array();
        }
        $query = DB::select(array('region_id', 'id'), array('region_name_'.$locate, 'name'))->from('region_');
        if($country_id) {
            $query->where('country_id', '=', intval($country_id));
        }
        $query->where('region_name_'.$locate, 'like', $str.'%');
        $query->limit(10);
        return $query->as_assoc()->execute()->as_array();
    }

}
