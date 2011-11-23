<?php

class Plussia_Finder {

    public static function findByCards($count = null, $from = null) {
        $id = Plussia_Dispatcher::getUserId();
        $locate = Plussia_Dispatcher::lang();
        $l = $locate=='ru' ? 'ru' : 'en';

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
                    left join sputnik_data sd
                        on sd.user_id=uc1.user_id
                    left join user_data userdata
                        on userdata.user_id=uc1.user_id
                    left join user_data ud
                        on ud.user_id=uc2.user_id
                    left join zodiac_harmony zh
                        on userdata.zodiac_id=zh.zodiac_id and zh.sputnik_zodiac like CONCAT('%;', ud.zodiac_id, ';%')
                    where uc1.user_id=$id
                    $addition
                    group by uc2.user_id
                    order by summ DESC";

        if($count) {
            $request .= " LIMIT $count";
        }
        if($from) {
            $request .= " OFFSET $from";
        }

        $query = DB::query(Database::SELECT, $request);

        $results = $query->as_assoc()->execute();
        $ans = array();

        foreach($results as $res) {
            if($res['summ'] && $res['summ']>0) {
                $node = array();
                $node['user_id'] = $res['user_id'];
                $node['summ'] = $res['summ'];
                $ans[] = $node;
            }
        }

        return $ans;
    }

}