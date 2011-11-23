<?php


class XML_Error extends XML_Base {

    protected $baseTag = 'error';

    public static function getErrorContent($id) {
        return XML_Error::factory('errors')->getById($id);
    }

    public function getById($id) {
        if(!$this->XML) {
            return array();
        }
        if(!$this->root) {
            return array();
        }
        $elements = $this->root->getElementsByTagName('error');
        $error_node = null;

        foreach($elements as $element) {
            if($element->getAttribute('id')==$id) {
                $error_node = $element;
                break;
            }
        }

        if($error_node) {
            return array(
                    'title' => $error_node->getElementsByTagName('title')->item(0)->textContent,
                    'message' => $error_node->getElementsByTagName('message')->item(0)->textContent);
        } else {
            return array(
                    'title' => 'Not Found Error',
                    'message' => 'Please, contact support');
        }
    }

}