<div class="step_title"><?php echo $text['step_title']; ?></div>
<div class="step_micro_title"><?php echo $text['step_micro_title']; ?></div>

<div id="register_step3">

    <?php
    $first = true;
    foreach ($userData['assoc'] as $key => $values) {
        $inc = $userData['meta'][$key]['other'] == 'true' ? 1 : 0;
        $incid = $userData['meta'][$key]['other'] == 'true' ? 0 : 1;
        $active = $first ? ' active' : '';
        $minus = $first ? '-' : '+';
        $style = $first ? ' style="display: block;"' : '';

        echo '<div class="reg3_pers_block' . $active . '" id="' . $key . '">
            <div class="reg3_pers_block_name"><span>' . $minus . '</span>' . $userData['meta'][$key]['print'] . '</div>
            <div class="reg3_pers_block_in"' . $style . '>
                <div class="' . $userData['meta'][$key]['type'] . '">';

        for ($i = $inc; $i < count($values); $i++) {
            echo '<div class="p_checkbox" id="' . $key . ($i + $incid) . '">' . $values[$i] . '</div>';
        }

        if ($inc) {
            echo '<div class="p_checkbox" id="' . $key . '0">' . $values[0] . '</div>';
        }

        echo '</div><!-- .radio_group-->
            </div><!-- .reg3_pers_block_in-->
        </div><!-- .reg3_pers_block-->';

        if ($first) {
            $first = false;
        }
    }
    ?>

    <div id="register_go_next3"><?php echo $text['register_go_next3']; ?></div>

    <div style="display:none;" id="right_col_load">
        <div class="reg3_r_col">
            <div class="register_main_col_img">
                <img src="/images/temp_samples/reg_step_3_1.jpg" />
            </div><!-- .register_main_col_img-->
            <div class="register_main_col_img_txt">
                <?php echo $text['register_main_col_img_txt']; ?>
            </div>

        </div>
    </div>

</div><!-- #register_step3-->