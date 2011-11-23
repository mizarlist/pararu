<?php

defined('SYSPATH') or die('No direct script access.');

class Model_TmpPass extends Plussia_ORM {

    protected static $_table_name = 'tmp_pass';
    protected static $_primary_key = 'tmp_pass_id';
    protected static $_fields = array('user_id', 'password', 'handler', 'data', 'dt_create', 'dt_expected');
    public $tmp_pass_id;        //id записи
    public $user_id;            //id пользователя
    public $password;           //код
    public $handler;            //обработчик
    public $data;               //данные
    public $dt_create;          //дата создания
    public $dt_expected;        //дата истечения
    private $link;

    public function  __construct($id = null, $hours = 24) {
        $this->user_id = Plussia_Dispatcher::getUser()->user_id;
        $this->password =  Model_TmpPass::generatePassword();
        $this->dt_create = time();
        $this->dt_expected = $this->dt_create+60*60*$hours;
        parent::__construct($id);
    }

    public function  save() {
        $old = Model_TmpPass::findOneBy(array('user_id' => $this->user_id, 'handler' => $this->handler));
        $old && $old->delete();
        parent::save();
    }

    public static function getByPassword($password) {
        return Model_TmpPass::findOneBy(array('password' => $password));
    }

    public static function generatePassword($count = 0) {

        if ($count > 5) {
            throw new Exception('Generation auth password error (number of iterrations > 5)');
        }

        $str = Session::instance()->id();
        $str .= microtime();
        $password = md5($str);

        $result = DB::select(array('COUNT("user_id")', 'count'))
                        ->from('tmp_pass')->where('password', '=', $password)
                        ->as_assoc()
                        ->execute();

        if ($result[0]['count'] > 0) {
            $count++;
            return self::generatePassword($count);
        } else {
            return $password;
        }
    }

    public function getLink() {
        if (!$this->link) {
            $this->link = '//' . URL::base() . Plussia_Dispatcher::lang() . '/pararuport?uid=' . Model_User::getUID($this->user_id) . '&password=' . $this->password;
        }

        return $this->link;
    }

}