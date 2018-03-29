<?php
/**
 * shopstar functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package shopstar
 */
define( 'SHOPSTAR_THEME_VERSION' , '1.0.23' );

if ( ! function_exists( 'shopstar_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function shopstar_setup() {
	
	$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,600,600italic,700,700italic' );
	add_editor_style( $font_url );
	
	$font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Raleway:100,300,400,500,600,700,800' );
	add_editor_style( $font_url );
	
	add_editor_style('editor-style.css');
	
	set_theme_mod( 'otb_shopstar_dot_org', true );
		
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on shopstar, use a find and replace
	 * to change 'shopstar' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'shopstar', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	*
	* @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	*/
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'shopstar_blog_img_side', 352, 230, true );
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'shopstar' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Setup Custom Logo Support for theme
	* Supported from WordPress version 4.5 onwards
	* More Info: https://make.wordpress.org/core/2016/03/10/custom-logo/
	*/
	if ( function_exists( 'has_custom_logo' ) ) {
		add_theme_support( 'custom-logo' );
	}
	
	// The custom header is used for the logo
	add_theme_support( 'custom-header', array(
		'default-image' => esc_url( get_template_directory_uri() ) . '/library/images/headers/default.jpg',
		'width'         => 1680,
		'height'        => 600,
		'flex-width'    => true,
		'flex-height'   => true,
		'header-text'   => false,
	) );	

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'shopstar_custom_background_args', array(
		'default-color' => 'FFFFFF',
		'default-image' => '',
	) ) );
	
	add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );
	
	if ( get_theme_mod( 'shopstar-woocommerce-product-image-zoom', true ) ) {	
		add_theme_support( 'wc-product-gallery-zoom' );
	}
		
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );	
}
endif; // shopstar_setup
add_action( 'after_setup_theme', 'shopstar_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shopstar_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shopstar_content_width', 640 );
}
add_action( 'after_setup_theme', 'shopstar_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shopstar_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'shopstar' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>'
	) );
	
	register_sidebar(array(
		'name' => __( 'Footer', 'shopstar' ),
		'id' => 'footer',
		'description' => ''
	));
}
add_action( 'widgets_init', 'shopstar_widgets_init' );

function shopstar_set_variables() {}
add_action('init', 'shopstar_set_variables', 10);

/**
 * Enqueue scripts and styles.
 */
