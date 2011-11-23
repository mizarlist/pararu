<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Step_4 extends Plussia_Step {
    //блок NIC-System

    public function validate($data) {
        return true; //переписать
    }

    public function save_step($data) {
        //данные приходят ввиде
        //set => array('<номер блока>_<номер вопроса>_<вариант - st, f, a, A, ...>_<не значащая цифра>' =>
        //<признак отметки (true) или кол-во выставленных баллов>)
        //order => порядок выбора блоков
        $order = $data['order'];
        $set = $data['set'];

        Plussia_Dispatcher::getUser()->updateNicCards($set, $order);
    }

    public function render_step($context) {
        $view = View::factory('registration/registration_4');
        $view->text = XML_Texts::factory('registration/registration_4')->getAssoc();
        $view->bloks = XML_Texts::factory('niccards', '/')->getAssoc();
        $context->response->body($view);
    }

}