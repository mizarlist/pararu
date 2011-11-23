<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tour extends Controller {

    public function action_index() {
        $this->action_1();
    }

    public function action_1() {
        $view = View::factory('tour/tour_1');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('tour/tour_1')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'tour_top' => Plussia_Links::tour_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_2() {
        $view = View::factory('tour/tour_2');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('tour/tour_2')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'tour_top' => Plussia_Links::tour_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_3() {
        $view = View::factory('tour/tour_3');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('tour/tour_3')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'tour_top' => Plussia_Links::tour_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_4() {
        $view = View::factory('tour/tour_4');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('tour/tour_4')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'tour_top' => Plussia_Links::tour_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_5() {
        $view = View::factory('tour/tour_5');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('tour/tour_5')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'tour_top' => Plussia_Links::tour_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

    public function action_6() {
        $view = View::factory('tour/tour_6');
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $view->lang = Plussia_Config::currentLang();
        $view->text = XML_Texts::factory('tour/tour_6')->getAssoc();
        $view->links = array('intro_top' => Plussia_Links::intro_top(),
                'tour_top' => Plussia_Links::tour_top());
        $view->regblok = Plussia_Viewer::getRegblok();
        $view->bookmarks = Plussia_Viewer::getBookmarks();
        $this->response->body($view);
    }

}