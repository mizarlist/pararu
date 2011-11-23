<div class="center_block_title"><?php echo $text['center_block_title']; ?></div>
<?php if (Plussia_Dispatcher::getUser()->validateNic()) { ?>
    <div class="thr_decr"><?php echo $text['top']; ?></div>
    <div id="sub_nic_menu">
        <ul>
            <li id="nictest_psy_res" class="active"><i></i><span><?php echo $text['menu'][0]; ?></span> </li>
            <li id="nictest_nic_res"><i></i><span><?php echo $text['menu'][1]; ?></span> </li>
        </ul>
    </div>
    <div class="clear"></div>
    <div id="sub_nic_page_in">
<?php echo $centerblock; ?>
</div><!-- #sub_nic_page_in -->
<?php } else { ?>
    <div class="thr_decr"><?php echo $text['top_no']; ?></div>
<?php } ?>