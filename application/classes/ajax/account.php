<?php

class Ajax_Account {

    public static function account_centerblock($data) {
        $allowed = array("ct_options", "ct_remind", "ct_apps", "ct_mobile", "ct_adv", "ct_help");
        if ($data && in_array($data, $allowed)) {
            $page = array_search($data, $allowed) + 1;
            return Controller_Account::getAccountCenterblock($page);
        }
        return '';
    }

    public static function account_save_answers($data) {
        foreach ($data as $function => $fdata) {
            return Ajax_Account::$function($fdata);
        }
    }

    private static function saveCheckboxes($data, $field) {
        $user = Plussia_Dispatcher::getUser();
        $msgs = XML_Msgs::factory('account')->getAssoc();
        $options = $user->getUserOptions();
        $newalerts = ';';
        foreach ($data as $k => $v) {
            if ($v) {
                $nar = explode('_', $k);
                $n = $nar[count($nar) - 1];
                $newalerts .= $n . ';';
            }
        }
        $options->$field = $newalerts;
        $options->save();
        return 'txt_' . $msgs['saved'];
    }

    private static function login_flap($data) {
        $user = Plussia_Dispatcher::getUser();
        $msgs = XML_Msgs::factory('account')->getAssoc();
        $newmtp = new Model_TmpPass(null, 12);
        if (isset($data['new_login']) && isset($data['pass_prove'])) {
            if ($user->password != $data['pass_prove']) {
                return 'msg_' . $msgs['old_pass_uncorrect'];
            }
            if (!Plussia_Help::is_mail($data['new_login'])) {
                return 'msg_' . $msgs['mail_uncorect'];
            }
            if (Model_User::findOneBy(array('email' => $data['new_login']))) {
                return 'msg_' . $msgs['mail_exuist'];
            }
            $newmtp->data = $data['new_login'];
            $newmtp->handler = 'newLogin1';
            Plussia_Mail::puckmail('newmail', 'newmail1', $user->email,
                            array(
                                'old' => $user->email,
                                'new' => $newmtp->data,
                                'link' => $newmtp->getLink()
                            )
            );
            $newmtp->save();
            return 'msg_' . $msgs['check_mail'];
        }
    }

    private static function pass_flap($data) {
        $user = Plussia_Dispatcher::getUser();
        $msgs = XML_Msgs::factory('account')->getAssoc();
        if ($user->password == $data['old_pass_change']) {
            if ($data['new_pass_change'] == $data['new_pass_change2']) {
                if (strlen($data['new_pass_change']) < 5) {
                    return 'msg_' . $msgs['pass_len_5'];
                }
                $user->password = $data['new_pass_change'];
                $user->save();
                $user = Plussia_Dispatcher::setUser($user);
                return 'txt_' . $msgs['saved'];
            } else {
                return 'msg_' . $msgs['pass_noeq'];
            }
        } else {
            return 'msg_' . $msgs['old_pass_uncorrect'];
        }
    }

    private static function show_flap($data) {

    }

    private static function set_secure_flap($data) {
        $user = Plussia_Dispatcher::getUser();
        $msgs = XML_Msgs::factory('account')->getAssoc();
        $options = $user->getUserOptions();
        $newconf = ';';
        foreach ($data as $k => $v) {
            $nar = explode('_', $v);
            $n = $nar[count($nar) - 1];
            $newconf .= $n . ';';
        }
        $options->confidence = $newconf;
        $options->save();
        return 'txt_' . $msgs['saved'];
    }

