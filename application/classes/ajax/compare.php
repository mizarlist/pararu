<?php


class Ajax_Compare {

    public static function compare_usercard($data){
        $i = $data;
        return Plussia_Viewer::getOnecardcompare($i);
    }

}
