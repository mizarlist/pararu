<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Question extends Plussia_ORM {

    protected static $_table_name = 'question';
    protected static $_primary_key = 'question_id';
    protected static $_fields = array('user_id', 'text', 'dt_create');

    public $question_id;        //id вопроса
    public $user_id;            //id пользователя
    public $text;               //текст вопроса
    public $dt_create;          //дата и время отправки

    public static function add($user_id, $text) {
        $q = new Model_Question();
        $q->user_id = $user_id;
        $q->text = $text;
        $q->dt_create = time();

        $q->save();
    }

}