function shopstar_scripts() {
	wp_enqueue_style( 'shopstar-site-title-font-default', '//fonts.googleapis.com/css?family=Prata:400', array(), SHOPSTAR_THEME_VERSION );
	wp_enqueue_style( 'shopstar-body-font-default', '//fonts.googleapis.com/css?family=Lato:300,300italic,400,400italic,600,600italic,700,700italic', array(), SHOPSTAR_THEME_VERSION );
	wp_enqueue_style( 'shopstar-heading-font-default', '//fonts.googleapis.com/css?family=Raleway:100,300,400,500,600,700,800', array(), SHOPSTAR_THEME_VERSION );

	if ( get_theme_mod( 'shopstar-header-layout', customizer_library_get_default( 'shopstar-header-layout' ) ) == 'shopstar-header-layout-centered' ) {
		wp_enqueue_style( 'shopstar-header-centered', get_template_directory_uri().'/library/css/header-centered.css', array(), SHOPSTAR_THEME_VERSION );
	} else {
		wp_enqueue_style( 'shopstar-header-left-aligned', get_template_directory_uri().'/library/css/header-left-aligned.css', array(), SHOPSTAR_THEME_VERSION );
	}
	
	wp_enqueue_style( 'shopstar-font-awesome', get_template_directory_uri().'/library/fonts/font-awesome/css/font-awesome.css', array(), '4.7.0' );
	wp_enqueue_style( 'shopstar-style', get_stylesheet_uri() );
	
	if ( shopstar_is_woocommerce_activated() ) {
		wp_enqueue_style( 'shopstar-woocommerce-custom', get_template_directory_uri().'/library/css/woocommerce-custom.css', array(), SHOPSTAR_THEME_VERSION );
	}
	
	wp_enqueue_script( 'shopstar-navigation-js', get_template_directory_uri() . '/library/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'shopstar-caroufredsel-js', get_template_directory_uri() . '/library/js/jquery.carouFredSel-6.2.1-packed.js', array('jquery'), SHOPSTAR_THEME_VERSION, true );
	wp_enqueue_script( 'shopstar-touchswipe-js', get_template_directory_uri() . '/library/js/jquery.touchSwipe.min.js', array('jquery'), SHOPSTAR_THEME_VERSION, true );
	wp_enqueue_script( 'shopstar-custom-js', get_template_directory_uri() . '/library/js/custom.js', array('jquery'), SHOPSTAR_THEME_VERSION, true );
	
	wp_enqueue_script( 'shopstar-skip-link-focus-fix-js', get_template_directory_uri() . '/library/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shopstar_scripts' );

// Recommended plugins installer
require_once get_template_directory() . '/library/includes/class-tgm-plugin-activation.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/library/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/library/includes/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/library/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/library/includes/jetpack.php';

// Helper library for the theme customizer.
require get_template_directory() . '/customizer/customizer-library/customizer-library.php';

// Define options for the theme customizer.
require get_template_directory() . '/customizer/customizer-options.php';

// Output inline styles based on theme customizer selections.
require get_template_directory() . '/customizer/styles.php';

// Additional filters and actions based on theme customizer selections.
require get_template_directory() . '/customizer/mods.php';

// Include TRT Customize Pro library
require_once( get_template_directory() . '/trt-customize-pro/class-customize.php' );

/**
 * Premium Upgrade Page
 */
include get_template_directory() . '/upgrade/upgrade.php';

/**
 * Enqueue shopstar custom customizer styling.
 */
function shopstar_load_customizer_script() {
	wp_enqueue_script( 'shopstar-customizer-custom-js', get_template_directory_uri() . '/customizer/customizer-library/js/customizer-custom.js', array('jquery'), SHOPSTAR_THEME_VERSION, true );
	wp_enqueue_style( 'shopstar-customizer', get_template_directory_uri() . '/customizer/customizer-library/css/customizer.css', array(), SHOPSTAR_THEME_VERSION );
}
add_action( 'customize_controls_enqueue_scripts', 'shopstar_load_customizer_script' );

if ( ! function_exists( 'shopstar_load_dynamic_css' ) ) :
	/**
	 * Add Dynamic CSS
	 */
	function shopstar_load_dynamic_css() {
		$shopstar_slider_has_min_width = get_theme_mod( 'shopstar-slider-has-min-width', customizer_library_get_default( 'shopstar-slider-has-min-width' ) );
		$shopstar_slider_min_width 	   = floatVal( get_theme_mod( 'shopstar-slider-min-width', customizer_library_get_default( 'shopstar-slider-min-width' ) ) );
	
		// Activate the mobile menu when on a mobile device
		if ( wp_is_mobile() ) {
			$mobile_menu_breakpoint = 10000000;
		} else {
			$mobile_menu_breakpoint = 960;
		}
		
		require get_template_directory() . '/library/includes/dynamic-css.php';
	}
endif;
add_action( 'wp_head', 'shopstar_load_dynamic_css' );

// Create function to check if WooCommerce exists.
if ( ! function_exists( 'shopstar_is_woocommerce_activated' ) ) :
	function shopstar_is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) {
			return true;
		} else {
			return false;
		}
	}
endif; // shopstar_is_woocommerce_activated

if ( shopstar_is_woocommerce_activated() ) {
	require get_template_directory() . '/library/includes/woocommerce-inc.php';
}

// Add CSS class to body by filter
function shopstar_add_body_class( $classes ) {
	
	if( wp_is_mobile() ) {
		$classes[] = 'mobile-device';
	}
	
	if ( get_theme_mod( 'shopstar-layout-woocommerce-shop-full-width', customizer_library_get_default( 'shopstar-layout-woocommerce-shop-full-width' ) ) ) {
		$classes[] = 'shopstar-shop-full-width';
	}

	if ( shopstar_is_woocommerce_activated() && is_woocommerce() ) {
		$is_woocommerce = true;
	} else {
		$is_woocommerce = false;
	}
	
	if ( $is_woocommerce && !is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'full-width';
	}	
	
	return $classes;
}
add_filter( 'body_class', 'shopstar_add_body_class' );

// Set the number or products per row
if (!function_exists('shopstar_loop_shop_columns')) {

	function shopstar_loop_shop_columns() {
		if ( get_theme_mod( 'shopstar-layout-woocommerce-shop-full-width', customizer_library_get_default( 'shopstar-layout-woocommerce-shop-full-width' ) ) || ! is_active_sidebar( 'sidebar-1' ) ) {
			return 4;
		} else {
			return 3;
		}
	}
	
}
add_filter('loop_shop_columns', 'shopstar_loop_shop_columns');

if (!function_exists('shopstar_woocommerce_product_thumbnails_columns')) {
	function shopstar_woocommerce_product_thumbnails_columns() {
		return 3;
	}
}
add_filter ( 'woocommerce_product_thumbnails_columns', 'shopstar_woocommerce_product_thumbnails_columns' );

