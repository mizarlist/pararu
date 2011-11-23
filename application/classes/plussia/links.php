<?php

class Plussia_Links {

    public static function intro_top() {
        $lang = Plussia_Config::currentLang();
        return array(
            '/',
            '/tour/1',
            '/whyweare',
            '/successes'
        );
    }

    public static function whyweare_top() {
        $lang = Plussia_Config::currentLang();
        return array(
            '/whyweare',
            '/whyweare/1',
            '/whyweare/2',
            '/whyweare/3'
        );
    }

    public static function tour_top() {
        $lang = Plussia_Config::currentLang();
        return array(
            '/tour/1',
            '/tour/2',
            '/tour/3',
            '/tour/4',
            '/tour/5',
            '/tour/6'
        );
    }

    public static function userpage_top() {
        $lang = Plussia_Config::currentLang();
        return array(
            '/profile',
            '/tour',
            '#',
            '/account',
            '/logout'
        );
    }

}