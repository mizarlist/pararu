<?php $user = Plussia_Dispatcher::getUser(); ?>
<div class="center_block_title"><?php echo $text['center_block_title']; ?></div>


<div class="flap_block closed" id="login_flap">
    <div class="p_title_1"><?php echo $text['login_flap'][0]; ?>
        <div class="p_title_add"><?php echo Plussia_Dispatcher::getUser()->email; ?></div>
    </div>
    <div class="flap_block_in">

        <div class="option_line">
            <label><?php echo $text['login_flap'][1]; ?></label>
            <input class="text_input" type="text" id="new_login" />
        </div>
        <div class="option_line">
            <label><?php echo $text['login_flap'][2]; ?></label>
            <input class="text_input" type="password" id="pass_prove" />
        </div>

        <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="pass_flap">
    <div class="p_title_1"><?php echo $text['pass_flap'][0]; ?></div>
    <div class="flap_block_in">

        <ul class="text_ul">
            <li><?php echo $text['pass_flap'][1]; ?></li>
            <li><?php echo $text['pass_flap'][2]; ?></li>
            <li><?php echo $text['pass_flap'][3]; ?></li>
            <li><?php echo $text['pass_flap'][4]; ?></li>
        </ul>

        <div class="option_line">
            <label><?php echo $text['pass_flap'][5]; ?></label>
            <input class="text_input" type="password" id="old_pass_change" />
        </div>

        <div class="option_line">
            <label><?php echo $text['pass_flap'][6]; ?></label>
            <input class="text_input" type="password" id="new_pass_change" />
        </div>

        <div class="option_line">
            <label><?php echo $text['pass_flap'][7]; ?></label>
            <input class="text_input" type="password" id="new_pass_change2" />
        </div>

        <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="show_flap">

    <div class="p_title_1"><?php echo $text['show_flap'][0]; ?></div>
    <div class="flap_block_in">

        <div class="option_line text_line">
            <?php echo $text['show_flap'][1]; ?>
        </div>

        <div class="save_block_changes"><span><?php echo $text['show_flap'][2]; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->


