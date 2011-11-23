<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Info_OutOfAuthTime extends Plussia_Info {

    public function get_texts($config) {
        $texts = array('title' => '', 'message' => '');
        $xml_assoc = XML_Texts::factory('infos/out_of_auth_time')->getAssoc();
        $texts['title'] = $xml_assoc['title'];
        $texts['message'] = $xml_assoc['mess'];
        $texts['message'] .= '<a href="/'.Plussia_Dispatcher::lang().'">'.$xml_assoc['link'].'</a>';
        return $texts;
    }

}