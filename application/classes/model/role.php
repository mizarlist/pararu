<?php defined('SYSPATH') or die('No direct script access.');

class Model_Role extends Plussia_ORM {

    protected static $_table_name = 'role';
    protected static $_primary_key = 'role_id';
    protected static $_fields = array('name', 'description');

    public $role_id;            //id роли
    public $name;               //имя роли
    public $description;        //описание

    public static function get($name) {
        return Model_Role::findOneBy(array('name'=>$name));
    }

}