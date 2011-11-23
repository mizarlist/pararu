<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-script-Type" content="text/html/javascript; charset=utf-8" />
        <title><?php echo $text['title']; ?></title>

        <?php echo $headers; ?>

    </head>


    <body>
        <div id="content">

            <div class="register_head" id="register_page">
                <div class="margins">
                    <div class="register_logo"><a href="/"><img src="/images/register/logo.png" /></a></div>
                    <div class="register_menu">
                        <ul>
                            <li id="rm_li1" class="active"><i></i><?php echo $text['rm_li'][0]; ?></li>
                            <li id="rm_li2" class="rm_red"><i></i><?php echo $text['rm_li'][1]; ?></li>
                            <li id="rm_li3"><i></i><?php echo $text['rm_li'][2]; ?></li>
                            <li id="rm_li4"><i></i><?php echo $text['rm_li'][3]; ?></li>
                            <li id="rm_li5"><i></i><?php echo $text['rm_li'][4]; ?></li>
                            <li id="rm_li6" class="last"><?php echo $text['rm_li'][5]; ?><div></div></li>
                        </ul>
                    </div>
                </div><!-- .margins-->
            </div><!-- .register_head-->


            <div class="register_main">
                <div class="margins">
                    <div class="left_column">
                        <div class="left_column_in" id="left_reg_column_in">
                            <div class="step_title"><?php echo $text['step_title']; ?></div>

                            <div id="register_step1">
                                <div class="rs1_img" id="rs_img1"><span><?php echo $cards['names'][1]; ?></span></div>
                                <div class="rs1_img" id="rs_img2"><span><?php echo $cards['names'][2]; ?></span></div>
                                <div class="rs1_img" id="rs_img3"><span><?php echo $cards['names'][3]; ?></span></div>
                                <div class="rs1_img" id="rs_img4"><span><?php echo $cards['names'][4]; ?></span></div>
                                <div class="rs1_img" id="rs_img5"><span><?php echo $cards['names'][5]; ?></span></div>
                                <div class="rs1_img" id="rs_img6"><span><?php echo $cards['names'][6]; ?></span></div>
                                <div class="rs1_img" id="rs_img7"><span><?php echo $cards['names'][7]; ?></span></div>
                                <div class="rs1_img" id="rs_img8"><span><?php echo $cards['names'][8]; ?></span></div>
                                <div class="rs1_img" id="rs_img9"><span><?php echo $cards['names'][9]; ?></span></div>
                                <div class="rs1_img" id="rs_img10"><span><?php echo $cards['names'][10]; ?></span></div>
                                <div class="rs1_img" id="rs_img11"><span><?php echo $cards['names'][11]; ?></span></div>
                                <div class="rs1_img" id="rs_img12"><span><?php echo $cards['names'][12]; ?></span></div>
                            </div>

                            <div style="display: none;">
                                <div class="rs1_box rs1_box1">
                                    <div class="close_rs1_box"></div>
                                    <div class="rs_box_title"><?php echo $text['rs_box_title']; ?></div>
                                    <div id="rs1_var_list"></div>
                                    <div class="clear"></div>
                                    <div class="rs1_save rs1_not_save"><?php echo $text['translation'][0]; ?></div>
                                </div>

                            </div>

                            <script>
                                var reg_step1_variants = [
                                    {},
<?php
        if (isset($cards) && is_array($cards)) {
            $iter_cards = 1;
            $count_cards = count($cards) - 1;
            foreach ($cards as $id_card => $card) {
                if ($id_card != 'names') {
                    echo '{';
                    $iter = 1;
                    $count = count($card);
                    foreach ($card as $id_variant => $variant) {
                        echo "$id_variant : '$variant'";
                        if ($iter != $count) {
                            echo ',';
                        }
                        $iter++;
                    }
                    echo '}';
                    if ($iter_cards != $count_cards) {
                        echo ',';
                    }
                    $iter_cards++;
                }
            }
        }
?>
    ];
    var translation = new Array();
    translation[0] = '<?php echo $text['translation'][0]; ?>';
    translation[1] = '<?php echo $text['translation'][1]; ?>';
    translation[2] = '<?php echo $text['translation'][2]; ?>';
    translation[3] = '<?php echo $text['translation'][3]; ?>';
    translation[4] = '<?php echo $text['translation'][4]; ?>';
    translation[5] = '<?php echo $text['translation'][5]; ?>';
    translation[6] = '<?php echo $text['translation'][6]; ?>';
    translation[7] = '<?php echo $text['translation'][7]; ?>';
    translation[8] = '<?php echo $text['translation'][8]; ?>';
    translation[9] = '<?php echo $text['translation'][9]; ?>';
    var emptyMsg = '<?php echo $text['emptyMsg']; ?>';
                            </script>

                        </div><!-- .left_column_in-->
                    </div><!-- .left_column-->

                    <div class="right_column">

                        <div class="register_pie" id="register_pie">
                            <div class="rp_list" id="rp_list1">
                                <i class="rpl_on"></i><i class="rpl_off"></i><i class="rpl_onoff"></i>
                            </div>
                            <div class="rp_list" id="rp_list2">
                                <i class="rpl_on"></i><i class="rpl_off"></i><i class="rpl_onoff"></i>
                            </div>
                            <div class="rp_list" id="rp_list3">
                                <i class="rpl_on"></i><i class="rpl_off"></i><i class="rpl_onoff"></i>
                            </div>
                            <div class="rp_list" id="rp_list4">
                                <i class="rpl_on"></i><i class="rpl_off"></i><i class="rpl_onoff"></i>
                            </div>
                            <div class="rp_list" id="rp_list5">
                                <i class="rpl_on"></i><i class="rpl_off"></i><i class="rpl_onoff"></i>
                            </div>
                        </div><!-- #register_pie-->

                        <div class="register_progress">
                            <div class="rp_text"><?php echo $text['rp_text']; ?></div>
                            <div class="rp_fill" style="width: 4%;"></div>
                        </div>

                        <div id="right_col_postload">

                        </div>

                        <div style="display:none;" id="right_col_load">
                            <div class="reg3_r_col">
                                <div class="register_main_col_img">
                                    <img src="/images/temp_samples/reg_step_1_1.jpg" />
                                </div><!-- .register_main_col_img-->
                                <div class="register_main_col_img_txt">
                                    <?php echo $text['ex_text']; ?>
                                </div>

                            </div>
                        </div>

                    </div><!-- .right_column-->

                </div><!-- .margins-->
            </div><!-- .main-->


            <div class="clear"></div>
            <div id="empty"></div>
        </div><!-- #content-->

        <div id="footer">
            <div class="margins">
                <div class="bookmarks_menu">
                    <div class="path">
                        <a href="/registration"><?php echo $text['bookmark']; ?></a>
                    </div>
                    <div class="one_bookmark one_bookmark9"></div>
                    <div class="one_bookmark one_bookmark8"></div>
                    <div class="one_bookmark one_bookmark7"></div>
                    <div class="one_bookmark one_bookmark6"></div>
                    <div class="one_bookmark one_bookmark5"></div>
                    <div class="one_bookmark one_bookmark4"></div>
                    <div class="one_bookmark one_bookmark3"></div>
                    <div class="one_bookmark one_bookmark2"></div>
                    <div class="one_bookmark one_bookmark1"></div>
                </div><!-- .bookmarks_menu-->

                <?php echo $footer; ?>

            </div><!-- .margins-->
        </div><!-- #footer-->
    </body>


</html>

