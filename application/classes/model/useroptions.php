<?php defined('SYSPATH') or die('No direct script access.');

class Model_UserOptions extends Plussia_ORM {

    protected static $_table_name = 'user_options';
    protected static $_primary_key = 'user_options_id';

    protected static $_fields = array('user_id','confidence','alerts','sms','commercial','commercial_off');

    public $user_data_id;           // id записи
    public $user_id;                // id пользователя
    public $confidence;             // настройки конфиденциальности
    public $alerts;                 // настройки оповещений
    public $sms;                    // настройки sms
    public $commercial;             // настройки рекламы
    public $commercial_off;         // настройки отключения рекламы

}