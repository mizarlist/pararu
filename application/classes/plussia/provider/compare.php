<?php

class Plussia_Provider_Compare {

    //Если все хорошо, то возвращается пустое значение, если нужно напечатать что-то
    //вместо вьюшки, возвращаем это что-то
    //при использовании функции важно проверять не вернулось ли что-то, т.к. в этом случае
    //скорее всего вьюшка не заполнена

    public static function page_1(&$view) {
        $max = 9;
        $maxSide = $max / 2;
        $sdText = XML_WithMeta::factory('sputnik_data')->getAssoc();
        $udText = XML_WithMeta::factory('user_data')->getAssoc();
        $count = count($sdText['assoc']);
        $part = $maxSide / $count;

        $keys = array_keys($sdText['assoc']);

        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;

        $view->allprocent = Plussia_Calc::getAll(Plussia_Dispatcher::getUserId(), $sputnik_id);

        $udata1 = Model_UserData::findOneBy(array('user_id' => Plussia_Dispatcher::getUserId()), false, true);
        $udata2 = Model_UserData::findOneBy(array('user_id' => $sputnik_id), false, true);
        $sdata1 = Model_SputnikData::findOneBy(array('user_id' => Plussia_Dispatcher::getUserId()), false, true);
        $sdata2 = Model_SputnikData::findOneBy(array('user_id' => $sputnik_id), false, true);

        $view->userTable = array('left' => array(), 'right' => array());
        $view->sputnikTable = array('left' => array(), 'right' => array());
        $view->userHeaders = array();
        $view->sputnikHeaders = array();
        $view->userEq = array();
        $view->sputnikEq = array();

        $view->procent = 0;

        foreach ($keys as $key) {

            $kor = $udText['meta'][$key]['other'] == 'true' ? 0 : 1;

            if ($sdata1[$key]) {
                $view->userHeaders[] = $udText['meta'][$key]['print'];
                $arrayvars = explode(';', $sdata1[$key]);
                array_shift($arrayvars);
                if ($udata2[$key]) {
                    $sput_index = array_search($udata2[$key], $arrayvars);
                    if ($sput_index !== false) {
                        $var = $arrayvars[$sput_index];
                        $view->procent += $part;
                        $view->userEq[] = true;
                    } else {
                        $var = $arrayvars[Plussia_Help::arrayFirstKey($arrayvars)];
                        $view->userEq[] = false;
                    }
                    $view->userTable['left'][] = $udText['assoc'][$key][$var-$kor] . (count($arrayvars) > 2 ? ', ...' : '');
                    $view->userTable['right'][] = $udText['assoc'][$key][$udata2[$key]-$kor];
                } else {
                    $var = $arrayvars[Plussia_Help::arrayFirstKey($arrayvars)];
                    $view->userTable['left'][] = $udText['assoc'][$key][$var-$kor] . (count($arrayvars) > 2 ? ', ...' : '');
                    $view->userTable['right'][] = '-';
                    $view->userEq[] = false;
                }
            } else {
                $view->procent += $part;
            }

            if ($sdata2[$key]) {
                $view->sputnikHeaders[] = $udText['meta'][$key]['print'];
                $arrayvars = explode(';', $sdata2[$key]);
                array_shift($arrayvars);
                if ($udata1[$key]) {
                    $sput_index = array_search($udata1[$key], $arrayvars);
                    if ($sput_index !== false) {
                        $var = $arrayvars[$sput_index];
                        $view->procent += $part;
                        $view->sputnikEq[] = true;
                    } else {
                        $var = $arrayvars[Plussia_Help::arrayFirstKey($arrayvars)];
                        $view->sputnikEq[] = false;
                    }
                    $view->sputnikTable['left'][] = $udText['assoc'][$key][$var-$kor] . (count($arrayvars) > 2 ? ', ...' : '');
                    $view->sputnikTable['right'][] = $udText['assoc'][$key][$udata1[$key]-$kor];
                } else {
                    $var = $arrayvars[Plussia_Help::arrayFirstKey($arrayvars)];
                    $view->sputnikTable['left'][] = $udText['assoc'][$key][$var-$kor] . (count($arrayvars) > 2 ? ', ...' : '');
                    $view->sputnikTable['right'][] = '-';
                    $view->sputnikEq[] = false;
                }
            } else {
                $view->procent += $part;
            }
        }
        $view->procent = round($view->procent, 2);
        $view->procent += Plussia_Calc::karma(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $view->karma = Plussia_Viewer::getKarma();
        return null;
    }

    public static function page_2(&$view) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;
        $view->allprocent = Plussia_Calc::getAll(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $equals = Plussia_Comparator::getCardEqArray(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $view->cards = XML_Codes::factory('cards')->getAssoc();
        $view->card_with_eq = array();
        $view->allcount = 0;

        $view->procent = Plussia_Calc::cards(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $view->equalCards = array();

        foreach ($equals as $card_id => $eq_array) {
            $num = count($eq_array);
            $i = substr($card_id, 5);
            if ($num) {
                $view->card_with_eq[] = $i;
            }
            $view->allcount += $num;

            if (count($eq_array)) {
                $view->equalCards[$i] = array();
                $view->equalCards[$i]['name'] = Plussia_Help::mb_ucfirst(str_replace('&lt;br/&gt;', '', $view->cards['names'][$i]));

                $arrEqs = array();
                foreach ($eq_array as $e) {
                    $arrEqs[] = $view->cards[$card_id][$e];
                }

                $view->equalCards[$i]['equals'] = join(', ', $arrEqs);
                $view->equalCards[$i]['num'] = count($eq_array);
            }
        }

        return null;
    }

    public static function page_3(&$view) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;
        if(!$sputnik->validateNic() || !Plussia_Dispatcher::getUser()->validateNic()){
            return $view->text['nic_disabled'];
        }
        $view->allprocent = Plussia_Calc::getAll(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $sputnikData = $sputnik->getUserData();
        $userData = Plussia_Dispatcher::getUser()->getUserData();
        $ut = Plussia_Getter::getLastNoeticType(Plussia_Dispatcher::getUser());
        $st = Plussia_Getter::getLastNoeticType($sputnik);
        $imgs = array(
            'left' => array('big' => Plussia_Linker::getUserSonicPic($userData->is_woman, $ut, 2, 'left'),
                'mini' => Plussia_Linker::getUserSonicPic($userData->is_woman, $ut, 1, 'left')),
            'right' => array('big' => Plussia_Linker::getUserSonicPic($sputnikData->is_woman, $st, 2, 'right'),
                'mini' => Plussia_Linker::getUserSonicPic($sputnikData->is_woman, $st, 1, 'right'))
        );
        $view->imgs = $imgs;

        $index = Plussia_Getter::getNoeticCompareIndex(Plussia_Dispatcher::getUser(), $sputnik);
        $unt = ($userData->is_woman ? 'w' : 'm') . '_' . $ut;
        $snt = ($sputnikData->is_woman ? 'w' : 'm') . '_' . $st;

        $ntText = XML_WithMeta::factory('noeticTypes')->getAssoc();

        $view->userTexts = array($ntText['assoc'][$unt], $ntText['assoc'][$snt]);
        $view->typeNames = array($ntText['meta'][$unt]['print'], $ntText['meta'][$snt]['print']);
        $view->procent = round(Plussia_Calc::noetic(Plussia_Dispatcher::getUserId(), $sputnik_id), 2);

        $compareXMLs = array(
            'sum' => XML_Texts::factory('compare/noeticCompare', '/')->getAssoc(),
            'psy' => XML_Texts::factory('compare/noeticCompare_psy', '/')->getAssoc(),
            'sex' => XML_Texts::factory('compare/noeticCompare_sex', '/')->getAssoc(),
            'soc' => XML_Texts::factory('compare/noeticCompare_soc', '/')->getAssoc(),
            'spi' => XML_Texts::factory('compare/noeticCompare_spi', '/')->getAssoc()
        );

        $view->compareTexts = array(
            'sum' => $compareXMLs['sum'][$index],
            'psy' => $compareXMLs['psy'][$index],
            'sex' => $compareXMLs['sex'][$index],
            'soc' => $compareXMLs['soc'][$index],
            'spi' => $compareXMLs['spi'][$index]
        );
        return null;
    }

    public static function page_4(&$view) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;
        if(!$sputnik->validateNic() || !Plussia_Dispatcher::getUser()->validateNic()){
            return $view->text['nic_disabled'];
        }
        $view->allprocent = Plussia_Calc::getAll(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $view->sonic = XML_Texts::factory('sonic', '/')->getAssoc();

        $view->uid1 = Plussia_Dispatcher::getUserId();
        $view->uid2 = $sputnik_id;

        $ptc = new Plussia_Test_Character();
        $view->percent = round($ptc->getPersent($view->uid1, $sputnik_id), 2);
        $c_like = $ptc->getGeneralPersent($view->uid1, $sputnik_id);
        $c_diff = $ptc->getDifferentPersent($view->uid1, $sputnik_id);
        $c_user_sputnik = $ptc->getUserCompl($view->uid1, $sputnik_id);
        $c_sputnik_user = $ptc->getStlCompl($view->uid1, $sputnik_id);
        $view->percents = array('c_like' => 0, 'c_diff' => 0, 'c_user_sputnik' => 0, 'c_sputnik_user' => 0);
        $fields = array('st', 'ha', 'la', 'fr', 'so', 'no');

        foreach ($view->percents as $key => &$val) {
            $truevals = array();
            $sum = 0;
            foreach ($$key as $i => $v) {
                $truevals[$fields[$i]] = $v < 0 ? 0 : ($v > 100 ? 100 : round($v));
                $sum += $truevals[$fields[$i]];
            }
            $view->$key = $truevals;
            $val = round($sum / 6, 2);
        }

        return null;
    }

    public static function page_5(&$view) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;
        $view->allprocent = Plussia_Calc::getAll(Plussia_Dispatcher::getUserId(), $sputnik_id);
        $view->procent = Plussia_Calc::zodiak(Plussia_Dispatcher::getUserId(), $sputnik_id);

        $view->userZodiak = Plussia_Dispatcher::getUser()->getUserData()->zodiac_id;
        $view->sputnikZodiak = $sputnik->getUserData()->zodiac_id;

        $view->zodiakText = XML_Base::factory('zodiac', null, null, null, 'zodiac')->getAssoc();
        $view->zodiakHarmonyText = XML_Texts::factory('zodiak_harmony_text', '/')->getAssoc();
        
        $view->zhi = Model_Extra_Zodiac::getHarmonyIndex($view->userZodiak, $view->sputnikZodiak);

        $view->pics = array(Plussia_Linker::getZodiakPic($view->userZodiak, 'left'),
            Plussia_Linker::getZodiakPic(),
            Plussia_Linker::getZodiakPic($view->sputnikZodiak, 'right'));

        return null;
    }

    public static function oneCardCompare(&$view, $card_number) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;

        $cards1 = Model_UserCard::getCadrsForUser(Plussia_Dispatcher::getUserId());
        $cards2 = Model_UserCard::getCadrsForUser($sputnik_id);
        $f = 'card_' . $card_number;

        $variants_eq = array_values(array_intersect($cards1[$f], $cards2[$f]));
        $variants_left = array_values(array_diff($cards1[$f], $cards2[$f]));
        $variants_right = array_values(array_diff($cards2[$f], $cards1[$f]));

        $view->subcount = count($variants_eq);
        $view->allcount = 0;

        $equals = Plussia_Comparator::getCardEqArray(Plussia_Dispatcher::getUserId(), $sputnik_id);
        foreach ($equals as $card_id => $eq_array) {
            $num = count($eq_array);
            $view->allcount += $num;
        }

        $cards_text = XML_Codes::factory('cards')->getAssoc();

        $ce = count($variants_eq);
        $cl = count($variants_left);
        $cr = count($variants_right);
        $view->table_lines = max(array($ce + $cl, $ce + $cr));
        $view->cardname = Plussia_Help::mb_ucfirst($cards_text['names'][$card_number]);

        $view->table = array('left' => array(), 'right' => array());
        for ($i = 0; $i < $view->table_lines; $i++) {
            if (isset($variants_eq[$i]) && $variants_eq[$i]) {
                $view->table['left'][] = $cards_text[$f][$variants_eq[$i]];
                $view->table['right'][] = $cards_text[$f][$variants_eq[$i]];
            } else if ((isset($variants_left[$i - $ce]) && $variants_left[$i - $ce]) || (isset($variants_right[$i - $ce]) && $variants_right[$i - $ce])) {
                $view->table['left'][] = (isset($variants_left[$i - $ce]) && $variants_left[$i - $ce]) ? $cards_text[$f][$variants_left[$i - $ce]] : '-';
                $view->table['right'][] = (isset($variants_right[$i - $ce]) && $variants_right[$i - $ce]) ? $cards_text[$f][$variants_right[$i - $ce]] : '-';
            }
        }

        return null;
    }

}
