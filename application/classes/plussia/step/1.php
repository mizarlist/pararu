<?php defined('SYSPATH') or die('No direct script access.');

class Plussia_Step_1 extends Plussia_Step {

    public static function canAccess() {
        $user = Plussia_Dispatcher::getUser();
        if(!$user) return false;
        return $user->access('regstep1');
    }

    public function validate($data) {
        if(isset($data['card_name']) && isset($data['selected'])) {
            $ansvers = explode(';', $data['selected']);
            if(count($ansvers) < 1 || !$ansvers[0]) {
                return false;
            }
            if($data['card_name'] < 1 || $data['card_name'] > 12){
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function save_step($data) {
        $user = Plussia_Dispatcher::getUser();
        $user instanceof Model_User;
        $user->fillCardsFromStr(intval($data['card_name']), $data['selected']);
        $user->active = 1;
        $user->afterlogin = 'profile';
        $user->save();

        $user->deleteRole(Model_Role::get('registration'));
        $user->addRole(Model_Role::get('user_page'));
    }

    public function render_step($context) {
        $view = View::factory('registration/registration_1');
        $view->text = XML_Texts::factory('registration/registration_1')->getAssoc();
        $view->cards = XML_Codes::factory('cards')->getAssoc();
        $view->footer = Plussia_Viewer::getFooter();
        $view->headers = Plussia_Viewer::getHeaders();
        $context->response->body($view);
    }

}