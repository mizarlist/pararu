<?php defined('SYSPATH') or die('No direct script access.');

abstract class Plussia_Info {

    public $texts = array('title' => '', 'message' => '');

    public function get_texts($config) {
        return $this->texts;
    }

    public static function factory($info_type, $config = null) {
        $class = 'Plussia_Info_'.$info_type;
        $info = new $class;
        Session::instance()->bind('info', $info_type);
        $texts = $info->get_texts($config);
        Session::instance()->bind('title', $texts['title']);
        Session::instance()->bind('message', $texts['message']);
        header("Location: /info");
        die();
    }

    public static function call($infoId) {
        Session::instance()->bind('info', $infoId);
        $texts = XML_Info::getInfoContent($infoId);
        Session::instance()->bind('title', $texts['title']);
        Session::instance()->bind('message', $texts['message']);
        header("Location: /info");
        die();
    }

}