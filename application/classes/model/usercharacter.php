<?php defined('SYSPATH') or die('No direct script access.');


class Model_UserCharacter extends Plussia_ORM {

    protected static $_table_name = 'user_character';
    protected static $_primary_key = 'user_character_id';
    protected static $_fields = array('user_id', 'strong', 'hardness', 'latitude',
                'fragility', 'softness', 'nonchalance');

    public $user_character_id;  //id записи
    public $user_id;            //id пользователя
    public $strong;             //Сила(уверенность)
    public $hardness;           //Твёрдость(надёжность)
    public $latitude;           //Широта(внимательность)
    public $fragility;          //Нежность(хрупкость) (слабость)
    public $softness;           //Мягкость(заботливость)
    public $nonchalance;        //Беспечность (беспечность) Упрямство (узость)

}
