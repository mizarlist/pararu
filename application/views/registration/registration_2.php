<?php
if(!isset($cards_only) || !$cards_only) {
    echo '<div class="step_title">'.$name.$text['step_title'][1].'</div>
            <div id="register_step2">
            <div id="register_step2_cards">';
}
?>

<?php
$iter = 1;
$count = count($sputniks);
foreach($sputniks as $sputnik) {
    $last = $count == $iter ? 'last' : '';
    $os = $sputnik['on_site'];
    $on_site = $os=='0' ? $intervals[$os].' '.$text['be'][2] : $text['be'][$sputnik['is_woman']].$text['be'][2].' '.$intervals[$os];

    $ulhtml = '';
  	$ulhtml_len = count($sputnik['card']);
  	$ul_i = 0;
    foreach($sputnik['card'] as $card_id) {
    	$zapataya = ($ul_i == $ulhtml_len - 1) ? '' : ',';
        $ulhtml .= '<li>'.$cards[$sputnik['card_name']][$card_id].$zapataya.'</li>';
        $ul_i++;
    }

    $stars = '';
    for($i=1; $i<=5; $i++){
        if($sputnik['zodiac_harmony']<$i && $sputnik['zodiac_harmony']>$i-1){
           $stars .= '<div class="one_star star05"></div>';
        } else if($sputnik['zodiac_harmony']>=$i){
           $stars .= '<div class="one_star star1"></div>';
        } else if($sputnik['zodiac_harmony']<$i){
           $stars .= '<div class="one_star star0"></div>';
        }
    }

    echo '<div class="one_quick_card '.$last.'" id="one_quick_card_id'.$sputnik['user_id'].'">
        <div class="photo">
        	<a href="'.$sputnik['photo_full_link'].'" class="zoom_in"></a>
            <img src="'.$sputnik['photo_link'].'" />
        </div><!-- .photo-->
        <div class="text">
            <div class="card_name">'.$sputnik['name'].'</div>
            <div class="card_location">'.$sputnik['location'].' • '.$on_site.'</div>
            <div class="card_user_love"><div class="card_user_love_title">'.$text['card_user_love_title'].'</div>
                <ul>
                    '.$ulhtml.'
                    <li class="clear"></li>
                </ul>
            </div>
            <div class="card_user_goroskop">
                <div class="goroskop_title">Ваш гороскоп:</div>
                <div class="goroskop_you">*ваш знак - '.$zodiac[$sputnik['user_zodiac']].'</div>
                <div class="goroskop_stars">
                	'.$stars.'
                	<div class="clear"></div>
                </div>
                
                <div class="gor_znaks">
                	<div class="odin_znak znak'.$sputnik['user_zodiac'].'">'.$zodiac[$sputnik['user_zodiac']].'</div>
                	<div class="odin_znak znak_plus"></div>
                	<div class="odin_znak znak'.$sputnik['zodiac'].'">'.$zodiac[$sputnik['zodiac']].'</div>
                	<div class="clear"></div>
                </div>
                


                <div class="goroskop_ico"></div>
            </div>
            <div class="clear"></div>

            <div class="card_controls">'./*$text['card'][5]*/''.'  <span class="save_in_prof">'.$text['card'][6].'</span></div>
            </div><!-- .text-->
    </div><!-- .one_quick_card-->';
    $iter++;
}

?>

<?php
if(!isset($cards_only) || !$cards_only) {
    echo '</div><!-- #register_step2_cards-->';

    if($pages && $pages > 1) {
        echo '<div class="page_selector">
            <div class="title">'.$text['page'].'</div>
            <div class="pages_stiks" id="max_page_'.$pages.'"></div>
            </div>';
    }

    echo '<a href="/profile" class="register_create_page1">'.$text['register_create_page1'].'</a>
            <div class="register_go_next2" id="register_go_next2">'.$text['register_go_next2'].'</div>
            <div class="clear"></div>
            </div><!-- #register_step2-->
            
            <div id="right_col_load">
            	<div class="right_col_text">
<p>'.$text['right_col_text'][0].'<strong>'.$text['right_col_text'][1].'</strong>'.$text['right_col_text'][2].'</p>
<p>
'.$text['right_col_text'][3].'<strong>'.$text['right_col_text'][4].'</strong>'.$text['right_col_text'][5].'
</p>        	
            	</div>
	            <div class="register_go_next1" id="register_go_next1">'.$text['register_go_next1'].'</div>
	            <div class="register_baner">
	            	<div class="register_baner_title">'.$text['register_baner_title'].'</div>
	            	<div class="register_baner_close"></div>
	            	<div class="register_baner_img"><img src="/images/register/baner1.jpg" /></div>
	            </div>
	            
	        </div>
            
            ';
}
?>