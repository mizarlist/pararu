<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Plussia_Controller {

    public function index() {

        $page = (isset($_GET['page']) && $_GET['page'] == 'faq') ? 6 : 1;

        $view = $this->view;
        $view->page = $page;
        $view->text = XML_Texts::factory('account_text')->getAssoc();
        $view->centerblock = Controller_Account::getAccountCenterblock($page);
        $view->leftuserinfo = Plussia_Viewer::getLeftuserinfo();
        $view->leftusersonic = Plussia_Viewer::getLeftusersonic();
        $view->loveusers = Plussia_Viewer::getLoveusers();
        $view->rightartmonth = Plussia_Viewer::getRightartmonth();
        $view->rightbanner = Plussia_Viewer::getRightbanner();
        $view->searchform = Plussia_Viewer::getSearchform();
        $view->userphoto = Plussia_Viewer::getUserphoto();
        $view->pagecomplete = Plussia_Viewer::getPagecoplete();
        $view->userleftmenu = Plussia_Viewer::getUserleftmenu();
        $view->usertopmenu = Plussia_Viewer::getUsertopmenu(null, 'account');
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('account');
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

}
