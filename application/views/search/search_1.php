<div class="thr_title"><?php echo $text["thr_title"]; ?></div>

<div class="one_line">
    <div class="line_name inline"><?php echo $text["isearch"]; ?></div>
    <div class="line_in inline">
        <div class="p_checkbox<?php echo ($findWoman ? ' active' : ''); ?>" id="find_woman"><?php echo $text["w"]; ?></div>
        <div class="p_checkbox<?php echo ($findWoman ? '' : ' active'); ?>" id="find_man"><?php echo $text["m"]; ?></div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["country"]; ?></div>
    <div class="line_in inline">
        <div class="in_combo" id="find_country">
            <div class="easy_mask"></div>
            <input type="text" value="<?php echo $text["any_country"]; ?>" name="find_country" />
            <div class="combo_variants"></div>
        </div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["region"]; ?></div>
    <div class="line_in inline">
        <div class="in_combo" id="find_area">
            <div class="easy_mask"></div>
            <input type="text" value="<?php echo $text["any_region"]; ?>" name="find_area" />
            <div class="combo_variants"></div>
        </div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["city"]; ?></div>
    <div class="line_in inline">
        <div class="in_combo" id="find_city">
            <div class="easy_mask"></div>
            <input type="text" value="<?php echo $text["any_city"]; ?>" name="find_city" />
            <div class="combo_variants"></div>
        </div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div class="line_name inline"><?php echo $text["age"]; ?></div>
    <div class="line_in inline">
	<?php echo $text["from"]; ?> <input type="text" class="just_text" name="find_age_from" value="18" />
	<?php echo $text["to"]; ?> <input type="text" class="just_text" name="find_age_to" value="90" />
        <div class="p_checkbox active" id="find_photo"><?php echo $text["with_photo"]; ?></div>
        <div class="p_checkbox" id="find_online"><?php echo $text["online"]; ?></div>
    </div>
</div><!-- .one_line-->

<div class="one_line">
    <div id="start_search" class="rs1_save rs1_find"><?php echo $text["find"]; ?><i></i></div>
</div><!-- .one_line-->

<div id="search_results"></div>