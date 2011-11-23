<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Info extends Controller {

    public function action_index() {
        $session = Session::instance()->as_array();
        if(isset($session['info']) && isset($session['title']) && isset($session['message'])){
            $view = View::factory('info');
            $view->text = array('title' => $session['title'], 'message' => $session['message']);
            $this->response->body($view);
            Session::instance()->delete('info');
            Session::instance()->delete('title');
            Session::instance()->delete('message');
        } else {
            header("Location: /".Plussia_Dispatcher::lang());
            die();
        }
    }

}