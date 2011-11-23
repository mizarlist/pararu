<div class="center_block_title"><?php echo $text["center_block_title"]; ?></div>

<div class="flap_block closed" id="sms_options_flap_1">
    <div class="p_title_1"><?php echo $text["p_title_1"]; ?></div>
    <div class="flap_block_in">
        <?php
        $alerts = $options->sms ? explode(';', $options->sms) : array();
        $active = '';
        foreach ($text["options"] as $k => $t) {
            $active = in_array($k . '', $alerts) ? ' active' : '';
            echo '<div class="option_line checkline">
            <div class="p_checkbox' . $active . '" id="option_' . $k . '">' . $t . '</div>
        </div>';
        }
        ?>

        <div class="save_block_changes"><span><?php echo $text["save_block_changes"]; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="sms_options_flap_2">
    <div class="p_title_1"><?php echo $text["p_title_2"]; ?></div>
    <div class="flap_block_in">
<?php echo $text["options2"]; ?>
        <div class="save_block_changes"><span><?php echo $text["tune"]; ?></span></div>
    </div><!-- .flap_block_in--></div><!-- .flap_block-->