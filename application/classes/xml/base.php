<?php

defined('SYSPATH') or die('No direct script access.');

class XML_Base {

    protected $XML;
    protected $root;
    protected $assoc = null;
    protected $folder = '/';
    protected $filename;
    protected $rootName = 'root';
    protected $idAttribute = 'name';
    protected $baseTag = 'node';
    protected $cacheEnabled = false;

    public function __construct($filename, $folder = null, $rootName = null, $idAttribute = null, $baseTag = null) {
        $this->filename = $filename;
        $this->folder = $folder ? $folder : $this->folder;
        $this->rootName = $rootName ? $rootName : $this->rootName;
        $this->idAttribute = $idAttribute ? $idAttribute : $this->idAttribute;
        $this->baseTag = $baseTag ? $baseTag : $this->baseTag;
        if ($filename) {
            $this->XML = new DOMDocument();
            $this->XML->load('locates/' . Plussia_Config::currentLang() . '/' . $this->folder . $filename . '.xml');
            $this->getRoot();
        }
    }

    /**
     *
     * @return XML_Base
     */
    public static function factory($filename, $folder = null, $rootName = null, $idAttribute = null, $baseTag = null) {
        $class = get_called_class();
        $object = new $class($filename, $folder, $rootName, $idAttribute, $baseTag);
        return $object;
    }

    protected function getRoot() {
        if ($this->XML) {
            $this->root = $this->XML->getElementsByTagName($this->rootName)->item(0);
        }
    }

    protected function getNodeChilds($node) {
        $node instanceof DOMElement;
        if ($node) {
            $childs = $node->childNodes;
            $ans = array();
            for ($i = 0; $i < $childs->length; $i++) {
                $n = $childs->item($i);
                if (get_class($n) == 'DOMElement') {
                    $ans[] = $n;
                }
            }
            return $ans;
        }
        return array();
    }

    public function getAssoc() {
        if ($this->assoc) {
            return $this->assoc;
        }
        if (!$this->cacheEnabled) {
            $this->assoc = $this->as_assoc();
            return $this->assoc;
        }
        $dir = 'xmlcache/' . Plussia_Config::currentLang();
        $fname = str_replace('/', '_', $this->folder . $this->filename);
        $fullname = $dir . '/' . $fname;
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        if (!file_exists($fullname)) {
            $fp = fopen($fullname, "w");
            $expression = $this->as_assoc();
            $content = serialize($expression);
            fwrite($fp, $content);
            fclose($fp);
            $this->assoc = $expression;
            return $this->assoc;
        } else {
            $fp = fopen($fullname, 'rb');
            $content = fread($fp, filesize($fullname));
            $parsed = unserialize($content);
            $this->assoc = $parsed;
            return $this->assoc;
        }
    }

    protected function as_assoc($node = null) {
        if (!$this->XML) {
            return array();
        }
        if (!$node && $this->root) {
            $node = $this->root;
        } else if (!$node) {
            return array();
        }

        $childs = $this->getNodeChilds($node);

        if (count($childs) > 0) {
            $assoc = array();
            foreach ($childs as $child) {
                if ($child->hasAttribute($this->idAttribute)) {
                    $assoc[$child->getAttribute($this->idAttribute)] = $this->as_assoc($child);
                } else {
                    $assoc[] = $this->as_assoc($child);
                }
            }
        } else {
            $assoc = $node->textContent;
        }
        if (!$node) {
            $this->assoc = $assoc;
        }
        return $assoc;
    }

}