<div class="sputnik_name"><?php echo $sputnik_name; ?></div>
<?php
if (false && $last_status) {
    echo '<div class="sputnik_status">
                            <div class="view">' . $last_status->text . '<span>' . $last_status->time . ' ' . $broad['time_specs'][$last_status->time_spec] . '. ' . $text['ago'] . '</span></div>
                            <div class="edit"></div>
                        </div><!-- .sputnik_status-->';
}
?>

<div class="sputnik_about">
    <?php
    foreach ($about_user['fields'] as $k => $f) {
        echo '<div class="one_line"><b>' . $f . ':</b> ' . $about_user['values'][$k] . '</div>';
    }
    ?>
</div><!-- .sputnik_about-->

<?php echo $somephoto; ?>

<div class="sputnik_last_present">
    <div class="fill_lp"></div>
    <img src="<?php echo $lastgift; ?>" />
    <br/><?php echo $text['lastgift']; ?>
</div>

<div class="sputnik_small_presents">
    <div class="p_title_1"><?php echo $text['gifts']; ?>
        <div class="sub_p_title_1">
            <?php echo $text['gifts_subtitle']; ?> »
        </div>
    </div>
    <?php
            $count = count($gifts);
            foreach ($gifts as $g) {
                $postfix = --$count ? '' : ' last';
                echo '<div class="one_present inline' . $postfix . '" style="background-image: url(' . $g . ');"></div>';
            }
    ?>
        </div>
<?php if ($is_sputnik_page) {?>
                <?php echo $wanabet; ?>
<?php } ?>