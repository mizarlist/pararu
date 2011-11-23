<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Calc extends Controller {

    public function action_index() {
//        if(!isset($_GET['username']) || !isset($_GET['password'])){
//            header('Location: /');
//            die;
//        }
//        $un = DB::select()->from('system_options')->where('name', '=', 'sonic_calc_username')->execute();
//        foreach($un as $u){
//            $un = $u['value'];
//            break;
//        }
//        $pass = DB::select()->from('system_options')->where('name', '=', 'sonic_calc_password')->execute();
//        foreach($pass as $p){
//            $pass = $p['value'];
//            break;
//        }
//        if($_GET['username']!=$un || $_GET['password']!=$pass){
//            header('Location: /');
//            die;
//        }
        $calc = new System_Calc();
        $calc->calculate();
    }

}

