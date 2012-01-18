<?php

class Plussia_Finder {

    public static function findByCards($count = null, $from = null) {
        $id = Plussia_Dispatcher::getUserId();
        $locate = Plussia_Dispatcher::lang();
        $l = $locate == 'ru' ? 'ru' : 'en';

        $addition = " and userdata.country_id=ud.country_id
                    and userdata.region_id=ud.region_id
                    and sd.is_woman=ud.is_woman ";

        $request = "select (sum(IFNULL(uc1.card_1 = uc2.card_1, 0)
                    + IFNULL(uc1.card_2 = uc2.card_2, 0)
                    + IFNULL(uc1.card_3 = uc2.card_3, 0)
                    + IFNULL(uc1.card_4 = uc2.card_4, 0)
                    + IFNULL(uc1.card_5 = uc2.card_5, 0)
                    + IFNULL(uc1.card_6 = uc2.card_6, 0)
                    + IFNULL(uc1.card_7 = uc2.card_7, 0)
                    + IFNULL(uc1.card_8 = uc2.card_8, 0)
                    + IFNULL(uc1.card_9 = uc2.card_9, 0)
                    + IFNULL(uc1.card_10 = uc2.card_10, 0)
                    + IFNULL(uc1.card_11 = uc2.card_11, 0)
                    + IFNULL(uc1.card_12 = uc2.card_12, 0)
                    ) + IFNULL(zh.weight, 0)) as summ, uc2.user_id
                    from user_card uc1
                    left join user_card uc2
                        on uc2.user_id!=uc1.user_id
                    left join user u2
                        on u2.user_id=uc2.user_id
                    left join sputnik_data sd
                        on sd.user_id=uc1.user_id
                    left join user_data userdata
                        on userdata.user_id=uc1.user_id
                    left join user_data ud
                        on ud.user_id=uc2.user_id
                    left join zodiac_harmony zh
                        on userdata.zodiac_id=zh.zodiac_id and zh.sputnik_zodiac like CONCAT('%;', ud.zodiac_id, ';%')
                    where uc1.user_id=$id and u2.active=1
                    $addition
                    group by uc2.user_id
                    order by summ DESC";

        if ($count) {
            $request .= " LIMIT $count";
        }
        if ($from) {
            $request .= " OFFSET $from";
        }

        $query = DB::query(Database::SELECT, $request);

        $results = $query->as_assoc()->execute();
        $ans = array();

        foreach ($results as $res) {
            if ($res['summ'] && $res['summ'] > 0) {
                $node = array();
                $node['user_id'] = $res['user_id'];
                $node['summ'] = $res['summ'];
                $ans[] = $node;
            }
        }

        return $ans;
    }

    public static function fastFind($data, $start = 0, $limit = 10) {

        $user = Plussia_Dispatcher::getUser();
        $locate = Plussia_Config::currentLang() == 'ru' ? 'ru' : 'en';

        $conditions = array();
        $conditions[] = "u2.active = 1";
        $conditions[] = 
        "u2.user_id not in (
            select sputnik_id from rs_new where user_id = {$user->user_id}
            union
            select sputnik_id from rs_saved where user_id = {$user->user_id}
            union
            select sputnik_id from rs_interes where user_id = {$user->user_id}
            union
            select sputnik_id from rs_nosearch where user_id = {$user->user_id}
            union
            select sputnik_id from rs_ignor where user_id = {$user->user_id}
         )";
         $conditions[] = "sd2.is_woman = ". ($user->isWoman() ? 1 : 0);
         $conditions[] = "ud2.is_woman = ". $data['is_woman'];

         if($data['country_id']) {
             $conditions[] = "c_.country_id = ". $data['country_id'];
         }
         if($data['region_id']) {
             $conditions[] = "r_.region_id = ". $data['region_id'];
         }
         if($data['city_id']) {
             $conditions[] = "ci_.city_id = ". $data['city_id'];
         }

         if($data['photo']) {
             $conditions[] = "(select count(*) from photo p where user_id = u2.user_id) > 0";
         }

         $data['age_from'] = intval($data['age_from']);
         if($data['age_from']) {
            $m= date("m");
            $de= date("d");
            $y= date("Y") - $data['age_from'];
            $date = date('Y-m-d', mktime(0,0,0,$m,$de,$y));
            $conditions[] = "ud2.birthday <= DATE_FORMAT('{$date}','%Y-%m-%d')";
         }

         $data['age_to'] = intval($data['age_to']);
         if($data['age_to']) {
            $m= date("m");
            $de= date("d");
            $y= date("Y") - $data['age_to'] - 1;
            $date = date('Y-m-d', mktime(0,0,0,$m,$de,$y));
            $conditions[] = "ud2.birthday >= DATE_FORMAT('{$date}','%Y-%m-%d')";
         }

         if($data['online']) {
            $conditions[] = "u2.last_active >= DATE_ADD(NOW(),INTERVAL -10 MINUTE)";
         }

        
        $request = "select ud2.user_id, ud2.name, ifnull(u2.username, u2.standart_username) as username,
                    ud2.birthday, ud2.is_woman, u2.active, u2.registration_date,
                    ifnull(u2.last_active, u2.registration_date) as last_active,
                    c_.country_name_$locate as country,
                    ci_.city_name_$locate as city
                    from user u2
                    left join user_data ud2 on ud2.user_id=u2.user_id
                    left join sputnik_data sd2 on sd2.user_id=u2.user_id
                    left join country_ c_ on c_.country_id=ud2.country_id
                    left join region_ r_ on r_.region_id=ud2.region_id
                    left join city_ ci_ on ci_.city_id=ud2.city_id

                    where

                    ".  join(' AND ', $conditions)."

                    order by u2.user_id DESC";

        $request .= " LIMIT $limit";
        $request .= " OFFSET $start";

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();
        $ans = array();

        foreach ($results as $res) {
            $res['ball'] = Plussia_Calc::all($user->user_id, $res['user_id']);
            $ans[] = $res;
        }

        return $ans;

    }

}