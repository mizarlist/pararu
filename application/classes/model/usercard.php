<?php

class Model_UserCard extends Plussia_ORM {

    protected static $_table_name = 'user_card';
    protected static $_primary_key = 'user_card_id';
    protected static $_fields = array('user_id', 'card_1', 'card_2', 'card_3', 'card_4', 'card_5', 'card_6',
        'card_7', 'card_8', 'card_9', 'card_10', 'card_11', 'card_12');
    public $user_card_id;
    public $user_id;
    public $card_1;
    public $card_2;
    public $card_3;
    public $card_4;
    public $card_5;
    public $card_6;
    public $card_7;
    public $card_8;
    public $card_9;
    public $card_10;
    public $card_11;
    public $card_12;

    public static function getCardFields() {
        return array('card_1', 'card_2', 'card_3', 'card_4', 'card_5', 'card_6',
            'card_7', 'card_8', 'card_9', 'card_10', 'card_11', 'card_12');
    }

    public static function getRandomEmptyCardId() {
        $user = Plussia_Dispatcher::getUser();
        $user instanceof Model_User;
        $cards = $user->getUserCards();
        $variants = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        foreach ($cards as $card) {
            for ($i = 1; $i <= 12; $i++) {
                $field = 'card_' . $i;
                if ($card->$field != null && isset($variants[$i])) {
                    unset($variants[$i]);
                }
            }
        }
        $empty = array();
        for ($i = 1; $i <= 12; $i++) {
            if (isset($variants[$i])) {
                $empty[] = $i;
            }
        }
        return count($empty) ? $empty[array_rand($empty, 1)] : 0;
    }

    public static function getCadrsForUser($user_id, $checkedOnly = true) {
        $rows = Model_UserCard::findBy(array('user_id' => $user_id), false, true);
        $fields = Model_UserCard::getCardFields();
        $cards = array();
        foreach ($fields as $f) {
            if (!isset($cards[$f])) {
                $cards[$f] = array();
            }
            foreach ($rows as $row) {
                if (!$checkedOnly || $row[$f] !== null) {
                    $cards[$f][] = $row[$f];
                }
            }
        }
        return $cards;
    }

}