<div class="flap_block closed set_secure" id="set_secure_flap">

    <div class="p_title_1"><?php echo $text['set_secure_flap_title']; ?></div>
    <div class="flap_block_in">

        <?php
            $confidence = $options->confidence ? explode(';', $options->confidence) : array();
            $confidence = array_slice($confidence, 1, count($confidence) - 2);
            $miter = 0;
            foreach ($text['set_secure_flap'] as $k => $ssf_text) {
                echo '<div class="option_line">
            <label>' . $ssf_text . '</label>
            <div class="in_combo" id="securetype' . $k . '">
                <div class="easy_mask"></div>
                <input type="text" readonly="readonly" value="' . (isset($confidence[$miter]) ? $text['secure_flap_variants'][$confidence[$miter]] : $text['secure_flap_variants'][0]) . '" name="securetype' . $k . '" />
                <div class="combo_variants">';
                $hover = ' hover';
                $iter = 0;
                foreach ($text['secure_flap_variants'] as $vk => $var) {
                    if ($confidence && isset($confidence[$miter]) && $confidence[$miter] == $iter) {
                        $hover = ' hover';
                    } else if ($confidence && isset($confidence[$miter])) {
                        $hover = '';
                    }
                    echo '<div class="one_combo' . $hover . '" id="securetype' . $k . '_' . $vk . '">' . $var . '</div>';
                    $hover = '';
                    $iter++;
                }
                echo '</div>
            </div><!-- #secure_type1-->
        </div>';
                $miter++;
            }
        ?>

            <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

        </div><!-- .flap_block_in--></div><!-- .flap_block-->


    <div class="flap_block closed" id="page_adr_flap">

        <div class="p_title_1"><?php echo $text['page_adr_flap'][0]; ?>
            <div class="p_title_add">http://www.pararu.ru/<?php echo $user->username ? $user->username : $user->standart_username; ?></div>
        </div>
        <div class="flap_block_in">

            <div class="option_line text_line">
                <b><?php echo $text['page_adr_flap'][1]; ?></b> <?php echo $user->username ? $user->username : Model_User::getUID($user->user_id); ?><br/>
                <b><?php echo $text['page_adr_flap'][2]; ?></b> http://www.pararu.ru/<?php echo $user->username ? $user->username : $user->standart_username; ?>
            </div>

            <div class="option_line">
                <label><?php echo $text['page_adr_flap'][5]; ?></label>
                <input class="text_input" type="text" id="new_pageaddr" />
            </div>

            <div class="option_line text_line">
                <b><?php echo $text['page_adr_flap'][6]; ?></b><br/>
            <?php echo $text['page_adr_flap'][7]; ?><br/>
            <?php echo $text['page_adr_flap'][8]; ?><br/>
            <?php echo $text['page_adr_flap'][9]; ?><br/>
        </div>

        <div class="save_block_changes"><span><?php echo $text['page_adr_flap'][3]; ?></span>
            <br/><?php echo $text['page_adr_flap'][4]; ?>
        </div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="main_photo_flap">

    <div class="p_title_1"><?php echo $text['main_photo_flap'][0]; ?></div>
    <div class="flap_block_in">

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="zone_flap">

    <div class="p_title_1"><?php echo $text['zone_flap_title']; ?>
        <div class="p_title_add"><?php echo $text['zone_flap'][$user->time_zone]; ?></div>
    </div>
    <div class="flap_block_in">
        <div class="option_line">

            <?php
            echo '<div class="option_line">
            <label>' . $text['zone_flap_title'] . '</label>
            <div class="in_combo" id="zoneflap">
                <div class="easy_mask"></div>
                <input type="text" readonly="readonly" value="' . $text['zone_flap'][$user->time_zone] . '" name="zoneflap_' . $user->time_zone . '" />
                <div class="combo_variants">';
            $hover = ' hover';
            $iter = 0;
            foreach ($text['zone_flap'] as $id_zone => $text_zone) {
                if ($id_zone == $user->time_zone) {
                    $hover = ' hover';
                } else {
                    $hover = '';
                }
                echo '<div class="one_combo' . $hover . '" id="zoneflap_' . $id_zone . '">' . $text_zone . '</div>';
                $hover = '';
            }
            echo '</div>
                    </div>
                    </div>';
            ?>

        </div><!-- .option_line-->

        <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="lang_flap">

    <div class="p_title_1"><?php echo $text['lang_flap'][0]; ?>
        <div class="p_title_add"><?php echo $broad['langs'][$user->language]; ?></div>
    </div>
    <div class="flap_block_in">
        <div class="option_line">
            <div class="radio_group">

                <?php
                foreach ($broad['langs'] as $key => $langname) {
                    $active = $user->language == $key ? ' active' : '';
                    echo '<div class="p_checkbox' . $active . '" id="langflap_' . $key . '">' . $langname . '</div><br><br>';
                }
                ?>
            </div><!-- .option_line--></div><!-- .radio_group-->

        <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block closed" id="logout_flap">

    <div class="p_title_1"><?php echo $text['logout_flap_title']; ?>
        <div class="p_title_add"><?php echo $text['logout_flap'][$user->logout]; ?></div>
    </div>
    <div class="flap_block_in">
        <div class="option_line">
            <div class="radio_group">

                <?php
                foreach ($text['logout_flap'] as $key => $logoutname) {
                    $active = $user->logout == $key ? ' active' : '';
                    echo '<div class="p_checkbox' . $active . '" id="logoutflap_' . $key . '">' . $logoutname . '</div><br><br>';
                }
                ?>
            </div><!-- .option_line--></div><!-- .radio_group-->

        <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<div class="flap_block gray closed" id="deactivate_flap">

    <div class="p_title_1"><?php echo $text['deactivate_flap'][0]; ?></div>
    <div class="flap_block_in">

        <div class="option_line">
            <label><?php echo $text['deactivate_flap'][1]; ?></label>
            <input class="text_input" type="text" id="login" />
        </div>
        <div class="option_line">
            <label><?php echo $text['deactivate_flap'][2]; ?></label>
            <input class="text_input" type="password" id="pass_prove" />
        </div>

        <div class="save_block_changes"><span><?php echo $text['deactivate_flap'][3]; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->