<?php

class Ajax_Base {

    private static $functionals = array(
        'get_arials' => 'Ajax_Index',

        'save_user' => 'Ajax_Relationsheeps',
        'get_user_count' => 'Ajax_Relationsheeps',

        'account_centerblock' => 'Ajax_Account',
        'account_save_answers' => 'Ajax_Account',

        'sputnik_centerblock' => 'Ajax_Sputnik',
        'compare_centerblock' => 'Ajax_Sputnik',

        'compare_usercard' => 'Ajax_Compare',

        'help' => 'Ajax_Help',
        'help_add_question' => 'Ajax_Help',

        'profile_centerblock' => 'Ajax_Profile',
        'profile_usercards' => 'Ajax_Profile',
        'get_interes_block' => 'Ajax_Profile',

        'aboutme_centerblock' => 'Ajax_Aboutme',

        'nic_centerblock' => 'Ajax_Nic',
        'nic_save_answers' => 'Ajax_Nic',
        'nic_save_card' => 'Ajax_Nic',
        'get_nictest_result' => 'Ajax_Nic',
        'save_nictest_answers' => 'Ajax_Nic',
        'get_nictest_test' => 'Ajax_Nic',

        'photoalbums_creatAlbums' => 'Ajax_Photo',
        'photoalbums_getAlbums' => 'Ajax_Photo',
        'photoalbums_getPhoto' => 'Ajax_Photo',
        'photoalbums_setDescription' => 'Ajax_Photo',
        'photoalbums_setAttrAlb' => 'Ajax_Photo',
        'photoalbums_delAlbums' => 'Ajax_Photo',
        'photoalbums_delPhoto' => 'Ajax_Photo',
        'photoalbums_setCommentPhoto' => 'Ajax_Photo',
        'photoalbums_setCover' => 'Ajax_Photo',
        'photoalbums_setAva' => 'Ajax_Photo',
        'photoalbums_setMiniAva' => 'Ajax_Photo',
        'photoalbums_changePrivilege' => 'Ajax_Photo',
        'photoalbums_getSomephoto' => 'Ajax_Photo',

        'actions_centerblock' => 'Ajax_Message',
        'message_send' => 'Ajax_Message',
        'message_send_to' => 'Ajax_Message',
        'message_deleteMessage' => 'Ajax_Message',
        'message_spam' => 'Ajax_Message',
        'message_deleteHistory' => 'Ajax_Message',
        'message_deleteAdminMessage' => 'Ajax_Message',

        'search_centerblock' => 'Ajax_Search',
        'search_fast' => 'Ajax_Search',
        'search_full' => 'Ajax_Search',
        'search_saveSputnikData' => 'Ajax_Search',
        );

    public static function ajax($data){
        if(!isset($_POST['functional'])) {
            return null;
        }

        $functional = $_POST['functional'];

        if(!isset(self::$functionals[$functional])) {
            return null;
        }

        $interface = self::$functionals[$functional];

        return $interface::$functional($data);
    }

}
