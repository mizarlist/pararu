<?php

class Ajax_Relationsheeps {

    public static function save_user($data) {
        $msgs = XML_Msgs::factory('relationsheeps')->getAssoc();
        $msg_ico_str = '<br/><br/><img src="/images/profile/msg_icons/';
        $msg_ico_end = '" />';

        
        if (!isset($data['as']) || !isset($data['user_id'])) {
            return 'show_text_'.$msgs['error'].$msg_ico_str.'cut.png'.$msg_ico_end;
        }
        $table = isset($data['table']) ? $data['table'] : null;
        if ($data['as'] == 'delete' && $table) {
            Plussia_Relationsheeps::deleteRelationsheep($data['user_id'], $table);
            return 'show_text_'.$msgs['delete'].$msg_ico_str.'trash_mini.png'.$msg_ico_end;
        }
        if (!in_array($data['as'], array('saved', 'interes', 'ignor', 'nosearch'))) {
            return 'show_text_'.$msgs['error'].$msg_ico_str.'cut.png'.$msg_ico_end;
        }
        $ui = intval($data['user_id']);
        if ($ui) {
            try {
                Plussia_Relationsheeps::addRelationsheep($data['user_id'], $data['as'], $table);
            } catch (Exception $e) {
                return 'show_text_'.$msgs['error'].$msg_ico_str.'cut.png'.$msg_ico_end;
            }
        }
        if($data['as']=='nosearch'){
            return true;
        }
        return 'show_text_'.$msgs['added'].$msgs['types'][$data['as']].$msg_ico_str.$data['as'].'.png" />';
    }

    public static function get_user_count() {
        $user = Plussia_Dispatcher::getUser();
        $user instanceof Model_User;
        $n = $user->getRSCount('new');
        $i = $user->getRSCount('interesme');
        return $n.','.$i;
    }

}