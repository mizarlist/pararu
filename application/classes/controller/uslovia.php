<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Uslovia extends Plussia_Controller {

    public function index() {
        $view = $this->view;
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('uslovia');
    }

}
