<img src="resource/noalbom.png" id="noalbom" style="cursor:pointer;display:none;margin-top:60px;margin-left:60px;"/>
<div class="reveal-modal-bg" style="display: none; "></div>
<div id="myModal"  align="center" class="reveal-modal" style="width:auto;padding:0px;background:white;margin-left:-410px;">

    <a  id="jcrop_albums" style="position: absolute;left:20px;top:14px;" >сделать обложкой альбома
    </a>
    <div  id="jcrop_albums2" style="display:none;position: absolute;left:20px;top:14px;" ><font style="text-decoration: underline">сделать обложкой альбома</font>
        <div class="alert_no_crop" ><div>Размер этой фотографии слишком мал.</div></div></div>
    <div style="width:4px;height:4px;position: absolute;left:187px;top:20px;background-image: url('resource/dot.png')"></div>
    <a  id="jcrop_ava"  style="position: absolute;left:198px;top:14px;">сделать аватаром</a>
    <div  id="jcrop_ava2"  style="display:none;position: absolute;left:198px;top:14px;"><font style="text-decoration: underline">сделать аватаром</font>
        <div class="alert_no_crop" ><div>Размер этой фотографии слишком мал.</div></div></div>

    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <div id="image_modal" style="padding: 30px;min-width:605px;max-width: 840px;height:500px;"><img id="im" style="max-width:810px;max-height:500px;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;cursor:pointer;" src="" alt="Фотография загружается" /></div>
    <div id="prev_foto_modal"  style="z-index:10;cursor:pointer;z-index:500;position:absolute;float:left;width:20px;height:600px;left:-40px;top:35px;background-image:url('resource/strelka_left_w.png');background-position:center center;background-repeat:no-repeat;"></div>
    <div id="next_foto_modal" style="position:absolute;right:-40px;width:20px;height:600px;top:35px;cursor:pointer;background-image:url('resource/strelka_right_w.png');background-position:center center;background-repeat:no-repeat;"></div>
    <div id="prev_foto_modal2" style="z-index:20;cursor:pointer;position: absolute;left:0px;width:0px;height:200%"></div>
    <div id="next_foto_modal2" style="cursor:pointer;position: absolute;right:0px;width:0px;height:200%"></div>
    <div id="comment_users" ></div>
    <div  style="height:1px;background: #808080  "></div>
    <div class="img_text_cont" ><div id="txt_image" >

        </div>
    </div>
    <a id="exit1" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>


<div id="myModal2"   align="center" class="reveal-modal" style="margin-left:-200px;width:400px;padding:0px;background:white;">
    <a class="label_dialog2"  >Загрузка фотографий с вашего компьютера</a>
    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>


    <div style="margin-left:30px;margin-top:30px;marggin-right:30px;">
        <ul style="margin-top:25px;margin-left:15px;">
            <li>
                Поддерживаемые форматы файлов: JPG, GIF
            </li>
            <li>
                Вы можете загружать до 20 фотографий за 1 раз
            </li>
            <li>
                Максимальный объем фотоальбома 20 фотографий
            </li>
            <li>
                Максимальный размер фотографии: 2 Mb
            </li>
        </ul>
    </div>
    <div class="button_load"><input type="file" name="uploadify" id="button_load" />
        <div id="alt_forms" style="display:none;">
            <iframe src="/frame" width="300px"  align="center">
                Ваш браузер не поддерживает плавающие фреймы!
            </iframe>

        </div>
    </div>
    <div class="txt2" style="line-height: 145%;">


        <font style="font-weight:bold;">Подсказка:</font> для того, чтобы выбрать сразу несколько фотографий, удерживайте клавишу Ctrl при выборе файлов в ОС Windows или клавишу Cmd в Mac OS.
    </div>
    <div class="razdelitel" style="margin-top:5px;margin-bottom:5px;">
    </div>
    <div class="txt3" style="margin-bottom:15px;line-height: 145%;">
        Вы используете Flash-загрузчик. Если у Вас возникли какие-либо проблемы с загрузкой фотографий попробуйте <a id="altern_down" class="altern_down" style="color: blue; text-decoration: underline; cursor: pointer;">загрузчик браузера</a>.
    </div>

    <a  id="close_window_load_img" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>
