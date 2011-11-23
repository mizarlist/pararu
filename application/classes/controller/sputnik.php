<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Sputnik extends Plussia_Controller {

    public function validate() {
        $user = Plussia_Dispatcher::getUser();
        return $user && true;
    }

    public function index() {

        $page = (isset($_GET['page']) && $_GET['page'] == 'communication') ? 4 : 1;

        $rController = Request::$current->controllerNameStore;
        if (!$rController) {
            throw new Http_Exception_404('The requested URL was not found on this server');
        }

        $sputnik = Model_User::get($rController);
        $sputnik_id = $sputnik->user_id;
        $view = $this->view;

        $finded = Plussia_Relationsheeps::searchRelationsheep($sputnik_id);
        if ($finded && !in_array($finded['table'], array('rs_nosearch', 'rs_new', 'rs_interesme'))) {
            $view->no_interes_menu = true;
        } else {
            $view->no_interes_menu = false;
        }
        $view->page = $page;
        $view->sputnik_name = $sputnik->getUserData()->name;
        $view->sputnik_ava = Plussia_Linker::getMainPhotoLink($sputnik_id, Plussia_Linker::VARIANT_SMALL);
        $view->text = XML_Texts::factory('sputnik')->getAssoc();
        $view->broad = XML_Base::factory('broad')->getAssoc();
        $view->userphoto = Plussia_Viewer::getUserphoto();
        $view->sputnikphoto = Plussia_Viewer::getUserphoto($sputnik_id);
        $view->sputnikident = $sputnik_id;
        $view->pagecomplete = Plussia_Viewer::getPagecoplete();
        $view->userleftmenu = Plussia_Viewer::getUserleftmenu();
        $view->leftuserinfo = Plussia_Viewer::getLeftuserinfo();
        $view->leftusersonic = Plussia_Viewer::getLeftusersonic();
        $view->usertopmenu = Plussia_Viewer::getUsertopmenu();
        $view->loveusers = Plussia_Viewer::getLoveusers();
        $view->adr = $rController;
        $view->centerblock = Plussia_Viewer::getSputnikCenterblock($page);
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('sputnik');
    }

}
