<?php

class Plussia_ORM {

    protected $_loaded = false;
    protected static $_table_name = '';
    protected static $_primary_key = 'id';
    protected static $_fields = array();
    protected $_changed = array();
    protected static $_cach = array();
    protected static $_cachCount = 0;

    public function __construct($id=null) {
        if ($id) {
            $_primary_key = $this->getStatic('_primary_key');
            $this->$_primary_key = $id;
            $query = DB::select()->from($this->getStatic('_table_name'))->where($this->getStatic('_primary_key'), '=', $id);
            $results = $query->as_assoc()->execute();
            if (count($results) > 0) {
                $this->fromArray($results[0]);
                $this->_loaded = true;
            }
        }
    }

    public static function findBy($assoc, $fieldsOnly=false, $asArray = false, $one = false) {
        $class = get_called_class();
        $hashKey = self::hashKey($assoc, $one);
        if (!isset(self::$_cach[$hashKey])) {
            $query = DB::select()->from($class::$_table_name);
            foreach ($assoc as $f => $v) {
                if (!$fieldsOnly || in_array($f, $class::$_fields) !== false) {
                    $query->where($f, '=', $v);
                }
            }
            $one && $query->limit(1);
            $results = $query->as_assoc()->execute();
            $count = count($results);
            self::$_cachCount += $count;
            if (self::$_cachCount > 100) {
                self::$_cach = array();
                self::$_cachCount = $count;
            }
            self::$_cach[$hashKey] = $results;
        }
        return $asArray ? self::$_cach[$hashKey] : self::fetchTo(self::$_cach[$hashKey]);
    }

    public static function hashKey($assoc, $one = false) {
        $class = get_called_class();
        $res = $class . ':';
        foreach ($assoc as $key => $value) {
            $res .= $key . '=>' . $value;
        }
        return $res.($one ? ' -one' : '');
    }

    public static function findOneBy($assoc, $fieldsOnly=false, $asArray = false) {
        $result = self::findBy($assoc, $fieldsOnly, $asArray, true);
        return count($result) ? $result[0] : null;
    }

    public static function fetchTo($selectResult) {
        $collection = array();
        $class = get_called_class();
        foreach ($selectResult as $sr) {
            $obj = new $class;
            if (isset($sr[$class::$_primary_key])) {
                $_primary_key = $class::$_primary_key;
                $obj->$_primary_key = $sr[$class::$_primary_key];
                $obj->setLoaded(true);
            }
            $obj->fromArray($sr);
            $collection[] = $obj;
        }
        return $collection;
    }

    public static function fetchArray($selectResult, $field = null) {
        $collection = array();
        foreach ($selectResult as $sr) {
            if ($field) {
                $collection[$sr[$field]] = $sr;
            } else {
                $collection[] = $sr;
            }
        }
        return $collection;
    }

    public function getStatic($field) {
        $class = get_class($this);
        if (isset($class::$$field)) {
            return $class::$$field;
        }
        return null;
    }

    public function pk() {
        $pk = $this->getStatic('_primary_key');
        return $this->$pk;
    }

    public function fromArray($array) {
        foreach ($array as $key => $value) {
            if (in_array($key, $this->getStatic('_fields')) !== false) {
                $this->set($key, $value);
            }
        }
        return $this;
    }

    public function set($field, $value) {
        if (in_array($field, $this->getStatic('_fields')) !== false) {
            $this->$field = $value;
            $this->_changed[] = $field;
        }
        return $this;
    }

    public function getAttr($column) {
        return $this->$column;
    }

    public function loaded() {
        return $this->_loaded;
    }

    public function setLoaded($bool = false) {
        $this->_loaded = $bool;
    }

    public function asArray($notNullOnly=false) {
        $ans = array();
        foreach ($this->getStatic('_fields') as $field) {
            if (!$notNullOnly || $this->$field != null) {
                $ans[$field] = $this->$field;
            }
        }
        return $ans;
    }

    public function save() {
        if ($this->loaded()) {
            $this->update();
        } else {
            $this->create();
        }
        return $this;
    }

    public function create() {
        $array = $this->asArray(true);
        $insert = DB::insert($this->getStatic('_table_name'), array_keys($array))->values(array_values($array));
        list($insert_id, $affected_rows) = $insert->execute();
        if (isset($insert_id) && $insert_id) {
            $pk = $this->getStatic('_primary_key');
            $this->$pk = $insert_id;
            $this->setLoaded(true);
            return true;
        } else {
            return false;
        }
    }

    public function update($changedOnly=false) {
        $setarr = array();
        $fieldsArr = $changedOnly ? $this->_changed : $this->getStatic('_fields');
        foreach ($fieldsArr as $field) {
            $setarr[$field] = $this->$field;
        }
        $pk = $this->getStatic('_primary_key');
        $affected_rows = DB::update($this->getStatic('_table_name'))
                        ->set($setarr)->where($pk, '=', $this->$pk)
                        ->execute();
        return $affected_rows;
    }

    public function delete() {
        $pk = $this->getStatic('_primary_key');
        $affected_rows = DB::delete($this->getStatic('_table_name'))->where($pk, '=', $this->$pk)->execute();
        if ($affected_rows) {
            $this->setLoaded(false);
        }
        return $affected_rows;
    }

}