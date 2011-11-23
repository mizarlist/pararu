<div class="b-block" link="<?php echo $msg['msg_link']; ?>">
    <div class="i-block<?php echo $msg['count']!=0 ? ' b-blue-back' : ''; ?>">
        <div class="b-block-left">
            <span class="b-frame"><a href="<?php echo $msg['sputnik_link']; ?>"><img width="100px" height="100px" src="<?php echo $msg['ava']; ?>" alt="" /></a></span>
        </div>
        <div class="b-block-right">
            <span class="b-time f-right"><?php echo $msg['time']; ?></span>
            <div class="b-head">
                <h2 class="h-head"><a class="b-<?php echo $msg['sputnik_is_woman']==1 ? 'redcol' : 'bluecol'; ?>" href="<?php echo $msg['sputnik_link']; ?>"><?php echo $msg['sputnik_name']; ?></a></h2>
                <?php if($msg['count']!=0) {?>
                <span class="b-head-mess b-bluecol">(<?php echo $msg['count']; ?> <?php echo $msg['count_text']; ?>)</span>
                <?php } ?>
            </div>
            <div class="b-msg <?php echo $msg['is_out']==1 ? ' no-tile' : ''; ?>">
                <a href="<?php echo $msg['msg_link']; ?>">
                    <span class="b-msg-inner">
                        <p><span class="i-title b-<?php echo $msg['msg_is_woman']==1 ? 'redcol' : 'bluecol'; ?>">
                        <?php echo $msg['is_out']==1 ? $msg['user_name'] : $msg['sputnik_name']; ?>:
                            </span> <?php echo $msg['text']; ?>
                        </p>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="b-band"></div>