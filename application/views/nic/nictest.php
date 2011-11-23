<div class="clear"></div>
<div id="sub_nic_page_in">

    <div class="thr_title"><?php echo $text['thr_title']; ?><sup>®</sup></div>

    <?php $active = ' active'; ?>
    <?php for ($i = 1; $i <= 5; $i++) { ?>
    <?php $blok = $bloks['card_' . $i]; ?>
        <div id="thr_page_<?php echo $i; ?>" class="thr_page_block<?php echo $active; ?>">
            <div class="thr_decr"><?php echo $text['bloktext'][$i]; ?></div>
            <div class="thr_progress">
                <div class="one_thr_progress<?php echo $i > 0 ? ' active' : ''; ?>"><?php echo $i == 1 ? '<i></i>' : ''; ?>Доверие</div>
                <div class="one_thr_progress<?php echo $i > 1 ? ' active' : ''; ?>"><?php echo $i == 2 ? '<i></i>' : ''; ?>Отношения  </div>
                <div class="one_thr_progress<?php echo $i > 2 ? ' active' : ''; ?>"><?php echo $i == 3 ? '<i></i>' : ''; ?>Сексуальность </div>
                <div class="one_thr_progress<?php echo $i > 3 ? ' active' : ''; ?>"><?php echo $i == 4 ? '<i></i>' : ''; ?>Личная Сила </div>
                <div class="one_thr_progress<?php echo $i > 4 ? ' active' : ''; ?>"><?php echo $i == 5 ? '<i></i>' : ''; ?>Мировосприятие </div>
            </div>
            <div class="clear"></div>
            <div id="thr_page_<?php echo $i; ?>_q_1" class="thr_block_in<?php echo $i == 1 ? ' active' : ''; ?>">
                <div class="nic_question">
                    <div class="q_title"><?php echo $blok['question_1']['q_title']; ?></div>
                    <div class="q_descr"><?php echo $blok['question_1']['q_descr']; ?></div>
                    <div class="q_checks">
                    <?php foreach ($blok['question_1']['variants'] as $k => $v) { ?>
                        <div class="p_checkbox" id="<?php echo $i; ?>_1_<?php echo $k; ?>"><?php echo $v; ?></div>
                    <?php } ?>
                </div>
            </div><!-- .nic_question-->
        </div>
        <div id="thr_page_<?php echo $i; ?>_q_2" class="thr_block_in">
            <div class="nic_question">
                <div class="q_title"><span>2.</span><span class="not_num"><?php echo $blok['question_2']['q_title']; ?></span></div>
                <div class="q_descr"><?php echo $blok['question_2']['q_descr']; ?></div>
                <div class="q_marks">
                    <div class="q_mark_summ"><div class="summ_in">15</div></div>

                    <?php $two = false; ?>
                    <?php foreach ($blok['question_2']['variants'] as $k => $v) { ?>
                    <?php
                        $suf = '';
                        if ($two) {
                            $suf = ' odd';
                        }
                        $two = !$two;
                    ?>
                        <div class="q_mark_line<?php echo $suf; ?>">
                            <div class="q_mark_text"><?php echo $v; ?></div>
                            <div class="q_marks_ctrls">
                                <span class="value" id="<?php echo $i; ?>_2_<?php echo $k; ?>">0</span>
                                <div class="set_left"></div>
                                <div class="set_right"></div>
                            </div>
                        </div><!-- .q_mark_line-->
                    <?php } ?>

                </div><!-- .q_marks-->
            </div><!-- .nic_question-->
        </div>
        <div id="thr_page_<?php echo $i; ?>_q_3" class="thr_block_in">
            <div class="nic_question">
                <div class="q_title"><span>3.</span><span class="not_num"><?php echo $blok['question_3']['q_title']; ?></span></div>
                <div class="q_descr"><?php echo $blok['question_3']['q_descr']; ?></div>
                <div class="q_marks">
                    <div class="q_mark_summ"><div class="summ_in">15</div></div>
                    <?php $two = false; ?>
                    <?php foreach ($blok['question_3']['variants'] as $k => $v) { ?>
                    <?php
                        $suf = '';
                        if ($two) {
                            $suf = ' odd';
                        }
                        $two = !$two;
                    ?>
                        <div class="q_mark_line<?php echo $suf; ?>">
                            <div class="q_mark_text"><?php echo $v; ?></div>
                            <div class="q_marks_ctrls">
                                <span class="value" id="<?php echo $i; ?>_3_<?php echo $k; ?>">0</span>
                                <div class="set_left"></div>
                                <div class="set_right"></div>
                            </div>
                        </div><!-- .q_mark_line-->
                    <?php } ?>

                </div><!-- .q_marks-->
            </div><!-- .nic_question-->
        </div>
        <div id="thr_page_<?php echo $i; ?>_q_4" class="thr_block_in">
            <div class="nic_question">
                <div class="q_title"><?php echo $blok['question_4']['q_title']; ?></div>
                <div class="q_descr"><?php echo $blok['question_4']['q_descr']; ?></div>
                <div class="question_photo">
                    <img src="<?php echo $blok['img']; ?>" />
                </div>
                <div class="q_tracks">

                <?php foreach ($blok['question_4']['variants'] as $k => $v) { ?>
                        <div class="q_track_line">
                            <div class="q_track_text">
                <?php echo $v; ?>
                        </div><!-- .q_track_line-->

                        <div class="q_track">
                            <div class="q_track_scale">
                                <div class="min"><?php echo $blok['question_4']['min']; ?></div>
                                <div class="max"><?php echo $blok['question_4']['max']; ?></div>
                            </div>
                            <div id="<?php echo $i; ?>_4_<?php echo $k; ?>" class="range_track"></div>
                        </div><!-- .q_track-->
                    </div><!-- .q_track_line-->
             <?php } ?>

                </div><!-- .q_tracks-->
            </div><!-- .nic_question-->
        </div>

    </div><!-- .thr_page_block #thr_page_1-->

        <?php } ?>

    <div class="buttons_block">
        <div id="next_thr_block" class="rs1_save next_thr_block"><?php echo $text['next_thr_block']; ?><i></i></div>
    </div>

</div><!-- #sub_nic_page_in-->