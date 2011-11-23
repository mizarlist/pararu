<?php

defined('SYSPATH') or die('No direct script access.');

class Model_User extends Plussia_ORM {

    protected static $_table_name = 'user';
    protected static $_primary_key = 'user_id';
    protected static $_fields = array('password', 'email', 'username', 'standart_username',
        'last_login', 'last_active', 'last_calculate', 'registration_date', 'afterlogin',
        'active', 'time_zone', 'language', 'logout', 'sonic_enabled');
    public $user_id;            //id пользователя
    public $password;           //пароль пользователя
    public $email;              //mail пользователя
    public $username;           //username пользователя (адрес страницы)
    public $standart_username;  //стандартный username пользователя (адрес страницы)
    public $last_login;         //последний вход
    public $last_active;        ////последняя активность
    public $registration_date;  //дата и время регистрации
    public $afterlogin;         //что делать после входа
    public $active;             //статус
    public $time_zone;          //часовой пояс (+/- часов)
    public $language;           //язык (2-х значная аббревиатура)
    public $logout;             //выходить через в минутах
    public $sonic_enabled;      //признак заполненности sonic
    public $last_calculate;
    public $password_confirm;
    private $hash = array();

    public static function get($name) {
        $field = 'username';
        if (substr($name, 0, 2) == 'id' && Plussia_Help::is_digit_only(substr($name, 2))) {
            $field = 'standart_username';
        }
        return Model_User::findOneBy(array($field => $name));
    }

    public static function getById($id) {
        return Model_User::findOneBy(array('user_id' => $id));
    }

    public function createProfileFiles() {
        $mainf = 'userfiles/';
        $userf = 'u' . Model_User::getUID($this->user_id);
        $uf = $mainf . $userf;

        $fm = $this->isWoman() ? 'female' : 'male';
        $mkdir1 = !is_dir($uf) && mkdir($uf);
        $mkdir2 = !is_dir($uf . '/photo') && mkdir($uf . '/photo');
        $mkdir3 = !is_dir($uf . '/photos') && mkdir($uf . '/photos');

        $copy1 = copy('images/profile/no_photo_' . $fm . '.jpg', $uf . '/photo/main.jpg');
        $copy2 = copy('images/profile/no_photo_' . $fm . '_medium.jpg', $uf . '/photo/main_medium.jpg');

        return $mkdir1 && $mkdir2 && $mkdir3 && $copy1 && $copy2;
    }

    public function getPhotoDir($is_ava_dir = false) {
        $mainf = 'userfiles/';
        $userf = 'u' . Model_User::getUID($this->user_id);
        $uf = $mainf . $userf;
        $dir = $uf . ($is_ava_dir ? '/photo' : '/photos');
        return $dir;
    }
    
    public function isAcount() {
        return $this->user_id == Plussia_Dispatcher::getUserId();
    }

    public function getSomePhoto() {
        return $this->isAcount() ? Model_Photo::getMyPhotoLast() : Model_Photo::getPhotoLast($this);
    }

    public function photoCount($album_id) {
        $select = "select a.user_id, a.album_id, count(p.photo_id) as count from album a
            left join photo p on p.album_id=a.album_id
            where a.user_id={$this->user_id} and a.album_id=$album_id
            group by (a.album_id)";
            list($result) = DB::query(Database::SELECT, $select)->execute();
            return $result ? $result['count'] : 0;
    }

    public function checkAlbum($album_id) {        
        return $this->photoCount($album_id) < 20;
    }

    public function isWoman() {
        $userData = $this->getUserData();
        return $userData->is_woman == 1;
    }

    public function getLastStatus() {
        $status = new stdClass();
        $status->text = 'I believe that we are fundamentally the same and have the same basic potential.';
        $status->time = 12;
        $status->time_spec = 'hour';
        return $status;
    }

    public static function getUsername($id) {
        $length = strlen($id . '');
        $suff = '';
        for ($i = $length; $i <= 5; $i++) {
            $suff .= '0';
        }
        $id = 'id' . $suff . $id;
        return $id;
    }

    public static function getUID($id) {
        $length = strlen($id . '');
        $suff = '';
        for ($i = $length; $i <= 5; $i++) {
            $suff .= '0';
        }
        $id = $suff . $id;
        return $id;
    }

    public static function validateData($data) {
        if (isset($data['password']) && !Plussia_Help::is_safe($data['password']) ||
                isset($data['password']) && isset($data['password_confirm']) && $data['password'] != $data['password_confirm'] ||
                isset($data['email']) && !Plussia_Help::is_mail($data['email'])) {
            return false;
        }
        return true;
    }

    public function access($rolenames) {
        $count = is_array($rolenames) ? count($rolenames) : 1;
        $str = is_array($rolenames) ? join(',', $rolenames) : $rolenames;
        $request = "SELECT COUNT(*) AS `records_found`
            FROM `user_role` WHERE `user_id` = " . $this->pk() . "
            AND `role_id` IN (select role_id from role where name = '$str')";

        $query = DB::query(Database::SELECT, $request);
        $rcount = (int) $query->execute()->get('records_found');

        return $count === $rcount;
    }

