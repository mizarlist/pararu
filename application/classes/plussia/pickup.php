<?php

class Plussia_Pickup {

    public static $cards = array('card_1', 'card_2', 'card_3', 'card_4', 'card_5', 'card_6',
        'card_7', 'card_8', 'card_9', 'card_10', 'card_11', 'card_12');

    public static function getReg2PagesCount() {
        $p = Session::instance()->get('sputniks_by_cards_pages');
        return $p ? $p : 1;
    }

    public static function findByCards($page=1) {
        $max = 5;
        $ui = Plussia_Dispatcher::getUserId();

        $session = Session::instance();
        $sa = $session->as_array();
        $array = array();

        if (!isset($sa['sputniks_by_cards'])) {
            $array = Plussia_Finder::findByCards(100);
            $pages = ceil(count($array) / $max);
            $session->bind('sputniks_by_cards', $array);
            $session->bind('sputniks_by_cards_pages', $pages);
        } else {
            $array = $sa['sputniks_by_cards'];
        }

        $num = count($array);
        if ($num == 0 || $num < ($page - 1) * $max) {
            return array();
        }

        $pieces = array_slice($array, ($page - 1) * $max, $max);
        $ids = array();
        $weights = array();
        foreach ($pieces as $piece) {
            $ids[] = $piece['user_id'];
            $weights[$piece['user_id']] = $piece['summ'];
        }

        $locate = Plussia_Dispatcher::lang();
        $l = $locate == 'ru' ? 'ru' : 'en';

        $request = "select
                city.city_name_$l as city,
                region.region_name_$l as region,
                country.country_name_$l as country,
                ud1.zodiac_id as user_zodiac,
                ud2.zodiac_id as zodiac_id,
                ud2.user_id as user_id,
                ud2.name as name,
                ifnull(sput.last_active, sput.registration_date) as last_active,
                ud2.is_woman as is_woman,
                zh.weight
                from user_data ud1
                left join user_data ud2 on ud2.user_id in (" . join(',', $ids) . ")
                left join user sput on sput.user_id=ud2.user_id
                left join zodiac_harmony zh on zh.zodiac_id=ud1.zodiac_id and zh.sputnik_zodiac like CONCAT('%;', ud2.zodiac_id, ';%')
                left join city_ city on city.city_id=ud2.city_id
                left join region_ region on region.region_id=ud2.region_id
                left join country_ country on country.country_id=ud2.country_id
                where ud1.user_id=$ui";

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $sputniks = array();
        $sputniks_ids = array();

        foreach ($results as $result) {
            $sputniks_ids[] = $result['user_id'];
        }

        $cons = self::getCoincidence($sputniks_ids);

        foreach ($results as $result) {
            $card = array();
            $card['user_id'] = $result['user_id'];
            $card['photo_link'] = Plussia_Linker::getMainPhotoLink($result['user_id'], 0);
            $card['photo_full_link'] = Plussia_Linker::getMainPhotoLink($result['user_id'], 2);
            $card['on_site'] = Plussia_Help::getDateInterval($result['last_active']);
            $card['weight'] = $weights[$result['user_id']];
            $card['is_woman'] = $result['is_woman'];
            $card['name'] = $result['name'];
            $card['user_zodiac'] = $result['user_zodiac'];
            $card['zodiac'] = $result['zodiac_id'];
            $card['zodiac_harmony'] = $result['weight'];
            $card['location'] = $result['city'] . ', ' . $result['region'] . ', ' . $result['country'];
            $card['card'] = array();

            if (isset($cons[$result['user_id']])) {
                foreach ($cons[$result['user_id']] as $card_name => $res) {
                    $card['card'] = $res;
                    $card['card_name'] = $card_name;
                    break;
                }
            } else {
                $card['card'] = array(0);
                $card['card_name'] = 'card_0';
            }

            $sputniks[] = $card;
        }

        usort($sputniks, 'self::cardSortByWeight');
        return $sputniks;
    }

    public static function cardSortByWeight($card1, $card2) {
        if ($card1['weight'] < $card2['weight']) {
            return 1;
        } else if ($card1['weight'] > $card2['weight']) {
            return -1;
        }
        return 0;
    }

    public static function getUsersCards($userIds = array()) {
        $query = DB::select()->from('user_card')->where('user_id', 'in', $userIds);
        $cards = $query->as_assoc()->execute();
        $user_cards = array();
        foreach ($cards as $card) {
            $userId = $card['user_id'];
            if (!isset($user_cards[$userId])) {
                $user_cards[$userId] = array();
            }
            foreach ($card as $field => $value) {
                if (in_array($field, Plussia_Pickup::$cards) !== false) {
                    if (!isset($user_cards[$userId][$field])) {
                        $user_cards[$userId][$field] = array();
                    }
                    $user_cards[$userId][$field][] = $value;
                }
            }
        }
        return $user_cards;
    }

    public static function getCoincidence($userIds = array()) {
        $uid = Plussia_Dispatcher::getUserId();
        $userIds[] = $uid;
        $ucs = self::getUsersCards($userIds);
        $user_cards = $ucs[$uid];
        $ans = array();
        foreach ($ucs as $ui => $cards) {
            if ($ui != $uid) {
                $ans[$ui] = array();
                foreach ($cards as $name => $values) {
                    $res = array_intersect($user_cards[$name], $values);
                    foreach ($res as $k => $r) {
                        if ($r === null) {
                            unset($res[$k]);
                        }
                    }
                    if (count($res)) {
                        $ans[$ui][$name] = $res;
                    }
                }
                if (!count($ans[$ui])) {
                    unset($ans[$ui]);
                }
            }
        }
        return $ans;
    }

}

?>
