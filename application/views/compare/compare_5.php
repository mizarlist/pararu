<div class="curr_compare_title"><?php echo $text["curr_compare_title"]; ?>  </div>
<div class="compare1_info compare5_info">
    <div class="life_count"><?php echo $text["compareable"]; ?> <span><?php echo $procent; ?>%</span> (<?php echo $text["from"]; ?> <?php echo $allprocent; ?>%)</div>
    <div id="show_top_percent_compare">+<?php echo $procent; ?> %</div>
</div><!-- .compare1_info-->


<div class="compare3_text">

    <div class="h3"><?php echo $zodiakText[$userZodiak]; ?> + <?php echo $zodiakText[$sputnikZodiak]; ?></div>
    <img src="<?php echo $pics[0]; ?>" />
    <img src="<?php echo $pics[1]; ?>" />
    <img src="<?php echo $pics[2]; ?>" />
    <p><?php echo $zodiakHarmonyText[$zhi]; ?></p>
</div><!-- .compare3_text -->

<?php echo $wanabet; ?>