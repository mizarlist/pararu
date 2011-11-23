<div id="albums">
    <div style="padding-top:5px;margin-left:-10px;margin-top:5px;width:550px;height:18px;background-image:url('resource/blue_line.png');">
        <div style="margin-left:10px;float:left;font-family:Arial;font-size:12px;color:#0082BE;font-weight:normal;"><?php echo $text['photocomment']; ?></div>
        <div style="margin-top:0px;margin-left:10px;float:right;font-family:Arial;font-size:10px;color:#666666;font-weight:normal;margin-right:1px;"><?php echo $text['photosubcomment']; ?></div>
    </div>

    <div  style="overflow:hidden;width:540px;height:300px;margin-top:30px;">
        <div id="prev_photo" style="cursor:pointer;float:left;width:20px;height:300px;background-image:url('resource/strelka_left.png');background-position:left center;background-repeat:no-repeat;"></div>
        <div id="cont_photo" style="overflow:hidden;margin-left:10px;margin-right:10px;float:left;width:480px;height:300px;"></div>
        <div id="next_photo" style="cursor:pointer;margin-left:0px;float:left;width:20px;height:300px;background-image:url('resource/strelka_right.png');background-position:left center;background-repeat:no-repeat;"></div>
    </div>
</div>

<img src="resource/noalbom.png" id="noalbom" style="cursor:pointer;display:none;margin-top:60px;margin-left:60px;"/>
<div class="reveal-modal-bg" style="display: none; "></div>
<div id="myModal"  align="center" class="reveal-modal" style="width:auto;padding:0px;background:white;margin-left:-410px;">

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

<div id="myModalError"  align="center" class="reveal-modal" style="margin-left:-185px;width:370px;padding:0px;background:white;">

    <a class="label_dialog2"  >Внимание!</a>
    <div class="shapka_modal" style="height:40px;"></div>
    <div style="height:1px;background: #808080;"></div>
    <div id="myModalError_text" style="margin-top:20px;margin-left: 20px; margin-right: 20px; font-family: Arial;font-size: 12px;line-height:145%;">Ошибка</div>
    <div style="margin-bottom:30px;margin-top:20px;width:48px;height:48px;background-image: url('/images/bug_48.png')"></div>
    <a id="close_error_modal" class="close-reveal-modal" style="font-weight:normal;font-family: Arial;font-size: 12px;top:-1px;line-height:145%;">закрыть <font style="font-size: 24px;position:relative;top:4px;left:1px;font-weight:bold;">&#215;</font></a>

</div>