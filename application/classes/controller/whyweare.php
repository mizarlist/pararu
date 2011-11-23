<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Whyweare extends Controller {

    public function action_index() {
        $view = View::factory('whyweare/whyweare');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('whyweare/whyweare')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'whyweare_top' => Plussia_Links::whyweare_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_1() {
        $view = View::factory('whyweare/whyweare_1');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('whyweare/whyweare_1')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'whyweare_top' => Plussia_Links::whyweare_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_2() {
        $view = View::factory('whyweare/whyweare_2');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('whyweare/whyweare_2')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'whyweare_top' => Plussia_Links::whyweare_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_3() {
        $view = View::factory('whyweare/whyweare_3');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('whyweare/whyweare_3')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'whyweare_top' => Plussia_Links::whyweare_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

}