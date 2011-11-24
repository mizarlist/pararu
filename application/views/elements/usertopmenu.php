<div class="head">
    <a href="/" class="logo"></a>

    <div class="icon_buttons">
        <div id="top_btn1" class="icon_button<?php echo ($active_index==1 ? ' active' : ''); ?>"><div class="count"><span<?php echo $values['new_users'] ? '' : ' style = "display: none;"'; ?>><i></i><?php echo $values['new_users']; ?></span></div></div>
        <div id="top_btn2" class="icon_button<?php echo ($active_index==2 ? ' active' : ''); ?>"><div class="count"><span<?php echo $values['new_interesme'] ? '' : ' style = "display: none;"'; ?>><i></i><?php echo $values['new_interesme']; ?></span></div></div>
        <div id="top_btn3" class="icon_button<?php echo ($active_index==3 ? ' active' : ''); ?>"><div class="count"><span<?php echo $values['new_masseges'] ? '' : ' style = "display: none;"'; ?>><i></i><?php echo $values['new_masseges']; ?></span></div></div>
        <div id="top_btn4" class="icon_button<?php echo ($active_index==4 ? ' active' : ''); ?>"></div>
        <div id="top_btn5" class="icon_button<?php echo ($active_index==5 ? ' active' : ''); ?>"></div>
    </div>

    <ul id="head_menu">
        <a href="<?php echo $links[0]; ?>"<?php echo ($type=='profile' ? ' class="active"' : '') ?>><?php echo $text['head_menu'][0]; ?></a>
        <a href="<?php echo $links[1]; ?>"><?php echo $text['head_menu'][1]; ?></a>
        <a href="<?php echo $links[2]; ?>"><?php echo $text['head_menu'][2]; ?></a>
        <a href="<?php echo $links[3]; ?>"<?php echo ($type=='account' ? ' class="active"' : '') ?>><?php echo $text['head_menu'][3]; ?></a>
        <a class="last" href="<?php echo $links[4]; ?>"><?php echo $text['head_menu'][4]; ?></a>
    </ul>
</div><!-- .head-->