</div>



<div id="myModal3"  align="center" class="reveal-modal" style="width:auto;padding:0px;background:white;">

    <a class="label_dialog" style="position: absolute;left:20px;" >Редактирование уменшенной копии</a>


    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <div >
        <div style="margin-right:230px;padding:30px;min-height: 375px;">
            <img id="im_ava1" style="max-width:560px;max-height:370px;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;cursor:pointer;" src=""  />
        </div>
    </div>
    <div style="width:200px;height:300px;overflow:hidden;position:absolute;right:30px;top:70px;">
        <img src="" id="preview" alt="Preview" />
    </div>

    <div  style="height:1px;background: #808080  "></div>
    <div class="img_text_cont" style="height:45px;" >
        <div id="save_ava" style="cursor:pointer;position: absolute;background: #00AFF0;right:130px;padding-top:8px;bottom: 15px;width:97px;height:22px;font-family: Arial;font-size: 12px;color:white;">Сохранить</div>
        <div  id="close_btn_ava" style="cursor:pointer;position: absolute;background: #8C8C8C;font-family:Arial;font-size:12px;color:white;right:20px;bottom: 15px;width:93px;height:22px;padding-top:8px;">Отменить</div>
    </div>

    <div align="left" class="pametka" style="top:375px">
        <div class="pametka_zag" >Ваш аватар</div>
        <div class="pametka_razd"></div>
        <div class="pametka_txt" >
            Выберете область которая будет отображаться на сайте.
        </div>
    </div>

    <a id="exit2" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>


<div id="myModal4"  align="center" class="reveal-modal" style="width:auto;padding:0px;background:white;">

    <a class="label_dialog" style="position: absolute;left:20px;" >Редактирование уменшенной копии</a>


    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <div >
        <div style="margin-right:230px;padding:30px;min-height:246px;">
            <img id="im_alboms" style="max-width:560px;max-height:370px;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;cursor:pointer;" src=""  />
        </div>
    </div>
    <div style="width:200px;height:135px;overflow:hidden;position:absolute;right:30px;top:70px;">
        <img src="" id="preview_alb" alt="Preview" style="max-width:560px;max-height:370px;" />
    </div>

    <div  style="height:1px;background: #808080  "></div>
    <div class="img_text_cont" style="height:45px;" >
        <div id="save_btn_album" style="cursor:pointer;position: absolute;background: #00AFF0;right:130px;padding-top:8px;bottom: 15px;width:97px;height:22px;font-family: Arial;font-size: 12px;color:white;">Сохранить</div>
        <div id="close_btn_alb" style="cursor:pointer;position: absolute;background: #8C8C8C;font-family:Arial;font-size:12px;color:white;right:20px;bottom: 15px;width:93px;height:22px;padding-top:8px;">Отменить</div>
    </div>

    <div align="left" class="pametka">
        <div class="pametka_zag" >Миниатюра фотографии</div>
        <div class="pametka_razd"></div>
        <div class="pametka_txt" >
            Выберите область на основной фотографии, которая будет отображаться в миниатюре обложки альбома на сайте.
        </div>
    </div>
    <a id ="close_alb" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>

