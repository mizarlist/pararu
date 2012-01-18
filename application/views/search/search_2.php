<div class="thr_title"><?php echo $text["thr_title"]; ?></div>

<div id="search_form">
<div class="one_line">
    <div class="line_name inline"><?php echo $text["isearch"]; ?></div>
    <div class="line_in radio_group inline">
        <div class="p_checkbox<?php echo ($findWoman ? ' active' : ''); ?>" id="find_woman"><?php echo $text["w"]; ?></div>
        <div class="p_checkbox<?php echo ($findWoman ? '' : ' active'); ?>" id="find_man"><?php echo $text["m"]; ?></div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["country"]; ?></div>
    <div class="line_in inline">
        <div class="in_combo" id="find_country">
            <div class="easy_mask"></div>
            <input class="send_name" type="text" value="<?php echo $text["any_country"]; ?>" name="find_country" />
            <input class="send_id" type="hidden" value="0" name="find_country_id" />
            <div class="combo_variants"></div>
        </div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["region"]; ?></div>
    <div class="line_in inline">

        <div class="in_combo" id="find_area">
            <div class="easy_mask"></div>
            <input class="send_name" type="text" value="<?php echo $text['any_region']; ?>" name="find_area" />
            <input class="send_id" type="hidden" value="0" name="find_area_id" />
            <div class="combo_variants"></div>
        </div>

    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["city"]; ?></div>
    <div class="line_in inline">

        <div class="in_combo" id="find_city">
            <div class="easy_mask"></div>
            <input class="send_name" type="text" value="<?php echo $text['any_city']; ?>" name="find_city" />
            <input class="send_id" type="hidden" value="0" name="find_city_id" />
            <div class="combo_variants"></div>
        </div>

    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["age"]; ?></div>
    <div class="line_in inline">
	<?php echo $text["from"]; ?> <input type="text" class="just_text" name="find_age_from" value="<?php echo ($sputnikData->age_min ? $sputnikData->age_min : 18); ?>" />
	<?php echo $text["to"]; ?> <input type="text" class="just_text" name="find_age_to" value="<?php echo ($sputnikData->age_max ? $sputnikData->age_max : 90); ?>" />
        <div class="p_checkbox active" id="find_photo"><?php echo $text["with_photo"]; ?></div>
        <div class="p_checkbox" id="find_online"><?php echo $text["online"]; ?></div>
    </div>
</div><!-- .one_line-->

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

<div class="one_line">
    <div id="start_search" class="rs1_save rs1_find"><?php echo $text["find"]; ?><i></i></div>
</div><!-- .one_line-->

</div>

<div id="search_results"></div>