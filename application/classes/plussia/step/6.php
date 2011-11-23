<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Step_6 extends Plussia_Step {

    public function validate($data) {
        return true; //переписать
    }

    public function save_step($data) {
    }

    public function render_step($context) {
        $view = View::factory('registration/registration_6');
        $view->text = XML_Texts::factory('registration/registration_6')->getAssoc();
        $view->userName = Model_UserData::findOneBy(array('user_id' => Plussia_Dispatcher::getUserId()))->name;

        $context->response->body($view);
    }

}