<div class="center_block_title"><?php echo $text['center_block_title']; ?></div>

<?php foreach ($user_data['assoc'] as $punkt_name => $variants) {
?>

    <div class="flap_block closed" id="<?php echo $punkt_name; ?>_flap">

        <div class="p_title_1"><?php echo $user_data['meta'][$punkt_name]['print']; ?>
        <?php
        $type = $user_data['meta'][$punkt_name]['type'];
        $current = $current_data->$punkt_name;
        if ($type == 'radio_group') {
            $cvalues = $current!==null ? array($current) : array();
        } else {
            $cvalues = $current ? explode(';', $current) : array();
            array_shift($cvalues);
            array_splice($cvalues, count($cvalues) - 1, 1);
        }
        ?>
        <div class="p_title_add"><?php
        $inc = $user_data['meta'][$punkt_name]['other'] == 'true' ? 1 : 0;
        $incid = $user_data['meta'][$punkt_name]['other'] == 'true' ? 0 : 1;
        $title_text = ($type == 'radio_group' && isset($cvalues[0])) ? $user_data['assoc'][$punkt_name][$cvalues[0]-$incid] : '';
        $title_text = strlen($title_text) > 30 ? mb_substr($title_text, 0, 30) : $title_text;
        echo $title_text;
        ?></div>
    </div>
    <div class="flap_block_in">
        <div class="option_line">
            <div class="<?php echo $type . ' cols' . $user_data['meta'][$punkt_name]['cols']; ?>">

                <?php
                for ($i = $inc; $i < count($variants); $i++) {
                    $index = $i + $incid;
                    $active = in_array($index, $cvalues) ? ' active' : '';
                    echo '<div class="p_checkbox' . $active . '" id="' . $punkt_name . '_' . $index . '">' . $variants[$i] . '</div>';
                }
                if ($inc) {
                    $active = in_array(0, $cvalues) ? ' active' : '';
                    echo '<div class="p_checkbox' . $active . '" id="' . $punkt_name . '_' . '0">' . $variants[0] . '</div>';
                }
                ?>

            </div><!-- .option_line--></div><!-- .radio_group-->

        <div class="save_block_changes"><span><?php echo $text['save_btn']; ?></span></div>

    </div><!-- .flap_block_in--></div><!-- .flap_block-->

<?php } ?>