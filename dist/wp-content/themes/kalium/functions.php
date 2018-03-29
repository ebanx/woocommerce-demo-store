<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

// Theme options and class loader
require_once get_template_directory() . '/inc/lib/smof/smof.php';

// Load classes
require_once get_template_directory() . '/inc/classes/kalium-main.php';


// Kalium instance
Kalium::instance();

// Core files
require_once locate_template( 'inc/laborator_functions.php' );
require_once locate_template( 'inc/laborator_actions.php' );
require_once locate_template( 'inc/laborator_filters.php' );
require_once locate_template( 'inc/laborator_portfolio.php' );
require_once locate_template( 'inc/laborator_woocommerce.php' );
require_once locate_template( 'inc/laborator_vc.php' );
require_once locate_template( 'inc/laborator_thumbnails.php' );

// Custom fields
require_once locate_template( 'inc/acf-fields.php' );

// Import Libraries
require_once kalium()->locateFile( 'inc/lib/dynamic_image_downsize.php' );
require_once kalium()->locateFile( 'inc/lib/acf-revslider-field.php' );
require_once kalium()->locateFile( 'inc/lib/class-tgm-plugin-activation.php' );
require_once kalium()->locateFile( 'inc/lib/laborator/laborator_custom_css.php' );
require_once kalium()->locateFile( 'inc/lib/laborator/typolab/typolab.php' );

// Admin Related Plugins
if ( is_admin() ) {
	require_once kalium()->locateFile( 'inc/lib/laborator/laborator-acf-grouped-metaboxes/laborator-acf-grouped-metaboxes.php' );
	require_once kalium()->locateFile( 'inc/lib/laborator/laborator-demo-content-importer/laborator_demo_content_importer.php' );
}

// Sidekick Configuration
define( 'SK_PRODUCT_ID', 454 );
define( 'SK_ENVATO_PARTNER', 'iZmD68ShqUyvu7HzjPWPTzxGSJeNLVxGnRXM/0Pqxv4=' );
define( 'SK_ENVATO_SECRET', 'RqjBt/YyaTOjDq+lKLWhL10sFCMCJciT9SPUKLBBmso=' );
