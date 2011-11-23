<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Logout extends Controller {

    public function action_index() {
        Session::instance()->delete('user_id');
        header("Location: /".Plussia_Dispatcher::lang());
        die();
    }

}