    private static function page_adr_flap($data) {
        $newaddr = $data['new_pageaddr'];
        $len = strlen($newaddr);
        $msgs = XML_Msgs::factory('account')->getAssoc();
        if ($len < 3 || $len > 126) {
            return 'msg_' . $msgs['pageaddr_length'];
        }
        $l12 = substr($newaddr, 0, 2);
        $l3 = substr($newaddr, 2, 1);
        if ($l12 == 'id' && Plussia_Help::is_digit_only($l3)) {
            return 'msg_' . $msgs['pageaddr_uncorrect'];
        }
        if (!Plussia_Help::is_safe_en($newaddr)) {
            return 'msg_' . $msgs['pageaddr_uncorrectchars'];
        }
        if (class_exists('controller_' . $newaddr) || in_array($newaddr, Plussia_Config::$locates)) {
            return 'msg_' . $msgs['pageaddr_reserv'];
        }
        $existuser = Model_User::findOneBy(array('username' => $newaddr));
        if ($existuser) {
            return 'msg_' . $msgs['pageaddr_nofree'];
        }
        $user = Plussia_Dispatcher::getUser();
        $user->username = $newaddr;
        $user->save();
        return 'txt_' . $msgs['saved'];
    }

    private static function zone_flap($data) {
        // от -11 до +12
        $msgs = XML_Msgs::factory('account')->getAssoc();
        foreach ($data as $tz => $v) {
            if ($v) {
                $time_zone = explode('_', $v);
                $time_zone = intval($time_zone[count($time_zone) - 1]);
                if ($time_zone >= -11 && $time_zone <= 12) {
                    $user = Plussia_Dispatcher::getUser();
                    $user->time_zone = $time_zone;
                    $user->save();
                    return 'txt_' . $msgs['saved'];
                } else {
                    return 'msg_' . $msgs['zone_uncorrect'];
                }
            }
        }
    }

    private static function lang_flap($data) {
        $msgs = XML_Msgs::factory('account')->getAssoc();
        foreach ($data as $l => $v) {
            if ($v) {
                $lang = explode('_', $l);
                $lang = $lang[count($lang) - 1];
                if (in_array($lang, Plussia_Config::$locates)) {
                    $user = Plussia_Dispatcher::getUser();
                    $user->language = $lang;
                    $user->save();
                    return 'txt_' . $msgs['saved'];
                } else {
                    return 'msg_' . $msgs['lang_uncorrect'];
                }
            }
        }
    }

    private static function logout_flap($data) {
        $msgs = XML_Msgs::factory('account')->getAssoc();
        foreach ($data as $l => $v) {
            if ($v) {
                $val = explode('_', $l);
                $val = $val[count($val) - 1];
                if (in_array($val, array(0,5,10,15,30,45,60))) {
                    $user = Plussia_Dispatcher::getUser();
                    $user->logout = $val;
                    $user->save();
                    return 'txt_' . $msgs['saved'];
                } else {
                    return 'msg_' . $msgs['logout_uncorrect'];
                }
            }
        }
    }

    private static function deactivate_flap($data) {
        $user = Plussia_Dispatcher::getUser();
        $msgs = XML_Msgs::factory('account')->getAssoc();
        $newmtp = new Model_TmpPass(null, 3);
        if (isset($data['pass_prove']) && isset($data['login'])) {
            if ($user->password != $data['pass_prove'] || $user->email != $data['login']) {
                return 'msg_' . $msgs['login_pass_uncorrect'];
            }
            $newmtp->handler = 'deleteProfile';
            Plussia_Mail::puckmail('linkmail', 'deleteProfile', $user->email,
                            array(
                                'link' => $newmtp->getLink()
                            )
            );
            $newmtp->save();
            return 'msg_' . $msgs['check_mail'];
        }
    }

    private static function mail_options_flap($data) {
        return self::saveCheckboxes($data, 'alerts');
    }

    private static function sms_options_flap_1($data) {
        return self::saveCheckboxes($data, 'sms');
    }

    private static function sms_options_flap_2($data) {
        return ' '; //not suported yet
    }

    private static function commercial_options_flap_1($data) {
        return self::saveCheckboxes($data, 'commercial');
    }

    private static function commercial_options_flap_2($data) {
        return self::saveCheckboxes($data, 'commercial_off');
    }

}