<?php

class Plussia_Message {

    private static $cText = null;
    private static $mView = null;

    public static function getContactText() {
        if (!self::$cText) {
            self::$cText = XML_Texts::factory('elements/contact')->getAssoc();
        }
        return self::$cText;
    }

    public static function getMsgView() {
        if (!self::$mView) {
            self::$mView = View::factory('elements/message');
            self::$mView->text = self::getContactText();
        }
        return self::$mView;
    }

    public static function getNewCount() {
        $user_id = Plussia_Dispatcher::getUserId();
        $request = "select ifnull(count(*), 0) as '0' from message where user_id = {$user_id} and is_out=0 and attribute=1";
        list(list($count)) = DB::query(Database::SELECT, $request)->execute()->as_array();
        return $count;
    }

    public static function getContacts() {
        $user = Plussia_Dispatcher::getUser();
        $request = "select m.*, ud1.name as user_name, ud2.name as sputnik_name, ud1.is_woman as user_is_woman, ud2.is_woman as sputnik_is_woman,
            (select count(*) from message mc where mc.user_id=m.user_id and mc.sputnik_id=m.sputnik_id and mc.is_out=0 and mc.attribute=1) as count
        from user u
            left join message m on m.user_id=u.user_id and m.dt_send =
            (select max(mes.dt_send) from message mes where mes.user_id=m.user_id and mes.sputnik_id=m.sputnik_id)
            left join user_data ud1 on ud1.user_id = m.user_id
            left join user_data ud2 on ud2.user_id = m.sputnik_id
            left join user sp on sp.user_id = m.sputnik_id
            where u.user_id={$user->user_id} and m.message_id is not null
            group by m.sputnik_id order by m.dt_send DESC";

        $result = DB::query(Database::SELECT, $request)->as_assoc()->execute()->as_array();
        return $result;
    }

    public static function getContactsData() {
        $contacts = self::getContacts();
        $text = XML_Texts::factory('elements/contact')->getAssoc();
        $ans = array();
        foreach ($contacts as $cont) {
            $msg = array();
            $msg = $cont;
            $msg['sputnik_link'] = '/id' . Model_User::getUID($msg['sputnik_id']);
            $msg['ava'] = Plussia_Linker::getMainPhotoLink($msg['sputnik_id'], Plussia_Linker::VARIANT_SMALL);
            $msg['msg_is_woman'] = $msg['is_out']==1 ? $msg['user_is_woman'] : $msg['sputnik_is_woman'];

            $date = date(Plussia_Help::$formatRuDT, intval($msg['dt_send']));
            $date_arr = explode(' ', $date);
            $msg['time'] = $date_arr[0] . ' ' . $text['in'] . ' ' . $date_arr[1];

            $msg['count_text'] = Plussia_Help::numText($msg['count'], $text['not_read']) . ' ' . Plussia_Help::numText($msg['count'], $text['message']);
            $msg['msg_link'] = $msg['sputnik_link'] . '?page=communication';
            $ans[] = $msg;
        }
        return $ans;
    }

    public static function getContactsHtml() {
        $contacts = self::getContactsData();
        $view = View::factory('elements/contact');
        $ans = '';
        foreach ($contacts as $contact) {
            $view->msg = $contact;
            $ans .= $view->render();
        }
        return $ans;
    }

    public static function getMessages($sputnik_id, $last = false) {
        $user = Plussia_Dispatcher::getUser();
        $request = "select m.*, ud1.name as user_name, ud2.name as sputnik_name, 
        (CASE m.is_out WHEN 1 THEN ud1.is_woman WHEN 0 THEN ud2.is_woman END) as is_woman
        from user u
            left join message m on m.user_id = u.user_id and m.sputnik_id = {$sputnik_id}
            left join user_data ud1 on ud1.user_id=m.user_id
            left join user_data ud2 on ud2.user_id=m.sputnik_id
            where u.user_id = {$user->user_id}";

        if ($last) {
            $request .= ' and m.dt_send =
            (select max(mes.dt_send) from message mes where mes.user_id=m.user_id and mes.sputnik_id=m.sputnik_id and is_out=1)';
        }

        $request .= ' and m.message_id is not null order by m.dt_send DESC';

        $result = DB::query(Database::SELECT, $request)->as_assoc()->execute()->as_array();
        return $result;
    }

