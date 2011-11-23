<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Info_MailSended extends Plussia_Info {

    public function get_texts($config) {
        //в конфиге name и email
        $texts = array('title' => '', 'message' => '');
        $xml_assoc = XML_Texts::factory('infos/mail_sended')->getAssoc();
        $texts['title'] = $xml_assoc['title'];
        $texts['message'] = $config['name'].$xml_assoc['intro'];
        $texts['message'] .= $xml_assoc['mail_begin'].$config['email'].$xml_assoc['mail_end'];
        $texts['message'] .= '<br><a href="/'.Plussia_Dispatcher::lang().'">'.$xml_assoc['link'].'</a>';
        return $texts;
    }

}