<div class="curr_compare_title"><?php echo $text["curr_compare_title"]; ?> </div>
<div class="compare1_info">
    <!-- <div class="life">Cовпадений во взглядах на жизнь 5:  +2,3%;</div> -->
    <div class="life">
        <?php echo $karma; ?>
    </div><!-- .life-->
    <div class="life_count"><?php echo $text['compareable']; ?> <span><?php echo $procent; ?>%</span> (<?php echo $text['from']; ?> <?php echo $allprocent; ?>%)</div>
    <div id="show_top_percent_compare">+<?php echo $procent; ?> %</div>
</div><!-- .compare1_info-->

<?php if (count($userTable['left'])) {
?>
            <div class="compare1_table">
                <div class="title_l"><?php echo $text['t_headers_1'][0]; ?></div>
                <div class="title_r"><?php echo $text['t_headers_1'][1]; ?></div>
                <div class="clear"></div>

    <?php
            foreach ($userTable['left'] as $i => $v) {
                echo '<div class="compare_line top_cut' . ($userEq[$i] ? ' active' : '') . '">';
                echo '<div class="compare_left">';
                echo '<span class="name">' . $userHeaders[$i] . ':</span><i>' . $userTable['left'][$i] . '</i>';
                echo '</div>';
                echo '<div class="compare_right">';
                echo '<span class="name">' . $userHeaders[$i] . ':</span><i>' . $userTable['right'][$i] . '</i>';
                echo '</div>';
                echo '</div><!-- .compare_line-->';
            }
    ?>

        </div><!-- .compare1_table-->

<?php
        } else {
            echo $text['no_spdata_1'];
        }
?>

<?php if (count($sputnikTable['left'])) {
?>
            <div class="compare1_table">
                <div class="title_l"><?php echo $text['t_headers_2'][0]; ?></div>
                <div class="title_r"><?php echo $text['t_headers_2'][1]; ?></div>
                <div class="clear"></div>

    <?php
            foreach ($sputnikTable['left'] as $i => $v) {
                echo '<div class="compare_line top_cut' . ($sputnikEq[$i] ? ' active' : '') . '">';
                echo '<div class="compare_left">';
                echo '<span class="name">' . $sputnikHeaders[$i] . ':</span><i>' . $sputnikTable['left'][$i] . '</i>';
                echo '</div>';
                echo '<div class="compare_right">';
                echo '<span class="name">' . $sputnikHeaders[$i] . ':</span><i>' . $sputnikTable['right'][$i] . '</i>';
                echo '</div>';
                echo '</div><!-- .compare_line-->';
            }
    ?>

        </div><!-- .compare1_table-->

<?php
        } else {
            echo $text['no_spdata_2'];
        }
?>

<?php echo $wanabet; ?>