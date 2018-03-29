<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = '';
$output = '';
// start: modified by Arlind (Deprecated)
$original_atts = $atts;
// end: modified by Arlind
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

// start: modified by Arlind (Deprecated)
$has_wow_class = false;
$reveal_effect = $reveal_duration = $reveal_delay = '';

if ( isset( $original_atts['reveal_effect'] ) != '' && $original_atts['reveal_effect'] != 'none' ) {
	$reveal_effect     = $original_atts['reveal_effect'];
	$reveal_duration   = isset( $original_atts['reveal_duration'] ) ? $original_atts['reveal_duration'] : '';
	$reveal_delay      = isset( $original_atts['reveal_delay'] ) ? $original_atts['reveal_delay'] : '';
	$has_wow_class = true;
	
}
// end: modified by Arlind

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
$output .= '<div class="vc_column-inner ' . esc_attr( trim( vc_shortcode_custom_css_class( $css ) ) ) . '">';
$output .= '<div class="wpb_wrapper' . ( $has_wow_class ? " wow {$reveal_effect}" : '' ) . '"' . lab_vc_reveal_effect_params( $reveal_effect, $reveal_duration, $reveal_delay ) . '>';
$output .= wpb_js_remove_wpautop( $content );
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
