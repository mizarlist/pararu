<?php

class Plussia_Comparator {

    public static function getCardsEqualsCount($uid1, $uid2) {

        $arr = self::getCardEqArray($uid1, $uid2);
        $result = array();

        foreach ($arr as $ar) {
            $result[] = count($ar);
        }

        return $result;
    }

    public static function getCardEqArray($uid1, $uid2) {

        $cards1 = Model_UserCard::getCadrsForUser($uid1);
        $cards2 = Model_UserCard::getCadrsForUser($uid2);
        $fields = Model_UserCard::getCardFields();

        $result = array();

        foreach ($fields as $f) {
            $equals = array_intersect($cards1[$f], $cards2[$f]);
            $result[$f] = $equals;
        }

        return $result;
    }

    public static function getKarma($user_id, $sputnik_ids) {
        if (!is_array($sputnik_ids)) {
            $sputnik_ids = array($sputnik_ids);
        }

        $request = "select u.user_id, ri.user_id as favor from user u
               left join rs_interes ri on ri.user_id=u.user_id and ri.sputnik_id=$user_id
               where u.user_id in (" . join(',', $sputnik_ids) . ")";

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();

        foreach($results as $r){
            $ans[$r['user_id']] = array();
            if($r['favor']){
                $ans[$r['user_id']][] = 'favor';
            }
            if(rand(0, 1)){
                $ans[$r['user_id']][] = 'chat'; //переписать для кармы по чату
            }
            if(rand(0, 1)){
                $ans[$r['user_id']][] = 'present'; //переписать для кармы по подаркам
            }
        }

        return $ans;
    }

}