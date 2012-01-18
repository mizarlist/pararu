<?php

defined('SYSPATH') or die('No direct script access.');

abstract class Plussia_Controller extends Controller {

    protected $needValidate = true;
    protected $needAjax = true;

    public function ajax($data) {
        return Ajax_Base::ajax($data);
    }

    public function index() {

    }

    public function validate() {
        $user = Plussia_Dispatcher::getUser();
        return $user && $user->active == 1;
    }

    public function invalid() {
        header('Location: /');
        die;
    }

    public function action_index() {
        Plussia_Dispatcher::updateActive();
        if (isset($_POST['post_functional'])) {
            Plussia_Post::post($_POST['post_functional']);
        } else {
            if (!$this->needValidate || ($this->needValidate && $this->validate())) {
                if (!$this->needAjax || ($this->needAjax && !Request::$current->is_ajax())) {
                    $this->view = $this->getView();
                    if ($this->view) {
                        $this->view->footer = Plussia_Viewer::getFooter();
                        $this->view->headers = Plussia_Viewer::getHeaders();
                        $this->view->lang = Plussia_Config::currentLang();
                    }
                    $this->index();
                    $last_controller = get_class($this);
                    Session::instance()->bind('last_controller', $last_controller);
                } else {
                    $data = isset($_POST['data']) ? $_POST['data'] : null;
                    fb::info($data);
                    $ahah = isset($_POST['ahah']) && $_POST['ahah'] && $_POST['ahah']!='false';
                    $raw_ans = $this->ajax($ahah ? $data : (is_array($data) ? $data : json_decode($data)));
                    $ans = $ahah ? $raw_ans : json_encode($raw_ans);
                    echo $ans;
                }
            } else {
                $this->invalid();
            }
        }
    }

    protected function getView() {
        return null;
    }

}