function shopstar_excerpt_length( $length ) {
	return get_theme_mod( 'shopstar-blog-excerpt-length', customizer_library_get_default( 'shopstar-blog-excerpt-length' ) );
}
add_filter( 'excerpt_length', 'shopstar_excerpt_length', 999 );

function shopstar_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . wp_kses_post( get_theme_mod( 'shopstar-blog-read-more-text', customizer_library_get_default( 'shopstar-blog-read-more-text' ) ), 'shopstar' ) . '</a>';
}
add_filter( 'excerpt_more', 'shopstar_excerpt_more' );

/**
 * Adjust is_home query if shopstar-slider-categories is set
 */
function shopstar_set_blog_queries( $query ) {

	$slider_categories = get_theme_mod( 'shopstar-slider-categories' );
    $slider_type = get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) );
	
	if ( $slider_categories != '' && $slider_type == 'shopstar-slider-default' ) {
	
		$is_front_page = ( $query->get('page_id') == get_option('page_on_front') || is_front_page() );
	
		if ( count($slider_categories) > 0) {
			// do not alter the query on wp-admin pages and only alter it if it's the main query
			if ( !is_admin() && !$is_front_page  && $query->get('id') != 'slider' || !is_admin() && $is_front_page && $query->get('id') != 'slider' ){
				$query->set( 'category__not_in', $slider_categories );
			}
		}
	}

}
add_action( 'pre_get_posts', 'shopstar_set_blog_queries' );

function shopstar_filter_recent_posts_widget_parameters( $params ) {
	
	$slider_categories = get_theme_mod( 'shopstar-slider-categories' );
	$slider_type = get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) );
	
	if ( $slider_categories != '' && $slider_type == 'shopstar-slider-default' ) {
		if ( count($slider_categories) > 0) {
			// do not alter the query on wp-admin pages and only alter it if it's the main query
			$params['category__not_in'] = $slider_categories;
		}
	}
	
	return $params;
}
add_filter('widget_posts_args','shopstar_filter_recent_posts_widget_parameters');

/**
 * Adjust the widget categories query if shopstar-slider-categories is set
*/
function shopstar_set_widget_categories_args($args){
	$slider_categories = get_theme_mod( 'shopstar-slider-categories' );
    $slider_type = get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) );
	
	if ( $slider_categories != '' && $slider_type == 'shopstar-slider-default' ) {
		if ( count($slider_categories) > 0) {
			$exclude = implode(',', $slider_categories);
			$args['exclude'] = $exclude;
		}
	}
	
	return $args;
}
add_filter('widget_categories_args', 'shopstar_set_widget_categories_args');

function shopstar_set_widget_categories_dropdown_arg($args){
	$slider_categories = get_theme_mod( 'shopstar-slider-categories' );
	$slider_type = get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) );

	if ( $slider_categories != '' && $slider_type == 'shopstar-slider-default' ) {
		if ( count($slider_categories) > 0) {
			$exclude = implode(',', $slider_categories);
			$args['exclude'] = $exclude;
		}
	}
	
	return $args;
}
add_filter('widget_categories_dropdown_args', 'shopstar_set_widget_categories_dropdown_arg');

function shopstar_update_allowed_tags( $tags ) {
	$tags["h1"] = array();
	$tags["h2"] = array();
	$tags["h3"] = array();
	$tags["h4"] = array();
	$tags["h5"] = array();
	$tags["h6"] = array();
	$tags["p"] 	= array();
	$tags["br"] = array();
	
	return $tags;
}
add_filter( 'wp_kses_allowed_html', 'shopstar_update_allowed_tags' );

function shopstar_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => 'Page Builder by SiteOrigin',
			'slug'      => 'siteorigin-panels',
			'required'  => false
		),
		array(
			'name'      => 'SiteOrigin Widgets Bundle',
			'slug'      => 'so-widgets-bundle',
			'required'  => false
		),
		array(
			'name'      => 'SiteOrigin CSS',
			'slug'      => 'so-css',
			'required'  => false
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false
		),
		array(
			'name'      => 'Breadcrumb NavXT',
			'slug'      => 'breadcrumb-navxt',
			'required'  => false
		),
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => false
		),
		array(
			'name'      => 'MailChimp for WordPress',
			'slug'      => 'mailchimp-for-wp',
			'required'  => false
		),
		array(
			'name'      => 'Anti-Spam',
			'slug'      => 'anti-spam',
			'required'  => false
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false
		)
	);

	$config = array(
		'id'           => 'shopstar',            // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => ''                       // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'shopstar_register_required_plugins' );
