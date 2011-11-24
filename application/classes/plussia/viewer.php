<?php

class Plussia_Viewer {

    public static $page;

    public static function getFooter() {
        $view = View::factory('footer');
        $view->lang = Plussia_Config::currentLang();
        $view->elements = XML_Base::factory('elements')->getAssoc();
        $view->broad = XML_Base::factory('broad')->getAssoc();
        $view->footer_some_pic_num = rand(1, 7);
        return $view->render();
    }

    public static function getHeaders() {
        $view = View::factory('headers');
        return $view->render();
    }

    public static function getRegblok() {
        $view = View::factory('regblok');
        $view->broad = XML_Base::factory('broad')->getAssoc();
        $view->text = XML_Texts::factory('regblok')->getAssoc();
        return $view->render();
    }

    public static function getBookmarks() {
        $view = View::factory('bookmarks');
        $view->footer_some_pic_num = rand(1, 7);
        return $view->render();
    }

    public static function getLeftuserinfo() {
        $view = View::factory('elements/leftuserinfo');
        $view->text = XML_Texts::factory('elements/leftuserinfo')->getAssoc();
        return $view->render();
    }

    public static function getLeftusersonic() {
        $card_number = Model_UserCard::getRandomEmptyCardId();

        if (!$card_number) {
            return '';
        }

        $view = View::factory('elements/leftusersonic');
        $view->text = XML_Texts::factory('elements/leftusersonic')->getAssoc();
        $view->cards = XML_Codes::factory('cards')->getAssoc();
        $view->card_number = $card_number;
        return $view->render();
    }

    public static function getLoveusers($without_div = false) {
        $view = View::factory('elements/loveusers');
        $interes = Plussia_Dispatcher::getUser()->getRS('interes');
        foreach ($interes as &$in) {
            $in['photo'] = Plussia_Linker::getMainPhotoLink($in['user_id'], 0);
        }
        $view->users = $interes;
        $view->without_div = $without_div;
        $view->text = XML_Texts::factory('elements/loveusers')->getAssoc();
        return $view->render();
    }

    public static function getRightartmonth() {
        $view = View::factory('elements/rightartmonth');
        $view->text = XML_Texts::factory('elements/rightartmonth')->getAssoc();
        return $view->render();
    }

    public static function getRightbanner() {
        $view = View::factory('elements/rightbanner');
        $view->text = XML_Texts::factory('elements/rightbanner')->getAssoc();
        return $view->render();
    }

    public static function getSearchform() {
        $view = View::factory('elements/searchform');
        $view->text = XML_Texts::factory('elements/searchform')->getAssoc();
        return $view->render();
    }

    public static function getUserphoto($user_id = null) {
        $user_id = $user_id ? $user_id : Plussia_Dispatcher::getUserId();
        $view = View::factory('elements/userphoto');
        $view->gifts = array(
            "/images/profile/gift1.png",
            "/images/profile/gift1.png",
            "/images/profile/gift1.png",
            "/images/profile/gift1.png"
        );
        $view->photo = Plussia_Linker::getMainPhotoLink($user_id, 1);
        return $view->render();
    }

    public static function getPagecoplete() {
        $view = View::factory('elements/pagecomplete');
        $t = XML_Texts::factory('elements/elements')->getAssoc();
        $view->text = $t['page_complete'];
        $view->value = 73;
        return $view->render();
    }

    public static function getUserleftmenu($numactive = 1) {
        $user = Plussia_Dispatcher::getUser();

        $view = View::factory('elements/userleftmenu');
        $view->user_name = Plussia_Dispatcher::getUser()->getUserData()->name;
        $view->text = XML_Texts::factory('elements/userleftmenu')->getAssoc();
        $view->values = Plussia_Getter::getTopValues();
        $view->numactive = $numactive;
        return $view->render();
    }

    public static function getUsertopmenu($active_index = null, $type = '') {
        $user = Plussia_Dispatcher::getUser();

        $view = View::factory('elements/usertopmenu');
        $view->type = $type;
        $view->text = XML_Texts::factory('elements/usertopmenu')->getAssoc();
        $view->links = Plussia_Links::userpage_top();
        $view->active_index = $active_index;
        $view->values = Plussia_Getter::getTopValues();
        return $view->render();
    }

