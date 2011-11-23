<?php

class Plussia_TPActions {

    public function deleteProfile(Model_TmpPass $mtp) {
        $user = new Model_User($mtp->user_id);
        if ($user->loaded()) {
            $user->active = 0;
            $user->save();
            $user = Plussia_Dispatcher::setUser($user);
            $mtp->delete();
            Plussia_Info::call(2);
        }
    }

    public function newLogin1(Model_TmpPass $mtp) {
        $user = new Model_User($mtp->user_id);
        if ($user->loaded()) {
            $mtp->delete();
            $newmtp = new Model_TmpPass(null, 12);
            $newmtp->data = $mtp->data;
            $newmtp->handler = 'newLogin2';
            Plussia_Mail::puckmail('newmail', 'newmail2', $newmtp->data,
                            array(
                                'old' => Plussia_Dispatcher::getUser()->email,
                                'new' => $mtp->data,
                                'link' => $newmtp->getLink()
                            )
            );
            $newmtp->save();
            Plussia_Info::call(4);
        }
    }

    public function newLogin2(Model_TmpPass $mtp) {
        $user = new Model_User($mtp->user_id);
        if ($user->loaded()) {
            $user->email = $mtp->data;
            $user->save();
            $mtp->delete();
            Plussia_Info::call(3);
        }
    }

}

?>
