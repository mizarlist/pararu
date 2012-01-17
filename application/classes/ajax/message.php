<?php

class Ajax_Message {

    public static function actions_centerblock($data) {
        $functions = array('ct_contacts', 'ct_admin');
        if (in_array($data, $functions)) {
            return Controller_Actions::getActionsCenterblock(array_search($data, $functions) + 1);
        }
        return null;
    }

    public static function message_deleteMessage($data) {
        $data = (array) $data;
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        if ($sputnik && isset($data['idmessage'])) {
            $sputnik_id = $sputnik->user_id;
            $message_id = $data['idmessage'];
            Plussia_Message::deleteMessage($sputnik_id, $message_id);
            return true;
        }
        return false;
    }

    public static function message_spam($data) {
        $data = (array) $data;
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        if ($sputnik && isset($data['idmessage'])) {
            $sputnik_id = $sputnik->user_id;
            $message_id = $data['idmessage'];
            Plussia_Message::spamMessage($sputnik_id, $message_id);
            return true;
        }
        return false;
    }

    public static function message_send($data) {
        $data = (array) $data;
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        if ($sputnik && isset($data['text'])) {
            $sputnik_id = $sputnik->user_id;
            $text = $data['text'];
            $ans = Plussia_Message::sendMessage($sputnik_id, $text);
            return $ans;
        }
        return false;
    }

    public static function message_send_to($data) {
        $data = (array) $data;
        if (isset($data['sputnikid']) && isset($data['text'])) {
            $sputnik_id = $data['sputnikid'];
            $text = $data['text'];
            $ans = Plussia_Message::sendMessage($sputnik_id, $text);
            return true;
        }
        return false;
    }

    public static function message_deleteHistory($data) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        if ($sputnik) {
            $sputnik_id = $sputnik->user_id;
            Plussia_Message::deleteHistory($sputnik_id);
            return true;
        }
        return false;
    }

    public static function message_deleteAdminMessage($data) {
        $data = (array)$data;
        if(isset($data['idmessage']) && $data['idmessage']) {
            Plussia_Message::deleteAdminMessage($data['idmessage']);
            return true;
        }
        return false;
    }

}