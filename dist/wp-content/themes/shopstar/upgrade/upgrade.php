<?php
/**
 * Functions for users wanting to upgrade to premium
 *
 * @package shopstar
 */

/**
 * Display the upgrade to Premium page & load styles.
 */
function shopstar_premium_admin_menu() {
    global $shopstar_upgrade_page;
    $shopstar_upgrade_page = add_theme_page(
    	__( 'Shopstar! Premium', 'shopstar' ),
    	'<span class="premium-link" style="">'. __( 'Shopstar! Premium', 'shopstar' ) .'</span>',
    	'edit_theme_options',
    	'premium_upgrade',
    	'shopstar_render_upgrade_page'
	);
}
add_action( 'admin_menu', 'shopstar_premium_admin_menu' );

/**
 * Enqueue admin stylesheet only on upgrade page.
 */
function shopstar_load_upgrade_page_scripts( $hook ) {
    global $shopstar_upgrade_page;
    if ( $hook != $shopstar_upgrade_page ) {
		return;
    }
    
    wp_enqueue_style( 'shopstar-upgrade-body-font-default', '//fonts.googleapis.com/css?family=Lato:400,400italic', array(), SHOPSTAR_THEME_VERSION );
    wp_enqueue_style( 'shopstar-upgrade-heading-font-default', '//fonts.googleapis.com/css?family=Montserrat:700', array(), SHOPSTAR_THEME_VERSION );
    wp_enqueue_style( 'shopstar-upgrade', get_template_directory_uri() .'/upgrade/library/css/upgrade.css', array(), SHOPSTAR_THEME_VERSION );
    wp_enqueue_style( 'shopstar-font-awesome', get_template_directory_uri().'/library/fonts/font-awesome/css/font-awesome.css', array(), '4.7.0' );
    wp_enqueue_script( 'shopstar-caroufredsel-js', get_template_directory_uri() .'/library/js/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), SHOPSTAR_THEME_VERSION, true );
    wp_enqueue_script( 'shopstar-upgrade-custom-js', get_template_directory_uri() .'/upgrade/library/js/upgrade.js', array( 'jquery' ), SHOPSTAR_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'shopstar_load_upgrade_page_scripts' );

/**
 * Render the premium upgrade/order page
 */
function shopstar_render_upgrade_page() {

	if ( isset( $_GET['action'] ) ) {
		$action = $_GET['action'];
	} else {
		$action = 'view-page';
	}

	switch ( $action ) {
		case 'view-page':
			get_template_part( 'upgrade/library/template-parts/content', 'upgrade' );
			break;
	}
}
