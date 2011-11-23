<div class="curr_compare_title"><?php echo $text['title']; ?>  </div>
<div class="compare1_info compare3_info">
    <div class="life_count"><?php echo $text['subtitle']; ?> <span><?php echo $procent; ?>%</span> (<?php echo $text['fromsumm']; ?> <?php echo $allprocent; ?>%)</div>
    <div id="show_top_percent_compare">+<?php echo $procent; ?> %</div>
</div><!-- .compare1_info-->

<div class="compare3_data">
    <img class="left_char" src="<?php echo $imgs['left']['big']; ?>" />
    <img class="right_char" src="<?php echo $imgs['right']['big']; ?>" />
    <div class="clear"></div>
    <div class="noetic_means"><?php echo $text['prim']; ?></div>
</div>

<div class="compare3_text">
    <div class="left_t_col">
        <div class="h3"><?php echo $typeNames[0]; ?></div>
        <div class="mini_photo" style="background-image: url(<?php echo $imgs['left']['mini']; ?>)"></div><div class="clear"></div>
        <p><?php echo $userTexts[0]; ?></p>
    </div><!-- .left_t_col -->

    <div class="right_t_col">
        <div class="h3"><?php echo $typeNames[1]; ?></div>
        <div class="mini_photo" style="background-image: url(<?php echo $imgs['right']['mini']; ?>)"></div><div class="clear"></div>
        <p><?php echo $userTexts[1]; ?></p>
    </div><!-- .right_t_col -->

    <div class="clear"></div>
    <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
</div><!-- .compare3_text -->



<div class="compare3_text">

    <div class="h3"><?php echo $typeNames[0]; ?> + <?php echo $typeNames[1]; ?>: <?php echo $text['compatibility']['sum']; ?><!-- (51,2%) --></div>
    <img src="/images/profile/compare/nic_logo/logo1.png" />
    <p><?php echo $compareTexts['sum']; ?></p>
    <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
</div><!-- .compare3_text -->


<div class="compare3_text">

    <div class="h3"><?php echo $text['compatibility']['sex']; ?><!-- (10,9% из 51,2%) --></div>
    <img src="/images/profile/compare/nic_logo/logo2.png" />
    <p><?php echo $compareTexts['sex']; ?></p>
    <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
</div><!-- .compare3_text -->

<div class="compare3_text">

    <div class="h3"><?php echo $text['compatibility']['psy']; ?><!-- (17,1% из 51,2%) --></div>
    <img src="/images/profile/compare/nic_logo/logo3.png" />
    <p><?php echo $compareTexts['psy']; ?></p>
    <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
</div><!-- .compare3_text -->

<div class="compare3_text">

    <div class="h3"><?php echo $text['compatibility']['soc']; ?><!-- (14,5% из 51,2%) --></div>
    <img src="/images/profile/compare/nic_logo/logo4.png" />
    <p><?php echo $compareTexts['soc']; ?></p>
    <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
</div><!-- .compare3_text -->



<div class="compare3_text">

    <div class="h3"><?php echo $text['compatibility']['spi']; ?><!-- (18,7% из 51,2%) --></div>
    <img src="/images/profile/compare/nic_logo/logo5.png" />
    <p><?php echo $compareTexts['spi']; ?></p>
    <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
</div><!-- .compare3_text -->

<?php echo $wanabet; ?>