    public function fillCardsFromStr($card_number, $str) {
        if (!is_numeric($card_number) || $card_number < 1 || $card_number > 12) {
            throw new Exception('invalid card number');
        }
        $arg = 'card_' . $card_number;

        $cards = $this->getUserCards();
        $ansvers = explode(';', $str);

        $this->set('afterlogin', 'registration');
        $this->save();

        for ($i = 1; $i <= 5; $i++) {
            $c = new Model_UserCard($cards[$i - 1]->user_card_id);
            if (isset($cards[$i - 1]) && isset($ansvers[$i - 1]) && $ansvers[$i - 1]) {
                $c->set($arg, $ansvers[$i - 1]);
                $c->save();
            } else {
                $c->set($arg, null);
                $c->save();
            }
        }
    }

    public function addRole(Model_Role $role) {
        DB::insert('user_role')
                ->columns(array('role_id', 'user_id'))
                ->values(array('role_id' => $role->role_id, 'user_id' => $this->user_id))
                ->execute();
    }

    public function deleteRole(Model_Role $role) {
        DB::delete('user_role')
                ->where('role_id', '=', $role->role_id)
                ->where('user_id', '=', $this->user_id)
                ->execute();
    }

    public function getUserCards() {
        return Model_UserCard::findBy(array('user_id' => $this->user_id));
    }

    /**
     * @return Model_UserData
     */
    public function getUserData() {
        if (!isset($this->hash['user_data'])) {
            $this->hash['user_data'] = Model_UserData::findOneBy(array('user_id' => $this->user_id));
        }
        return $this->hash['user_data'];
    }

    /**
     * @return Model_UserOptions
     */
    public function getUserOptions() {
        if (!isset($this->hash['user_options'])) {
            $this->hash['user_options'] = Model_UserOptions::findOneBy(array('user_id' => $this->user_id));
        }
        return $this->hash['user_options'];
    }

    public function validateNic() {
        $query = DB::select(array('COUNT("*")', 'total'))->from('nic_card')->where('user_id', '=', $this->user_id);
        foreach ($query->as_object()->execute() as $r) {
            return $r->total == 5;
        }
        return false;
    }

    public function updateNicCards($set, $order) {
        //данные приходят ввиде
        //set => array('<номер блока>_<номер вопроса>_<вариант - st, f, a, A, ...>_<не значащая цифра>' =>
        //<признак отметки (true) или кол-во выставленных баллов>)
        //order => порядок выбора блоков

        if ($this->validateNic()) {
            $cards = Model_NicCard::findBy(array('user_id' => $this->user_id));
            $iter = 1;
            $resarr = array();
            foreach ($cards as $card) {
                $card->clear();
                $resarr[$iter] = $card;
                $iter++;
            }
        } else {
            $resarr = array(
                1 => new Model_NicCard(),
                2 => new Model_NicCard(),
                3 => new Model_NicCard(),
                4 => new Model_NicCard(),
                5 => new Model_NicCard());
        }

        foreach ($set as $key => $value) {
            $keyarr = explode('_', $key);
            $keyarr[0] = intval($keyarr[0]);
            $keyarr[1] = intval($keyarr[1]);
            $object = $resarr[$keyarr[0]];
            $field = Model_NicCard::$short[$keyarr[2]];

            if ($keyarr[1] == 2 || $keyarr[1] == 3) {
                $object->$field = intval($value);
            } else if ($keyarr[1] == 1) {
                $object->$field += 1;
            } else if ($keyarr[1] == 4) {
                $val = intval($value) / 10;
                $object->$field += $val;
            }
        }

        foreach ($resarr as $niccard) {
            if (!$niccard->validateSumms()) {
                return;
            }
        }

        Model_NicCard::deleteForUser($this->user_id);

        foreach ($resarr as $key => $niccard) {
            $niccard->user_id = $this->user_id;
            $niccard->type = Model_NicCard::$types[$key];
            $niccard->lineno = array_search($key, $order) + 1;
            $niccard->save();
        }
        $this->sonic_enabled = 1;
        $this->save();
    }

    public function getRS($type = 'interes', $offset = null, $limit = null) {

        $locate = Plussia_Config::currentLang() == 'ru' ? 'ru' : 'en';

        $table = 'rs_' . $type;
        $request = "select ud.user_id, ud.name, ifnull(u.username, u.standart_username) as username,
                    ud.birthday, rs.ball, ud.is_woman, u.active, u.registration_date,
                    ifnull(u.last_active, u.registration_date) as last_active,
                    c_.country_name_$locate as country,
                    ci_.city_name_$locate as city,
                    rs.dt_added 
                    from $table rs
                    left join user u on u.user_id=rs.sputnik_id
                    left join user_data ud on ud.user_id=rs.sputnik_id
                    left join country_ c_ on c_.country_id=ud.country_id
                    left join city_ ci_ on ci_.city_id=ud.city_id
                    where rs.user_id = $this->user_id  order by lineno DESC";

        if ($limit) {
            $request .= ' limit ' . $limit;
        }
        if ($offset) {
            $request .= ' offset ' . $offset;
        }

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();

        foreach ($results as $res) {
            $ans[] = $res;
        }
        return $ans;
    }

    private static $rscount_cach = array();

    public function getRSCount($type = 'interes') {
        if (!isset($rscount_cach[$type])) {
            $table = 'rs_' . $type;
            $request = "select count(*) as count from $table rs
                    where rs.user_id = $this->user_id";

            $query = DB::query(Database::SELECT, $request);
            $results = $query->as_assoc()->execute();

            foreach ($results as $res) {
                $rscount_cach[$type] = $res['count'];
                break;
            }
        }
        return $rscount_cach[$type];
    }

}
