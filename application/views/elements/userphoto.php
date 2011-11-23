<div class="user_photo">
    <div id="user_gift_photo">

        <?php
        foreach ($gifts as $gift) {
            echo '<img src="' . $gift . '" />';
        }
        ?>

    </div>
    <div id="edit_user_photo"></div>
    <div class="user_photo_in">
        <img src="<?php echo $photo; ?>" />
    </div>
</div><!-- .user_photo-->