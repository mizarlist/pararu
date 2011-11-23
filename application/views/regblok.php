<script type="text/javascript">

    $.extend($.validator.messages, {
        password : { minlength : "<?php echo $text['js']['password']; ?>" },
        password_confirm : { equalTo : "<?php echo $text['js']['password_confirm']; ?>" },
        required: "<?php echo $text['js']['required']; ?>",
        i_agree: {required : "<?php echo $text['js']['i_agree']; ?>"},
        remote: "<?php echo $text['js']['remote']; ?>",
        email: "<?php echo $text['js']['email']; ?>",
        url: "<?php echo $text['js']['url']; ?>",
        date: "<?php echo $text['js']['date']; ?>",
        dateISO: "<?php echo $text['js']['dateISO']; ?>",
        number: "<?php echo $text['js']['number']; ?>",
        digits: "<?php echo $text['js']['digits']; ?>",
        creditcard: "<?php echo $text['js']['creditcard']; ?>",
        equalTo: "<?php echo $text['js']['equalTo']; ?>",
        accept: "<?php echo $text['js']['accept']; ?>",
        maxlength: $.format("<?php echo $text['js']['maxlength']; ?>"),
        minlength: $.format("<?php echo $text['js']['minlength']; ?>"),
        rangelength: $.format("<?php echo $text['js']['rangelength']; ?>"),
        range: $.format("<?php echo $text['js']['range']; ?>"),
        max: $.format("<?php echo $text['js']['max']; ?>"),
        min: $.format("<?php echo $text['js']['min']; ?>")
    });



</script>