    public static function getSputnikCenterblock($page = 1) {
        $view = View::factory('sputnik/sputnik_' . $page);
        $view->text = XML_Texts::factory('sputnik/sputnik_' . $page)->getAssoc();

        $view->somephoto = View::factory('elements/somephoto');
        $view->somephoto->text = $view->text;
        $view->somephoto->is_sputnik_page = true;

        $view->is_sputnik_page = true;
        $view->wanabet = Plussia_Viewer::getWanabet();
        $fn = 'page_' . $page;
        $elseResult = Plussia_Provider_Sputnik::$fn($view);
        return $elseResult ? $elseResult : $view->render();
    }

    public static function getAboutmeCenterblock($page = 1) {
        if ($page == 1) {
            $view = View::factory('sputnik/sputnik_1');
            $view->text = XML_Texts::factory('sputnik/sputnik_1')->getAssoc();

            $view->somephoto = View::factory('elements/somephoto');
            $view->somephoto->text = $view->text;
            $view->somephoto->is_sputnik_page = false;

            $view->is_sputnik_page = false;
            $elseResult = Plussia_Provider_Sputnik::page_1($view, true);
            return $elseResult ? $elseResult : $view->render();
        } else if ($page == 2) {
            $view = View::factory('photo/myphotos');
            return $view->render();
        }
    }

    public static function getSearchCenterblock($page = 1) {
        if ($page == 1) {
            $view = View::factory('search/search_1');
            $view->text = XML_Texts::factory('search/search_1')->getAssoc();
            return $view->render();
        } else if ($page == 2) {
            $view = View::factory('search/search_2');
            $view->text = XML_Texts::factory('search/search_2')->getAssoc();
            return $view->render();
        }
    }

    public static function getCompareCenterblock($page = 1) {
        $view = View::factory('compare/compare_' . $page);
        $view->text = XML_Texts::factory('compare/compare_' . $page)->getAssoc();
        $view->wanabet = Plussia_Viewer::getWanabet();
        $fn = 'page_' . $page;
        $elseResult = Plussia_Provider_Compare::$fn($view);
        return $elseResult ? $elseResult : $view->render();
    }

    public static function getWanabet() {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $sputnik_id = $sputnik->user_id;
        $finded = Plussia_Relationsheeps::searchRelationsheep($sputnik_id);
        if (!$finded || in_array($finded['table'], array('rs_nosearch', 'rs_new', 'rs_interesme'))) {
            $view = View::factory('elements/wanabet');
            $view->text = XML_Texts::factory('elements/wanabet')->getAssoc();
            $view->no_nosearch = ($finded && $finded['table'] == 'rs_nosearch');
            return $view->render();
        } else {
            return '';
        }
    }

    public static function getAccountCenterblock($page = 1) {
        $view = View::factory('account/account_' . $page);
        if ($page == 6) {
            $view->helpText = XML_Texts::factory('help')->getAssoc();
        }
        $view->text = XML_Texts::factory('account/account_' . $page)->getAssoc();
        $view->broad = $page == 1 ? XML_Base::factory('broad')->getAssoc() : null;
        $view->options = Plussia_Dispatcher::getUser()->getUserOptions();
        return $view->render();
    }

    public static function getActionsCenterblock($page = 1) {
        $view = View::factory('actions/actions_' . $page);
        $view->text = XML_Texts::factory('actions/actions_' . $page)->getAssoc();
        if ($page == 1) {
            $view->contacts = Plussia_Message::getContactsHtml();
        } else if($page==2) {
            $view->messages = Plussia_Message::getAdminMessagesHtml();
            Plussia_Message::admin_message_asReaded();
        }
        return $view->render();
    }

    public static function getNicCenterblock($page = 1) {
        $view = View::factory('nic/nic_' . $page);
        $view->text = XML_Texts::factory('nic/nic_' . $page)->getAssoc();
        $provider_fn = 'page_' . $page;
        Plussia_Provider_Nic::$provider_fn($view);
        return $view->render();
    }

    public static function getNictestResult($type = 'psy') {
        $view = View::factory('nic/' . $type . '_result');
        $view->text = XML_Texts::factory('nic/' . $type . '_result')->getAssoc();
        $provider_fn = $type . '_result';
        Plussia_Provider_Nic::$provider_fn($view);
        return $view->render();
    }

    public static function getNicTestBlock() {
        $view = View::factory('nic/nictest');
        $view->bloks = XML_Texts::factory('niccards', '/')->getAssoc();
        $view->text = XML_Texts::factory('nic/nictest')->getAssoc();
        return $view->render();
    }

