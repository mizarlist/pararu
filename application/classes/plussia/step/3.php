<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Step_3 extends Plussia_Step {

    public function validate($data) {
        return true; //переписать
    }

    public function save_step($data) {
        if(is_array($data)) {
            $user_data = Model_UserData::findOneBy(array('user_id' => Plussia_Dispatcher::getUserId()));
            $asarray = array('languages');

            foreach($data as $field => $values) {
                $value = null;
                if(!in_array($field, $asarray)) {
                    $va = Plussia_Help::arrayFirstKey($values);
                    $v = substr($va, strlen($field));
                    $value = intval($v);
                } else {
                    $value = ';';
                    foreach($values as $val => $truefalse) {
                        $v = substr($val, strlen($field));
                        $value .= $v.';';
                    }
                }
                $user_data->set($field, $value);
            }

            $user_data->save();
        }
    }

    public function render_step($context) {
        $view = View::factory('registration/registration_3');
        $view->text = XML_Texts::factory('registration/registration_3')->getAssoc();
        $view->userData = XML_WithMeta::factory('user_data')->getAssoc();

        $context->response->body($view);
    }

}
