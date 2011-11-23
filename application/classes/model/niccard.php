<?php

defined('SYSPATH') or die('No direct script access.');

class Model_NicCard extends Plussia_ORM {

    private static $_cacheStructures = array();
    protected static $_table_name = 'nic_card';
    protected static $_primary_key = 'nic_card_id';
    protected static $_fields = array('user_id', 'type', 'lineno', 'strong', 'hardness', 'latitude', 'fragility',
        'softness', 'nonchalance', 'a_l', 'b_l', 'c_l', 'd_l', 'e_l', 'f_l', 'a_b', 'b_b', 'c_b', 'd_b', 'e_b', 'f_b');
    public static $short = array(
        'st' => 'strong',
        'ha' => 'hardness',
        'la' => 'latitude',
        'fr' => 'fragility',
        'so' => 'softness',
        'no' => 'nonchalance',
        'a' => 'a_l',
        'b' => 'b_l',
        'c' => 'c_l',
        'd' => 'd_l',
        'e' => 'e_l',
        'f' => 'f_l',
        'A' => 'a_b',
        'B' => 'b_b',
        'C' => 'c_b',
        'D' => 'd_b',
        'E' => 'e_b',
        'F' => 'f_b');
    public static $types = array(
        1 => 'friendship',
        2 => 'family',
        3 => 'organism',
        4 => 'activity',
        5 => 'dreams');
    public $nic_card_id;
    public $user_id;
    public $type;
    public $lineno;
    public $strong;
    public $hardness;
    public $latitude;
    public $fragility;
    public $softness;
    public $nonchalance;
    public $a_l;
    public $b_l;
    public $c_l;
    public $d_l;
    public $e_l;
    public $f_l;
    public $a_b;
    public $b_b;
    public $c_b;
    public $d_b;
    public $e_b;
    public $f_b;

    public function __construct($id = null) {
        $this->strong = 0;
        $this->hardness = 0;
        $this->latitude = 0;
        $this->fragility = 0;
        $this->softness = 0;
        $this->nonchalance = 0;
        parent::__construct($id);
    }

    public function clear() {
        foreach(self::$short as $k => $field){
            $this->$field = 0;
        }
    }

    private static function getStructureForUser($start, $end, $uid) {
        $cachekey = $start . '_' . $end . '_' . $uid;
        if (!isset(self::$_cacheStructures[$cachekey])) {
            if (count(self::$_cacheStructures) > 1000) {
                self::$_cacheStructures = array();
            }
            $fieldsarr = array("user_id as '0'");
            $fields = array_slice(array_values(self::$short), $start, $end);
            for ($i = 0; $i < count($fields); $i++) {
                $fieldsarr[] = "sum(" . $fields[$i] . ") as '" . ($i + 1) . "'";
            }
            $req = 'select ' . join(',', $fieldsarr) . ' from ' . self::$_table_name . ' where user_id = ' . $uid . ' group by user_id';
            $res = DB::query(Database::SELECT, $req)->execute()->as_array();
            self::$_cacheStructures[$cachekey] = isset($res[0]) ? $res[0] : null;
        }
        return self::$_cacheStructures[$cachekey];
    }

    public static function getNoeticForUser($uid) {
        return self::getStructureForUser(6, 12, $uid);
    }

    public static function getCharacterForUser($uid) {
        return self::getStructureForUser(0, 6, $uid);
    }

    public static function get($id) {
        return Model_User::findOneBy(array('nic_card_id' => $id));
    }

    public function validateSumms() {
        $arr = array('a', 'b', 'c', 'd', 'e', 'f');
        $summ1 = 0;
        $summ2 = 0;
        foreach (array('summ1' => 'l', 'summ2' => 'b') as $summname => $postfix) {
            foreach ($arr as $liter) {
                $attr = $liter . '_' . $postfix;
                $$summname += $this->$attr;
            }
        }
        if ($summ1 == 15 && $summ2 == 15) {
            return true;
        } else {
            return false;
        }
    }

    public static function getForUser($userId) {
        return Model_NicCard::findBy(array('user_id' => $userId));
    }

    public static function deleteForUser($userId) {
        $query = DB::delete(self::$_table_name)->where('user_id', '=', $userId);
    }

}