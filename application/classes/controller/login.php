<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Plussia_Controller {

    public function index() {
        $array = $_POST;
        if ($array) {
            if (!isset($array['password']) || !isset($array['login'])) {
                Plussia_Error::call(5);
            }
            if (!Plussia_Help::is_safe($array['password']) || !Plussia_Help::is_mail($array['login'])) {
                Plussia_Error::call(5);
            }

            $user = Model_User::findOneBy(array('email' => $array['login'], 'password' => $array['password']));
            if (!$user) {
                Plussia_Error::call(5);
            }
            if (!$user->access('login')) {
                Plussia_Error::call(6);
            }

            Session::instance()->bind('user_id', $user->user_id);
            $afterlogin = ($user->afterlogin && $user->afterlogin != '') ? $user->afterlogin : $user->username;

            Plussia_Dispatcher::updateActive(true);

            header("Location: /" . $afterlogin);
            die();
        } else if (Plussia_Dispatcher::isLogined()) {
            $user = Plussia_Dispatcher::getUser();
            $afterlogin = ($user->afterlogin && $user->afterlogin != '') ? $user->afterlogin : $user->username;
            header("Location: /" . $afterlogin);
            die();
        } else {
            $view = View::factory('login');
            $this->response->body($view);
        }
    }

}