<?php

class Request extends Kohana_Request {

    public $controllerNameStore = null;
    public $currentAdr = '/';

    public function getCurAdr() {
        return $this->controllerNameStore;
    }

    public function controller($controller = NULL) {
        $uri = $this->_uri;
        $uricount = strlen($uri);
        $lang_candidate = $uricount==2 ? $uri : substr($uri, 0, 2);
        if (($uricount==2 || (substr($uri, 2, 1) == '/')) && in_array($lang_candidate, Plussia_Config::$locates)) {
            Plussia_Config::registerLang($lang_candidate);
            $newLocation  = $uricount==2 ? '/' : substr($uri, 2);
            if($this->_get && is_array($this->_get)) {
                $newLocation .= '?';
                foreach($this->_get as $k => $v) {
                    $newLocation .= "$k=$v";
                }
            }
            header('Location: ' . $newLocation);
            die;
        }
        $this->controllerNameStore = $this->_controller;
        $this->currentAdr = substr($this->uri(), 3);
        if (!$controller) {
            $prefix = 'controller_';
            if (!class_exists($prefix . $this->_controller)) {
                $up = null;

                if (Plussia_Help::is_safe($this->_controller)) {
                    $user = Model_User::get($this->_controller);
                    if ($user && $user->active==1) {
                        if ($user->user_id == Plussia_Dispatcher::getUserId()) {
                            $up = 'profile';
                        } else {
                            $up = 'sputnik';
                        }
                    }
                }

                $this->_controller = $up ? $up : $this->_controller;
                $this->_uri = $up ? $up : $this->_uri;
                $this->_params['uri'] = $up ? $up : $this->_params['uri'];
            }
            return $this->_controller;
        }

        $this->_controller = (string) $controller;
        return $this;
    }

}