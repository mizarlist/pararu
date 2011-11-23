<?php

class Plussia_Test_Noetic {

    private $mas_user_first;
    private $mas_user_second;
    private $mas_rank_5_first;
    private $mas_rank_4_first;
    private $mas_rank_3_first;
    private $mas_rank_2_first;
    private $mas_rank_5_second;
    private $mas_rank_4_second;
    private $mas_rank_3_second;
    private $mas_rank_2_second;

    private function getAnswers($userId_first, $userId_second) {
        $this->mas_user_first = Model_NicCard::getNoeticForUser($userId_first);
        $this->mas_user_second = Model_NicCard::getNoeticForUser($userId_second);
    }

    private function getMasRank5($mas_from) {
        $mas_to = array();
        for ($i = 1; $i < 7; $i++) {
            $next = $i + 7;
            $prev = $i + 5;
            if ($i == 1)
                $mas_to[] = $mas_from[$i] + $mas_from[$next];
            if ($i != 1 && $i != 6) {
                $mas_to[] = $mas_from[$i] + $mas_from[$prev];
                $mas_to[] = $mas_from[$i] + $mas_from[$next];
            }
            if ($i == 6)
                $mas_to[] = $mas_from[$i] + $mas_from[$prev];
        }
        return $mas_to;
    }

    private function getMasRank4($mas_from) {
        $mas_to = array();
        for ($i = 1; $i < 7; $i++) {
            $next = $i + 6;
            $mas_to[] = $mas_from[$i] + $mas_from[$next];
        }
        return $mas_to;
    }

    private function getMasRank3($mas_from) {
        $mas_to = array();
        for ($i = 8; $i < 12; $i++) {
            $mas_to[] = $mas_from[$i];
        }
        return $mas_to;
    }

    private function getMasRank2($mas_from) {
        $mas_to = array();
        for ($i = 2; $i < 6; $i++) {
            $mas_to[] = $mas_from[$i];
        }
        return $mas_to;
    }

    private function getRankMass($mas_from, $max_rank, $const) {
        $max = max($mas_from) * $const;
        $mas_to = array();
        for ($i = 0; $i < count($mas_from); $i++) {
            $mas_to[] = (($mas_from[$i] * $const) * $max_rank) / $max;
        }

        return $mas_to;
    }

    private function getResultRank5() {
        $mas_to = array();
        $i = 0;
        while ($i < 10) {
            $first = $this->mas_rank_5_first[$i];
            $second = $this->mas_rank_5_second[$i + 1];
            $mas_to[] = (($first * 5) + ($second * 5)) / 2;
            $first = $this->mas_rank_5_first[$i + 1];
            $second = $this->mas_rank_5_second[$i];
            $mas_to[] = (($first * 5) + ($second * 5)) / 2;

            $i+=2;
        }

        rsort($mas_to, SORT_NUMERIC);
        $result = ((($mas_to[0] + $mas_to[1]) / 2) * 35) / 50;
        return $result;
    }

    private function getResultRank4() {
        $mas_to = array();
        $i = 0;
        for ($i = 0; $i < count($this->mas_rank_4_first); $i++) {
            $first = $this->mas_rank_4_first[$i];
            $second = $this->mas_rank_4_second[$i];
            $mas_to[] = ($first * 4 + $second * 4) / 2;
        }

        $result = (max($mas_to) * 10) / 24;
        return $result;
    }

    private function getResultRank3() {
        $mas_to = array();
        $i = 0;
        while ($i < 4) {
            $first = $this->mas_rank_3_first[$i];
            $second = $this->mas_rank_3_second[$i + 1];
            $mas_to[] = (($first * 3) + ($second * 3)) / 2;
            $first = $this->mas_rank_3_first[$i + 1];
            $second = $this->mas_rank_3_second[$i];
            $mas_to[] = (($first * 3) + ($second * 3)) / 2;

            $i+=2;
        }

        rsort($mas_to, SORT_NUMERIC);
        $result = (max($mas_to) * 3) / 12;
        return $result;
    }

    private function getResultRank2() {
        $mas_to = array();
        $i = 0;
        for ($i = 0; $i < count($this->mas_rank_2_first); $i++) {
            $first = $this->mas_rank_2_first[$i];
            $second = $this->mas_rank_2_second[$i];
            $mas_to[] = ($first * 2 + $second * 2) / 2;
        }

        $result = (max($mas_to) * 2) / 8;
        return $result;
    }

    public function getResult($user_id, $sputnik_id) {
        $this->getAnswers($sputnik_id, $user_id);
        $this->mas_rank_5_first = $this->getMasRank5($this->mas_user_first);
        $this->mas_rank_5_second = $this->getMasRank5($this->mas_user_second);
        $this->mas_rank_4_first = $this->getMasRank4($this->mas_user_first);
        $this->mas_rank_4_second = $this->getMasRank4($this->mas_user_second);
        $this->mas_rank_3_first = $this->getMasRank3($this->mas_user_first);
        $this->mas_rank_3_second = $this->getMasRank3($this->mas_user_second);
        $this->mas_rank_2_first = $this->getMasRank2($this->mas_user_first);
        $this->mas_rank_2_second = $this->getMasRank2($this->mas_user_second);

        $this->mas_rank_5_first = $this->getRankMass($this->mas_rank_5_first, 10, 5);
        $this->mas_rank_5_second = $this->getRankMass($this->mas_rank_5_second, 10, 5);

        $this->mas_rank_4_first = $this->getRankMass($this->mas_rank_4_first, 6, 4);
        $this->mas_rank_4_second = $this->getRankMass($this->mas_rank_4_second, 6, 4);

        $this->mas_rank_3_first = $this->getRankMass($this->mas_rank_3_first, 4, 3);
        $this->mas_rank_3_second = $this->getRankMass($this->mas_rank_3_second, 4, 3);

        $this->mas_rank_2_first = $this->getRankMass($this->mas_rank_2_first, 4, 2);
        $this->mas_rank_2_second = $this->getRankMass($this->mas_rank_2_second, 4, 2);

        $result_5 = $this->getResultRank5();
        $result_4 = $this->getResultRank4();
        $result_3 = $this->getResultRank3();
        $result_2 = $this->getResultRank2();
        return $result_2 + $result_3 + $result_4 + $result_5;
    }

}

?>
