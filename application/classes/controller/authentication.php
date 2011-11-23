<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Authentication extends Controller {

    public function action_index() {
        if(!isset($_GET['password'])) {
            header("Location: /".Plussia_Dispatcher::lang());
            die();
        }
        $user = Model_MailProve::getUserByPassword($_GET['password']);
        if(!$user || !$user->loaded()) {
            Plussia_Info::call(1);
        } else {
            $user instanceof Model_User;
            $date = date_parse($user->registration_date);
            $date_time = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
            if(time() - $date_time > 24*60*60) {
                $user->delete();
                Plussia_Info::factory('OutOfAuthTime');
            } else {
                $mp = Model_MailProve::findOneBy(array('password'=>$_GET['password']));
                $user->addRole(Model_Role::get('login'));
                $user->addRole(Model_Role::get('registration'));
                $user->addRole(Model_Role::get('regstep1'));
                $user->set('afterlogin', 'registration');
                $user->save();
                $mp && $mp->delete();
                Plussia_Info::factory('AuthenticationSuccess', array('name' => $user->getUserData()->name));
            }
        }
        Plussia_Error::call(2);
    }

}
