<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Aboutme extends Plussia_Controller {

    public function  validate() {
        $user = Plussia_Dispatcher::getUser();
        return $user && true;
    }

    public function index() {

        $page = (isset($_GET['page']) && $_GET['page'] == 'photo') ? 2 : 1;

        $view = $this->view;
        $view->page = $page;
        $view->text = XML_Texts::factory('aboutme_text')->getAssoc();
        $view->centerblock = Plussia_Viewer::getAboutmeCenterblock($page);
        $view->leftuserinfo = Plussia_Viewer::getLeftuserinfo();
        $view->leftusersonic = Plussia_Viewer::getLeftusersonic();
        $view->loveusers = Plussia_Viewer::getLoveusers();
        $view->rightartmonth = Plussia_Viewer::getRightartmonth();
        $view->rightbanner = Plussia_Viewer::getRightbanner();
        $view->searchform = Plussia_Viewer::getSearchform();
        $view->userphoto = Plussia_Viewer::getUserphoto();
        $view->pagecomplete = Plussia_Viewer::getPagecoplete();
        $view->userleftmenu = Plussia_Viewer::getUserleftmenu(4);
        $view->usertopmenu = Plussia_Viewer::getUsertopmenu();
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('aboutme');
    }

}