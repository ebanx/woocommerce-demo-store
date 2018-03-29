<?php
$output ='';
extract(shortcode_atts(array(
	'style'				=>'default',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));

$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class($visibility);

// Extract tab titles
preg_match_all( '/dh_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();

if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}
$output .='<div class="tabbable tabs-'.$style.' '.$el_class.'">';
$tabs_nav = '';
$tabs_nav .= '<ul class="nav nav-tabs" role="tablist">';
$i = 0;
global $tab_active;
$tab_active = '';
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts($tab[0]);
	if($i == 0 && empty($tab_active)){
		$tab_active =  ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) );
	}
	$tabs_nav .= '<li'.($i == 0 ? ' class="active"':'').'><a href="#' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '" role="tab" data-toggle="tab">' . ( isset( $tab_atts['icon']) && !empty($tab_atts['icon']) ? '<i class="'.esc_attr($tab_atts['icon']).'"></i>' : '' ) . '' . $tab_atts['title'] . '</a></li>';
	$i++;
}
$tabs_nav .= '</ul>';
$output .= $tabs_nav;
$output .='<div class="tab-content">';
$output .= wpb_js_remove_wpautop( $content );
$output .='</div>';
$output .='</div>';
echo $output;