<div id="myModal5"  align="center" class="reveal-modal" style="margin-left:-100px;width:auto;padding:0px;background:white;">

    <a class="label_dialog" style="position: absolute;left:20px;" >Редактирование уменшенной копии</a>


    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <div >
        <div style="margin-right:230px;padding:30px;">
            <img id="im_ava2" style="max-width:560px;max-height:370px;margin-left:auto;margin-right:auto;margin-top:auto;margin-bottom:auto;cursor:pointer;" src=""  />
        </div>
    </div>
    <div style="width:100px;height:100px;overflow:hidden;position:absolute;right:130px;top:70px;">
        <img src="" id="preview_ava1" alt="Preview" />
    </div>
    <div style="width:50px;height:50px;overflow:hidden;position:absolute;right:64px;top:120px;">
        <img src="" id="preview_ava2" alt="Preview" />
    </div>
    <div style="width:30px;height:30px;overflow:hidden;position:absolute;right:20px;top:140px;">
        <img src="" id="preview_ava3" alt="Preview" />
    </div>

    <div  style="height:1px;background: #808080  "></div>
    <div class="img_text_cont" style="height:45px;" >
        <div id="save_btn_mini_ava" style="cursor:pointer;position: absolute;background: #00AFF0;right:130px;padding-top:8px;bottom: 15px;width:97px;height:22px;font-family: Arial;font-size: 12px;color:white;">Сохранить</div>
        <div id="btn_close_mini_ava" style="cursor:pointer;position: absolute;background: #8C8C8C;font-family:Arial;font-size:12px;color:white;right:20px;bottom: 15px;width:93px;height:22px;padding-top:8px;">Отменить</div>
    </div>


    <div align="left" class="pametka" style="top:185px;">
        <div class="pametka_zag" >Миниатюра фотографии</div>
        <div class="pametka_razd"></div>
        <div class="pametka_txt" >
            Выберите область на основной фотографии, которая будет отображаться в миниатюре на сайте.
        </div>
    </div>

    <a id="close_miniava" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>


<div id="myModal6"  align="center" class="reveal-modal" style="margin-left:-185px;width:370px;padding:0px;background:white;">

    <a class="label_dialog2"  >Загрузка фотографий с вашего компьютера</a>


    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <div style="margin-top:20px;font-family: Arial;font-size: 12px;line-height:145%;">Подождите пока изображения загрузяться полностью. <font id="count_load_label2">Загружено</font> <font id="count_load">0</font><font id="count_load_label"> фотографий.</font></div>
    <div style="margin-bottom:30px;margin-top:20px;width:48px;height:48px;background-image: url('/images/ajax.gif')"></div>

    <a id="close_load_image" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;"></a>

</div>

<div id="myModal7"  align="center" class="reveal-modal" style="margin-left:-185px;width:370px;padding:0px;background:white;">
    <a class="label_dialog2"  >Удаление альбома</a>


    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <div id="alb_del_ram" style="margin-top:13px;width:246px;height:181px;background-image: url('resource/frame_alb1.png')">
        <img src="" id="alb_del_img" alt="Preview" style="width:200px;height:135px;margin-top:23px;margin-bottom: 13px;margin-left:1px;" />
    </div>
    <div style="font-family: Arial;font-size: 12px;color:#666666;margin-top:13px;">Вы уверены, что хотите удалить альбом:</div>


    <div id="name_del"style="margin-top:10px;font-family: Arial;font-size: 14px;color:#0082BE;font-weight: bold;"></div>

    <div style="margin-top:10px;font-family: Arial;font-size: 12px;color:#666666">со всеми <font id="kol_photo"></font> фотографиями в нем?</div>
    <div style="width:210px; height:30px;margin-top:30px;margin-bottom:35px;">
        <div id="del_btn_mod"  >Удалить</div>
        <div id="cancel_del" >Отмена</div>
    </div>
    <a id="close_del_alb" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>

