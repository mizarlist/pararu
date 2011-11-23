<div class="quick_search">
    <div class="p_title_1"><?php echo $text["p_title_1"]; ?><div class="pt_control up"></div></div>

    <div class="form_line">
        <div class="in_combo" id="me_country">
            <div class="easy_mask"></div>
            <input type="text" value="<?php echo $text["me_country"]; ?>" name="me_country" />
            <div class="combo_variants"></div>
        </div>
    </div><!-- .form_line-->

    <div class="form_line">
        <div class="in_combo" id="me_city">
            <div class="easy_mask"></div>
            <input type="text" value="<?php echo $text["me_city"]; ?>" name="me_city" />
            <div class="combo_variants"></div>
        </div>
    </div><!-- .form_line-->

    <div class="form_line gender_line">
        <label><?php echo $text["is_woman"][0]; ?></label>
        <div class="radio_group">
        <div class="p_checkbox active" id="find_woman"><?php echo $text["is_woman"][1]; ?></div>
        <div class="p_checkbox" id="find_man"><?php echo $text["is_woman"][2]; ?></div>
        </div>
    </div><!-- .form_line-->

    <div class="form_line age_line">
        <label style="margin-right: 14px;"><?php echo $text["age"][0]; ?></label>
        <label style="margin-right: 4px;"><?php echo $text["age"][1]; ?></label>
        <input type="text" class="text_input" value="18" id="find_from">
        <label style="margin-right: 5px; margin-left: 19px;"><?php echo $text["age"][2]; ?></label>
        <input type="text" class="text_input" value="95" id="find_to">
    </div><!-- .form_line-->

    <div class="form_line">
        <div class="p_checkbox" id="find_photo_only"><?php echo $text["photo_only"]; ?></div>
    </div>

    <div class="form_line">
        <div class="rs1_save rs1_find"><?php echo $text["find"]; ?><i></i></div>
    </div>

</div><!-- .quick_search-->