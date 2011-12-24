<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-script-Type" content="text/html/javascript; charset=utf-8" />
        <title><?php echo $text['title'] ?></title>

        <link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/style_in.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/style_add.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/photoalbums.css" media="screen" />

        <link rel="stylesheet" type="text/css" href="/plugins/reveal/reveal.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/plugins/uploadify/uploadify.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/plugins/jcrop/css/jquery.Jcrop.css" media="screen" />

        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/plugins.js"></script>
        <script type="text/javascript" src="/js/main_in.js"></script>
        <script type="text/javascript" src="/js/change.js"></script>
        <script type="text/javascript" src="/js/jquery.limit.js"></script>
        <script type="text/javascript" src="/js/jquery.keyboard.js"></script>

        <script src="/js/myphoto.js" type="text/javascript"></script>

    </head>

    <body>

        <div id="content">
            <div class="margins">

                <?php echo $usertopmenu; ?>

                <div class="center_block_wrap">

                    <div id="center_top_menu" class="center_top_menu">
                        <ul>
                            <li id="ct_sput_page"<?php echo $page==1 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][0] ?></li>
                            <li id="ct_sput_photo"<?php echo $page==2 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][1] ?></li>
                            <li id="ct_sput_comp"<?php echo $page==3 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][2] ?></li>
                            <li id="ct_sput_talk"<?php echo $page==4 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][3] ?></li>
                            <li id="ct_sput_dates"<?php echo $page==5 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][4] ?></li>

                        </ul>
                    </div><!-- .center_top_menu-->

                    <div id="center_block" class="center_sputnik_block">
                    	<a name="sb_sput_comp"></a><a name="#sb_sput_comp"></a>                    	
                        <?php echo $centerblock; ?>
                    </div><!-- #center_block -->
                </div><!-- #center_block -->

                <div id="left_block">

                    <?php echo $userphoto; ?>
                    <?php echo $userleftmenu; ?>
                    <?php echo $pagecomplete; ?>

                        <div id="left_block_load">

                        <?php echo $leftusersonic; ?>
                        <?php echo $leftuserinfo; ?>

                    </div><!-- #left_block_load -->


                </div><!-- #left_block -->

                <div id="right_block">
                    <div class="other_user_right" id="other_user_id<?php echo $sputnikident; ?>">

                        <?php echo $sputnikphoto; ?>

                        <div class="user_name">
                            <?php echo $sputnik_name; ?>
                        </div><!-- .user_name-->

                        <div class="user_menu" id="sputkin_r_menu">
                            <div id="sb_sput_comp" class="menu_line"><i class="ico"></i><span><?php echo $text['user_menu'][0]; ?></span></div>
                            <div id="sb_sput_photo" class="menu_line"><i class="ico"></i><span><?php echo $text['user_menu'][1]; ?></span></div>
                            <div id="user_menu8" class="menu_line"><i class="ico"></i><span><?php echo $text['user_menu'][2]; ?></span></div>
                            <?php if (!$no_interes_menu) {
 ?>
                                <div id="user_menu9" class="menu_line"><i class="ico"></i><span><?php echo $text['user_menu'][3]; ?></span></div>
<?php } ?>
                            <div id="user_menu10" class="menu_line"><i class="ico"></i><span><?php echo $text['user_menu'][4]; ?></span></div>
                        </div><!-- .user_menu-->

                    </div><!-- .other_user_right -->

<?php echo $loveusers; ?>

                        </div><!-- #right_block -->

                        <div class="clear"></div>
                        <div id="empty"></div>
                    </div>
                </div><!-- #content-->

                <div id="footer">
                    <div class="margins">

                        <div class="bookmarks_menu">

                            <div class="path">
                                <a href="/" class="go_hart"></a>
                                <a href="/"><?php echo $text['bookmarks'][0]; ?></a>
                                <a href="/<?php echo $adr; ?>" class="last"><?php echo $adr; ?></a>
                            </div>

                        </div><!-- .bookmarks_menu-->

<?php echo $footer; ?>

            </div><!-- .margins-->
        </div><!-- #footer-->

        <!--popup удалить сообщения -->
        <div class="popupbox" id="popuprel">
            <div id="intabdiv">
                <div style="position:relative">
                    <h2><a class="close_btn" style="cursor:pointer;"><?php echo $text['close_btn']; ?> x</a></h2>
                    <span class="poptitle"><?php echo $text['poptitle']; ?></span>
                </div>
                <div id="del_content">
                    <div id="del_photo"><img width="50px" height="50px" src="<?php echo $sputnik_ava; ?>" /></div>
                    <div id="del_text"><p><?php echo $text['del_text']; ?> <?php echo $sputnik_name; ?>?</p></div>
                </div>
                <div id="del_btns">
                    <span class="btn_cancel"><a style="cursor:pointer;"><?php echo $text['btn_cancel']; ?></a></span>
                    <span class="btn_del"><a id="delhist" style="cursor:pointer;"><?php echo $text['btn_del']; ?></a></span>
                </div>
            </div>
        </div>
        <!--конец popup удалить сообщения -->

    </body>

</html>