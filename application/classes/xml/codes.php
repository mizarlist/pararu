<?php

defined('SYSPATH') or die('No direct access allowed.');

class XML_Codes extends XML_Base {

    protected $assoc = null;
    protected $XML;
    protected $root;
    protected $rootName = 'root';
    protected $idAttribute_l1 = 'id';
    protected $idAttribute_l2 = 'id_variant';
    protected $baseTag_l1 = 'card';
    protected $baseTag_l2 = 'variant';

    protected function as_assoc($node = null) {
        if ($this->assoc) {
            return $this->assoc;
        }
        if (!$this->XML) {
            return array();
        }
        if (!$node && $this->root) {
            $node = $this->root;
        } else if (!$node) {
            return array();
        }

        $assoc = array();

        $childs = $node->getElementsByTagName($this->baseTag_l1);

        foreach ($childs as $child) {
            $id = $child->getAttribute($this->idAttribute_l1);
            $assoc[$id] = array();
            $variants = $child->getElementsByTagName($this->baseTag_l2);
            foreach ($variants as $variant) {
                $id_2 = $variant->getAttribute($this->idAttribute_l2);
                $assoc[$id][$id_2] = $variant->textContent;
            }
        }

        if (!$node) {
            $this->assoc = $assoc;
        }
        return $assoc;
    }

}
