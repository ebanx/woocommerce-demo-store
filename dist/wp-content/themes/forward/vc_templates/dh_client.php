<?php
$output = '';
extract(shortcode_atts(array(
	'images'			=>'',
	'custom_links'		=>'',
	'display'			=>'slider',
	'visible'			=>'2',
	'style'				=>'normal',
	'hide_pagination'   =>'',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));

$show_pagination = empty($hide_pagination)  ? true : false;

$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class ($visibility);

$custom_links = explode( ',', $custom_links );
if ( $images == '' ) $images = '-1,-2,-3';


$images = explode( ',', $images );
$output .= '<div class="client client-'.$display.$el_class.'">';
if($display == 'slider'){
	/**
	 * script
	 * {{
	 */
	wp_enqueue_script('carouFredSel');
	$output .='<div class="caroufredsel" data-height="variable" data-visible-min="1" data-visible-max="'.$visible.'" data-responsive="1" data-infinite="1" data-autoplay="1" data-speed="15000">';
	$output .='<div class="caroufredsel-wrap">';
	$output .='<ul class="caroufredsel-items row">';
	$i=0;
	foreach ( $images as $attach_id ):
		
		if ( $attach_id > 0 ) {
			$attach = wp_get_attachment_url($attach_id);
		} else {
			$attach = vc_asset_url( 'vc/no_image.png' );
		}
		$attach_src = $attach;
		$output .='<li class="caroufredsel-item col-md-'.(12/$visible).'">';
		if(isset( $custom_links[$i] ) && $custom_links[$i] != '' ){
			$output .='<a target="_blank" href="'.esc_url($custom_links[$i]).'">';
		}
		$output .='<img alt="'.$attach_id.'" src="'.$attach_src.'" '.($style == 'grayscale'?' class="grayscale"':'').'>';
		if(isset( $custom_links[$i] ) && $custom_links[$i] != '' ){
			$output .='</a>';
		}
		$output .='</li>';
		$i++;
	endforeach;
	$output .='</ul>';
	$output .='<a href="#" class="caroufredsel-prev"></a>';
	$output .='<a href="#" class="caroufredsel-next"></a>';
	$output .='</div>';
	if($show_pagination == 'true') {
		$output .='<div class="caroufredsel-pagination">';
		$output .='</div>';
	}
	$output .='</div>';
}else{
	$r = 0;
	$i = 0;
	foreach ( $images as $attach_id ):
		if ( $attach_id > 0 ) {
			$attach = wp_get_attachment_url($attach_id);
		} else {
			$attach = vc_asset_url( 'vc/no_image.png' );
		}
		$attach_src = $attach;
		if ($r++ % $visible == 0):
			$output .='<div class="row">';
		endif;
		$output .='<div class="col-md-'.(12/$visible).' col-sm-6">';
		$output .='<div class="client-item">';
		if(isset( $custom_links[$i] ) && $custom_links[$i] != '' ){
			$output .='<a target="_blank" href="'.esc_url($custom_links[$i]).'">';
		}
		$output .='<img alt="'.$attach_id.'" src="'.$attach_src.'" '.($style == 'grayscale'?' class="grayscale"':'').'>';
		if(isset( $custom_links[$i] ) && $custom_links[$i] != '' ){
			$output .='</a>';
		}
		$output .='</div>';
		$output .='</div>';
		if ($r % $visible == 0 || $r == count($images)):
			$output .='</div>';
		endif;
		$i++;
	endforeach;
}
$output .= '</div>';
echo $output;