<div  id="myModal9"   align="center" class="reveal-modal" style="height:595px;margin-left:-250px;width:550px;padding:0px;background:white;">
    <a class="label_dialog2"  >Загрузка фотографий с вашего компьютера</a>
    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>

    <iframe scrolling="no" align="center" id="frame1" name="frame1" src="/frame" width="500px" height="120px" align="center">
        Ваш браузер не поддерживает плавающие фреймы!
    </iframe>
    <div style="margin-left:0px;width:490px;height:1px;background-image:url('resource/blue_line.png');"></div>
    <iframe scrolling="no" align="center" id="frame2" hspace="0px" name="frame2" src="/frame" width="500px" height="120px"  align="center">
        Ваш браузер не поддерживает плавающие фреймы!
    </iframe>
    <div style="margin-left:0px;width:490px;height:1px;background-image:url('resource/blue_line.png');"></div>
    <iframe scrolling="no"  align="center" id="frame3" name="frame3" src="/frame" width="500px" height="120px"  align="center">
        Ваш браузер не поддерживает плавающие фреймы!
    </iframe>
    <div style="margin-left:0px;width:490px;height:1px;background-image:url('resource/blue_line.png');"></div>
    <iframe scrolling="no"  align="center" id="frame4" name="frame4" src="/frame" width="500px" height="120px"  align="center">
        Ваш браузер не поддерживает плавающие фреймы!
    </iframe>

    <div style="margin-left:0px;margin-top:0px;width:490px;height:1px;background-image:url('resource/blue_line.png');"></div>

    <div class="razdelitel" style="margin-top:5px;margin-bottom:10px;">
    </div>
    <div class="txt3" style="margin-bottom:15px;">
        Вы используете загрузчик браузера.<br>Попробуйте <a href="#" id="alter_down2" class="altern_down">Flash-загрузчик</a>.
    </div>
    <div id='modal9_save' >
        Сохранить и вернуться к фотоальбому
    </div>

    <a  id="close_window_load_img_st" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>
</div>


<div id="myModal10"   align="center" class="reveal-modal" style="height:350px;margin-left:-330px;width:660px;padding:0px;background:white;">
    <a class="label_dialog2"  >Выбор фотографии из галереи</a>
    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>


    <div  style="width:600px;height:200px;overflow: hidden;margin-top:30px;">
        <div id="cont_cover" style="position:relative;left:0px;height:200px;width:10000px;"></div>
    </div>
    <div id="cancel_cover" style="cursor:pointer;width:115px;height:22px;background: #8C8C8C;color:white;margin-top:30px;font-family: Arial;font-size: 12px;padding-top: 8px;">Закрыть окно</div>


    <div id="prev_cover_modal"  style="z-index:10;cursor:pointer;z-index:500;position:absolute;float:left;width:20px;height:300px;left:-40px;top:35px;background-image:url('resource/strelka_left_w.png');background-position:center center;background-repeat:no-repeat;"></div>
    <div id="next_cover_modal" style="position:absolute;right:-40px;width:20px;height:300px;top:35px;cursor:pointer;background-image:url('resource/strelka_right_w.png');background-position:center center;background-repeat:no-repeat;"></div>
    <div id="prev_cover_modal2" style="z-index:20;cursor:pointer;position: absolute;left:0px;width:0px;height:200%"></div>
    <div id="next_cover_modal2" style="cursor:pointer;position: absolute;right:0px;width:0px;height:200%"></div>



    <a  id="close_window_create_cover" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>
</div>

<div id="myModalError"  align="center" class="reveal-modal" style="margin-left:-185px;width:370px;padding:0px;background:white;">

    <a class="label_dialog2"  >Внимание!</a>
    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>
    <div id="myModalError_text" style="margin-top:20px;margin-left: 20px; margin-right: 20px; font-family: Arial;font-size: 12px;line-height:145%;">Ошибка</div>
    <div style="margin-bottom:30px;margin-top:20px;width:48px;height:48px;background-image: url('/images/bug_48.png')"></div>
    <a id="close_error_modal" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>

