<div class="del_history">
    <a style="cursor:pointer;" rel="popuprel" class="popup"><?php echo $text['dell_all']; ?></a>
</div>
<div class="your_mes"><?php echo $text['your_mes']; ?></div>
<div class="form_mes">
    <span class="b-time f-right m10"><?php echo $text['ostalos']; ?> <span class="num">100</span> <?php echo $text['simvolov']; ?></span>
    <form action="#" method=post>
        <textarea class="txtarea" name="message" wrap="virtual" cols="65" rows="3"></textarea><br>
    </form>
</div>
<div id="step_to" class="step"><a style="cursor: pointer;"><?php echo $text['step']; ?></a></div>
<div class="btn_send"><?php echo $text['send']; ?></div>
<div class="cl"></div>


<div id="b-msg-list">

    <div class="bl_msg">
    </div>

    <?php echo $messages; ?>
</div>