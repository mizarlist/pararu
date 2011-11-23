<div class="center_block_title"><?php echo $text['center_block_title']; ?></div>

<div class="compare2_table">
    <?php
    foreach ($cards['names'] as $index => $txt) {
        $card = $cards['card_' . $index];
        $txt = str_replace('<br/>', ' ', $txt);
        echo '<div class="one_line c2_img' . $index . '">';
        echo '<div class="one_line_in" id="card_rs_img' . $index . '"><i></i>';
        echo '<div class="title">' . Plussia_Help::mb_ucfirst($txt) . '</div>';
        echo '<div class="descr"><ul>';
        if ($current['card_' . $index]) {
            foreach ($current['card_' . $index] as $vind) {
                if ($vind) {
                    echo '<li>' . $card[$vind] . '</li>';
                }
            }
        } else {
            echo '<li class="red">' . $text['not_filled'] . '</li>';
        }
        echo '</ul></div>';
        echo '<div class="show_more">' . $text['edit'] . '</div>';
        echo '</div>';
        echo '</div><!-- .one_line -->';
    }
    ?>
</div><!-- .compare2_table -->

<div style="display: none;">
    <div class="rs1_box rs1_box1 rs1_new_box">
        <div class="close_rs1_box"></div>
        <div class="rs_box_title"><?php echo $text['rs_box_title']; ?></div>
        <div id="rs1_var_list"></div>
        <div class="clear"></div>
        <div class="rs1_save rs1_not_save"><?php echo $text['rs1_not_save']; ?></div>
    </div>
</div>

<script>
<?php
    $result = array();
    if (isset($cards) && is_array($cards)) {
        $result = array(new stdClass());
        for ($ck = 1; $ck <= 12; $ck++) {
            $card = $cards['card_' . $ck];
            $ans_card = array();
            foreach ($card as $id_variant => $variant) {
                $checked = isset($current['card_' . $ck]) && in_array(intval($id_variant), $current['card_' . $ck]);
                $ans_card[$id_variant . ''] = array('text' => $variant, 'checked' => $checked);
            }
            $result[$ck] = $ans_card;
        }
    }
?>
    var reg_step1_variants = <?php echo json_encode($result); ?>;
    var translation = new Array();
    translation[0] = '<?php echo $text['translation'][0]; ?>';
    translation[1] = '<?php echo $text['translation'][1]; ?>';
    translation[2] = '<?php echo $text['translation'][2]; ?>';
    translation[3] = '<?php echo $text['translation'][3]; ?>';
    var emptyMsg = '<?php echo $text['emptyMsg']; ?>';
</script>