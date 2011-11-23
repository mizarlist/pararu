<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller {

    public function action_index() {
        $session = Session::instance()->as_array();
        if(isset($session['error']) && isset($session['title']) && isset($session['message'])){
            $view = View::factory('error');
            $celar_text = XML_Base::factory('error_celar', null, null, null, 'text')->getAssoc();
            $view->text = array('title' => $session['title'], 'message' => $session['message'], 'celar' => $celar_text['celar']);
            $this->response->body($view);
            Session::instance()->delete('error');
            Session::instance()->delete('title');
            Session::instance()->delete('message');
        } else {
            header("Location: /".Plussia_Dispatcher::lang());
            die();
        }
    }
    
}