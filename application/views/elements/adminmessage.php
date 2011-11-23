<div class="bl_msg">
    <div class="bl_msg_inner_blue">
        <div class="bl-tl"></div>
        <div class="bl-tr"></div>
        <div class="b-msg-padd">
            <div class="b-msg-padd-inner">
                <span class="b-time f-right m10">
                    <a  class="b-cls" idmessage="<?php echo $msg['message_id']; ?>" style="cursor:pointer">X</a>
                </span>
                <h2 class="h-head">
                    <div class="b-bluecol" style="float:left; margin-right: 5px;"><?php echo $text['admin']; ?></div>
                    <?php if($msg['attribute']==1) { ?>
                            <img src="/images/star16.png" alt="new!"/>
                    <?php } ?>
                </h2>
                <div class="b-time mb10"><?php echo date(Plussia_Help::$formatRuDT, $msg['dt_send']); ?></div>
                <p><?php echo $msg['text']; ?></p>
            </div>
        </div>
        <div class="bl-bl"></div>
        <div class="bl-br"></div>
    </div>
    <div class="cl"></div>
</div>