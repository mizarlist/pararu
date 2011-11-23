<?php


class XML_Info extends XML_Base {

    protected $baseTag = 'info';

    public static function getInfoContent($id) {
        return XML_Info::factory('infos')->getById($id);
    }

    public function getById($id) {
        if(!$this->XML) {
            return array();
        }
        if(!$this->root) {
            return array();
        }
        $elements = $this->root->getElementsByTagName('info');
        $info_node = null;

        foreach($elements as $element) {
            if($element->getAttribute('id')==$id) {
                $info_node = $element;
                break;
            }
        }

        if($info_node) {
            return array(
                    'title' => $info_node->getElementsByTagName('title')->item(0)->textContent,
                    'message' => $info_node->getElementsByTagName('message')->item(0)->textContent);
        }
        return array(
                'title' => '',
                'message' => '');
    }

}