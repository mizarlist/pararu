<?php defined('SYSPATH') or die('No direct script access.');

class Model_UserToken extends Plussia_ORM {

    protected static $_table_name = 'user_token';
    protected static $_primary_key = 'token_id';
    protected static $_fields = array('user_id','user_agent','token','created','expires');

    public $token_id;               //id входа
    public $user_id;                //id пользователя
    public $user_agent;             //браузер
    public $token;                  //уникальный идентификатор сессии
    public $created;                //создан
    public $expires;                //истекает

    public static function get($token) {
        return Model_UserToken::findOneBy(array('token'=>$token));
    }

}