<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Registration extends Plussia_Controller {

    protected $needAjax = false;

    public function validate() {
        $user = Plussia_Dispatcher::getUser();
        return Request::$current->is_ajax() || ($user && $user->access('registration')) || true;
    }

    public function invalid() {
        if (Plussia_Dispatcher::isLogined()) {
            $user = Plussia_Dispatcher::getUser();
            $afterlogin = ($user->afterlogin && $user->afterlogin != '') ? $user->afterlogin : $user->username;
            header("Location: /" . $afterlogin);
            die();
        } else {
            header("Location: /");
            die();
        }
    }

    public function index() {
        if (!isset($_POST['current_step']) || !isset($_POST['request_step'])) {
            Plussia_Step::render($this, 1);
        } else {
            if (Plussia_Step::validateStep($_POST['current_step'], $_POST['request_step'])) {
                if ($_POST['current_step'] != $_POST['request_step']) {
                    $data = isset($_POST['data']) ? $_POST['data'] : null;
                    Plussia_Step::factory($_POST['current_step'])->save($data);
                }
                Plussia_Step::render($this, $_POST['request_step'], (isset($_POST['page']) ? $_POST['page'] : null));
            }
        }
    }

}