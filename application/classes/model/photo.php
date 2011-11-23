<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Photo extends Plussia_ORM {

    protected static $_table_name = 'photo';
    protected static $_primary_key = 'photo_id';
    protected static $_fields = array('album_id', 'user_id', 'name', 'comment', 'type', 'link', 'dt_create', 'lineno');
    public $photo_id;           //id фото
    public $album_id;           //id альбома
    public $user_id;            //id пользователя, чей альбом
    public $name;               //название фото
    public $comment;            //комментарий от пользователя к фото
    public $type;               //тип фото
    public $link;               //ссылка на фото
    public $dt_create;          //дата создания в time
    public $lineno;             //порядок

    /**
     * @param Integer $id
     * @return Model_Photo
     */

    public static function getById($id) {
        return Model_Photo::findOneBy(array('photo_id' => $id));
    }

    public static function addPhoto($user_id, $album_id, $link) {
        $photo = new Model_Photo();
        $photo->fromArray(array(
            'user_id' => $user_id,
            'album_id' => $album_id,
            'link' => $link,
            'type' => 'N',
            'name' => ' ',
            'comment' => ' ',
            'dt_create' => time()));
        $photo->save();
        $photo->lineno = $photo->photo_id;
        return $photo->save();
    }

    public static function getCropVals(Array $whxy, $filename) {
        list($wp, $hp) = getimagesize($filename);
        return Model_Photo::getCropSizes($whxy, $wp, $hp);
    }

    public static function getCropSizes(Array $whxy, $photo_width, $photo_height) {
        $wp = $photo_width;
        $hp = $photo_height;
        $maxw = 560;
        $maxh = 370;

        $wminus = $photo_width - $maxw;
        $hminus = $photo_height - $maxh;

        if ($wminus <= 0 && $hminus <= 0) {
            $wm = $xm = $photo_width;
            $hm = $ym = $photo_height;
        } else if ($wminus > $hminus) {
            $wm = $xm = $maxw;
            $hm = $ym = ($hp/$wp)*$maxw;
        } else if ($wminus < $hminus) {
            $hm = $ym = $maxh;
            $wm = $xm = ($wp/$hp)*$maxh;
        }

        $xp = $wp;
        $yp = $hp;

        $ans = array('w' => 0, 'h' => 0, 'x' => 0, 'y' => 0);
        foreach ($ans as $k => $v) {
            if (isset($whxy[$k]) && $whxy[$k]) {
                $m = $k . 'm';
                $p = $k . 'p';
                $ans[$k] = $$m < $$p ? (($whxy[$k] / $$m) * $$p) : $whxy[$k];
            }
        }
        return $ans;
    }

    public static function getMyPhotoByAlbum($album_id) {
        $user_id = Plussia_Dispatcher::getUserId();

        $like_hash = array();
        $request = 'select p.photo_id, pl.like_num from photo p
            left join photo_like pl on pl.photo_id=p.photo_id
            where p.album_id=' . $album_id;
        foreach (DB::query(Database::SELECT, $request)->as_assoc()->execute() as $like) {
            if (!isset($like_hash[$like['photo_id']])) {
                $like_hash[$like['photo_id']] = array();
            }
            if (!isset($like_hash[$like['photo_id']][$like['like_num']])) {
                $like_hash[$like['photo_id']][$like['like_num']] = 0;
            }
            $like_hash[$like['photo_id']][$like['like_num']]++;
        }

        foreach ($like_hash as $pi => $larr) {
            $val = max($larr);
            $index = array_search($val, $larr);
            $like_hash[$pi] = $index;
        }

        $request = 'select p.photo_id, p.link, p.comment, count(pl.like_num) as com
            from photo p
            left join photo_like pl on pl.photo_id=p.photo_id
            where album_id=' . $album_id . ' group by (p.photo_id) order by p.lineno DESC';
        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();
        $folder = '/userfiles/u' . Model_User::getUID($user_id) . '/photos/';
        $likes = XML_Texts::factory('photolikes', '/')->getAssoc();

        foreach ($results as $r) {
            $like = isset($like_hash[$r['photo_id']]) ? $like_hash[$r['photo_id']] : null;
            $one = array();
            $one['id'] = $r['photo_id'];
            $one['img'] = $folder . $r['link'];
            $one['minimg'] = $folder . self::getMinLink($r['link']);
            $one['txt'] = $r['comment'];
            $one['com'] = $r['com'];
            $one['com2'] = $like ? $likes[$like] : null;
            $ans[] = $one;
        }

        return $ans;
    }

    public static function getPhotosByAlbum($album_id, $user_id = null) {
        $request = 'select photo_id, link, comment from photo where album_id=' . $album_id. ' order by lineno DESC';
        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();
        $folder = '/userfiles/u' . Model_User::getUID($user_id) . '/photos/';

        foreach ($results as $r) {
            $one = array();
            $one['id'] = $r['photo_id'];
            $one['img'] = $folder . $r['link'];
            $one['minimg'] = $folder . self::getMinLink($r['link']);
            $one['txt'] = $r['comment'];
            $ans[] = $one;
        }

        return $ans;
    }

    public static function getMyPhotoLast($count = 30) {
        $user_id = Plussia_Dispatcher::getUserId();

        $like_hash = array();
        $request = 'select p.photo_id, pl.like_num from photo p
            left join photo_like pl on pl.photo_id=p.photo_id
            where p.user_id=' . $user_id .' order by p.lineno DESC limit '.$count;
        foreach (DB::query(Database::SELECT, $request)->as_assoc()->execute() as $like) {
            if (!isset($like_hash[$like['photo_id']])) {
                $like_hash[$like['photo_id']] = array();
            }
            if (!isset($like_hash[$like['photo_id']][$like['like_num']])) {
                $like_hash[$like['photo_id']][$like['like_num']] = 0;
            }
            $like_hash[$like['photo_id']][$like['like_num']]++;
        }

        foreach ($like_hash as $pi => $larr) {
            $val = max($larr);
            $index = array_search($val, $larr);
            $like_hash[$pi] = $index;
        }

        $request = 'select p.photo_id, p.link, p.comment, count(pl.like_num) as com
            from photo p
            left join photo_like pl on pl.photo_id=p.photo_id
            where p.user_id=' . $user_id . ' group by (p.photo_id) order by p.lineno DESC limit '.$count;
        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();
        $folder = '/userfiles/u' . Model_User::getUID($user_id) . '/photos/';
        $likes = XML_Texts::factory('photolikes', '/')->getAssoc();

        foreach ($results as $r) {
            $like = isset($like_hash[$r['photo_id']]) ? $like_hash[$r['photo_id']] : null;
            $one = array();
            $one['id'] = $r['photo_id'];
            $one['img'] = $folder . $r['link'];
            $one['minimg'] = $folder . self::getMinLink($r['link']);
            $one['txt'] = $r['comment'];
            $one['com'] = $r['com'];
            $one['com2'] = $like ? $likes[$like] : null;
            $ans[] = $one;
        }

        return $ans;
    }

    public static function getPhotoLast(Model_User $user, $count = 30) {
        $request = 'select photo_id, link, comment from photo where user_id=' . $user->user_id . ' order by lineno DESC limit '.$count;
        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();
        $folder = '/userfiles/u' . Model_User::getUID($user->user_id) . '/photos/';

        foreach ($results as $r) {
            $one = array();
            $one['id'] = $r['photo_id'];
            $one['img'] = $folder . $r['link'];
            $one['minimg'] = $folder . self::getMinLink($r['link']);
            $one['txt'] = $r['comment'];
            $ans[] = $one;
        }

        return $ans;
    }

    public function getAlbum() {
        return new Model_Album($this->album_id);
    }

    public function getArrayPhoto() {
        $folder = '/userfiles/u' . Model_User::getUID($this->user_id) . '/photos/';
        $one = array();
        $one['id'] = $this->photo_id;
        $one['img'] = $folder . $this->link;
        $one['minimg'] = $folder . self::getMinLink($this->link);
        $one['txt'] = $this->comment;
        return $one;
    }

    public static function getMinLink($link) {
        list($fn, $ext) = explode('.', $link);
        return $fn.'_min.'.$ext;
    }

    public function getLink() {
        $folder = 'userfiles/u' . Model_User::getUID($this->user_id) . '/photos/';
        return $folder . $this->link;
    }

    public function rm($databaseDelete = true) {
        $link = $this->getLink();
        file_exists($link) && unlink($link);
        $min_link = self::getMinLink($link);
        file_exists($min_link) && unlink($min_link);
        $databaseDelete && $this->delete();
    }

    public function addComment($comment) {
        $user_id = Plussia_Dispatcher::getUserId();
        DB::insert('photo_comment')->values(array(
            'photo_id' => $this->photo_id,
            'user_id' => $user_id,
            'text' => $comment,
            'microtime' => microtime(),
            'dt_create' => time()
        ))->execute();
    }

}
