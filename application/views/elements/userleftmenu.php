<div class="user_name">
    <?php echo $user_name; ?>
    <div id="edit_user_name"><?php echo $text['edit_user_name']; ?></div>
</div><!-- .user_name-->

<div class="user_menu">
    <div id="user_menu1" class="menu_line<?php echo ($numactive==1 ? ' active' : ''); ?>"><i class="ico"></i><span><?php echo $text['userleftmenu'][0]; ?></span>
        <div class="count_old"<?php echo $values['new_users'] ? '' : ' style = "display: none;"'; ?>><i></i><?php echo $values['new_users']; ?></div>
        <div class="count_new"<?php echo $values['new_interesme'] ? '' : ' style = "display: none;"'; ?>><i></i><?php echo $values['new_interesme']; ?></div>
    </div>
    <div id="user_menu2" class="menu_line<?php echo ($numactive==2 ? ' active' : ''); ?>"><i class="ico"></i><span><?php echo $text['userleftmenu'][1]; ?></span></div>
    <div id="user_menu3" class="menu_line<?php echo ($numactive==3 ? ' active' : ''); ?>"><i class="ico"></i><span>S.O.N.I.C.<sup>®</sup></span></div>
    <div id="user_menu4" class="menu_line<?php echo ($numactive==4 ? ' active' : ''); ?>"><i class="ico"></i><span><?php echo $text['userleftmenu'][3]; ?></span></div>
    <div id="user_menu5" class="menu_line<?php echo ($numactive==5 ? ' active' : ''); ?>"><i class="ico"></i><span><?php echo $text['userleftmenu'][4]; ?></span></div>
    <div id="user_menu6" class="menu_line<?php echo ($numactive==6 ? ' active' : ''); ?>"><i class="ico"></i><span><?php echo $text['userleftmenu'][5]; ?></span></div>
</div><!-- .user_menu-->