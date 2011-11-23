<?php

class Plussia_Test_NoeticOne {

    private $mas_user_first;
    private $mas_rank_5_first;

    private function getAnswers($user_id) {
        $this->mas_user_first = Model_NicCard::getNoeticForUser($user_id);
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

    private function getStatus() {
        $maxUser1 = max($this->mas_rank_5_first);
        foreach ($this->mas_rank_5_first as $key => $value) {
            if ($value == $maxUser1) {
                return $key+1;
            }
        }
    }

    public function getResult($user_id) {
        $this->getAnswers($user_id);
        $this->mas_rank_5_first = $this->getMasRank5($this->mas_user_first);
        return $this->getStatus();
    }

}

?>