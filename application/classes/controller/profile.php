<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Profile extends Plussia_Controller {

    public static $page;

    public function index() {
        $user = Plussia_Dispatcher::getUser();
        
        $view = $this->view;
        $view->text = XML_Texts::factory('profile_text')->getAssoc();
        $view->centerblock = Controller_Profile::getProfileCenterblock();
        $view->leftuserinfo = Plussia_Viewer::getLeftuserinfo();
        $view->leftusersonic = Plussia_Viewer::getLeftusersonic();
        $view->loveusers = Plussia_Viewer::getLoveusers();
        $view->rightartmonth = Plussia_Viewer::getRightartmonth();
        $view->rightbanner = Plussia_Viewer::getRightbanner();
        $view->searchform = Plussia_Viewer::getSearchform();
        $view->userphoto = Plussia_Viewer::getUserphoto();
        $view->pagecomplete = Plussia_Viewer::getPagecoplete();
        $view->userleftmenu = Plussia_Viewer::getUserleftmenu();
        $view->usertopmenu = Plussia_Viewer::getUsertopmenu(null, 'profile');

        $view->values = array(
            'new_users' => $user->getRSCount('new'),
            'new_interesme' => $user->getRSCount('interesme')
        );

        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('profile');
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
        $view->user_blocks = Plussia_Viewer::getRSCards($type, $cardsPage);
        $view->curPage = self::$page;

        return $view->render();
    }

}