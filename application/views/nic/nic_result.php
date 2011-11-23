<div class="compare3_data">
    <img class="left_char" src="<?php echo $img; ?>" />

    <div class="compare3_text">
        <div class="h3"><?php echo $text['titles'][0]; ?><?php echo $typeName; ?></div>
        <p><?php echo $typeTexts[0]; ?></p>
    </div><!-- .compare3_text -->

    <?php for ($i = 1; $i <= 5; $i++) { ?>
        <div class="compare3_text">
            <div class="h3"><?php echo $text['titles'][$i]; ?></div>
            <img src="<?php echo $text['images'][$i]; ?>" />
            <p><?php echo $typeTexts[$i]; ?></p>
            <div class="go_up"><a href="#"><?php echo $text['up']; ?></a></div>
        </div><!-- .compare3_text -->

<?php } ?>
</div>