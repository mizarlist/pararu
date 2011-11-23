<?php defined('SYSPATH') or die('No direct script access.');

class Model_MailProve extends Plussia_ORM {

    protected static $_table_name = 'mail_prove';
    protected static $_primary_key = 'mail_prove_id';
    protected static $_fields = array('user_id', 'password');

    public $mail_prove_id;      //id записи
    public $user_id;            //id пользователя
    public $password;           //код

    public static function getUserByPassword($password){
        $mp = Model_MailProve::findOneBy(array('password'=>$password));
        if($mp){
            $user = new Model_User($mp->user_id);
            return $user;
        }
        return null;
    }

    public static function createAuth(Model_User $user) {
        $exist = Model_MailProve::findOneBy(array('user_id'=>$user->user_id));
        if($exist){
            $exist->delete();
        }
        $auth = new Model_MailProve();
        $auth->set('user_id', $user->user_id);

        $password = $auth->generatePassword();
        $auth->set('password', $password);

        $auth->save();
        return $password;
    }

    public static function generatePassword($count = 0) {

        if($count > 5){
            throw new Exception('Generation auth password error (number of iterrations > 5)');
        }

        $str = Session::instance()->id();
        $str .= microtime();
        $password = md5($str);

        $result = DB::select(array('COUNT("user_id")', 'count'))
                ->from('mail_prove')->where('password', '=', $password)
                ->as_assoc()
                ->execute();
        
        if($result[0]['count'] > 0) {
            $count++;
            return self::generatePassword($count);
        } else {
            return $password;
        }
    }

}