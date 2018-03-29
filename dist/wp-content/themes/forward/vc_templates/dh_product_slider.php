<?php
$output = '';
extract(shortcode_atts(array(
	'title'				=>'',
	'title_color'		=>'',
	'fx'				=>'',
	'scroll_item'		=>'',
	'scroll_speed'		=>'',
	'easing'			=>'',
	'no_padding'		=>'',
	'auto_play'			=>'',
	'hide_pagination'	=>'',
	'hide_control'		=>'',
	'control_position'	=>'default',
	'css'				=>'',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));
$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= ' '.vc_shortcode_custom_css_class($css,' ');
$el_class .= ' nav-position-'.$control_position.' ';
$el_class .= dh_visibility_class($visibility);
/**
 * script
 * {{
 */
wp_enqueue_script('carouFredSel');
$output .='<div class="caroufredsel product-slider'.(!empty($no_padding) ? ' caroufredsel-item-no-padding':'').$el_class.'" data-scroll-fx="'.$fx.'" data-speed="'.$scroll_speed.'" data-easing="'.$easing.'" data-height="variable" data-visible-min="1" data-scroll-item="'.$scroll_item.'" data-responsive="1" data-infinite="1" data-autoplay="'.(!empty($auto_play)?'1':'0').'">';
$output .= !empty($title) ? '<div class="product-slider-title color-'.$title_color.'"><h3 class="el-heading">'.$title.'</h3></div>':'';
$output .='<div class="caroufredsel-wrap">';
$output .= wpb_js_remove_wpautop( $content );
if(empty($hide_control)){
	$output .='<a href="#" class="caroufredsel-prev"></a>';
	$output .='<a href="#" class="caroufredsel-next"></a>';
}
$output .='</div>';
if(empty($hide_pagination)){
	$output .='<div class="caroufredsel-pagination">';
	$output .='</div>';
}
$output .='</div>';
echo $output;