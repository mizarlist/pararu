<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Album extends Plussia_ORM {

    protected static $_table_name = 'album';
    protected static $_primary_key = 'album_id';
    protected static $_fields = array('user_id', 'name', 'comment', 'dt_create', 'dt_update');
    public $album_id;           //id альбома
    public $user_id;            //id пользователя, чей альбом
    public $name;               //название альбома
    public $comment;            //комментарий от пользователя к альбому
    public $dt_create;          //дата создания в time
    public $dt_update;          //дата обновления альбома в time

    /**
     * @param Integer $id
     * @return Model_Album
     */

    public static function getById($id) {
        return Model_Album::findOneBy(array('album_id' => $id));
    }

    public static function countByUser($id){
        $result = DB::select(array('COUNT("album_id")', 'count'))
                        ->from('album')->where('user_id', '=', $id)
                        ->as_assoc()
                        ->execute();
        return isset($result[0]) && isset($result[0]['count']) ? $result[0]['count'] : 0;
    }

    public static function createNew($name = null) {
        $album = new Model_Album();
        $album->dt_create = $album->dt_update = time();
        $album->comment = '';
        $album->user_id = Plussia_Dispatcher::getUserId();
        $album->name = $name ? $name : date('d.m.Y H:i:s', $album->dt_create);
        $album->save();
        return $album;
    }

    public static function getAlbumsByUser($user_id) {
        $request = "select a.album_id, a.name, a.comment, a.dt_create, a.dt_update, count(p.photo_id) as count
            from album a
            left join photo p on p.album_id=a.album_id
            where a.user_id=$user_id
            group by (a.album_id)";

        $query = DB::query(Database::SELECT, $request);
        $results = $query->as_assoc()->execute();

        $ans = array();
        $folder = '/userfiles/u' . Model_User::getUID($user_id) . '/photos/';

        foreach ($results as $r) {
            $one = array();
            $one['id'] = $r['album_id'];
            $one['img'] = $folder . $r['album_id'] . '.jpg' . '?mt=' . microtime();
            $one['name'] = $r['name'];
            $one['txt'] = $r['comment'] ? $r['comment'] : '';
            $one['count_photo'] = $r['count'];
            $one['date_create'] = date('d.m.Y H:i:s', $r['dt_create']);
            $one['date_update'] = date('d.m.Y H:i:s', $r['dt_update']);
            $ans[] = $one;
        }

        return $ans;
    }

    public function getPhotos() {
        return Model_Photo::findBy(array('album_id' => $this->album_id));
    }

    public function getLink() {
        return 'userfiles/u' . Model_User::getUID($this->user_id) . '/photos/';
    }

    public function rm() {
        $folder = $this->getLink();
        foreach ($this->getPhotos() as $photo) {
            $photo->rm(false);
        }
        if (file_exists($folder . $this->album_id . '.jpg')) {
            unlink($folder . $this->album_id . '.jpg');
        }
        $this->delete();
    }

}
