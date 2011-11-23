<div class="compare4_graph">
    <?php Session::instance()->set('graph_allowed', true); ?>
    <img src="/graph?&u3=<?php echo microtime(); ?>" />
</div><!-- .compare4_graph-->

<?php

    function getPercentColor($p) {
        return $p ? ($p == 100 ? ' color3' : ($p > 50 ? ' color2' : '')) : ' color1';
    }
?>

    <div class="compare4_blocks">
        <div class="one_block inline">
            <div class="block_title"><?php echo $text['psy_profile']; ?></div>
        <?php
        $letters = array('', 'st', 'ha', 'la', 'fr', 'so', 'no');
        foreach ($percents as $i => $p) {
            $color = getPercentColor($p);
            $t = $letters[$i];
            $p = ($p == 100 ? 'MAX' : $p . '%');
            echo '<div class="block_line' . $color . '">';
            echo '<div class="line_name inline">' . $sonic['types'][$t] . '<div class="line_count">' . $p . '</div></div>';
            echo '<div class="line_progress inline"><div class="in" style="width: ' . $p . ';"></div></div>';
            echo '</div>';
        }
        ?>
    </div><!-- .one_block-->
</div>

<?php for ($i = 1; $i <= 4; $i++) { ?>
            <div class="compare3_text">
                <div class="h3"><?php echo $text['titles'][$i - 1]; ?></div>
                <p><?php echo $portret[$i - 1]; ?></p>
                <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
            </div><!-- .compare3_text -->
<?php } ?>

        <div class="compare3_text">
            <div class="h3"><?php echo $text['titles'][4]; ?></div>
            <p><?php echo $text['hidden_block']; ?></p>
            <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
        </div><!-- .compare3_text -->

<?php for ($i = 6; $i <= 11; $i++) { ?>
            <div class="compare3_text">
                <div class="h3"><?php echo $text['titles'][$i - 1]; ?></div>
                <p><?php echo $portret[$i - 2]; ?></p>
                <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
            </div><!-- .compare3_text -->
<?php } ?>