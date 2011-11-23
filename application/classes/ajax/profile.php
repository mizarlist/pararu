<?php

class Ajax_Profile {

    public static $allowed = array("spt_new", "spt_intrme", "spt_inter", "spt_saved", "spt_ignore");

    public static function profile_centerblock($data) {
        $type = (is_array($data) && isset($data['type'])) ? $data['type'] : $data;
        $page = (is_array($data) && isset($data['page'])) ? $data['page'] : 1;
        $allowed = self::$allowed;
        if ($type && in_array($type, $allowed)) {
            $typePage = array_search($type, $allowed) + 1;
            return Plussia_Viewer::getProfileCenterblock($typePage, $page);
        }
        return '';
    }

    public static function profile_usercards($data) {
        if (!isset($data['type'])) {
            return '';
        }
        $type = $data['type'];
        $page = isset($data['page']) ? intval($data['page']) : 1;
        $allowed = self::$allowed;
        if ($type && in_array($type, $allowed)) {
            $typePage = array_search($type, $allowed) + 1;
            $types = array('', 'new', 'interesme', 'interes', 'saved', 'ignor');
            $typePage = $types[$typePage];
            return Plussia_Viewer::getRSCards($typePage, $page);
        }
        return '';
    }

    public static function get_interes_block() {
        return Plussia_Viewer::getLoveusers(true);
    }

}