<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Step_2 extends Plussia_Step {

    public static function canAccess() {
        $user = Plussia_Dispatcher::getUser();
        if(!$user) return false;
        return true;
    }

    public function validate($data) {
        return true; //переписать
    }

    public function save_step($data) {

    }

    public function render_step($context, $page=null) {
        $view = View::factory('registration/registration_2');

        $view->text = XML_Texts::factory('registration/registration_2')->getAssoc();
        $view->intervals = XML_Base::factory('intervals', null, null, null, 'interval')->getAssoc();
        $view->zodiac = XML_Base::factory('zodiac', null, null, null, 'zodiac')->getAssoc();
        $view->harmony = XML_Base::factory('zodiac_harmony', null, null, null, 'harmony')->getAssoc();
        $view->cards = XML_Codes::factory('cards')->getAssoc();
        
        $view->cards_only = $page===null ? false : true;

        $view->name = Plussia_Dispatcher::getUser()->getUserData()->name;
        
        $view->sputniks = Plussia_Pickup::findByCards($page ? $page : 1);
        $view->pages = Plussia_Pickup::getReg2PagesCount();

        $context->response->body($view);
    }

}