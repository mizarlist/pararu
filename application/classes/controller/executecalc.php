<?php

class Controller_ExecuteCalc extends Controller {

    public function action_index() {
        if(!isset($_GET['n']) || !isset($_GET['p'])){
            return;
        }
        $u = DB::select()->from('system_options')->where('name', '=', 'sonic_calc_username')
                ->limit(1)->as_assoc()->execute();
        $p = DB::select()->from('system_options')->where('name', '=', 'sonic_calc_password')
                ->limit(1)->as_assoc()->execute();
        $u = $u[0]['value'];
        $p = $p[0]['value'];
        if($_GET['n']!=$u || $_GET['p']!=$p){
            return;
        }
        $count = 1;

        while($count){
            $count = 0;
        }
    }

}