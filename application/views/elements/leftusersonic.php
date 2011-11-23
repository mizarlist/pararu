<div class="left_user_sonic">
    <div class="p_title_1"><?php echo $text["p_title_1"]; ?><sup>®</sup></div>
    <?php //$card_number - номер карточки ?>
    <div class="sub_decription"><?php echo $text["p_titles"][$card_number]; ?></div>
    
    <?php

    foreach($cards['card_'.$card_number] as $id_variant => $variant){
        echo '<div class="p_checkbox max5sonic" id="'.'card_'.$card_number.'_'.$id_variant.'">'.$variant.'</div>';
    }

    ?>

    <div class="rs1_save"><?php echo $text["rs1_save"]; ?><i></i></div>
    <div class="hide_sonic"><?php echo $text["hide_sonic"]; ?></div>
    <div class="full_sonic"><a href="/nic"><?php echo $text["full_sonic"]; ?></a></div>
    <div class="clear"></div>
</div><!-- .left_user_sonic-->