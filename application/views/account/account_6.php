<div class="center_block_title"><?php echo $helpText['title']; ?></div>

<?php
$iter3 = 1;
foreach($helpText['columns'] as $name => $punkts){
    $evr = $iter3==3 ? ' evr3' : '';
    echo '<div class="inline one_help_col'.$evr.'">';
    echo '<div class="help_col_title">'.$helpText['columns'][$name]['title'].'</div>';
    foreach($punkts as $punkt_name => $t){
        if($punkt_name == 'title') continue;
        echo '<div class="go_help" id="help_'.$name.'_'.$punkt_name.'">'.$helpText['columns'][$name][$punkt_name]['title'].'</div>';
    }
    echo '</div>';
    echo ' ';

    if($iter3==3){
        $iter3==1;
    } else {
        $iter3++;
    }
}

?>

<div class="flap_block closed" id="ask_for_help">
    <div class="p_title_1"><?php echo $text['p_title_1']; ?></div>
    <div class="flap_block_in">
        <div class="option_line text_line"><?php echo $text['text_line']; ?></div>
        <textarea></textarea>
        <div class="rs1_save"><?php echo $text['rs1_save']; ?></div>
        <div class="clear"></div>
    </div><!-- .flap_block_in-->
</div><!-- .flap_block-->