<?php

class Ajax_Sputnik {

    public static function sputnik_centerblock($data) {
        $functions = array('ct_sput_page', 'ct_sput_photo', 'ct_sput_comp', 'ct_sput_talk', 'ct_sput_dates');
        if (in_array($data, $functions)) {
            return Plussia_Viewer::getSputnikCenterblock(array_search($data, $functions)+1);
        }
        return null;
    }

    public static function compare_centerblock($data) {
        $functions = array('compare_mode_1', 'compare_mode_2', 'compare_mode_3', 'compare_mode_4', 'compare_mode_5');
        if (in_array($data, $functions)) {
            return Plussia_Viewer::getCompareCenterblock(array_search($data, $functions)+1);
        }
        return null;
    }

}