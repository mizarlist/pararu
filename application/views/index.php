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

            <div class="head">
                <div class="plessen"></div>
                <div class="margins">

                    <div class="head_lang">
                        <?php
                        foreach ($langs as $l) {
                            echo '<div class="one_lang' . ($l == $lang ? ' active' : '') . '"><a href="/' . $l . '"><img src="/images/localization/mini_flag_' . $l . '.png" /></a></div>';
                        }
                        ?>
                    </div>


                    <div class="index_logo"><a href="/"><img src="/images/index/logo.png" />
                            <span><?php echo $text['img_title']; ?></span>
                        </a></div>

                    <div class="index_menu">
                        <ul>
                            <li><a href="<?php echo '/tour/1'; ?>"><?php echo $text['index_menu'][0]; ?></a></li>
                            <li><a href="<?php echo '/whyweare'; ?>"><?php echo $text['index_menu'][1]; ?></a></li>
                            <li class="last"><a href="<?php echo '/successes'; ?>"><?php echo $text['index_menu'][2]; ?></a></li>
                        </ul>
                        <a class="kaspersky" href="#" style="background: url(/images/localization/index/kaspersky_<?php echo $lang; ?>.png) repeat scroll 0 0 transparent;"></a>
                    </div><!-- .index_menu-->

                    <div class="top_links">
                       <!-- <div class="top_links_r" id="index_go_reg"><a href="#"><?php echo $text['top_links_r']; ?></a></div>-->
                        <div class="top_links_i"><?php echo $text['registredq']; ?> <a href="/login"><?php echo Plussia_Dispatcher::isLogined() ? (Plussia_Dispatcher::getUser()->getUserData()->name) : $text['top_links_i']; ?></a></div>
                    </div><!-- .top_links-->

                    <div class="clear"></div>

                    <div class="index_slides">


                        <div class="index_slides_pages">
                            <div id="one_slide_page1" class="one_slide_page">
                            	<a href="http://yandex.ru/" class="link"></a>
                                <div class="one_slide_title"><?php echo $text['one_slide_title']; ?></div>
                                <div class="one_slide_text"><?php echo $text['one_slide_text']; ?>
                                </div>
                                <div class="do_first_step"><?php echo $text['do_first_step']; ?></div>
                                <img src="/images/index/baner_1.png" />
                            </div><!-- .one_slide_page1-->

                            <div id="one_slide_page2" class="one_slide_page">
                            	<a href="http://ya.ru/" class="link"></a>
                                <div class="one_slide_title"><?php echo $text['one_slide_title2']; ?></div>
                                <div class="one_slide_text"><?php echo $text['one_slide_text2']; ?>
                                </div>
                                <div class="do_first_step"><?php echo $text['do_first_step']; ?></div>
                                <img src="/images/index/baner_1.png" />
                            </div><!-- .one_slide_page2-->


                            <div id="one_slide_page3" class="one_slide_page">
                            	<a href="http://google.ru/" class="link"></a>
                                <div class="one_slide_title"><?php echo $text['one_slide_title3']; ?></div>
                                <div class="one_slide_text"><?php echo $text['one_slide_text3']; ?>
                                </div>
                                <div class="do_first_step"><?php echo $text['do_first_step']; ?></div>
                                <img src="/images/index/baner_1.png" />
                            </div><!-- .one_slide_page3-->


                        </div><!-- .index_slides_pages-->

                        <div class="index_sildes_controls">
                            <ul>
                                <li id="slide1" class="active"></li>
                                <li id="slide2"></li>
                                <li id="slide3"></li>
                            </ul>
                        </div>

                    </div><!-- .index_slides-->


                </div><!-- .head-->
            </div><!-- .margins-->

            <div class="main">
                <div class="margins">

                    <div class="index_5_steps">
                        <div class="index_5_steps_title"><?php echo $text['5steps']; ?></div>
                        <a class="one_5_step one_5_step1" href="#">
                            <strong class="o5s_title"><?php echo $text['one_5_step1'][0]; ?></strong>
                            <?php //echo $text['one_5_step1'][1]; ?>
                        </a>
                        <a class="one_5_step one_5_step2" href="#">
                            <strong class="o5s_title"><?php echo $text['one_5_step2'][0]; ?></strong>
                            <?php //echo $text['one_5_step2'][1]; ?>
                        </a>
                        <a class="one_5_step one_5_step3" href="#">
                            <strong class="o5s_title"><?php echo $text['one_5_step3'][0]; ?></strong>
                            <?php //echo $text['one_5_step3'][1]; ?>
                        </a>
                        <a class="one_5_step one_5_step4" href="#">
                            <strong class="o5s_title"><?php echo $text['one_5_step4'][0]; ?></strong>
                            <?php //echo $text['one_5_step4'][1]; ?>
                        </a>
                        <a class="one_5_step one_5_step5 last" href="#">
                            <strong class="o5s_title"><?php echo $text['one_5_step5'][0]; ?></strong>
                            <?php //echo $text['one_5_step5'][1]; ?>
                        </a>

                        <div class="index_know_more">
                            <a href="/tour/1"><?php echo $text['index_know_more']; ?><i></i></a>
                        </div>

                        <div class="clear"></div>
                    </div><!-- .index_5_steps-->


                    <div class="index_text_formula">
                        <div class="video">
                            <h2><?php echo $text['video']; ?></h2>
                            <div class="embded_video">
                                <img src="/images/temp_samples/sample_index.png" width="600" />
                            </div>
                        </div><!-- .video-->

                        <div class="text">
                            <h2><?php echo $text['textb']['h2']; ?></h2>
                            <div class="text_in_img"><img src="/images/temp_samples/sample_index2.png" /></div>
                            <?php echo $text['textb']['text']; ?>
                            <div class="clear"></div>
                            <div class="index_know_formula"><a href="/whyweare"><?php echo $text['index_know_formula']; ?> <i></i></a></div>

                        </div><!-- .text-->

                    </div><!-- .index_text_formula-->
                    <?php /*
                              <div class="index_bottom_video">
                              <div class="one_bottom_video">
                              <div class="embded_video">
                              <img src="/images/temp_samples/sample_index3.jpg" />
                              </div>
                              <div class="text">
                              <div class="text_title"><?php echo $text['textb']['title1']; ?></div>
                              <?php echo $text['textb']['text1']; ?>
                              </div>
                              </div><!-- .one_bottom_video-->

                              <div class="one_bottom_video">
                              <div class="embded_video">
                              <img src="/images/temp_samples/sample_index4.jpg" />
                              </div>
                              <div class="text">
                              <div class="text_title"><?php echo $text['textb']['title2']; ?></div>
                              <?php echo $text['textb']['text2']; ?>
                              </div>
                              </div><!-- .one_bottom_video-->


                              <div class="one_bottom_video last">
                              <div class="embded_video">
                              <img src="/images/temp_samples/sample_index5.jpg" />
                              </div>
                              <div class="text">
                              <div class="text_title"><?php echo $text['textb']['title3']; ?></div>
                              <?php echo $text['textb']['text3']; ?>
                              </div>
                              </div><!-- .one_bottom_video-->

                              </div><!-- .index_bottom_video-->
                             */ ?>
                        </div><!-- .margins-->
                    </div><!-- .main-->


                    <div class="clear"></div>
                    <div id="empty"></div>
                </div><!-- #content-->

                <div id="footer">
                    <div class="margins">

                        <div class="bookmarks_menu">

                        <div class="path">
                        	<a href="/" class="go_hart"></a>
                            <a href="/" class="last"><?php echo $text['bookmark']; ?></a>
                        </div>
                    <?php echo $bookmarks; ?>

                        </div><!-- .bookmarks_menu-->

                <?php echo $footer; ?>

            </div><!-- .margins-->
        </div><!-- #footer-->

    </body>


</html>