<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Pararuport extends Controller {

    public function action_index() {
        if (!isset($_GET['password']) || !isset($_GET['uid'])) {
            header("Location: /" . Plussia_Dispatcher::lang());
            die();
        }
        $mtp = Model_TmpPass::findOneBy(array('password' => $_GET['password'], 'user_id' => $_GET['uid']));
        if (!$mtp) {
            Plussia_Info::call(1);
        }
        if ($mtp->dt_expected < time()) {
            $mtp->delete();
            Plussia_Info::factory('OutOfAuthTime');
        }
        $actions = new Plussia_TPActions();
        $action = $mtp->handler;
        if (method_exists($actions, $action)) {
            $actions->$action($mtp);
        }
        $mtp->delete();
    }

}
