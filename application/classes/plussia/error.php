<?php defined('SYSPATH') or die('No direct script access.');

abstract class Plussia_Error {

    public $texts = array('title' => '', 'message' => '');

    public function get_texts($config) {
        return $this->texts;
    }

    public static function factory($error_type, $config = null) {
        $class = 'Plussia_Error_'.$error_type;
        $error = new $class;
        Session::instance()->bind('error', $error_type);
        $texts = $error->get_texts($config);
        Session::instance()->bind('title', $texts['title']);
        Session::instance()->bind('message', $texts['message']);
        header('Location: /error');
        die();
    }

    public static function call($errorId) {
        Session::instance()->set('error', $errorId);
        $texts = XML_Error::getErrorContent($errorId);
        Session::instance()->set('title', $texts['title']);
        Session::instance()->set('message', $texts['message']);
        header('Location: /error');
        die();
    }

}
