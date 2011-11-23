<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Intro extends Controller {

    public function action_index() {
        echo time();
        echo '<br>';
        echo get_magic_quotes_gpc();
//        $f = fopen('z.txt', 'w');
//        foreach(array('2_3_4', '5_6_1', '1_2_3', '6_5_4', '6_1_2', '5_4_3') as $i){
//            fwrite($f, "<text name='$i'>");
//            foreach(array('30', '60', '100') as $proc){
//                fwrite($f, "<text name='$proc'>{$i}=={$proc}</text>");
//            }
//            fwrite($f, "</text>");
//        }
//        fclose($f);
    }

//    public function action_index() {
//        $img = new Image_GD('test/main_large.jpg');
//        $img->crop(200, 250, 200, 200);
//        $img->save('test/main_min.jpg');
//    }
//    public function action_index() {
//        echo microtime().'<br/>';
//        $size = getimagesize('userfiles/u000001/photo/main_large.jpg');
//        print_r($size);
//    }
}

