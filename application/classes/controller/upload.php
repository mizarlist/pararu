<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Upload extends Controller {

    private function getSizes($photo_width, $photo_height, $maxw, $maxh) { 
        
        if ($photo_width <= $maxw && $photo_height <= $maxh) {
            return array('width' => $photo_width, 'height' => $photo_height);
        }

        $newwidth = ($photo_width / $photo_height) * $maxh;
        $newheight = ($photo_height / $photo_width) * $maxw;

        if($newwidth > $maxw) {
            return array('width' => $maxw, 'height' => $newheight);
        }
        if($newheight > $maxw) {
            return array('width' => $newwidth, 'height' => $maxh);
        }

        $wminus = $photo_width - $maxw;
        $hminus = $photo_height - $maxh;

        if ($wminus <= 0 && $hminus <= 0) {
            $width = $photo_width;
            $height = $photo_height;
        } else if ($wminus < $hminus) {
            $width = $maxw;
            $height = ($photo_height / $photo_width) * $maxw;
        } else if ($wminus > $hminus) {
            $height = $maxh;
            $width = ($photo_width / $photo_height) * $maxh;
        }

        return array('width' => $width, 'height' => $height);
    }

    private function errorH($file_key, $type) {
        if ($file_key == 'Filedata') {
            return 'error ' . $type;
        } else {
            $texts = XML_Texts::factory('upload', '/')->getAssoc();
            return $texts[$type];
        }
    }

    public function action_index() {
        $user = Plussia_Dispatcher::getUser();
        $file_key = isset($_FILES['Filedata']) ? 'Filedata' : 'upl1';
        $is_ava = (isset($_POST['type']) && $_POST['type'] == 'ava') ? true : false;
        $album_id = (isset($_POST['id']) && $_POST['id']) ? $_POST['id'] : null;
        $pcount = !$is_ava && $album_id ? $user->photoCount($album_id) : 0;

        if (!$is_ava && (!$album_id || $pcount >= 20)) {
            echo $this->errorH($file_key, 'limit');
            return;
        }

        if ($user) {
            if (!empty($_FILES)) {
                $tempFile = $_FILES[$file_key]['tmp_name'];
                if ($_FILES[$file_key]['size'] > 2097152) {
                    echo $this->errorH($file_key, 'size');
                    return;
                }
                $folder = $user->getPhotoDir($is_ava);
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/' . $folder . '/';
                $ext = preg_replace('/(?:.*)(\.{1}[a-zA-Z]{3,4})$/', '$1', $_FILES[$file_key]['name']);
                $ext = strtolower($ext);
                if (!in_array($ext, array('.gif', '.jpg'))) {
                    echo $this->errorH($file_key, 'type');
                    return;
                }
                $ext = ($ext != '.gif') ? '.jpg' : '.gif';

                $path = str_replace('//', '/', $targetPath);
                $fname = $path . 'temp';
                $targetFile = $fname . $ext;

                move_uploaded_file($tempFile, $targetFile);

                $imsz = getimagesize($targetFile);
                $width = $imsz[0];
                $height = $imsz[1];
                $mime = $imsz['mime'];
                if (!in_array($mime, array('image/jpeg', 'image/gif'))) {
                    unlink($targetFile);
                    echo $this->errorH($file_key, 'type');
                    return;
                }

                if ($is_ava) {
                    if ($ext == '.gif') {
                        $img = imagecreatefromgif($targetFile);
                        imagejpeg($img, $fname . '.jpg', 100);
                        unlink($targetFile);
                        $ext = '.jpg';
                        $targetFile = $fname . '.jpg';
                    }
                    $name = 'main_large.jpg';
                } else {
                    $microtime = microtime();
                    list($msec, $sec) = explode(' ', $microtime);
                    $msec = substr($msec, 2);
                    $name = $sec . '_' . $msec . $ext;
                    $mininame = $path . $sec . '_' . $msec . '_min' . $ext;
                }

                $fix_name = $path . $name;
                $link_name = '/' . $folder . '/' . $name;
                $time = time();
                $img = Image_GD::factory($targetFile);
                $img->save(null, 80);
                $sizes = $this->getSizes($width, $height, 780, 440);

                $img->resize($sizes['width'], $sizes['height']);
                $width = $sizes['width'];
                $height = $sizes['height'];

                $img->save($fix_name);

                if ($is_ava) {
                    //list($width, $height) = getimagesize($fix_name);
                    $side = ($width - 200 < $height - 300) ? 'width' : 'height';
                    $max = ($side == 'width') ? 200 : 300;
                    if ($$side > $max) {
                        $img->resize(($side == 'width') ? 200 : NULL, ($side == 'height') ? 300 : NULL);
                    }
                    $img->crop(200, 300, 0, 0);
                    $img->save($path . 'main_medium.jpg');

                    $img->resize(100, NULL);
                    $img->crop(100, 100, 0, 0);
                    $img->save($path . 'main.jpg');
                } else {
                    $side = ($width < $height) ? 'width' : 'height';
                    if (($side=='width' && $$side > 200) || ($side=='height' && $$side > 170)) {
                        $img->resize(($side == 'width') ? 200 : NULL, ($side == 'height') ? 170 : NULL);
                    }
                    $img->save($mininame);
                    $width = $img->width;
                    $height = $img->height;
                    if (!$pcount) {
                        //list($width, $height) = getimagesize($fix_name);
                        $side = ($width - 200 < $height - 135) ? 'width' : 'height';
                        $max = ($side == 'width') ? 200 : 135;
                        if ($$side > $max) {
                            $img->resize(($side == 'width') ? 200 : NULL, ($side == 'height') ? 135 : NULL);
                        }
                        $img->crop(200, 135, 0, 0);
                        $img->save($path . $album_id . '.jpg');
                    }
                    $p = Model_Photo::addPhoto($user->user_id, $album_id, $name);
                }

                unlink($targetFile);
                $arr = $p->getArrayPhoto();
                $view = null;
                if ($file_key != 'Filedata') {
                    $view = View::factory('photoanswer');
                    $view->photo = $arr;
                }
                echo (($file_key == 'Filedata') ? json_encode($arr) : $view->render());
            }
        }
    }

}