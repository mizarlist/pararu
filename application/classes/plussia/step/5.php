<?php

defined('SYSPATH') or die('No direct script access.');

class Plussia_Step_5 extends Plussia_Step {

    public function validate($data) {
        return true; //переписать
    }

    public function save_step($data) {
        if (is_array($data)) {
            $sputnik_data = Model_SputnikData::findOneBy(array('user_id' => Plussia_Dispatcher::getUserId()));
            $asobject = array();

            foreach ($data as $field => $values) {
                $value = null;
                if (in_array($field, $asobject)) {
                    $va = Plussia_Help::arrayFirstKey($values);
                    $v = substr($va, strlen($field));
                    $value = intval($v);
                } else {
                    $value = ';';
                    foreach ($values as $val => $truefalse) {
                        $v = substr($val, strlen($field));
                        $value .= $v . ';';
                    }
                }
                $sputnik_data->set($field, $value);
            }

            $sputnik_data->save();
        }
    }

    public function render_step($context) {
        $view = View::factory('registration/registration_5');
        $view->text = XML_Texts::factory('registration/registration_5')->getAssoc();
        $view->userData = XML_WithMeta::factory('sputnik_data')->getAssoc();

        $context->response->body($view);
    }

}