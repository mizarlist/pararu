<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Plussia_Controller {

    public function validate() {
        return true;
    }

    public function index() {
        $view = $this->view;
        $view->text = XML_Texts::factory('index_text')->getAssoc();
        $view->langs = Plussia_Config::$locates;
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    protected function getView() {
        return View::factory('index');
    }

}
