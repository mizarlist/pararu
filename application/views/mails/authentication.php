<?php echo $text['inmail']; ?>
<br />
<a href="<?php echo $link; ?>"><?php echo isset($text['link_text']) ? $text['link_text'] : 'http:'.$link; ?></a>
<br />
<?php echo $text['or'].'http:'.$link; ?>