    public static function getOnecardcompare($card_number) {
        if (!$card_number) {
            return Plussia_Viewer::getWanabet();
        }
        $view = View::factory('elements/onecardcompare');
        $view->text = XML_Texts::factory('elements/onecardcompare')->getAssoc();
        $view->wanabet = Plussia_Viewer::getWanabet();
        Plussia_Provider_Compare::oneCardCompare($view, $card_number);
        return $view->render();
    }

    public static function getKarma() {
        $view = View::factory('elements/karma');
        $view->text = XML_Texts::factory('elements/karma')->getAssoc();
        return $view->render();
    }

    public static function getHelp($column, $punkt) {
        $view = View::factory('elements/help');
        $helpText = XML_Texts::factory('help')->getAssoc();

        $view->title = $helpText['title'] . ': ' . $helpText['columns'][$column][$punkt]['title'];
        $view->img = $helpText['columns'][$column][$punkt]['img'];
        $view->text = $helpText['columns'][$column][$punkt]['text'];

        return $view->render();
    }

    public static function getProfileCenterblock($page = 1, $cardsPage = 1) {

        $max = 5;
        self::$page = $cardsPage;

        $types = array('', 'new', 'interesme', 'interes', 'saved', 'ignor');
        $type = $types[$page];
        $user = Plussia_Dispatcher::getUser();
        $user instanceof Model_User;

        $view = View::factory('profile/profile_' . $page);
        $view->text = XML_Texts::factory('profile/profile_' . $page)->getAssoc();

        $view->count = $user->getRSCount($type);
        $view->max_pages = ceil($view->count / $max);
        $view->user_name = $user->getUserData()->name;
        $view->user_blocks = self::getRSCards($type, $cardsPage);
        $view->curPage = self::$page;

        return $view->render();
    }

    public static function getRSCards($type, $page = 1) {

        $answer = '';
        $max = 5;
        $offset = ($page - 1) * $max;
        $limit = $max;

        $user_cards = Plussia_Dispatcher::getUser()->getRS($type, $offset, $limit);

        if (!$user_cards && $page > 1) {
            $page = $page - 1;
            self::$page = $page;
            $offset = ($page - 1) * $max;
            $limit = $max;
            $user_cards = Plussia_Dispatcher::getUser()->getRS($type, $offset, $limit);
        }

        $actions = array(
            'new' => array('do_send_msg', 'do_save', 'do_add_favor', 'do_nosearch'),
            'interesme' => array('do_send_msg', 'do_save', 'do_add_favor', 'do_delete'),
            'interes' => array('do_send_msg', 'do_save', 'do_delete'),
            'saved' => array('do_send_msg', 'do_add_favor', 'do_delete'),
            'ignor' => array('do_save', 'do_add_favor', 'do_delete'),
        );

        $view = View::factory('vizitka');
        $view->text = XML_Texts::factory('vizitka')->getAssoc();
        $view->intervals = XML_Base::factory('intervals', null, null, null, 'interval')->getAssoc();
        $view->karma_text = XML_Texts::factory('karma', '/')->getAssoc();
        $view->actions = $actions[$type];

        if ($user_cards) {
            $ids = array();

            foreach ($user_cards as $uc) {
                $ids[] = $uc['user_id'];
            }

            $karma = Plussia_Comparator::getKarma(Plussia_Dispatcher::getUserId(), $ids);
        }

        if ($type == 'new') {
            $now = date(Plussia_Help::$ddtFormat);
            $oldtime = 60 * 60 * 24 * 7;
        }

        foreach ($user_cards as $card) {
            $view->photo = Plussia_Linker::getMainPhotoLink($card['user_id'], Plussia_Linker::VARIANT_SMALL);
            $view->name = $card['name'];
            $view->one_user_id = $card['user_id'];
            $view->age = Model_UserData::getAgeByDate($card['birthday']);
            $view->age_text = Plussia_Help::numText($view->age, $view->text['age_text']);
            $view->ball = $card['ball'] ? $card['ball'] : 0;

            $view->country = $card['country'];
            $view->city = $card['city'];

            $view->karma = $karma[$card['user_id']];

            $view->on_site = Plussia_Help::getDateInterval($card['last_active']);
            $view->is_woman = $card['is_woman'];
            $view->active = $card['active'];

            if ($type == 'new') {
                $diff = Plussia_Help::getDateDiff($now, $card['dt_added']);
                $view->new = $diff > $oldtime ? false : true;
            } else {
                $view->new = false;
            }

            $answer .= $view->render();
        }

        return $answer;
    }

}