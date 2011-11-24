<a href="/successes"><img class="footer_some_pic" src="/images/footer_pics/pic<?php echo $footer_some_pic_num; ?>.png" /></a>
<div class="footer_menu">
    <div class="rights"><a href="#"><?php echo $elements['footer_menu']['confidence']; ?></a> Pararu.ru © 2010-2011 </div>

    <div class="lang_sel">
        <div class="lang_flag">
            <span>
                <img src="/images/localization/flag_<?php echo $lang; ?>.png" />
            </span>
        </div>
        <div class="lang_active"><?php echo $broad['langs'][$lang]; ?></div>
        <ul class="lang_menu">
            <?php
            foreach($broad['langs'] as $key => $text) {
                if($key!=$lang) {
                    echo "<li><a href='/$key/".Request::current()->getCurAdr()."'>".$text."</a></li>";
                }
            }
            ?>
            <!-- Текущий язык помещается в список последним  -->
            <li><a href="/<?php echo $lang."/".Request::current()->getCurAdr(); ?>"><?php echo $broad['langs'][$lang]; ?></a></li>
        </ul>
    </div><!-- .lang_sel-->

    <ul class="footer_menu_ul">
        <li><a href="#"><?php echo $elements['footer_menu']['ul'][0]; ?></a></li>
        <li><a href="#"><?php echo $elements['footer_menu']['ul'][1]; ?></a></li>
        <li><a href="#"><?php echo $elements['footer_menu']['ul'][2]; ?></a></li>
        <li><a href="#"><?php echo $elements['footer_menu']['ul'][3]; ?></a></li>
        <li><a href="#"><?php echo $elements['footer_menu']['ul'][4]; ?></a></li>
        <li class="last"><a href="#"><?php echo $elements['footer_menu']['ul'][5]; ?></a></li>
       <!-- <li><a href="#"><?php  echo $elements['footer_menu']['ul'][6]; ?></a></li>
        <li class="last"><a href="#"><?php echo $elements['footer_menu']['ul'][7]; ?></a></li>-->
    </ul><!-- .footer_menu_ul-->


</div><!-- .footer_menu-->
