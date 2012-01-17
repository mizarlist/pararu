<?php

class Ajax_Search {

    public static function search_centerblock($data) {
        $functions = array('ct_search1', 'ct_search2');
        if (in_array($data, $functions)) {
            return Controller_Search::getSearchCenterblock(array_search($data, $functions)+1);
        }
        return null;
    }

    public static function search_fast($data) {
        print_r($data);
    }

    public static function search_full($data) {
        print_r($data);
    }

    public static function search_saveSputnikData($data) {
        print_r($data);
    }

}