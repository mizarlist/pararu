<?php

class Ajax_Photo {

    public static function photoalbums_creatAlbums($data = null) {
        if(Model_Album::countByUser(Plussia_Dispatcher::getUserId()) > 2) {
            return 'error Вы не можете создать более 3-х альбомов!';
        }
        $album = Model_Album::createNew();
        $one = array();
        $one['id'] = $album->album_id;
        $one['img'] = null;
        $one['name'] = $album->name;
        $one['txt'] = $album->comment ? $album->comment : '';
        $one['count_photo'] = 0;
        $one['date_create'] = date('d.m.Y H:i:s', $album->dt_create);
        $one['date_update'] = date('d.m.Y H:i:s', $album->dt_update);
        $ans[] = $one;
        return $ans;
    }

    public static function photoalbums_getAlbums($data = null) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $albums = Model_Album::getAlbumsByUser($sputnik ? $sputnik->user_id : Plussia_Dispatcher::getUserId());
        return $albums;
    }

    public static function photoalbums_getPhoto($data) {
        $album_id = $data->id;
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $uid = $sputnik ? $sputnik->user_id : Plussia_Dispatcher::getUserId();
        $is_me = $uid == Plussia_Dispatcher::getUserId() ? true : false;
        $photos = $is_me ? Model_Photo::getMyPhotoByAlbum($album_id) : Model_Photo::getPhotosByAlbum($album_id, $uid);
        return $photos;
    }

    public static function photoalbums_setDescription($data) {
        $photo_id = $data->id;
        $comment = $data->txt;
        $photo = Model_Photo::getById($photo_id);
        if (Plussia_Dispatcher::getUserId() == $photo->user_id) {
            $photo->set('comment', $comment)->save();
            return true;
        }
        return false;
    }

    public static function photoalbums_setAttrAlb($data) {
        $album_id = $data->id;
        $comment = $data->txt;
        $name = $data->name;
        $album = Model_Album::getById($album_id);
        if (Plussia_Dispatcher::getUserId() == $album->user_id) {
            $album->set('name', $name)->set('comment', $comment)->save();
            return true;
        }
        return false;
    }

    public static function photoalbums_setCommentPhoto($data) {
        $photo_id = $data->id;
        $comment = $data->txt;
        $photo = Model_Photo::getById($photo_id);
        $photo->addComment($comment);
        return true;
    }

    public static function photoalbums_delAlbums($data) {
        $album_id = $data->id;
        $album = new Model_Album($album_id);
        $album->rm();
        return true;
    }

    public static function photoalbums_delPhoto($data) {
        $photo_id = $data->id;
        if (is_object($photo_id)) {
            $photo_id = $photo_id->id;
        }
        $photo = new Model_Photo($photo_id);
        $photo->rm();
        return true;
    }

    public static function photoalbums_setCover($data) {
        $photo = new Model_Photo($data->id);
        $album = $photo->getAlbum();
        $cover = $album->getLink() . $album->album_id . '.jpg';

        $img = Image_GD::factory($photo->getLink());
        $data = Model_Photo::getCropVals((array) $data, $photo->getLink());
        $img->crop($data['w'], $data['h'], $data['x'], $data['y']);
        $cover = $album->getLink() . $album->album_id . '.jpg';
        $img->save($cover);
        return $cover . '?mt=' . microtime();
    }

    public static function photoalbums_setAva($data) {
        $photo = new Model_Photo($data->id);
        $img = Image_GD::factory($photo->getLink());

        $folder = 'userfiles/u' . Model_User::getUID(Plussia_Dispatcher::getUserId()) . '/photo/';
        $img->save($folder . 'main_large.jpg');
        
        $data = Model_Photo::getCropVals((array) $data, $folder . 'main_large.jpg');
        $img->crop($data['w'], $data['h'], $data['x'], $data['y']);

        $width = $img->width;
        $height = $img->height;
        $side = ($width - 200 < $height - 300) ? 'width' : 'height';
        $max = ($side == 'width') ? 200 : 300;
        if ($$side > $max) {
            $img->resize(($side == 'width') ? 200 : NULL, ($side == 'height') ? 300 : NULL);
        }
        
        $img->save($folder . 'main_medium.jpg');

        $img->resize(100, NULL);
        $img->crop(100, 100, 0, 0);
        $img->save($folder . 'main.jpg');
        return '/'.$folder . 'main_medium.jpg?mt=' . microtime();
    }

     public static function photoalbums_setMiniAva($data) {
         $folder = 'userfiles/u' . Model_User::getUID(Plussia_Dispatcher::getUserId()) . '/photo/';
         $img = Image_GD::factory($folder . 'main_medium.jpg');
         $data = (array) $data;
         $img->crop($data['w'], $data['h'], $data['x'], $data['y']);
         if($data['x'] > 100){
             $img->resize(100, NULL);
         }
         $img->save($folder . 'main.jpg');
         return true;
     }

     public static function photoalbums_changePrivilege($data) {
         $p1 = new Model_Photo($data->id1);
         $p2 = new Model_Photo($data->id2);
         $l1 = $p1->lineno;
         $l2 = $p1->lineno;
         $p1->lineno = $l2;
         $p2->lineno = $l1;
         $p1->save();
         $p2->save();
         return true;
     }

     public static function photoalbums_getSomephoto($data) {
        $sputnik = Model_User::get(Request::$current->controllerNameStore);
        $user = $sputnik ? $sputnik : Plussia_Dispatcher::getUser();
        $photos = $user->getSomePhoto();
        return $photos;
    }

}
