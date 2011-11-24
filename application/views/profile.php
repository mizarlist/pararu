<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-script-Type" content="text/html/javascript; charset=utf-8" />
        <title><?php echo $text['title']; ?></title>

        <link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/style_in.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="/css/style_add.css" media="screen" />

        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type="text/javascript" src="/js/plugins.js"></script>
        <script type="text/javascript" src="/js/main_in.js"></script>
        <script type="text/javascript" src="/js/jquery.limit.js"></script>

    </head>


    <body>
        <div id="content">
            <div class="margins">

                <?php echo $usertopmenu; ?>

                <div class="center_block_wrap">

                    <div id="center_top_menu" class="center_top_menu">
                        <ul>
                            <li id="spt_new" class="active"><i></i><?php echo $text['center_top_menu'][0]; ?> <span><?php echo ($values['new_users'] ? '('.$values['new_users'].')' : ''); ?></span></li>
                            <li id="spt_intrme"><i></i><?php echo $text['center_top_menu'][1]; ?> <span><?php echo ($values['new_interesme'] ? '('.$values['new_interesme'].')' : ''); ?></span></li>
                            <li id="spt_inter"><i></i><?php echo $text['center_top_menu'][2]; ?></li>
                            <li id="spt_saved"><i></i><?php echo $text['center_top_menu'][3]; ?></li>
                            <li id="spt_ignore"><i></i><?php echo $text['center_top_menu'][4]; ?></li>
                        </ul>
                    </div><!-- .center_top_menu-->

                    <div id="center_block" class="center_myfvorits_block">
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
                            <a href="/" class="go_hart"></a>
                            <a href="/"><?php echo $text['bookmarks'][0]; ?></a>
                            <a href="/profile" class="last"><?php echo $text['bookmarks'][1]; ?></a>
                        </div>

                    </div><!-- .bookmarks_menu-->

                <?php echo $footer; ?>

            </div><!-- .margins-->
        </div><!-- #footer-->

<div class="popupbox" id="popup2rel">
   <div id="intabdiv">
      <div style="position:relative">
         <h2><a class="close_btn" href="#">закрыть x</a></h2>
		 <span class="poptitle">Сообщение пользователю <span></span></span>
	  </div>
      <div id="del_content">
	     <div class="form_mes_inn" style="margin: 3px 20px 0 15px !important;">
		    <span class="b-time f-right m10">осталось <span class="num">1000</span> символов</span>
			<textarea class="txtarea" name="message" wrap="virtual" cols="65" rows="3"></textarea>
		 </div>
      </div>
      <div id="del_btns">
         <div class="rs1_save" id="send_msg_action" style="float:right;margin-right: 23px; width: 70px !important">отправить<i></i></div>
      </div>
   </div>
</div>

    </body>


</html>