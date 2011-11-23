<div class="curr_compare_title"><?php echo $text['curr_compare_title']; ?>  </div>
<div class="compare1_info compare4_info">
    <div class="life_count"><?php echo $text['life_count']; ?> <span><?php echo $percent; ?>%</span> (<?php echo $text['from']; ?> <?php echo $allprocent; ?>%)</div>
    <div id="show_top_percent_compare">+<?php echo $percent; ?> %</div>
</div><!-- .compare4_blocks-->

<div class="compare4_graph">
    <?php Session::instance()->set('graphic_allowed', true); ?>
    <img src="/graphic?u1=<?php echo $uid1; ?>&u2=<?php echo $uid2; ?>&u3=<?php echo microtime(); ?>" />
</div><!-- .compare4_graph-->

<?php
function getPercentColor($p) {
    return $p ? ($p == 100 ? ' color3' : ($p > 50 ? ' color2' : '')) : ' color1';
}
?>

<div class="compare4_blocks">
    <div class="one_block inline">
        <div class="block_title"><?php echo $text['block_title'][0]; ?><div class="block_count<?php echo getPercentColor($percents['c_like']); ?>"><?php echo $percents['c_like']; ?>%</div></div>
        <?php
        foreach ($c_like as $t => $p) {
            $color = getPercentColor($p);
            $p = ($p==100 ? 'MAX' : $p.'%');
            echo '<div class="block_line' . $color . '">';
            echo '<div class="line_name inline">' . $sonic['types'][$t] . '<div class="line_count">' . $p . '</div></div>';
            echo '<div class="line_progress inline"><div class="in" style="width: ' . $p . ';"></div></div>';
            echo '</div>';
        }
        ?>
    </div><!-- .one_block-->

    <div class="one_block inline evr2">
        <div class="block_title"><?php echo $text['block_title'][1]; ?><div class="block_count<?php echo getPercentColor($percents['c_diff']); ?>"><?php echo $percents['c_diff']; ?>%</div></div>

        <?php
        foreach ($c_diff as $t => $p) {
            $color = getPercentColor($p);
            $p = ($p==100 ? 'MAX' : $p.'%');
            echo '<div class="block_line' . $color . '">';
            echo '<div class="line_name inline">' . $sonic['types'][$t] . '<div class="line_count">' . $p . '</div></div>';
            echo '<div class="line_progress inline"><div class="in" style="width: ' . $p . ';"></div></div>';
            echo '</div>';
        }
        ?>
    </div><!-- .one_block-->

    <div class="one_block inline">
        <div class="block_title"><?php echo $text['block_title'][2]; ?><div class="block_count<?php echo getPercentColor($percents['c_user_sputnik']); ?>"><?php echo $percents['c_user_sputnik']; ?>%</div></div>

        <?php
        foreach ($c_user_sputnik as $t => $p) {
            $color = getPercentColor($p);
            $p = ($p==100 ? 'MAX' : $p.'%');
            echo '<div class="block_line' . $color . '">';
            echo '<div class="line_name inline">' . $sonic['types'][$t] . '<div class="line_count">' . $p . '</div></div>';
            echo '<div class="line_progress inline"><div class="in" style="width: ' . $p . ';"></div></div>';
            echo '</div>';
        }
        ?>
    </div><!-- .one_block-->

    <div class="one_block inline evr2">
        <div class="block_title"><?php echo $text['block_title'][3]; ?><div class="block_count<?php echo getPercentColor($percents['c_sputnik_user']); ?>"><?php echo $percents['c_sputnik_user']; ?>%</div></div>

        <?php
        foreach ($c_sputnik_user as $t => $p) {
            $color = getPercentColor($p);
            $p = ($p==100 ? 'MAX' : $p.'%');
            echo '<div class="block_line' . $color . '">';
            echo '<div class="line_name inline">' . $sonic['types'][$t] . '<div class="line_count">' . $p . '</div></div>';
            echo '<div class="line_progress inline"><div class="in" style="width: ' . $p . ';"></div></div>';
            echo '</div>';
        }
        ?>
    </div><!-- .one_block-->

</div>	<!-- .compare4_blocks-->

<?php echo $wanabet; ?>