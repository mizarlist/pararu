<?php

defined('SYSPATH') or die('No direct script access.');

class Model_UserData extends Plussia_ORM {

    protected static $_table_name = 'user_data';
    protected static $_primary_key = 'user_data_id';
    protected static $_fields = array('user_id', 'is_woman', 'name', 'birthday', 'country_id', 'region_id', 'city_id',
        'eyescolor', 'haircolor', 'growth', 'physique', 'ethnos', 'relationshep_status', 'family_status',
        'material_lavel', 'education_lavel', 'baby_exist', 'baby_want', 'religion', 'spirituality', 'political_views',
        'atmosphere_views', 'smoke_times', 'drink_times', 'humor_sense', 'profession', 'languages', 'zodiac_id');
    public $user_data_id;           // id записи
    public $user_id;                // id пользователя
    public $is_woman;               // признак женщины
    public $name;                   // имя
    public $birthday;               // дата рождения
    public $country_id;             // страна
    public $region_id;              // область
    public $city_id;                // город\район
    public $eyescolor;              // цвет глаз
    public $haircolor;              // цвет волос
    public $growth;                 // рост
    public $physique;               // телосложение
    public $ethnos;                 // этнос
    public $relationshep_status;    // статус отношений
    public $family_status;          // семейное положение
    public $material_lavel;         // уровень дохода
    public $education_lavel;        // уровень образования
    public $baby_exist;             // существуют ли дети до 18 лет, живущие с вами
    public $baby_want;              // желание завести ребенка
    public $religion;               // религия
    public $spirituality;           // духовность
    public $political_views;        // политические взгляды
    public $atmosphere_views;       // отношение к окружающей среде
    public $smoke_times;            // сколько вы курите
    public $drink_times;            // отношение к алкоголю
    public $humor_sense;            // чувство юмора
    public $profession;             // профессия
    public $languages;              // языки, на которых говорите
    public $zodiac_id;              // идентификатор знака зодиака

    public function getFields() {
        return self::$_fields;
    }

    public static function validateData($data) {
        if (isset($data['is_woman']) && !(intval($data['is_woman']) == 0 || intval($data['is_woman']) == 1)) {
            return false;
        }
        foreach (array(
    'is_woman' => array(0, 1),
    'eyescolor' => array(1, 7),
    'haircolor' => array(1, 7),
    'growth' => array(1, 7),
    'physique' => array(1, 7),
    'ethnos' => array(1, 7),
    'relationshep_status' => array(1, 7),
    'family_status' => array(1, 7),
    'material_lavel' => array(1, 7),
    'education_lavel' => array(1, 7),
    'baby_exist' => array(1, 7),
    'baby_want' => array(1, 7),
    'religion' => array(1, 7),
    'spirituality' => array(1, 7),
    'political_views' => array(1, 7),
    'atmosphere_views' => array(1, 7),
    'smoke_times' => array(1, 7),
    'drink_times' => array(1, 7),
    'humor_sense' => array(1, 7),
    'profession' => array(1, 7)
        ) as $cond => $minmax) {
            if (isset($data[$cond]) && !(intval($data[$cond]) >= $minmax[0] && intval($data[$cond]) <= $minmax[1])) {
                return false;
            }
        }
        if (isset($data['languages'])) {
            $languages = explode(';', $data['languages']);
            $kol = count($languages) - count(array_unique($languages));
            if ($kol) {
                return false;
            }
            foreach ($languages as $language) {
                if ($language != '') {
                    if (intval($language) < 1 || intval($language) > 7) {
                        return false;
                    }
                } else if (array_search($language, $languages) != count($languages) - 1) {
                    return false;
                }
            }
        }
        return true;
    }

    public function updateZodiak() {
        $birth_date = $this->birthday;
        $zodiak_id = Model_Extra_Zodiac::getZodiakByDate($birth_date);
        $this->set('zodiac_id', $zodiak_id);
    }

    public static function getAgeByDate($date) {
        $arr = date_parse($date);
        $r = mktime(0, 0, 0, $arr['month'], $arr['day'], $arr['year']);
        $age = (time() - $r) / 31536000;
        $a = floor($age);
        return $a; // 24
    }

}