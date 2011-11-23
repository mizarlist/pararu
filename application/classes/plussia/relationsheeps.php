<?php

class Plussia_Relationsheeps {

    public static $tables = array('rs_new', 'rs_interesme', 'rs_interes', 'rs_saved', 'rs_ignor', 'rs_nosearch');

    public static function deleteRelationsheep($user_id, $table = null, $forUser = null) {
        $forUser = $forUser ? $forUser : Plussia_Dispatcher::getUserId();
        $tables = Ajax_Profile::$allowed;
        if (!$table) {
            return self::deleteAllRelationsheep($user_id, $forUser);
        } else if ($table && in_array($table, $tables)) {
            $index = array_search($table, $tables);
            $table = self::$tables[$index];
        } else {
            return false;
        }

        $request = "DELETE FROM $table WHERE user_id=$forUser and sputnik_id=$user_id";

        DB::query(DATABASE::DELETE, $request)->execute();

        if ($table == 'rs_interes') {
            $sputfind = self::searchRelationsheep($forUser, 'rs_interesme', $user_id);
            if ($sputfind) {
                $request = "DELETE FROM rs_interesme WHERE user_id=$forUser and sputnik_id=$user_id";
                DB::query(DATABASE::DELETE, $request)->execute();
            }
        }

        return true;
    }

    public static function addRelationsheep($user_id, $as, $table = null, $forUser = null) {
        $forUser = $forUser ? $forUser : Plussia_Dispatcher::getUserId();
        $dbtable = 'rs_' . $as;
        $rawtable = $table;
        $tables = Ajax_Profile::$allowed;
        $olddata = array();

        if ($table) {
            $index = array_search($table, $tables);
            $table = self::$tables[$index];
            $resarray = self::searchRelationsheep($user_id, $table, $forUser);
            if ($resarray) {
                $olddata = $resarray['row'];
            } else {
                return false;
            }
        } else {
            $resarray = self::searchRelationsheep($user_id, null, $forUser);
            if ($resarray) {
                $olddata = $resarray['row'];
                $table = $resarray['table'];
            }
        }

        $table && self::deleteRelationsheep($user_id, $rawtable, $forUser);
        $ball = $olddata ? $olddata['ball'] : Plussia_Calc::getAll($forUser, $user_id);
        $ball = $ball ? $ball : '0';
        $time = time();

        $request = "INSERT INTO `$dbtable` (user_id, sputnik_id, dt_added, dt_active, ball, lineno)
            VALUES ($forUser, $user_id, NOW(), NOW(), $ball, $time)";

        DB::query(DATABASE::INSERT, $request)->execute();

        if ($dbtable == 'rs_interes') {
            $sputfind = self::searchRelationsheep($forUser, null, $user_id);
            if (!$sputfind || in_array($sputfind['table'], array('rs_new', 'rs_nosearch'))) {
                if ($sputfind) {
                    $request = "DELETE FROM {$sputfind['table']} WHERE user_id=$user_id and sputnik_id=$forUser";
                    DB::query(DATABASE::DELETE, $request)->execute();
                }
                $request = "INSERT INTO `rs_interesme` (user_id, sputnik_id, dt_added, dt_active, ball, lineno)
                VALUES ($user_id, $forUser, NOW(), NOW(), $ball, $time)";

                DB::query(DATABASE::INSERT, $request)->execute();
            }
        }
        return true;
    }

    public static function searchRelationsheep($user_id, $dbtable = null, $forUser = null) {

        $forUser = $forUser ? $forUser : Plussia_Dispatcher::getUserId();
        $tables = $dbtable ? array($dbtable) : self::$tables;

        foreach ($tables as $table) {
            $res = DB::select()->from($table)
                            ->where('user_id', '=', $forUser)
                            ->where('sputnik_id', '=', $user_id)
                            ->limit(1)
                            ->as_assoc()->execute();
            $var = null;
            foreach ($res as $r) {
                $var = $r;
                break;
            }
            if ($var) {
                return array('table' => $table, 'row' => $var);
            }
        }
        return null;
    }

    public static function deleteAllRelationsheep($user_id, $forUser = null) {

        $forUser = $forUser ? $forUser : Plussia_Dispatcher::getUserId();

        $request = "DELETE FROM rs_new, rs_interesme, rs_interes, rs_saved, rs_ignor, rs_nosearch
            USING user
            LEFT JOIN rs_new ON rs_new.user_id=$forUser AND rs_new.sputnik_id=$user_id
            LEFT JOIN rs_interesme ON rs_interesme.user_id=$forUser AND rs_interesme.sputnik_id=$user_id
            LEFT JOIN rs_interes ON rs_interes.user_id=$forUser AND rs_interes.sputnik_id=$user_id
            LEFT JOIN rs_saved ON rs_saved.user_id=$forUser AND rs_saved.sputnik_id=$user_id
            LEFT JOIN rs_ignor ON rs_ignor.user_id=$forUser AND rs_ignor.sputnik_id=$user_id
            LEFT JOIN rs_nosearch ON rs_nosearch.user_id=$forUser AND rs_nosearch.sputnik_id=$user_id
            WHERE user.user_id=$forUser";

        DB::query(DATABASE::DELETE, $request)->execute();

        return true;
    }

}