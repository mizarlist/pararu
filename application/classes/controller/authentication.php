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
            if(false && (time() - $date_time > 24*60*60)) {
                $user->delete();
                Plussia_Info::factory('OutOfAuthTime');
            } else {
                $mp = Model_MailProve::findOneBy(array('password'=>$_GET['password']));
                $user->set('afterlogin', 'registration');
                $user->save();
                Plussia_Dispatcher::setUser($user);
                $mp && $mp->delete();

                $afterlogin = ($user->afterlogin && $user->afterlogin != '') ? $user->afterlogin : $user->username;
                Plussia_Dispatcher::updateActive(true);
                header("Location: /" . $afterlogin);
                die;
                //Plussia_Info::factory('AuthenticationSuccess', array('name' => $user->getUserData()->name));
            }
        }
        Plussia_Error::call(2);
    }

}
