<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Plussia_Controller {

    public function  validate() {
        $user = Plussia_Dispatcher::getUser();
        return $user && true;
    }

    public function index() {
        $view = $this->view;
        $view->text = XML_Texts::factory('search_text')->getAssoc();
        $view->centerblock = Plussia_Viewer::getSearchCenterblock();
        $view->leftuserinfo = Plussia_Viewer::getLeftuserinfo();
        $view->leftusersonic = Plussia_Viewer::getLeftusersonic();
        $view->loveusers = Plussia_Viewer::getLoveusers();
        $view->rightartmonth = Plussia_Viewer::getRightartmonth();
        $view->rightbanner = Plussia_Viewer::getRightbanner();
        $view->userphoto = Plussia_Viewer::getUserphoto();
        $view->pagecomplete = Plussia_Viewer::getPagecoplete();
        $view->userleftmenu = Plussia_Viewer::getUserleftmenu(5);
        $view->usertopmenu = Plussia_Viewer::getUsertopmenu();
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('search');
    }

}