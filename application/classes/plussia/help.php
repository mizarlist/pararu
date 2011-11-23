<?php

defined('SYSPATH') or die('No direct script access.');

class Plussia_Help {

    public static $locates = array('ru', 'en');
    public static $ruChars = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н',
        'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ь', 'ы', 'ъ', 'э', 'ю', 'я');
    public static $enChars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o',
        'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    public static $textPatern = "/^[абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИКЛМНОПРСТУФХЧШЩЬЫЪЭЮЯa-zA-Z ]{0,255}$/";
    public static $digitPatern = "/^[0-9]{1,11}$/";
    public static $safePatern = "/^[абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИКЛМНОПРСТУФХЧШЩЬЫЪЭЮЯa-zA-Z0-9_ ]*$/";
    public static $safeEnPatern = "/^[a-zA-Z0-9_ ]*$/";

    public static $ddtFormat = 'y-m-d G:i:s';
    public static $formatRuDT = 'd.m.Y H:i:s';

    public static function getFirstCharLocate($str) {
        $char = mb_strtolower(mb_substr($str, 0, 1));
        foreach (self::$locates as $locate) {
            $arrayName = $locate . 'Chars';
            if (in_array($char, self::$$arrayName)) {
                return $locate;
            }
        }
        return null;
    }

    public static function is_text_only($str) {
        return preg_match(self::$textPatern, $str);
    }

    public static function is_digit_only($str) {
        return preg_match(self::$digitPatern, $str);
    }

    public static function is_safe($str) {
        return preg_match(self::$safePatern, $str);
    }

    public static function is_safe_en($str) {
        return preg_match(self::$safeEnPatern, $str);
    }

    public static function is_mail($str) {
        return preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $str);
    }

    public static function arrayFirstKey($array) {
        foreach ($array as $k => $v) {
            return $k;
        }
    }

    public static function mb_ucfirst($str) {
        $c1 = mb_substr($str, 0, 1);
        $cc = substr($str, 1, strlen($str));
        return mb_strtoupper($c1) . mb_strtolower($cc);
    }

    public static function numText($number, Array $words) {
        $number = abs($number);
        if(!$number) return $words[2];
        $t1 = $number % 10;
        $t2 = $number % 100;
        return ($t1 == 1 && $t2 != 11 ? $words[0] : ($t1 >= 2 && $t1 <= 4 && ($t2 < 10 || $t2 >= 20) ? $words[1] : $words[2]));
    }

    public static function getDateDiff($date1, $date2){
        $date1 = date_parse($date1);
        $date2 = date_parse($date2);

        $date_time1 = mktime($date1['hour'], $date1['minute'], $date1['second'], $date1['month'], $date1['day'], $date1['year']);
        $date_time2 = mktime($date2['hour'], $date2['minute'], $date2['second'], $date2['month'], $date2['day'], $date2['year']);

        return $date_time1 - $date_time2;
    }

    public static function getDateInterval($date){
        $date = date_parse($date);
        $now = date_parse(date(self::$ddtFormat));

        $date_time = mktime($date['hour'], $date['minute'], $date['second'], $date['month'], $date['day'], $date['year']);
        $now_time = time();

        $dif = $date_time - $now_time;
        $pre = $dif > 0 ? '' : '-';
        
        $y = abs($now['year'] - $date['year']);
        $m = abs($now['month'] - $date['month']);
        $d = abs($now['day'] - $date['day']);
        $h = abs($now['hour'] - $date['hour']);
        $mi = abs($now['minute'] - $date['minute']);

        if($y){
            return $y > 1 ? $pre.'100500' : $pre.'730';
        }

        if($m){
            return $m > 1 ? $pre.'365' : $pre.'60';
        }

        $fwn = getdate($now_time);
        $wdn = $fwn["wday"];
        $wdn = $wdn==0 ? 7 : $wdn;
        $dwdn = $dif > 0 ? (8-$wdn) : $wdn;

        if($d){
            return ($d >= ($dwdn + 7)) ? $pre.'30' : (($d==2 || $d==1) ? $pre.$d : ($d >= $dwdn ? $pre.'14' : $pre.'7'));
        }

        if($h){
            return '-0';
        }

        if($mi){
            return $mi > 10 ? '-0' : '0';
        }
    }

}
