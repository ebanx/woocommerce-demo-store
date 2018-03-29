<?php
/**
 * Functions used to implement options
 *
 * @package Customizer Library Demo
 */

/**
 * Enqueue Google Fonts Example
 */
function shopstar_customizer_theme_fonts() {

	// Font options
	$fonts = array(
		get_theme_mod( 'shopstar-site-title-font', customizer_library_get_default( 'shopstar-site-title-font' ) ),
		get_theme_mod( 'shopstar-body-font', customizer_library_get_default( 'shopstar-body-font' ) ),
		get_theme_mod( 'shopstar-heading-font', customizer_library_get_default( 'shopstar-heading-font' ) )
	);

	$font_uri = customizer_library_get_google_font_uri( $fonts );

	// Load Google Fonts
	wp_enqueue_style( 'shopstar_customizer_theme_fonts', $font_uri, array(), null, 'screen' );

}
add_action( 'wp_enqueue_scripts', 'shopstar_customizer_theme_fonts' );