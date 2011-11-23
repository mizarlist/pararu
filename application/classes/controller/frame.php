<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Frame extends Controller {

    public function action_index() {
        $view = View::factory('frame');
        $view->id = isset($_GET['id']) ? $_GET['id'] : null;
        $this->response->body($view);
    }

}