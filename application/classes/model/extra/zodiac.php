<?php

class Model_Extra_Zodiac {

    public static function getZodiakByDate($date) {
        $elements = explode('-', $date);
        $month = $elements[1];
        $day = $elements[2];
        $request = "select zodiac_id from zodiac where (month_begin=$month and day_begin>=$day) or (month_end=$month and day_end<=$day)";
        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();
        return $results[0]['zodiac_id'];
    }

    public static function getHarmonyWeight($user_zodiac_id, $sputnik_zodiac_id) {
        $request = "select weight from zodiac_harmony where zodiac_id=$user_zodiac_id and sputnik_zodiac like CONCAT('%;', $sputnik_zodiac_id, ';%')";
        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();
        return is_array($results) && isset($results[0]) ? $results[0]['weight'] : 0;
    }

    public static function getHarmonyIndex($zid1, $zid2) {
        if ($zid1 < $zid2 || $zid1 == $zid2) {
            return $zid1 . '_' . $zid2;
        }
        return $zid2 . '_' . $zid1;
    }

}