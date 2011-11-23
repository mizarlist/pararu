<div class="curr_compare_title curr_compare_title2">
    <?php echo $text['curr_compare_title'][0] . $allcount . $text['curr_compare_title'][1] . $subcount . $text['curr_compare_title'][2]; ?>
    <div class="what_artic">«<?php echo $cardname; ?>»</div>
</div>

<?php if($table_lines) { ?>
<div class="compare1_table compare1_table2">
    <div class="title_l"><?php echo $text['title_l']; ?></div>
    <div class="title_r"><?php echo $text['title_r']; ?></div>
    <div class="clear"></div>

    <?php
    for ($i = 0; $i < $table_lines; $i++) {
        echo '<div class="compare_line top_cut'.((($i+1)>$subcount) ? '' : ' active').'">';
        echo '<div class="compare_left">';
        echo $table['left'][$i];
        echo '</div>';
        echo '<div class="compare_right">';
        echo $table['right'][$i];
        echo '</div>';
        echo '</div><!-- .compare_line-->';
    }
    ?>
</div><!-- .compare1_table-->
<?php } ?>

<?php echo $wanabet; ?>