<?php
$output = array();
extract(shortcode_atts(array(
	'animation'			=>'fadeIn',
	'animation_timing'	=>'linear',
	'animation_duration'=>'1000',
	'animation_delay'	=>'',
	'css'				=>'',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));

wp_enqueue_script('appear');

$class          = !empty($el_class) ? 'animate-box '.esc_attr( $el_class ) : 'animate-box';
$class .= ' '.vc_shortcode_custom_css_class($css,' ');
$class .= dh_visibility_class($visibility);

$inline_style='';
$data_animation = '';
if(!empty($animation)){
	$data_animation = 'data-animate="1"';
	$class .=' animated '.$animation.' '.$animation_timing;
	$inline_style = "style=\"-webkit-animation-duration:".$animation_duration."ms;animation-duration:".$animation_duration."ms; -webkit-animation-delay:".$animation_delay."ms;animation-delay:".$animation_delay."ms\"";
}

!empty($class) ? $class = 'class="'.$class.'"' : '';

$output []= "<div {$class} {$data_animation} {$inline_style}>" . wpb_js_remove_wpautop( $content ) . "</div>";
echo implode("\n",$output);
