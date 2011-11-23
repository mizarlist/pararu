<?php

class System_Calc {

    private $userIds = array();

    public function __construct() {
        foreach (DB::select('user_id')
                ->from('user')
                ->where('active', '=', 1)
                ->where('last_calculate', 'is', null)
                ->execute() as $id) {
            $this->userIds[] = $id['user_id'];
        }
    }

    public function calculate() {
        foreach ($this->userIds as $user_id) {
            $res = $this->calculateId($user_id);
            usort($res, 'self::usortRevertPB');
            $res = self::getLast($res, 100);
            $count = count($res);
            $group_request = "INSERT INTO `rs_new` (user_id, sputnik_id, dt_added, dt_active, ball, lineno) VALUES ";
            $pieces = array();
            $time = time();
            for ($i = 0; $i < 100 && $i < $count; $i++) {
                $t = $time+$i;
                $pieces[] = "($user_id, {$res[$i]['user_id']}, NOW(), NOW(), {$res[$i]['ball']}, {$t})";
            }
            $group_request .= join(',', $pieces);
            $count && DB::query(DATABASE::INSERT, $group_request)->execute();
        }
    }

    public static function getLast($array, $number){
        $count = count($array);
        if($count < $number) {
            return $array;
        }
        return array_slice($array, $count-$number, $number);
    }

    public static function usortPB($el1, $el2, $revert = false) {
        if ($el1['position_type'] < $el2['position_type']) {
            return $revert ? 1 : -1;
        }
        if ($el1['position_type'] > $el2['position_type']) {
            return $revert ? -1 : 1;
        }
        if ($el1['ball'] > $el2['ball']) {
            return $revert ? 1 : -1;
        }
        if ($el1['ball'] < $el2['ball']) {
            return $revert ? -1 : 1;
        }
        return 0;
    }

    public static function usortRevertPB($el1, $el2) {
        return self::usortPB($el1, $el2, true);
    }

    private function calculateId($user_id) {
        $candidates = $this->getCandidates($user_id);
        $result = array();
        $positions = array('1' => array(), '2' => array(), '3' => array());
        foreach ($candidates as $c => $position_type) {
            $r = Plussia_Calc::all($user_id, $c, false);
            $result[$c] = array('ball' => $r, 'position_type' => $position_type, 'user_id' => $c);
        }
        return $result;
    }

    private function getCandidates($user_id) {
        $request = "select u2.user_id, 
        CASE ud2.city_id=ud1.city_id WHEN true THEN 1 WHEN false THEN (
        CASE ud2.region_id=ud1.region_id WHEN true THEN 2 WHEN false THEN (
        CASE ud2.country_id=ud1.country_id WHEN true THEN 3 WHEN false THEN 4 END) END ) END as position_type
        from user u1
            left join sputnik_data sd1 on sd1.user_id=u1.user_id
            left join user_data ud1 on ud1.user_id=u1.user_id
            left join user_data ud2 on ud2.is_woman=sd1.is_woman
            left join user u2 on u2.user_id=ud2.user_id
            left join sputnik_data sd2 on sd2.user_id=u2.user_id
            where u1.user_id=$user_id
            and u2.user_id != u1.user_id
            and sd2.is_woman = ud1.is_woman
            and u2.user_id not in (select idExisted.sputnik_id from (
        (select sputnik_id from rs_ignor rig where rig.user_id=$user_id) union
        (select sputnik_id from rs_interes rin where rin.user_id=$user_id) union
        (select sputnik_id from rs_new rne where rne.user_id=$user_id) union
        (select sputnik_id from rs_nosearch rno where rno.user_id=$user_id) union
        (select sputnik_id from rs_saved rsa where rsa.user_id=$user_id)) idExisted )";

        $result = array();
        foreach (DB::query(Database::SELECT, $request)->execute() as $id) {
            $result[$id['user_id'] . ''] = $id['position_type'] . '';
        }
        return $result;
    }

}