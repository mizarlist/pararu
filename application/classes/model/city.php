<?php defined('SYSPATH') or die('No direct script access.');

class Model_City extends Model {

    protected $_table_name = 'city_';
    protected $_primary_key = 'city_id';

    public $city_id;        //id города
    public $region_id;      //id региона
    public $country_id;     //id страны
    public $city_name_ru;   //русское название города
    public $city_name_en;   //английское название города

    public static function getAssoc($str, $region_id = null, $country_id = null) {
        $locate = Plussia_Help::getFirstCharLocate($str);
        $locate = !$locate ? (Plussia_Config::currentLang()=='ru' ? 'ru' : 'en') : $locate;
        if(!$locate) {
            return array();
        }

        $query = $region_id!==NULL ? DB::select(array('city_.city_id', 'id'),
                array('city_.city_name_'.$locate, 'name')) :
                DB::select(array('city_.city_id', 'id'),
                'city_.region_id',
                array('city_.city_name_'.$locate, 'name'),
                array('region_.region_name_'.$locate, 'region_name'));

        $query = $query
                ->from('city_')
                ->join('region_')->on('city_.region_id', '=', 'region_.region_id');

        if($country_id) {
            $query->where('city_.country_id', '=', intval($country_id));
        }
        if($region_id) {
            $query->where('city_.region_id', '=', intval($region_id));
        }
        $query->where('city_name_'.$locate, 'like', $str.'%');

        $query->limit(10);
        return $query->as_assoc()->execute()->as_array();
    }

    public static function getLocationByCityId($id){
        $locate = Plussia_Dispatcher::lang();
        $l = $locate=='ru' ? 'ru' : 'en';

        $request = "select c.city_name_$l as city, r.region_name_$l as region, co.country_name_$l as country
        from city_ c
        left join region_ r on r.region_id=c.region_id
        left join country_ co on co.country_id=c.country_id
        where c.city_id=$id";

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        return $results[0];
    }

}