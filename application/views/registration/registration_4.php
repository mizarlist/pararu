<div id="register_step4">
    <div class="nic_top_controls">
        <div class="step_title"><?php echo $text["step_title"]; ?><span class="title_r">®</span></div>
        <div class="nic_top_steps">
            <ul>
                <li id="nic_top_li1"></li>
                <li id="nic_top_li2"></li>
                <li id="nic_top_li3"></li>
                <li id="nic_top_li4"></li>
                <li id="nic_top_li5"></li>
                <img src="/images/register/nic_arrows.png" />
            </ul>
        </div><!-- .nic_top_steps-->
        <div class="clear"></div>

        <?php
        for ($i = 1; $i <= 5; $i++) {
            $style = $i == 1 ? ' style="display:block;"' : '';
            echo '<div class="select_text" id="select_text' . $i . '"' . $style . '>
            ' . $text["select_text" . $i][0] . '<span class="title_r">®</span>.<br/>
            ' . $text["select_text" . $i][1] . '
            </div>';
        }
        ?>

        <div class="select_text" id="select_text6"><?php echo $text["final"][0]; ?><br/><br/>
            <?php echo $text["final"][1]; ?><span class="title_r">®</span>
            <?php echo $text["final"][2]; ?><br/><br/><br/>
            <div id="register_go_next5"><?php echo $text["register_go_next5"]; ?></div>
            <div class="clear"></div>
        </div>

        <div class="nic_step_select">
            <ul>
                <li id="nic_sel_li1" class="new_li"><?php echo $text["bloks_names"][0]; ?></li>
                <li id="nic_sel_li2" class="new_li"><?php echo $text["bloks_names"][1]; ?></li>
                <li id="nic_sel_li3" class="new_li"><?php echo $text["bloks_names"][2]; ?></li>
                <li id="nic_sel_li4" style="font-size: 15px;" class="new_li"><?php echo $text["bloks_names"][3]; ?></li>
                <li id="nic_sel_li5" class="new_li"><?php echo $text["bloks_names"][4]; ?></li>
            </ul>
        </div><!-- .nic_step_select-->
        <div class="clear"></div>
    </div><!-- .nic_top_controls-->

    <div class="nic_questions_blocks">
        <?php
            for ($i = 1; $i <= 5; $i++) {
                $blok = $bloks['card_' . $i];
                echo '<div id="nic_question_block' . $i . '" class="nic_question_block">
            <div class="block_title">' . $blok['title'] . '<span class="title_r">®</span></div>
            <div class="nic_question">
                <div class="q_title">' . $blok['question_1']['q_title'] . '</div>
                <div class="q_descr">' . $blok['question_1']['q_descr'] . '</div>
                <div class="q_checks">';

                foreach ($blok['question_1']['variants'] as $k => $v) {
                    echo '<div class="p_checkbox" id="' . $i . '_1_' . $k . '">' . $v . '</div>';
                }

                echo '</div>

            </div><!-- .nic_question-->

            <div class="nic_question">
                <div class="q_title"><span>2.</span><span class="not_num">' . $blok['question_2']['q_title'] . '</span>
                </div>
                <div class="q_descr">' . $blok['question_2']['q_descr'] . '</div>
                <div class="q_marks">

                    <div class="q_mark_summ"><div class="summ_in">15</div></div>';

                $two = false;
                foreach ($blok['question_2']['variants'] as $k => $v) {
                    $suf = '';
                    if ($two) {
                        $suf = ' odd';
                    }
                    $two = !$two;
                    echo '<div class="q_mark_line' . $suf . '">
                        <div class="q_mark_text">' . $v . '</div>
                        <div class="q_marks_ctrls">
                            <span class="value" id="' . $i . '_2_' . $k . '">0</span>
                            <div class="set_left"></div>
                            <div class="set_right"></div>
                        </div>
                    </div><!-- .q_mark_line-->';
                }

                echo '</div><!-- .q_marks-->

            </div><!-- .nic_question-->

            <div class="nic_question">
                <div class="q_title"><span>3.</span><span class="not_num">' . $blok['question_3']['q_title'] . '</span>
                </div>
                <div class="q_descr">' . $blok['question_3']['q_descr'] . '</div>
                <div class="q_marks">

                    <div class="q_mark_summ"><div class="summ_in">15</div></div>';

                $two = false;
                foreach ($blok['question_3']['variants'] as $k => $v) {
                    $suf = '';
                    if ($two) {
                        $suf = ' odd';
                    }
                    $two = !$two;
                    echo '<div class="q_mark_line' . $suf . '">
                        <div class="q_mark_text">' . $v . '</div>
                        <div class="q_marks_ctrls">
                            <span class="value" id="' . $i . '_3_' . $k . '">0</span>
                            <div class="set_left"></div>
                            <div class="set_right"></div>
                        </div>
                    </div><!-- .q_mark_line-->';
                }

                echo '</div><!-- .q_marks-->

            </div><!-- .nic_question-->

            <div class="nic_question">
                <div class="q_title">' . $blok['question_4']['q_title'] . '</div>
                <div class="q_descr">' . $blok['question_4']['q_descr'] . '</div>
                <div class="question_photo">
                    <img src="' . $blok['img'] . '" />
                </div>
                <div class="q_tracks">';

                foreach ($blok['question_4']['variants'] as $k => $v) {
                    echo '<div class="q_track_line">
                        <div class="q_track_text">
			' . $v . '
                        </div><!-- .q_track_line-->

                        <div class="q_track">
                            <div class="q_track_scale">
                                <div class="min">' . $blok['question_4']['min'] . '</div>
                                <div class="max">' . $blok['question_4']['max'] . '</div>
                            </div>
                            <div id="' . $i . '_4_' . $k . '" class="range_track"></div>
                        </div><!-- .q_track-->
                    </div><!-- .q_track_line-->';
                }

                echo '</div><!-- .q_tracks-->

            </div><!-- .nic_question-->
            
            <div class="close_nic_question">' . $bloks['cancel'] . '</div>
            <div class="next_nic_question">' . $bloks['save'] . '</div>
            <div class="clear"></div>

        </div><!-- #nic_question_block1-->';
            }
        ?>
        </div><!-- .nic_questions_blocks-->

        <div style="display:none;" id="right_col_load">
            <div class="reg3_r_col">
                <div class="register_main_col_img">
                    <img src="/images/temp_samples/reg_step_4_1.jpg" />
                </div><!-- .register_main_col_img-->
                <div class="register_main_col_img_txt">
                <?php echo $text['register_main_col_img_txt']; ?>
            </div>

        </div>
    </div>

</div><!-- #register_step4-->