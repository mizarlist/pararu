<head>
    <script type="text/javascript" src="http://pararubversia.ru/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="css/photoalbums.css" media="screen" />
</head>


<div id_ph="<?php echo $photo['id']; ?>" style="margin-top: 20px; margin-left:-27px; overflow-x: hidden; overflow-y: hidden; height: 90px; ">
    <div align="center" style="float: left; width: 115px;  margin-left: 11.5px; ">
        <img src="<?php echo $photo['img']; ?>" class="image_change_win" style="max-width:75px;max-height:75px ">
    </div>
    <div id="label1" style="margin-left:100px;color:#0082BE;font-family:Arial;font-weight:bold;font-size:14px;">Описание</div>
    <div class="valid_input" style="margin-right: 60px;"></div>
    <div style="margin-bottom:10px;margin-left:120px;margin-top:5px;">
        <textarea class="coment_input" onkeyup="parent.myphoto.fr_valid_comment(window)" onblur="parent.myphoto.fr_auto_save(window, <?php echo $photo['id']; ?>)" onfocus="parent.myphoto.fr_focus_input(window)" maxlength="200" name="comment" cols="40" style="width:325px;height:45px;background-color:white;border:1px solid #BCCFDF;font-size:12px;color:#666666;font-family:Arial;padding:5px;"></textarea></div>
    <div onclick="parent.myphoto.fr_del_photo(<?php echo $photo['id']; ?>, document)" style="cursor: pointer; margin-top: -40px; margin-left: 463px;text-decoration:underline; color: rgb(51, 102, 204); font-size: 12px;font-family:arial; ">Удалить</div>
    <a></a>
</div>

<script>window.img=<?php echo str_replace('\\', '', json_encode($photo)); ?></script>
