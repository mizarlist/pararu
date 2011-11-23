<?php

class Ajax_Nic {

    public static $allowed = array("ct_nic1", "ct_nic2", "ct_nic3", "ct_nic4");

    public static function nic_centerblock($data) {
        $type = $data;
        $allowed = self::$allowed;
        if ($type && in_array($type, $allowed)) {
            $typePage = array_search($type, $allowed) + 1;
            return Plussia_Viewer::getNicCenterblock($typePage);
        }
        return '';
    }

    public static function nic_save_answers($data) {
        $msgs = XML_Msgs::factory('nic')->getAssoc();
        $user_data = Plussia_Dispatcher::getUser()->getUserData();
        foreach ($data as $key => $vals) {
            $param = substr($key, 0, strlen($key) - 5);
            $new_langs = array();
            if (!in_array($param, array('user_data_id', 'user_id', 'is_woman', 'name', 'birthday', 'country_id', 'region_id', 'city_id'))) {
                foreach ($vals as $k => $v) {
                    $last = strrpos($k, '_');
                    $index = substr($k, $last + 1);
                    if ($param != 'languages') {
                        $user_data->$param = $index;
                        $user_data->save();
                        break;
                    } else {
                        $new_langs[] = $index;
                    }
                }
                $user_data->languages = ';' . join(';', $new_langs) . ';';
                $user_data->save();
            }
            break;
        }
        return 'txt_' . $msgs['saved'];
    }

    public static function nic_save_card($data) {
        $msgs = XML_Msgs::factory('nic')->getAssoc();
        $user = Plussia_Dispatcher::getUser();
        if (!$user || !isset($data['card_name']) || !isset($data['selected'])) {
            return 'msg_' . $msgs['error'];
        }
        $user->fillCardsFromStr(intval($data['card_name']), $data['selected']);
        return 'txt_' . $msgs['saved'];
    }

    public static function get_nictest_result($data) {
        $pieces = explode('_', $data);
        if (isset($pieces[1]) && in_array($pieces[1], array('psy', 'nic'))) {
            return Plussia_Viewer::getNictestResult($pieces[1]);
        }
        return '';
    }

    public static function save_nictest_answers($data) {
        $order = array(1, 2, 3, 4, 5);
        $set = $data['set'];
        Plussia_Dispatcher::getUser()->updateNicCards($set, $order);

        $ans_view = View::factory('nic/test_saved');
        $ans_view->text = XML_Texts::factory('nic/test_saved')->getAssoc();
        return $ans_view->render();
    }

    public static function get_nictest_test($data) {
        return Plussia_Viewer::getNicTestBlock();
    }

}