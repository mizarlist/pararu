<?php

class Plussia_Dispatcher {

    private static $current_user = null;

    public static function lang() {
        return Plussia_Config::currentLang();
    }

    public static function isLogined() {
        if (Session::instance()->get('user_id')) {
            return true;
        }
        return false;
    }

    /**
     * @return Model_User
     */
    public static function getUser() {
        $user_id = self::getUserId();
        if (!self::$current_user) {
            $user = Model_User::findOneBy(array('user_id' => $user_id));
            if ($user) {
                self::$current_user = $user;
            }
        }
        return self::$current_user;
    }

    public static function setUser($user) {
        self::$current_user = $user;
    }

    public static function getUserId() {
        $sessid = null;
        if(isset($_GET['session'])){
            $sessid = $_GET['session'];
        }
        return Session::instance(null, $sessid)->get('user_id') ? Session::instance()->get('user_id') : null;
    }

    public static function updateActive($is_login = false) {
        $user = Plussia_Dispatcher::getUser();
        if ($user) {
            $user->last_active = date(Plussia_Help::$ddtFormat);
            if ($is_login) {
                $user->last_login = date(Plussia_Help::$ddtFormat);
            }
            $user->save();
        }
    }

}