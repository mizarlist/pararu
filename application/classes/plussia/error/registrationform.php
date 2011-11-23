<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Error_RegistrationForm extends Plussia_Error {

    public function get_texts($config) {
        //требует fiels => array('field1', 'field2'...)
        $texts = array('title' => '', 'message' => '');
        if(!isset($config['fields']) || !is_array($config['fields'])) {
            $xml_assoc = XML_Texts::factory('errors/registration_form')->getAssoc();
            $texts['title'] = $xml_assoc['title'];
            $texts['message'] = '';
            return $texts;
        }
        $xml_assoc = XML_Texts::factory('errors/registration_form')->getAssoc();
        $texts['title'] = $xml_assoc['title'];

        if(count($config['fields']) > 1) {
            $texts['message'] = $xml_assoc['start_text_many'];
        } else {
            $texts['message'] = $xml_assoc['start_text_one'];
        }

        $fl = false;

        foreach($config['fields'] as $field) {
            if(isset($xml_assoc[$field])) {
                $fl = true;
                $texts['message'] .= $xml_assoc[$field].', ';
            }
        }
        if($fl) {
            $texts['message'] = mb_substr($texts['message'], 0, mb_strlen($texts['message'])-2);
        }
        return $texts;
    }

}