<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-script-Type" content="text/html/javascript; charset=utf-8" />
        <title><?php echo $text['title']; ?></title>

        <link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/style_in.css" media="screen" />

        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/plugins.js"></script>
        <script type="text/javascript" src="/js/main_in.js"></script>
    </head>

    <body>
        <div id="content">
            <div class="margins">

                <?php echo $usertopmenu; ?>

                <div class="center_block_wrap">

                    <div id="center_top_menu" class="center_top_menu">
                        <ul>
                            <li id="ct_options"<?php echo $page==1 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][0]; ?></li>
                            <li id="ct_remind"<?php echo $page==2 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][1]; ?></li>
                            <li id="ct_apps"<?php echo $page==3 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][2]; ?></li>
                            <li id="ct_mobile"<?php echo $page==4 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][3]; ?></li>
                            <li id="ct_adv"<?php echo $page==5 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][4]; ?></li>
                            <li id="ct_help"<?php echo $page==6 ? 'class="active"' : ''; ?>><i></i><?php echo $text['center_top_menu'][5]; ?></li>
                        </ul>
                    </div><!-- .center_top_menu-->

                    <div id="center_block" class="center_account_block">

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
                    <?php echo $searchform; ?>
                    <?php echo $loveusers; ?>
                    <?php echo $rightbanner; ?>
                    <?php echo $rightartmonth; ?>
                    </div><!-- #right_block -->


                    <div class="clear"></div>
                    <div id="empty"></div>
                </div>
            </div><!-- #content-->

            <div id="footer">
                <div class="margins">

                    <div class="bookmarks_menu">

                        <div class="path">
                            <a href="/"><?php echo $text['bookmarks'][0]; ?></a>
                            <a href="/profile"><?php echo $text['bookmarks'][1]; ?></a>
                            <a href="/account"><?php echo $text['bookmarks'][2]; ?></a>
                        </div>

                    </div><!-- .bookmarks_menu-->

                <?php echo $footer; ?>

            </div><!-- .margins-->
        </div><!-- #footer-->

    </body>

</html>