<div style="display:none;">
    <div id="index_reg_form">
        <div class="close_irf"></div>
        <form method="post" action="">
            <input type="hidden" name="post_functional" value="registration" />
            <div class="form_line">
                <div class="first_hide"><input tabindex="0" type="text" /></div>
                <label><?php echo $text['index_reg_form'][0]; ?></label>
                <div class="in_combo" id="me_gender">
                    <div class="easy_mask"></div>
                    <input type="text" readonly="readonly" value="<?php echo $broad['me_gender'][0]; ?>" name="me_gender" />
                    <div class="combo_variants">
                        <div class="one_combo hover" id="me_gender_0"><?php echo $broad['me_gender'][0]; ?></div>
                        <div class="one_combo" id="me_gender_1"><?php echo $broad['me_gender'][1]; ?></div>
                    </div>
                </div><!-- #me_gender-->
                <span class="label"><?php echo $text['index_reg_form'][1]; ?></span>
                <div class="in_combo" id="find_gender">
                    <div class="easy_mask"></div>
                    <input type="text" readonly="readonly" value="<?php echo $broad['sputnik_gender'][1]; ?>" name="find_gender" />
                    <div class="combo_variants">
                        <div class="one_combo hover" id="find_gender_0"><?php echo $broad['sputnik_gender'][1]; ?></div>
                        <div class="one_combo" id="find_gender_1"><?php echo $broad['sputnik_gender'][0]; ?></div>
                    </div>
                </div><!-- #find_gender-->
            </div><!-- .form_line-->

            <div class="form_line">
                <label><?php echo $text['index_reg_form'][2]; ?></label>
                <input type="text" class="pluss_textin" name="me_name" id="me_name" />
            </div>

            <div class="form_line">
                <label><?php echo $text['index_reg_form'][3]; ?></label>
                <input type="text" class="pluss_textin" maxlength="2" name="birth_date" id="birth_date" value="1" />
                <div class="in_combo" id="birth_month">
                    <div class="easy_mask"></div>
                    <input type="text" readonly="readonly" value="<?php echo $broad['months'][1]; ?>" name="birth_month" />
                    <div class="combo_variants">
                        <div class="one_combo hover" id="birth_month_0"><?php echo $broad['months'][1]; ?></div>
                        <div class="one_combo" id="birth_month_1"><?php echo $broad['months'][2]; ?></div>
                        <div class="one_combo" id="birth_month_2"><?php echo $broad['months'][3]; ?></div>
                        <div class="one_combo" id="birth_month_3"><?php echo $broad['months'][4]; ?></div>
                        <div class="one_combo" id="birth_month_4"><?php echo $broad['months'][5]; ?></div>
                        <div class="one_combo" id="birth_month_5"><?php echo $broad['months'][6]; ?></div>
                        <div class="one_combo" id="birth_month_6"><?php echo $broad['months'][7]; ?></div>
                        <div class="one_combo" id="birth_month_7"><?php echo $broad['months'][8]; ?></div>
                        <div class="one_combo" id="birth_month_8"><?php echo $broad['months'][9]; ?></div>
                        <div class="one_combo" id="birth_month_9"><?php echo $broad['months'][10]; ?></div>
                        <div class="one_combo" id="birth_month_10"><?php echo $broad['months'][11]; ?></div>
                        <div class="one_combo" id="birth_month_11"><?php echo $broad['months'][12]; ?></div>
                    </div>
                </div><!-- #birth_month-->
                <input type="text" class="pluss_textin" maxlength="4" name="birth_year" id="birth_year" value="1989" />
                <div class="p_checkbox active">
                    <input type="checkbox" checked="checked" name="me_hide_date" value="me_hide_date" />
                    <?php echo $text['index_reg_form'][4]; ?></div>
            </div><!-- .form_line-->

            <div class="form_line">
                <label><?php echo $text['index_reg_form'][5]; ?></label>
                <div class="in_combo" id="me_country">
                    <div class="easy_mask"></div>
                    <input class="send_name" type="text" value="<?php echo $text['defoult_country']; ?>" name="me_country" />
                    <input class="send_id" type="hidden" value="1" name="me_country_id" />
                    <div class="combo_variants"></div>
                </div>
            </div><!-- .form_line-->

            <div class="form_line form_cut_line">
                <label><?php echo $text['index_reg_form'][6]; ?></label>
                <div class="in_combo" id="me_city">
                    <div class="easy_mask"></div>
                    <input class="send_name" type="text" value="<?php echo $text['defoult_city']; ?>" name="me_city" />
                    <input class="send_id" type="hidden" value="1" name="me_city_id" />
                    <div class="combo_variants"></div>
                </div>
            </div><!-- .form_line-->

            <div class="form_line">
                <label><?php echo $text['index_reg_form'][7]; ?></label>
                <input type="text" value="" class="pluss_textin" name="me_mail" />
            </div><!-- .form_line-->

            <div class="form_line">
                <label><?php echo $text['index_reg_form'][8]; ?></label>
                <input type="password" value="" class="pluss_textin" name="password" id="password"  />
            </div><!-- .form_line-->

            <div class="form_line form_cut_line">
                <label><?php echo $text['index_reg_form'][9]; ?></label>
                <input type="password" value="" class="pluss_textin" name="password_confirm" />
            </div><!-- .form_line-->

            <div class="form_line how_about_pluss">
                <label><?php echo $text['index_reg_form'][10]; ?></label>
                <div class="in_combo" id="how_do_get">
                    <div class="easy_mask"></div>
                    <input type="text" readonly="readonly" value="<?php echo $text['one_combo'][0]; ?>" name="how_do_get" />
                    <div class="combo_variants">
                        <div class="one_combo hover" id="how_do_get_0"><?php echo $text['one_combo'][0]; ?></div>
                        <div class="one_combo" id="how_do_get_1"><?php echo $text['one_combo'][1]; ?></div>
                        <div class="one_combo" id="how_do_get_2"><?php echo $text['one_combo'][2]; ?></div>
                    </div>
                </div><!-- #how_do_get-->
            </div>


            <div class="form_line i_agree">
                <div class="p_checkbox">
                    <input type="checkbox" name="i_agree" value="i_agree" />
                    <?php echo $text['index_reg_form'][11]; ?><a href="/uslovia"><?php echo $text['index_reg_form'][12]; ?></a>
                    <?php //echo $text['index_reg_form'][11]; ?></div>
                <div class="clear"></div>
            </div><!-- .form_line-->

            <div class="form_line">
                <div class="agree_button"><?php echo $text['index_reg_form'][13]; ?></div>
            </div><!-- .form_line-->


        </form><!-- .form-->
    </div><!-- #index_reg_form-->
</div><!-- display:none-->