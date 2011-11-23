<div class="center_block_title"><?php echo $text['wellcome']; ?></div>

<?php if(!$count) { ?>
<div class="last_news_descr"><?php echo $text['empty']; ?></div>
<?php } ?>

<div id="one_last_profiles">
<?php echo $user_blocks; ?>
</div>


<?php if ($max_pages > 1) {?>
        <div class="page_selector">
            <div class="title"><?php echo $text['page']; ?>:</div>
            <div class="pages_stiks" id="max_page_<?php echo $max_pages; ?>">
                <div id="current_page" class="current_page_<?php echo $curPage; ?>"></div>
            </div>
        </div>
<?php } ?>