<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-script-Type" content="text/html/javascript; charset=utf-8" />
        <title><?php echo $text['title']; ?></title>

        <?php echo $headers; ?>

    </head>

    <body>
        <?php echo $regblok; ?>
        <div id="content">

            <div class="register_head" id="why_we_are">
                <div class="margins">
                    <div class="register_logo"><a href="/"><img src="/images/register/logo.png" /></a></div>
                    <div class="register_menu">
                        <ul>
                            <li><i></i><a href="<?php echo $links['intro_top'][0]; ?>"><?php echo $text['top_menu'][0]; ?></a></li>
                            <li><i></i><a href="<?php echo $links['intro_top'][1]; ?>"><?php echo $text['top_menu'][1]; ?></a></li>
                            <li class="active"><i></i><a href="<?php echo $links['intro_top'][2]; ?>"><?php echo $text['top_menu'][2]; ?></a></li>
                            <li><i></i><a href="<?php echo $links['intro_top'][3]; ?>"><?php echo $text['top_menu'][3]; ?></a></li>
                            <li class="last"><i></i><?php echo $text['top_menu'][4]; ?></li>
                        </ul>
                    </div>
                </div><!-- .margins-->
            </div><!-- .register_head-->


            <div class="register_main why_we_are_main">
                <div class="margins">
                    <div class="left_column">
                        <div class="left_column_in">
                            <div class="goods_menu tour_menu wwr_menu">
                                <ul>
                                    <li class="active first"><i></i><a href="<?php echo $links['whyweare_top'][0]; ?>"><?php echo $text['goods_menu'][0]; ?></a></li>
                                    <li><i></i><a href="<?php echo $links['whyweare_top'][1]; ?>"><?php echo $text['goods_menu'][1]; ?></a></li>
                                    <li><i></i><a href="<?php echo $links['whyweare_top'][2]; ?>"><?php echo $text['goods_menu'][2]; ?></a></li>
                                    <li><i></i><a href="<?php echo $links['whyweare_top'][3]; ?>"><?php echo $text['goods_menu'][3]; ?></a></li>
                                    <div class="clear"></div>
                                </ul>
                            </div>

                            <div class="text_block">

                                <div class="h1"><?php echo $text['h1']; ?></div>

                                <p>
                                    <span class="strong"><?php echo $text['sns']; ?></span><?php echo $text['snst']; ?>
                                    <span class="strong"><?php echo $text['ns']; ?></span><?php echo $text['nst']; ?>
                                </p>
                                <p>
                                    <?php echo $text['piu']; ?>
                                </p>

                                <div class="h4"><?php echo $text['h4']; ?></div>
                                <?php echo $text['h4t']; ?><span class="strong"><?php echo $text['h4s']; ?></span><?php echo $text['h4st']; ?>


                                <div class="get_in_now get_in_now_wwr">
                                    <div class="get_in_txt"><?php echo $text['get_in_now'][0]; ?><?php echo $text['get_in_now'][1]; ?><?php echo $text['get_in_now'][2]; ?></div>
                                    <div class="get_in_btn"><?php echo $text['get_in_now'][3]; ?></div>
                                    <div class="clear"></div>
                                </div>	<!-- .get_in_now-->

                                <p class="micro_help">
                                    <?php echo $text['micro_help']; ?>
                                </p>

                            </div><!-- .text_block-->
                        </div><!-- .left_column_in-->


                        <div class="main_good_cols">
                            <div class="one_good_col one_good_col1">
                                <div class="col_top">
                                    <?php echo $text['col_top']; ?>
                                </div>

                                <div class="col_text">
                                    <p><?php echo $text['col_text'][0]; ?>
                                    </p><p>
                                        <?php echo $text['col_text'][1]; ?>
                                    </p>
                                </div>


                                <a class="know_more" href="<?php echo $links['whyweare_top'][1]; ?>"><?php echo $text['know_more']; ?></a>


                            </div><!-- .one_good_col1-->

                            <div class="one_good_col one_good_col2">
                                <div class="col_top">
                                    <?php echo $text['col_top1'][0]; ?><br/> <?php echo $text['col_top1'][1]; ?>
                                </div>

                                <div class="col_text">

                                    <p>
                                        <?php echo $text['col_text1']; ?>
                                    </p>
                                </div>


                                <a class="know_more" href="<?php echo $links['whyweare_top'][2]; ?>"><?php echo $text['know_more']; ?></a>

                            </div><!-- .one_good_col2-->


                            <div class="one_good_col one_good_col3">
                                <div class="col_top">
                                    <?php echo $text['col_top2'][0]; ?><br/> <?php echo $text['col_top2'][1]; ?> <?php echo $text['col_top2'][2]; ?>
                                </div>

                                <div class="col_text">

                                    <p><?php echo $text['col_text2'][0]; ?>
                                    </p><p>
                                        <?php echo $text['col_text2'][1]; ?>
                                    </p>

                                </div>


                                <a class="know_more" href="<?php echo $links['whyweare_top'][3]; ?>"><?php echo $text['know_more']; ?></a>


                            </div><!-- .one_good_col3-->
                            <div class="clear"></div>

                        </div>	<!-- .main_good_cols-->

                    </div><!-- .left_column-->

                    <div class="right_column">
                        <img src="/images/why_we_are/pokatai_mena_loshadka.png" style="top: -71px;"/>
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
                        <a href="<?php echo $links['intro_top'][2]; ?>"><?php echo $text['bookmarks_menu'][0]; ?></a>
                        <a href="<?php echo $links['whyweare_top'][0]; ?>"><?php echo $text['bookmarks_menu'][1]; ?></a>
                    </div>
                    <?php echo $bookmarks; ?>

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