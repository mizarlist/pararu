<?php if (!$without_div) { ?>
    <div class="right_favor">
    <?php } ?>
    <div class="p_title_1"><?php echo $text['p_title_1']; ?><div class="pt_control up"></div></div>
    <?php
    foreach ($users as $user) {
        echo '<div class="one_fav_photo"><a title="' . $user['name'] . '" href="/' . $user['username'] . '"><img width="50px" height="50px" src="' . $user['photo'] . '" /></a></div>';
    }
    ?>
    <div class="clear"></div>
    <?php if (!$without_div) {
 ?>
    </div><!-- .right_favor-->
<?php } ?>