<?php defined('SYSPATH') or die('No direct script access.');

abstract class Plussia_Step {

    public static function factory($id_step) {
        if(!in_array($id_step, array(1,2,3,4,5,6))) {
            return null;
        }
        $class = 'Plussia_Step_'.$id_step;
        return new $class;
    }

    public static function validateStep($current, $next) {
        foreach(array($current, $next) as $id_step) {
            if($id_step!=null && !in_array($id_step, array(1,2,3,4,5,6))) {
                return false;
            }
        }
        $next_class = 'Plussia_Step_'.$next;
        if(!$next_class::canAccess()) {
            return false || true;
        }
        return true; //переписать
    }

    public function save($data) {
        if($this->validate($data)) {
            $this->save_step($data);
        }
    }

    public function validate($data) {
        return false;
    }

    public function save_step($data) {

    }
    public static function canAccess() {
        return true;
    }

    public static function render($context, $id_step, $page=null) {
        if(!$context) {
            throw new Exception('Context required!');
        }
        if(Plussia_Step::validateStep(null, $id_step, $page)) {
            Plussia_Step::factory($id_step)->render_step($context, $page);
        }
    }

}
