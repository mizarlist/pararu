<div class="one_last_profile<?php echo ($active==0 ? (($is_woman==1 ? ' she' : ' he').'_is_dell') : ($new ? (($is_woman==1 ? ' she' : ' he').'_is_new') : ''));?>" id="one_profile_user_<?php echo $one_user_id; ?>">
    <div class="photo">
        <div class="photo_in">
            <img width="100px" height="100px" src="<?php echo $photo; ?>" />
        </div>
        <div class="ribbon"></div>
    </div><!-- .photo-->
    <div class="data">
        <div class="name"><?php echo $name; ?>, <?php echo $age; ?> <?php echo $age_text; ?></div>
        <div class="state">
		<?php echo $city; ?>, <?php echo $country; ?><br/><?php
                $os=$on_site ? $on_site.'' : '0';
                echo($os=='0' ? $intervals[$os].' '.$text['be'][2] : $text['be'][$is_woman].$text['be'][2].' '.$intervals[$os]);
                ?>
        </div>
    </div><!-- .data-->
    <div class="controls">

        <?php
        $count = count($actions);
        $iter = 1;
        foreach($actions as $action){
            $last = $iter==$count ? ' last' : '';
            $rel = $action=='do_send_msg' ? 'rel="popup2rel"' : '';
            echo '<span class="'.$action.$last.'"'.$rel.'>'.$text['actions'][$action].'</span>';
            $iter++;
        }
        ?>

        <?php
        foreach($karma as $karm){
            echo '<div class="'.$karm.'"><acronym title="'.$karma_text[$karm].'"></acronym></div>';
        }
        ?>

    </div>	<!-- .controls-->
    <div class="count">
        <div class="val_count"><?php echo $ball; ?>%</div>
        <div class="do_count"><?php echo $text['do_count']; ?></div>
    </div>	<!-- .count-->
</div><!-- .one_last_profile-->