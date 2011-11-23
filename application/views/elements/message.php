<div class="bl_msg">
    <div class="bl_msg_inner_<?php echo $msg['is_woman']==1 ? 'rose' : 'blue'; ?><?php echo $msg['is_out']==1 ? '' : ' f-right'; ?>" style="width:<?php echo rand(300, 500); ?>px">
        <div class="bl-tl"></div>
        <div class="bl-tr"></div>
        <div class="b-tile-<?php echo $msg['is_out']==1 ? 'left' : 'right'; ?>"></div>
        <div class="b-photo"><img width="25px" height="25px" src="<?php echo $msg['ava']; ?>" alt="" /></div>
        <div class="b-msg-padd">
            <div class="b-msg-padd-inner" style="overflow:hidden;">
                <span class="b-time f-right m10">
                    <?php if($msg['is_out']!=1) { ?>
                    <a class="b-spam" style="cursor:pointer;"><?php echo $text['spam']; ?></a> |
                    <?php } ?>
                    <a class="b-cls" iduser="<?php echo $msg['user_id']; ?>" idsputnik="<?php echo $msg['sputnik_id']; ?>" idmessage="<?php echo $msg['message_id']; ?>" style="cursor:pointer;">X</a>
                </span>
                <h2 class="h-head">
                    <a class="b-<?php echo $msg['is_woman']==1 ? 'redcol' : 'bluecol'; ?>
                       " href="<?php echo $msg['is_out']==1 ? $msg['user_link'] : $msg['sputnik_link']; ?>">
                       <?php echo $msg['is_out']==1 ? $msg['user_name'] : $msg['sputnik_name']; ?>
                    </a>
                    <?php if($msg['attribute']==1) { ?>
                        <?php if($msg['is_out']!=1) { ?>
                            <img src="/images/star16.png" alt="new!"/>
                        <?php } else {?>
                            <img src="/images/bookmark16.png" alt="not readed"/>
                        <?php } ?>
                    <?php } ?>
                </h2>
                <div class="b-time mb10"><?php echo $msg['time']; ?></div>
                <p><?php echo $msg['text']; ?></p>
            </div>
        </div>
        <div class="bl-bl"></div>
        <div class="bl-br"></div>
    </div>
    <div class="cl"></div>
</div>