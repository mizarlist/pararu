<?php


class Plussia_Config {

    public static $locates = array('ru');
    
    public static function currentLang() {
        $l = Session::instance()->get('current_lang');
        return $l ? $l : 'ru';
    }

    public static function registerLang($lang) {
        Session::instance()->set('current_lang', $lang);
    }
    
}