<?php

class Ajax_Help {

    public static function help($data) {
        list($column, $punkt) = explode('_', $data);
        return Plussia_Viewer::getHelp($column, $punkt);
    }

    public static function help_add_question($data) {
        $msgs = XML_Msgs::factory('other')->getAssoc();
        if (!$data) {
            return 'txt_' . $msgs['empty_question'];
        }
        Model_Question::add(Plussia_Dispatcher::getUserId(), $data);
        return 'txt_' . $msgs['thanks_for_question'];
    }

}