<?php

class Plussia_Calc {

    public static function karma($uid1, $uid2) {
        return 5;
    }

    public static function views($uid1, $uid2) {
        $max = 9;
        $maxSide = $max / 2;
        $sdText = XML_WithMeta::factory('sputnik_data')->getAssoc();
        $count = count($sdText['assoc']);
        $part = $maxSide / $count;

        $keys = array_keys($sdText['assoc']);

        $sputnik_id = $uid2;

        $udata1 = Model_UserData::findOneBy(array('user_id' => $uid1), false, true);
        $udata2 = Model_UserData::findOneBy(array('user_id' => $sputnik_id), false, true);
        $sdata1 = Model_SputnikData::findOneBy(array('user_id' => $uid1), false, true);
        $sdata2 = Model_SputnikData::findOneBy(array('user_id' => $sputnik_id), false, true);

        $procent = 0;

        foreach ($keys as $key) {

            if ($sdata1[$key]) {
                $arrayvars = explode(';', $sdata1[$key]);
                array_shift($arrayvars);
                if ($udata2[$key]) {
                    $sput_index = array_search($udata2[$key], $arrayvars);
                    if ($sput_index !== false) {
                        $procent += $part;
                    }
                }
            } else {
                $procent += $part;
            }

            if ($sdata2[$key]) {
                $arrayvars = explode(';', $sdata2[$key]);
                array_shift($arrayvars);
                if ($udata1[$key]) {
                    $sput_index = array_search($udata1[$key], $arrayvars);
                    if ($sput_index !== false) {
                        $var = $arrayvars[$sput_index];
                        $procent += $part;
                    }
                }
            } else {
                $procent += $part;
            }
        }
        $procent = round($procent, 2);
        $procent = $procent + self::karma($uid1, $uid2);
        return $procent;
    }

    public static function cards($uid1, $uid2) {

        $max = 12;
        $cardsCount = 12;
        $side = $max / 2;
        $sideBall = $side / $cardsCount;

        $cards1 = Model_UserCard::getCadrsForUser($uid1);
        $cards2 = Model_UserCard::getCadrsForUser($uid2);
        $result = 0;
        $fields = Model_UserCard::getCardFields();

        foreach ($fields as $f) {
            $count1 = count($cards1[$f]);
            $count2 = count($cards2[$f]);
            if ($count1 == 0 || $count2 == 0) {
                continue;
            }
            $eqBall1 = $sideBall / $count1;
            $eqBall2 = $sideBall / $count2;
            $equals = array_intersect($cards1[$f], $cards2[$f]);
            $eqCount = count($equals);
            $result += $eqBall1 * $eqCount + $eqBall2 * $eqCount;
        }

        return round($result, 2);
    }

    public static function noetic($uid1, $uid2) {
        if (Model_User::getById($uid2)->validateNic() && Model_User::getById($uid1)->validateNic()) {
            $ptn = new Plussia_Test_Noetic();
            return $ptn->getResult($uid1, $uid2);
        }
        return 0;
    }

    public static function character($uid1, $uid2) {
        if (Model_User::getById($uid2)->validateNic() && Model_User::getById($uid1)->validateNic()) {
            $ptc = new Plussia_Test_Character();
            return $ptc->getPersent($uid1, $uid2);
        }
        return 0;
    }

    public static function zodiak($uid1, $uid2) {

        $request = "select zh.weight from user_data ud left join user_data sd on sd.user_id=$uid2
        left join zodiac_harmony zh on ud.zodiac_id=zh.zodiac_id and zh.sputnik_zodiac like
        CONCAT('%;', sd.zodiac_id, ';%')
        where ud.user_id = $uid1
        limit 1";

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        foreach ($results as $r) {
            return $r['weight'];
        }
    }

    public static function all($uid1, $uid2, $bindResult = true) {
        $t1 = self::views($uid1, $uid2);
        $t2 = self::cards($uid1, $uid2);
        $t3 = self::noetic($uid1, $uid2);
        $t4 = self::character($uid1, $uid2);
        $t5 = self::zodiak($uid1, $uid2);

        $all = $t1 + $t2 + $t3 + $t4 + $t5;
        $all = round($all, 2);
        $bindResult && Session::instance()->bind('user_compare_proc:' . $uid1 . '_' . $uid2, $all);
        return $all;
    }

    public static function getAll($uid1, $uid2) {
        $all = Session::instance()->get('user_compare_proc:' . $uid1 . '_' . $uid2);
        if (!$all) {
            $all = self::all($uid1, $uid2);
        }
        return $all;
    }

}

?>
