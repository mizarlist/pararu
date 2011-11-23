<?php defined('SYSPATH') or die('No direct script access.');

class Model_Country extends Model {

    protected $_table_name = 'country_';
    protected $_primary_key = 'country_id';

    public $country_id;         //id страны
    public $country_name_ru;    //русское название страны
    public $country_name_en;    //английское название страны

    public static function getAssoc($str) {
        $locate = Plussia_Help::getFirstCharLocate($str);
        $locate = !$locate ? (Plussia_Config::currentLang()=='ru' ? 'ru' : 'en') : $locate;
        if(!$locate) {
            return array();
        }

        $query = DB::select(array('country_id', 'id'), array('country_name_'.$locate, 'name'))->from('country_');

        $query->where('country_name_'.$locate, 'like', $str.'%');
        $query->limit(10);
        return $query->as_assoc()->execute()->as_array();
    }

}
