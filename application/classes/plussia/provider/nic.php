<?php

class Plussia_Provider_Nic {

    //Если все хорошо, то возвращается пустое значение, если нужно напечатать что-то
    //вместо вьюшки, возвращаем это что-то
    //при использовании функции важно проверять не вернулось ли что-то, т.к. в этом случае
    //скорее всего вьюшка не заполнена

    public static function page_1(&$view) {
        $view->user_data = XML_WithMeta::factory('user_data')->addMetaAttrs(array('cols'))->getAssoc();
        $view->current_data = Plussia_Dispatcher::getUser()->getUserData();
        return null;
    }

    public static function page_2(&$view) {
        $view->cards = XML_Codes::factory('cards')->getAssoc();
        $user_id = Plussia_Dispatcher::getUserId();
        $ucards = Plussia_Pickup::getUsersCards(array($user_id));
        $user_cards = array();
        foreach ($ucards[$user_id] as $k => $vs) {
            $user_cards[$k] = array();
            foreach ($vs as $v) {
                if ($v) {
                    $user_cards[$k][] = $v;
                }
            }
        }
        $view->current = $user_cards;
        return null;
    }

    public static function page_3(&$view) {
        return null;
    }

    public static function page_4(&$view) {
        $view->centerblock = Plussia_Viewer::getNictestResult('psy');
        return null;
    }

    public static function psy_result(&$view) {
        $view->sonic = XML_Texts::factory('sonic', '/')->getAssoc();
        $test = new Plussia_Test_Character();
        $view->percents = $test->getUserPercent(Plussia_Dispatcher::getUserId());
        foreach ($view->percents as &$percent) {
            $percent = round($percent, 2);
        }
        $view->portret = Plussia_Getter::getPsyProfileText($view->percents);
        return null;
    }

    public static function nic_result(&$view) {
        $test = new Plussia_Test_NoeticOne();
        $type = $test->getResult(Plussia_Dispatcher::getUserId());
        $userData = Plussia_Dispatcher::getUser()->getUserData();
        $ntText = XML_WithMeta::factory('noeticTypes')->getAssoc();
        $ntExpText = XML_Texts::factory('noeticTypesExp', '/')->getAssoc();
        $nicKey = ($userData->is_woman ? 'w' : 'm').'_'.$type;

        $view->img = Plussia_Linker::getUserSonicPic($userData->is_woman, $type, 2, 'left');
        $view->typeName = $ntText['meta'][$nicKey]['print'];

        $typeTexts = array();
        $typeTexts[] = $ntText['assoc'][$nicKey];
        for($i=1; $i<=5; $i++){
            $typeTexts[] = $ntExpText[$nicKey][$i];
        }

        $view->typeTexts = $typeTexts;

        return null;
    }

}