<?php

class Plussia_Linker {
    const VARIANT_SMALL = 0;
    const VARIANT_MEDIUM = 1;
    const VARIANT_LARGE = 2;

    const TYPE_OFF = 'off';
    const TYPE_ON = 'on';

    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';

    public static function getMainPhotoLink($user_id, $variant=0) {
        //$user_id = 1;
        $postfix = $variant ? ($variant == self::VARIANT_MEDIUM ? '_medium' : '_large') : '';
        $link = '/userfiles/u' . Model_User::getUID($user_id) . '/photo/main' . $postfix . '.jpg?mk='.  microtime();
        return $link;
    }

    public static function getLastGift($user_id, $variant=0) {
        return "/images/profile/presents/palm.jpg";
    }

    public static function getLastGifts($user_id, $variant=0) {
        return array('/images/profile/presents/mini_flower1.jpg',
        '/images/profile/presents/mini_ice.jpg',
        '/images/profile/presents/mini_flower1.jpg',
        '/images/profile/presents/mini_ice.jpg',
        '/images/profile/presents/mini_martini.jpg');
    }

    public static function getReligionIcon($religion, $type='off'){
        return "/images/sonic/religion/".$religion."_$type.png";
    }
    public static function getZodiacIcon($zodiac, $type='off'){
        return "/images/sonic/zodiac/".$zodiac."_$type.png";
    }
    public static function getInteresIcon($interes, $type='off'){
        return "/images/sonic/intereses/".$interes."_$type.png";
    }
    public static function getMWIcon($is_woman = 0, $position='left', $type='off'){
        $pre = $is_woman ? 'w' : 'm';
        return "/images/sonic/mw/".$pre."_$position"."_$type.png";
    }
    public static function getHeartIcon($position='left', $type='off'){
        return "/images/sonic/heart/".$position."_$type.png";
    }

    public static function getUserSonicPic($is_woman = 0, $type = 1, $variant = 1, $position = 'left'){
        $pre = $is_woman ? 'w' : 'm';
        return "/images/sonic/types".($variant==1 ? '/mini' : '')."/".$pre."_$type"."_$position".($variant==1 ? '_mini' : '').".png";
    }

    public static function getZodiakPic($zodiac_id = 0, $position='left'){
        if(!$zodiac_id){
            return "/images/sonic/zodiac_pic/g_plus.jpg";
        }
        return "/images/sonic/zodiac_pic/".$position."_$zodiac_id.jpg";
    }

}