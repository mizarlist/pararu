<div class="center_block_title"><?php echo $text["center_block_title"]; ?></div>

<div class="flap_block" id="commercial_options_flap">
    <div class="flap_block_in">
        <?php echo $text["text"]; ?>
    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="commercial_options_flap_1">
    <div class="p_title_1"><?php echo $text["p_title_1"]; ?></div>
    <div class="flap_block_in">
        <?php
        $alerts = $options->commercial ? explode(';', $options->commercial) : array();
        $active = '';

        echo '<div class="option_line checkline">';
        echo '<div class="p_checkbox active disabled" id="option_0">' . $text["options_1"][0] . '</div>';
        echo '</div>';

        foreach ($text["options_1"] as $k => $t) {
            if ($k == 0)
                continue;
            $active = in_array($k . '', $alerts) ? ' active' : '';
            echo '<div class="option_line checkline">
            <div class="p_checkbox' . $active . '" id="option_' . $k . '">' . $t . '</div>
        </div>';
        }
        ?>

        <div class="save_block_changes"><span><?php echo $text["save_block_changes"]; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="commercial_options_flap_2">
    <div class="p_title_1"><?php echo $text["p_title_2"]; ?></div>
    <div class="flap_block_in">
        <?php
        $alerts = $options->commercial_off ? explode(';', $options->commercial_off) : array();
        $active = '';
        foreach ($text["options_2"] as $k => $t) {
            $active = in_array($k . '', $alerts) ? ' active' : '';
            echo '<div class="option_line checkline">
            <div class="p_checkbox' . $active . '" id="option_' . $k . '">' . $t . '</div>
        </div>';
        }
        ?>
        <div class="save_block_changes"><span><?php echo $text["save_block_changes"]; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->