<div id="albums"  >
    <div class="center_block_title">Ваши фотоальбомы</div>
    <div id="new_albums" style="float:right;font-family: Arial;font-size: 12px;text-decoration: underline;color:#36C;margin-top: -48px;cursor: pointer;">Создать новый альбом</div>

    <div  style="width:540px;height:170px;">

        <div id="prev_albums" ></div>
        <div id="cont_albums" style="width:473px;height:170px;overflow:hidden;float:left;">
            <div id="albums_lenta" style="height:170px;width:10000px;">

            </div>
        </div>
        <div id="next_albums" ></div>
    </div>



    <div style="padding-top:5px;margin-left:-10px;margin-top:46px;width:550px;height:18px;background-image:url('resource/blue_line.png');">
        <div style="margin-left:10px;float:left;font-family:Arial;font-size:12px;color:#0082BE;font-weight:normal;">Некоторые из ваших фотографий</div>
        <div style="margin-top:0px;margin-left:10px;float:right;font-family:Arial;font-size:10px;color:#666666;font-weight:normal;margin-right:1px;">нажмите на фотографию, чтобы увеличить</div>

    </div>

    <div  style="overflow:hidden;width:540px;height:300px;margin-top:30px;">
        <div id="prev_photo" style="cursor:pointer;float:left;width:20px;height:300px;background-image:url('resource/strelka_left.png');background-position:left center;background-repeat:no-repeat;"></div>


        <div id="cont_photo" style="overflow:hidden;margin-left:10px;margin-right:10px;float:left;width:480px;height:300px;">

        </div>

        <div id="next_photo" style="cursor:pointer;margin-left:0px;float:left;width:20px;height:300px;background-image:url('resource/strelka_right.png');background-position:left center;background-repeat:no-repeat;"></div>
    </div>
</div>


<div id="albums_change" style="display:none">
    <div class="center_block_title">Редактирование альбома</div>

    <div  style="width:270px;height:10px;float:left;">

        <img id="albums_foto_changeten" src="resource/frame_alb1.png" style="position:relative;top:-18px;left:9px;"/>
        <img id="albums_foto_change" src="" style="position:relative;width:200px;height:135px;top:-175px;left:33px;"/>
    </div>

    <div style="width:240px;height:135px;margin-left: 270px;position: relative;">
        <div id="name_alb_edit"  style="text-align: left;color:#0082BE;text-family:Arial;font-weight:bold;font-size:14px;">Название</div>
        <div id="val_name_alb_edit"></div>
        <div style="margin-top:5px;"><input onkeyup="myphoto.valid_name(this)" onBlur="myphoto.auto_save_name()"  onFocus="myphoto.focus_input_name(this)" id="name_albums_change" maxlength="27h"  name="name_albums" type="text" style="width:240px;height:15px;background-color:white;border:1px solid #BCCFDF;font-size:12px;padding-left:5px;padding-right:5px;color:#666666;font-family:Arial;"></div>
        <div id="description_alb_edit" style="margin-top:20px;text-align: left;color:#0082BE;text-family:Arial;font-weight:bold;font-size:14px;">Описание альбома</div>
        <div id="val_description_alb_edit"></div>
        <div style="margin-top:5px;"><textarea onkeyup="myphoto.valid_description(this)" onBlur="myphoto.auto_save_description()"  onFocus="myphoto.focus_input_decription(this)" maxlength="100" id="com_albums" name="comment" cols="40" style="width:240px;height:45px;background-color:white;border:1px solid #BCCFDF;font-size:12px;color:#666666;font-family:Arial;padding:5px;"></textarea></div>
    </div>
    <div  style="position:relative;top:23px;left:78px;"><a id="change_cover"  style="text-decoration:underline;cursor:pointer;font-family:Arial;font-size:12px;color:#3366CC;">Изменить обложку</a></div>
    <div style="position:relative;top:11px;left:270px;width:250px;height:32px; color:#3366CC;">
        <div id="add_photo_p2" style="float:left;margin-right:14px;text-decoration: underline">Добавить фотографии</div>|

        <div id="btn_del_alb" style="float:right;text-decoration: underline">Удалить альбом</div>
    </div>




    <div style="margin-left:-10px;margin-top:37px;width:550px;height:1px;background-image:url('resource/blue_line.png');">
        <div id="back_albums" style="cursor:pointer;margin-left:10px;float:left;margin-top:-15px;font-family:Arial;font-size:12px;color:#3366CC;font-weight:normal;">вернуться к альбомам</div>


    </div>

    <div  id="cont_foto_change" style="width:550px;margin-top:10px;">

    </div>
    <div id="back_albums2" style="cursor:pointer;margin-left:0px;float:left;margin-top:10px;font-family:Arial;font-size:12px;color:#3366CC;font-weight:normal;">вернуться к альбомам</div>


    <!-- --------------------------------------------------------------------------------->
    <!-- .flap_block_in--></div><!-- .flap_block-->
