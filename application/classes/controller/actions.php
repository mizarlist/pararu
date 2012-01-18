<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Actions extends Plussia_Controller {

    public function index() {
        $view = $this->view;
        $view->text = XML_Texts::factory('actions_text')->getAssoc();
        $view->centerblock = Controller_Actions::getActionsCenterblock();
        $view->leftuserinfo = Plussia_Viewer::getLeftuserinfo();
        $view->leftusersonic = Plussia_Viewer::getLeftusersonic();
        $view->loveusers = Plussia_Viewer::getLoveusers();
        $view->rightartmonth = Plussia_Viewer::getRightartmonth();
        $view->rightbanner = Plussia_Viewer::getRightbanner();
        $view->searchform = Plussia_Viewer::getSearchform();
        $view->userphoto = Plussia_Viewer::getUserphoto();
        $view->pagecomplete = Plussia_Viewer::getPagecoplete();
        $view->userleftmenu = Plussia_Viewer::getUserleftmenu(2);
        $view->usertopmenu = Plussia_Viewer::getUsertopmenu();
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('actions');
    }

    public static function getActionsCenterblock($page = 1) {
        $view = View::factory('actions/actions_' . $page);
        $view->text = XML_Texts::factory('actions/actions_' . $page)->getAssoc();
        if ($page == 1) {
            $view->contacts = Plussia_Message::getContactsHtml();
        } else if ($page == 2) {
            $view->messages = Plussia_Message::getAdminMessagesHtml();
            Plussia_Message::admin_message_asReaded();
        }
        return $view->render();
    }

}
