<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Info_AuthenticationSuccess extends Plussia_Info {

    public function get_texts($config) {
        //необходим name
        $texts = array('title' => '', 'message' => '');
        $xml_assoc = XML_Texts::factory('infos/authentication_success')->getAssoc();
        $texts['title'] = $xml_assoc['title'];
        $texts['message'] = $config['name'].$xml_assoc['mess'];
        $texts['message'] .= '<a href="/'.Plussia_Dispatcher::lang().'">'.$xml_assoc['link'].'</a>';
        return $texts;
    }

}