<?php

defined('SYSPATH') or die('No direct script access.');

class Plussia_Post_Registration {

    private $fields = array('me_gender_id', 'find_gender_id', 'me_name', 'birth_date',
        'birth_month_id', 'birth_year', 'me_country_id', 'me_region', 'me_city_id', 'me_mail',
        'password', 'password_confirm', 'how_do_get', 'i_agree');

    public function validate() {
        $notPosted = array();
        foreach ($this->fields as $f) {
            if (!isset($_POST[$f]) && $f != 'me_region') {
                $notPosted[] = $f;
            }
        }
        if (!$_POST['i_agree']) {
            $notPosted[] = 'i_agree';
        }
        if (!isset($_POST['me_region'])) {
            $_POST['me_region'] = '1';
        }
        if (count($notPosted)) {
            Plussia_Error::factory('RegistrationForm', array('fields' => $notPosted));
        }
        return true;
    }

    public function mailCheck($mail) {
        $result = DB::select(array('COUNT("user_id")', 'count'))
                        ->from('user')->where('email', '=', $mail)
                        ->as_assoc()
                        ->execute();
        if ($result[0]['count'] > 0) {
            Plussia_Error::call(3);
        }
    }

    public function do_post() {

        Plussia_Dispatcher::logout();

        $reg_date = date(Plussia_Help::$ddtFormat);

        $user = array('email' => $_POST['me_mail'],
            'password' => $_POST['password'],
            'language' => Plussia_Dispatcher::lang(),
            'time_zone' => 0,
            'registration_date' => $reg_date . '',
            'password_confirm' => $_POST['password_confirm']);

        $month = intval($_POST['birth_month_id']) + 1;
        if ($month < 1 || $month > 12) {
            Plussia_Error::call(1);
        }

        $user_data = array('is_woman' => $_POST['me_gender_id'],
            'name' => $_POST['me_name'],
            'country_id' => $_POST['me_country_id'],
            'region_id' => $_POST['me_region'],
            'city_id' => $_POST['me_city_id'],
            'birthday' => $_POST['birth_year'] . '-' . $month . '-' . $_POST['birth_date']);

        $sputnik_data = array('is_woman' => ($_POST['find_gender_id'] == '0' ? '1' : '0'));

        if (!Model_User::validateData($user) ||
                !Model_UserData::validateData($user_data) ||
                !Model_SputnikData::validateData($sputnik_data)) {
            Plussia_Error::call(1);
        }

        $this->mailCheck($user['email']);

        $u = new Model_User();
        $ud = new Model_UserData();
        $sd = new Model_SputnikData();

        $u->fromArray($user);
        $u->active = 2;
        $u->afterlogin = 'registration';
        $ud->fromArray($user_data);
        $sd->fromArray($sputnik_data);

        $u->save();

        $u->addRole(Model_Role::get('login'));
        $u->addRole(Model_Role::get('registration'));
        $u->addRole(Model_Role::get('regstep1'));

        $u->set('standart_username', Model_User::getUsername($u->user_id));
        $u->update(true);

        Plussia_Dispatcher::setUser($u);

        $ud->set('user_id', $u->user_id);
        $ud->updateZodiak();
        $sd->set('user_id', $u->user_id);
        $ud->save();
        $sd->save();

        $uo = new Model_UserOptions();
        $uo->user_id = $u->user_id;
        $uo->save();

        for ($i = 1; $i <= 5; $i++) {
            $card = new Model_UserCard();
            $card->set('user_id', $u->user_id);
            $card->save();
        }

        $u->createProfileFiles();

        $password = Model_MailProve::createAuth($u);
        $texts = XML_Mail::factory('authentication')->getMail();
        $mail = new Plussia_Mail();
        $view = View::factory('mails/authentication');
        $view->text = $texts['text'];
        $view->link = '//' . URL::base() . Plussia_Dispatcher::lang() . '/authentication?password=' . $password;
        $mail->setAdress($user['email'])->setTheme($texts['title'])->addText($view->render())->send();
        header('Location: /registration');
        die;
        /* if (!$mail->lastResult) {
            Plussia_Error::call(4);
        } else {
            header('Location: /registration');
            die;
            //Plussia_Info::factory('MailSended', array('name' => $user_data['name'], 'email' => $user['email']));
        } */
    }

}