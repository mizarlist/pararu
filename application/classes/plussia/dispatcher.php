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

    public static function logout() {
        self::$current_user = NULL;
        Session::instance()->delete('user_id');
    }

    public static function setUser($user) {
        self::$current_user = $user;
        Session::instance()->bind('user_id', $user->user_id);
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
        $update = "UPDATE user SET last_active=NOW()";
        if ($user) {
            if ($is_login) {
                $update. ' last_login=NOW()';
            }
            $update .= " where user_id = {$user->user_id}";
            DB::query(Database::UPDATE, $update)->execute();
        }
    }

}