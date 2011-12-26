<div class="page_complete">
    <div id="user_complete">
        <div class="complete_txt"><?php echo $text['page_complete']; ?><?php echo $pagecomplete['value']; ?>%</div>
        <div class="complete_bar" style="width: <?php echo $pagecomplete['value']; ?>%;"></div>
    </div>
    <div id="user_complete_help">   
    </div>

    <div id="user_complete_help_block">
        <div class="title"><?php echo $text['title']; ?></div>
        <div class="text"><?php echo $text['text']; ?></div>

        <ul>
            <?php
            for($i=0; $i<4; $i++) {
               echo '<li'.($pagecomplete['punkts'][$i] ? ' class="active"' : '').'>'.$text['punkts'][$i].'</li>';
            }
            ?>
        </ul>
        <div class="close"></div>
    </div>

</div><!-- .page_complete-->