<?php defined('SYSPATH') or die('No direct script access.');

abstract class Plussia_Post {
    
    private static $post_functionals = array(
        'registration' => 'Plussia_Post_Registration'
    );

    public static function post($functional){
        if(isset(self::$post_functionals[$functional])){
            $post = new self::$post_functionals[$functional];
            if($post->validate()){
                $post->do_post();
            }
        }
    }
}