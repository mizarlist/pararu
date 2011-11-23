<?php

class Plussia_Provider_Sputnik {

    //Если все хорошо, то возвращается пустое значение, если нужно напечатать что-то
    //вместо вьюшки, возвращаем это что-то
    //при использовании функции важно проверять не вернулось ли что-то, т.к. в этом случае
    //скорее всего вьюшка не заполнена

    public static function page_1(&$view, $aboutme = false) {
        if (!$aboutme) {
            $sputnik = Model_User::get(Request::$current->controllerNameStore);
            $sputnik_id = $sputnik->user_id;
        } else {
            $sputnik = Plussia_Dispatcher::getUser();
            $sputnik_id = $sputnik->user_id;
        }

        $view->sputnik_name = $sputnik->getUserData()->name;
        $view->broad = XML_Base::factory('broad')->getAssoc();
        $view->lastgift = Plussia_Linker::getLastGift($sputnik_id, Plussia_Linker::VARIANT_LARGE);
        $view->gifts = Plussia_Linker::getLastGifts($sputnik_id, Plussia_Linker::VARIANT_MEDIUM);
        $view->last_status = $sputnik->getLastStatus();
        $view->about_user = Plussia_Getter::getAboutUser($sputnik_id);
        return null;
    }

    public static function page_2(&$view) {
        return null;
    }

    public static function page_3(&$view) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;

        $sputnikData = $sputnik->getUserData();
        $userData = Plussia_Dispatcher::getUser()->getUserData();

        $view->allprocent = Plussia_Calc::all(Plussia_Dispatcher::getUserId(), $sputnik_id);

        $view->centerblock = Plussia_Viewer::getCompareCenterblock();
        $eqs = Plussia_Comparator::getCardsEqualsCount($userData->user_id, $sputnikData->user_id);
        $eqMaxInd = (count($eqs) ? array_search(max($eqs), $eqs) : -1) + 1;
        $icons = array(
            'religion' => array(
                'left' => array(Plussia_Linker::getReligionIcon($userData->religion, 'off'),
                    Plussia_Linker::getReligionIcon($userData->religion, 'on')),
                'right' => array(Plussia_Linker::getReligionIcon($sputnikData->religion, 'off'),
                    Plussia_Linker::getReligionIcon($sputnikData->religion, 'on'))
            ),
            'intereses' => array(
                'left' => array(Plussia_Linker::getInteresIcon($eqMaxInd, 'off'),
                    Plussia_Linker::getInteresIcon($eqMaxInd, 'on')),
                'right' => array(Plussia_Linker::getInteresIcon($eqMaxInd, 'off'),
                    Plussia_Linker::getInteresIcon($eqMaxInd, 'on'))
            ),
            'heart' => array(
                'left' => array(Plussia_Linker::getHeartIcon('left', 'off'),
                    Plussia_Linker::getHeartIcon('left', 'on')),
                'right' => array(Plussia_Linker::getHeartIcon('right', 'off'),
                    Plussia_Linker::getHeartIcon('right', 'on'))
            ),
            'mv' => array(
                'left' => array(Plussia_Linker::getMWIcon($userData->is_woman, 'left', 'off'),
                    Plussia_Linker::getMWIcon($userData->is_woman, 'left', 'on')),
                'right' => array(Plussia_Linker::getMWIcon($sputnikData->is_woman, 'right', 'off'),
                    Plussia_Linker::getMWIcon($sputnikData->is_woman, 'right', 'on'))
            ),
            'zodiac' => array(
                'left' => array(Plussia_Linker::getZodiacIcon($userData->zodiac_id, 'off'),
                    Plussia_Linker::getZodiacIcon($userData->zodiac_id, 'on')),
                'right' => array(Plussia_Linker::getZodiacIcon($sputnikData->zodiac_id, 'off'),
                    Plussia_Linker::getZodiacIcon($sputnikData->zodiac_id, 'on'))
            )
        );
        $view->icons = $icons;

        $user = Plussia_Dispatcher::getUser();

        $zodiac = XML_Base::factory('zodiac', null, null, null, 'zodiac')->getAssoc();
        $nicTypes = XML_WithMeta::factory('noeticTypes')->getAssoc();
        $sonicText = XML_Texts::factory('sonic', '/')->getAssoc();
        $userTypes = array($user->validateNic() ? Plussia_Getter::getNoeticType($user) : null,
            $sputnik->validateNic() ? Plussia_Getter::getNoeticType($sputnik) : null);

        $icTexts = array(
            'heart' => array(
                'left' => $user->validateNic() ? $nicTypes['meta'][($userData->is_woman ? 'w' : 'm') . '_' . $userTypes[0]]['print'] : '-',
                'right' => $sputnik->validateNic() ? $nicTypes['meta'][($sputnikData->is_woman ? 'w' : 'm') . '_' . $userTypes[1]]['print'] : '-'
            ),
            'mw' => array(
                'left' => $user->validateNic() ? $sonicText['types'][Plussia_Getter::getTypeOf6($user)] : '-',
                'right' => $sputnik->validateNic() ? $sonicText['types'][Plussia_Getter::getTypeOf6($sputnik)] : '-'
            ),
            'zodiac' => array(
                'left' => $zodiac[$userData->zodiac_id],
                'right' => $zodiac[$sputnikData->zodiac_id]
            )
        );
        $view->icTexts = $icTexts;
        return null;
    }

    public static function page_4(&$view) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;
        $view->messages = Plussia_Message::getMessagesHtml($sputnik_id);
        Plussia_Message::message_asReaded();
        return null;
    }

    public static function page_5(&$view) {
        return null;
    }

}