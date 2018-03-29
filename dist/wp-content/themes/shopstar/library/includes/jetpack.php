<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package shopstar
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function shopstar_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'shopstar_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function shopstar_jetpack_setup
add_action( 'after_setup_theme', 'shopstar_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function shopstar_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'library/template-parts/content' );
	}
} // end function shopstar_infinite_scroll_render
