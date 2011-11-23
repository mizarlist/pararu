<div class="curr_compare_title"><?php echo $text['title']; ?> </div>
<div class="compare1_info compare2_info">
    <div class="life"><?php echo $text['compare_info1']; ?> <?php echo $allcount; ?></div>
    <div class="life_count"><?php echo $text['compare_info2']; ?> <span><?php echo $procent; ?>%</span> (<?php echo $text['from']; ?> <?php echo $allprocent; ?>%)</div>
    <div id="show_top_percent_compare">+<?php echo $procent; ?> %</div>
</div><!-- .compare1_info-->

<div id="compare2_list">
    <?php
    for ($i = 1; $i <= 12; $i++) {
        echo '<div class="rs1_img' . (in_array($i, $card_with_eq) ? '' : ' bw') . '" id="rs_img' . $i . '"><span>' . $cards['names'][$i] . '</span></div>';
    }
    ?>
</div>

<div class="compare2_table">
    <?php
    if (count($equalCards)) {
        foreach ($equalCards as $i => $params) {
            echo '<div class="one_line c2_img' . $i . '">';
            echo '<div class="one_line_in" id="card_rs_img' . $i . '"><i></i>';

            echo '<div class="title">' . $params['name'] . ' (' . $params['num'] . ' ' . $text['equals'][$params['num']-1] . ')</div>';
            echo '<div class="descr">' . $params['equals'] . '</div>';
            echo '<div class="show_more">' . $text['show_more'] . '</div>';

            echo '</div>';
            echo '</div><!-- .one_line -->';
        }
    } else {
        echo $text['no_eq'];
    }
    ?>
</div><!-- .compare2_table -->

<?php echo $wanabet; ?>