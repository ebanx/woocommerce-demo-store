<?php
$output = '';
extract(shortcode_atts(array(
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));

$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
switch ($visibility) {
	case 'hidden-phone':
		$el_class .= ' hidden-xs';
		break;
	case 'hidden-tablet':
		$el_class .= ' hidden-sm hidden-md';
		break;
	case 'hidden-pc':
		$el_class .= ' hidden-lg';
		break;
	case 'visible-phone':
		$el_class .= ' visible-xs-inline';
		break;
	case 'visible-tablet':
		$el_class .= ' visible-sm-inline visible-md-inline';
		break;
	case 'visible-pc':
		$el_class .= ' visible-lg-inline';
		break;
}

$columns = explode("[dh_pricing_table_item", $content);
$count = count($columns);
$count = $count - 1;

$output .='<div class="pricing-table pricing-'.$count.'-column'.$el_class.'">';
$output .= wpb_js_remove_wpautop($content);
$output .='</div>';
echo $output;