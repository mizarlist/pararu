<?php


class Controller_Links extends Controller {

    private $allowed = array('localhost/', 'plussia/');

    public function action_index() {
        $result = DB::select('user.user_id', 'user.email', 'mail_prove.password')->from('mail_prove')->join('user')->on('mail_prove.user_id', '=', 'user.user_id')->execute();
        foreach($result as $r) {
            echo $r['user_id'].' - ',$r['email'].'<br>';
            echo '<a href="http://'.URL::base().'authentication?password='.$r['password'].'">';
            echo 'http://'.URL::base().'authentication?password='.$r['password'].'</a><br>';
        }
    }

}