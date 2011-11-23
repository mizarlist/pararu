<?php

defined('SYSPATH') or die('No direct access allowed.');

class XML_WithMeta extends XML_Base {

    protected $assoc = null;
    protected $meta = null;
    protected $XML;
    protected $root;
    protected $rootName = 'root';
    protected $idAttribute = 'name';
    protected $baseTag = 'text';
    protected $metaattrs = array('type', 'each', 'other', 'print');

    public function addMetaAttrs(Array $adding) {
        $this->metaattrs = array_merge($this->metaattrs, $adding);
        return $this;
    }

    public function setMetaAttrs(Array $setting) {
        $this->metaattrs = $setting;
        return $this;
    }

    protected function as_assoc($node = null) {
        if (!$node && $this->root) {
            $node = $this->root;
        }

        $childs = $this->getNodeChilds($node);

        if (count($childs) > 0) {
            $assoc = array();
            $meta = array();
            foreach ($childs as $child) {
                $associter = $this->as_assoc($child);
                if ($child->hasAttribute($this->idAttribute)) {
                    $meta[$child->getAttribute($this->idAttribute)] = $this->getMeta($child);
                    $assoc[$child->getAttribute($this->idAttribute)] = $associter['assoc'];
                } else {
                    $meta[] = $this->getMeta($child);
                    $assoc[] = $associter['assoc'];
                }
            }
        } else {
            $assoc = $node->textContent;
            $meta = array();
        }
        if (!$node) {
            $this->assoc = $assoc;
            $this->meta = $meta;
        }
        return array('assoc' => $assoc, 'meta' => $meta);
    }

    protected function getMeta($node) {
        $meta = array();
        if ($node) {
            foreach ($this->metaattrs as $field) {
                if ($node->hasAttribute($field)) {
                    $meta[$field] = $node->getAttribute($field);
                }
            }
        }
        return $meta;
    }

}
