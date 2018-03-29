<?php
global $dh_testimonial_columns;
$output = '';
extract(shortcode_atts(array(
	'background_transparent'=>'',
	'color'					=>'',
	'columns'				=>'1',
	'style'                 =>'style-1',
	'hide_pagination'   =>'',
	'fx'					=>'scroll',
	'visibility'			=>'',
	'el_class'				=>'',
), $atts));
$dh_testimonial_columns = $columns;
$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class($visibility);
$el_class .= $style;
/**
 * script
 * {{
 */
wp_enqueue_script('carouFredSel');
$color = dh_format_color($color);
$output .='<div class="testimonial '.(!empty($background_transparent)?' bg-transparent':'').$el_class.'">';
$output .='<div class="caroufredsel" data-height="variable" data-visible-min="1" data-visible-max="3" data-scroll-fx="'.$fx.'"  data-speed="5000" data-responsive="1" data-infinite="1" data-autoplay="0">';
$output .='<div class="caroufredsel-wrap">';
$output .='<ul class="caroufredsel-items"'.(!empty($color) ? ' style="color:'.$color.'"':'').'>';
$output .= wpb_js_remove_wpautop( $content );
$output .='</ul>';
$output .='</div>';
if(empty($hide_pagination)){
	$output .='<div class="caroufredsel-pagination">';
	$output .='</div>';
}
$output .='</div>';
$output .='</div>';
echo $output;