    public static function getMessageData($mesage) {
        $text = self::getContactText();
        $msg = $mesage;
        $msg['user_link'] = '/id' . Model_User::getUID($msg['user_id']);
        $msg['sputnik_link'] = '/id' . Model_User::getUID($msg['sputnik_id']);
        $msg['ava'] = Plussia_Linker::getMainPhotoLink($msg['is_out'] == 1 ? $msg['user_id'] : $msg['sputnik_id'], Plussia_Linker::VARIANT_SMALL);

        $date = date(Plussia_Help::$formatRuDT, intval($msg['dt_send']));
        $date_arr = explode(' ', $date);
        $msg['time'] = $date_arr[0] . ' ' . $text['in'] . ' ' . $date_arr[1];
        return $msg;
    }

    public static function getMessageHtml($mesage) {
        $msg = self::getMessageData($mesage);
        $view = self::getMsgView();
        $view->msg = $msg;
        return $view->render();
    }

    public static function getMessagesHtml($sputnik_id) {
        $messages = self::getMessages($sputnik_id);
        $ans = '';
        foreach ($messages as $message) {
            $ans .= self::getMessageHtml($message);
        }
        return $ans;
    }

    public static function getLastMessageHtml($sputnik_id) {
        $messages = self::getMessages($sputnik_id, true);
        $ans = '';
        foreach ($messages as $message) {
            $ans .= self::getMessageHtml($message);
        }
        return $ans;
    }

    public static function deleteMessage($sputnik_id, $message_id) {
        $user_id = Plussia_Dispatcher::getUserId();
        $request = "delete from message where user_id={$user_id} and sputnik_id={$sputnik_id} and message_id='{$message_id}'";
        DB::query(Database::DELETE, $request)->execute();
        return true;
    }

    public static function spamMessage($sputnik_id, $message_id) {
        $user_id = Plussia_Dispatcher::getUserId();
        $time = time();
        $insert = "insert into spam
        select user_id, message_id, sputnik_id, dt_send, {$time} as dt_spam, text
        from message where user_id={$user_id} and sputnik_id={$sputnik_id} and message_id='{$message_id}' limit 1";
        DB::query(Database::INSERT, $insert)->execute();
        self::deleteMessage($sputnik_id, $message_id);
        return true;
    }

    public static function sendMessage($sputnik_id, $text) {
        $user_id = Plussia_Dispatcher::getUserId();
        $mt = microtime() . '';
        str_replace(" ", "_", $mt);
        $time = time();
        $insert = "insert into message (user_id, message_id, sputnik_id, dt_send, text, is_out, attribute)
        values ($user_id, '$mt', $sputnik_id, " . $time . ", '$text', 1, 1),
        ($sputnik_id, '$mt', $user_id, " . $time . ", '$text', 0, 1)";
        DB::query(Database::INSERT, $insert)->execute();
        return self::getLastMessageHtml($sputnik_id);
    }

    public static function message_asReaded() {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $user_id = Plussia_Dispatcher::getUserId();
        if ($sputnik) {
            $sputnik_id = $sputnik->user_id;
            $request = "update message set attribute=0
            where ((user_id={$user_id} and sputnik_id={$sputnik_id} and is_out=0) or
            (user_id={$sputnik_id} and sputnik_id={$user_id} and is_out=1)) and attribute=1";
            DB::query(Database::UPDATE, $request)->execute();
            return true;
        }
        return false;
    }

    public static function deleteHistory($sputnik_id) {
        $user_id = Plussia_Dispatcher::getUserId();
        $request = "delete from message where user_id={$user_id} and sputnik_id={$sputnik_id}";
        DB::query(Database::DELETE, $request)->execute();
        return true;
    }

    public static function getAdminMessages() {
        $user_id = Plussia_Dispatcher::getUserId();
        $request = "select * from admin_message where user_id={$user_id} order by dt_send DESC";
        $res = DB::query(Database::SELECT, $request)->execute()->as_array();
        return $res;
    }

    public static function getAdminMessagesHtml() {
        $messages = self::getAdminMessages();
        $view = View::factory('elements/adminmessage');
        $view->text = XML_Texts::factory('actions_text')->getAssoc();
        $ans = '';
        foreach ($messages as $msg) {
            $view->msg = $msg;
            $ans .= $view->render();
        }
        return $ans;
    }

    public static function deleteAdminMessage($message_id) {
        $user_id = Plussia_Dispatcher::getUserId();
        $request = "delete from admin_message where user_id={$user_id} and message_id='{$message_id}'";
        DB::query(Database::DELETE, $request)->execute();
        return true;
    }

    public static function admin_message_asReaded() {
        $user_id = Plussia_Dispatcher::getUserId();
        $request = "update admin_message set attribute=0
            where user_id={$user_id} and attribute=1";
        DB::query(Database::UPDATE, $request)->execute();
        return true;
    }

}