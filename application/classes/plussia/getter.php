<?php

class Plussia_Getter {

    public static function getAboutUser($user_id) {
        $ui = XML_WithMeta::factory('user_data')->getAssoc();
        $broad = XML_Base::factory('broad')->getAssoc();
        $p = Plussia_Dispatcher::lang();
        $p = in_array($p, array('ru', 'en')) ? $p : 'en';
        $request = 'select u.birthday, country.country_name_' . $p . ' as country, region.region_name_' . $p . ' as region, city.city_name_' . $p . ' as city, u.eyescolor, u.is_woman, u.haircolor, u.growth, u.physique, u.ethnos, u.languages
            from user_data u
            left join country_ country on country.country_id=u.country_id
            left join region_ region on region.region_id=u.region_id
            left join city_ city on city.city_id=u.city_id
            where user_id=' . $user_id;

        $query = DB::query(Database::SELECT, $request);
        list($result) = $query->as_assoc()->execute();

        $values = array();

        foreach ($result as $k => $r) {
            if (!in_array($k, array('birthday', 'country', 'region', 'city', 'languages', 'is_woman'))) {
                $values[$k] = $r ? $ui['assoc'][$k][$r - ($ui['meta'][$k]['other'] == 'true' ? 0 : 1)] : $broad['not_spec'];
            }
        }
        $values['gender'] = $broad['me_gender'][$result['is_woman']];
        foreach (array('birthday', 'country', 'region', 'city') as $k) {
            $values[$k] = $result[$k];
        }
        $values['age'] = Model_UserData::getAgeByDate($result['birthday']);
        $values['languages'] = $broad['not_spec'];

        if ($result['languages']) {
            $nums = explode(';', $result['languages']);
            $langs = array();
            foreach ($nums as $n) {
                if ($n) {
                    $langs[] = $ui['assoc']['languages'][$n];
                }
            }
            $values['languages'] = join(',', $langs);
        }

        $names = array();

        foreach (array('age', 'country', 'region', 'city') as $f) {
            $names[$f] = $broad[$f];
        }
        $names['gender'] = $broad['gender'];
        foreach (array('eyescolor', 'haircolor', 'growth', 'physique', 'ethnos') as $f) {
            $names[$f] = $ui['meta'][$f]['print'];
        }
        list($names['languages']) = explode(',', $ui['meta']['languages']['print']);

        return array('fields' => $names, 'values' => $values);
    }

    public static function getTypeOf6(Model_User $u) {
        $types = array('st', 'ha', 'la', 'fr', 'so', 'no');
        $utypes = Model_NicCard::getCharacterForUser($u->user_id);
        array_shift($utypes);
        $max = max($utypes);
        return $types[array_search($max, $utypes)];
    }

    public static function getNoeticType(Model_User $user) {
        $ptno = new Plussia_Test_NoeticOne();
        $type = $ptno->getResult($user->user_id);
        Session::instance()->bind('lastTypeFor_' . $user->user_id, $type);
        return $type;
    }

    public static function getLastNoeticType(Model_User $user) {
        $type = Session::instance()->get('lastTypeFor_' . $user->user_id);
        return $type ? $type : self::getNoeticType($user);
    }

    public static function getNoeticCompareIndex(Model_User $u1, Model_User $u2) {
        $types = array(self::getLastNoeticType($u1), self::getLastNoeticType($u2));
        $prefix = 'mw';
        $post1 = '';
        $post2 = '';
        if ($u1->getUserData()->is_woman != $u2->getUserData()->is_woman) {
            $var1 = 'post' . ($u1->getUserData()->is_woman ? 2 : 1);
            $var2 = 'post' . ($u2->getUserData()->is_woman ? 2 : 1);
            $$var1 = $types[0];
            $$var2 = $types[1];
        } else {
            $post1 = $types[0];
            $post2 = $types[1];
        }
        return $prefix . '_' . $post1 . '_' . $post2;
    }

    public static function getLimitPercent($per, $vals) {
        foreach ($vals as $v) {
            if ($per < $v) {
                return $v;
            }
        }
        return $vals[count($vals) - 1];
    }

    public static function getPsyProfileText1($percents) {
        $key = array();
        foreach ($percents as $p) {
            $key[] = self::getLimitPercent($p, array(50, 100)) . '';
        }
        $key = join('_', $key);
        $text = XML_Texts::factory('psy_profile', '/')->getAssoc();
        return $text[$key];
    }

    public static function getPsyProfileText2($percents) {
        $pares = array(array(1, 4), array(3, 6), array(5, 2));
        $result = array('', '', '');
        $text = XML_Texts::factory('psy_profile_2', '/')->getAssoc();
        foreach ($pares as $i => $pare) {
            foreach ($pare as $k) {
                $result[$i] .= $text[$k][self::getLimitPercent($percents[$k], array(30, 60, 100)) . ''];
            }
        }
        return $result;
    }

    public static function getPsyProfileText3($percents) {
        $triades = array(array(2, 3, 4), array(5, 6, 1), array(1, 2, 3), array(6, 5, 4), array(6, 1, 2), array(5, 4, 3));
        $text = XML_Texts::factory('psy_profile_3', '/')->getAssoc();
        $result = array();
        foreach ($triades as $triade) {
            $key = join('_', $triade);
            $val = ($percents[$triade[0]] + $percents[$triade[1]] + $percents[$triade[2]]) / 3;
            $result[] = $text[$key][self::getLimitPercent($val, array(30, 60, 100)) . ''];
        }
        return $result;
    }

    public static function getPsyProfileText($percents) {
        $t1 = array(self::getPsyProfileText1($percents));
        $t2 = self::getPsyProfileText2($percents);
        $t3 = self::getPsyProfileText3($percents);
        $result = array();
        foreach (array($t1, $t2, $t3) as $arr) {
            foreach ($arr as $t) {
                $result[] = $t;
            }
        }
        return $result;
    }

    static $values = null;
    public static function getTopValues() {
        if(!self::$values){
            $user = Plussia_Dispatcher::getUser();
            self::$values = array(
            'new_users' => $user->getRSCount('new'),
            'new_interesme' => $user->getRSCount('interesme'),
            'new_masseges' => Plussia_Message::getNewCount(),
            'page_complete' => 73);
        }
        return self::$values;
    }

}