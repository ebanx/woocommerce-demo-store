<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Demo
 */

function shopstar_customizer_library_options() {
	// Theme defaults
	$primary_color = '#000000';
	$site_title_font_color = '#000000';
	$nav_menu_font_color = '#000000';
	$nav_menu_rollover_font_color = '#ba2227';
	$slider_font_color = '#FFFFFF';
	$heading_font_color = '#000000';
    $body_font_color = '#4F4F4F';
    $link_font_color = '#939598';
    $link_rollover_font_color = '#4F4F4F';
    $slider_control_button_color = '#000000';
    $button_color = '#000000';
    $footer_color = '#ECEDED';
    
    
	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Adds the sections to the $options array
	$options['sections'] = $sections;
	
	// Site Identity
	$section = 'title_tagline';
	
	$sections[] = array(
		'id' => $section,
		'title' => __( 'Site Identity', 'shopstar' ),
		'priority' => '25'
	);
	
	if ( ! function_exists( 'has_custom_logo' ) ) {
		$options['shopstar-logo'] = array(
			'id' => 'shopstar-logo',
			'label'   => __( 'Logo', 'shopstar' ),
			'section' => $section,
			'type'    => 'image'
		);
	}
    
    // Layout Settings
    $section = 'shopstar-layout';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Layout', 'shopstar' ),
        'priority' => '30'
    );
    
        
    // Header Settings
    $section = 'shopstar-header';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Header', 'shopstar' ),
    	'priority' => '35'
    );
    $choices = array(
    	'shopstar-header-layout-centered' => 'Centered',
    	'shopstar-header-layout-left-aligned' => 'Left Aligned'
    );
    $options['shopstar-header-layout'] = array(
    	'id' => 'shopstar-header-layout',
    	'label'   => __( 'Layout', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'select',
    	'choices' => $choices,
    	'default' => 'shopstar-header-layout-centered'
    );
    $options['shopstar-show-header-top-bar'] = array(
    	'id' => 'shopstar-show-header-top-bar',
    	'label'   => __( 'Show Top Bar', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    $options['shopstar-header-info-text'] = array(
    	'id' => 'shopstar-header-info-text',
    	'label'   => __( 'Info Text', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => ''
    );
    
    // Social Settings
    $section = 'shopstar-social';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Social Media Links', 'shopstar' ),
    	'priority' => '35'
    );
    
    $options['shopstar-social-email'] = array(
    	'id' => 'shopstar-social-email',
    	'label'   => __( 'Email Address', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    );
    $options['shopstar-social-skype'] = array(
    	'id' => 'shopstar-social-skype',
    	'label'   => __( 'Skype Name', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    );
    $options['shopstar-social-tumblr'] = array(
    	'id' => 'shopstar-social-tumblr',
    	'label'   => __( 'Tumblr', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    );
    $options['shopstar-social-flickr'] = array(
    	'id' => 'shopstar-social-flickr',
    	'label'   => __( 'Flickr', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    );
    
    
    // Search Settings
    $section = 'shopstar-search';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Search', 'shopstar' ),
    	'priority' => '35'
    );
    
    $options['shopstar-header-search'] = array(
    	'id' => 'shopstar-header-search',
    	'label'   => __( 'Show Search in the Navigation Menu', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $options['shopstar-search-placeholder-text'] = array(
    	'id' => 'shopstar-search-placeholder-text',
    	'label'   => __( 'Default Search Input Text', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => __( 'Search...', 'shopstar' )
    );
    
    $options['shopstar-search-no-search-results-heading'] = array(
    	'id' => 'shopstar-search-no-search-results-heading',
    	'label'   => __( 'No Search Results Found Heading', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => __( 'Nothing Found!', 'shopstar')
    );
    $options['shopstar-search-no-search-results-text'] = array(
        'id' => 'shopstar-search-no-search-results-text',
        'label'   => __( 'No Search Results Found Message', 'shopstar' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shopstar')
    );
    
    
    // Slider Settings
    $section = 'shopstar-slider';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Slider', 'shopstar' ),
        'priority' => '35'
    );
    
    $choices = array(
        'shopstar-slider-default' => 'Default Slider',
        'shopstar-slider-plugin' => 'Slider Plugin',
        'shopstar-no-slider' => 'None'
    );
    $options['shopstar-slider-type'] = array(
        'id' => 'shopstar-slider-type',
        'label'   => __( 'Choose a Slider', 'shopstar' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'shopstar-no-slider'
    );
    
	$options['shopstar-slider-categories'] = array(
		'id' => 'shopstar-slider-categories',
		'label'   => __( 'Slider Categories', 'shopstar' ),
		'section' => $section,
		'type'    => 'dropdown-categories',
		'description' => __( 'Select the categories of the posts you want to display in the slider. The featured image will be the slide image and the post content will display over it. Hold down the Ctrl (windows) / Command (Mac) button to select multiple categories.', 'shopstar' )
	);
	
    $options['shopstar-slider-has-min-width'] = array(
    	'id' => 'shopstar-slider-has-min-width',
    	'label'   => __( 'Slider has a minimum width', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );
    
    $options['shopstar-slider-min-width'] = array(
    	'id' => 'shopstar-slider-min-width',
    	'label'   => __( 'Minimum Width', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'pixels',
    	'default' => 600
    );
	
    $options['shopstar-slider-transition-speed'] = array(
    	'id' => 'shopstar-slider-transition-speed',
    	'label'   => __( 'Slide Transition Speed', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'milliseconds',
    	'default' => 450,
    	'description' => __( 'The speed it takes to transition between slides in milliseconds. 1000 milliseconds equals 1 second.', 'shopstar' )
    );
    
    $options['shopstar-slider-plugin-shortcode'] = array(
    	'id' => 'shopstar-slider-plugin-shortcode',
    	'label'   => __( 'Slider Shortcode', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    	'description' => __( 'Enter the shortcode given by the slider plugin you\'re using.', 'shopstar' )
    );
    
    
    // Header Image
    $section = 'header_image';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Header Image', 'shopstar' ),
    	'priority' => '35'
    );
    
    $options['shopstar-header-image-text'] = array(
    	'id' => 'shopstar-header-image-text',
    	'label'   => __( 'Text', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'textarea'
    );    

    
    // WooCommerce
    $section = 'woocommerce';
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'WooCommerce', 'shopstar' ),
    	'priority' => '35'
    );
    
    $options['shopstar-header-shop-links'] = array(
    	'id' => 'shopstar-header-shop-links',
    	'label'   => __( 'Shop Links', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
		'description' => __( 'Display the My Account and Checkout links when WooCommerce is active.', 'shopstar' )
    );
    
    $options['shopstar-layout-woocommerce-shop-full-width'] = array(
    	'id' => 'shopstar-layout-woocommerce-shop-full-width',
    	'label'   => __( 'Full width WooCommerce Shop page', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 0,
    );
    
    $options['shopstar-woocommerce-product-image-zoom'] = array(
    	'id' => 'shopstar-woocommerce-product-image-zoom',
    	'label'   => __( 'Enable zoom on product image', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'checkbox',
    	'default' => 1,
    );    


    // Colors
    $section = 'colors';
    $font_choices = customizer_library_get_font_choices();
    
    $sections[] = array(
    	'id' => $section,
    	'title' => __( 'Colors', 'shopstar' ),
    	'priority' => '25'
    );
    
    $options['shopstar-primary-color'] = array(
    	'id' => 'shopstar-primary-color',
    	'label'   => __( 'Primary Color', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $primary_color,
    );
    
    $options['shopstar-slider-control-button-color'] = array(
    	'id' => 'shopstar-slider-control-button-color',
    	'label'   => __( 'Slider Prev / Next Button Color', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $slider_control_button_color,
    );
    
    $options['shopstar-button-color'] = array(
    	'id' => 'shopstar-button-color',
    	'label'   => __( 'Button Color', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $button_color,
    );
    
    $options['shopstar-footer-color'] = array(
    	'id' => 'shopstar-footer-color',
    	'label'   => __( 'Footer Color', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $footer_color,
    );
    
    
	// Font Settings
	$section = 'shopstar-fonts';
    $font_choices = customizer_library_get_font_choices();

	$sections[] = array(
		'id' => $section,
		'title' => __( 'Fonts', 'shopstar' ),
		'priority' => '25'
	);

	$options['shopstar-site-title-font'] = array(
		'id' => 'shopstar-site-title-font',
		'label'   => __( 'Site Title Font', 'shopstar' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Prata'
	);
	$options['shopstar-site-title-font-color'] = array(
		'id' => 'shopstar-site-title-font-color',
		'label'   => __( 'Site Title Font Color', 'shopstar' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $site_title_font_color,
	);
	$options['shopstar-nav-menu-font-color'] = array(
		'id' => 'shopstar-nav-menu-font-color',
		'label'   => __( 'Nav Menu Font Color', 'shopstar' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $nav_menu_font_color,
	);
	$options['shopstar-nav-menu-rollover-font-color'] = array(
		'id' => 'shopstar-nav-menu-rollover-font-color',
		'label'   => __( 'Nav Menu Rollover Font Color', 'shopstar' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $nav_menu_rollover_font_color,
	);
	
	$options['shopstar-slider-font-color'] = array(
		'id' => 'shopstar-slider-font-color',
		'label'   => __( 'Slider Font Color', 'shopstar' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $slider_font_color,
	);
	
	$options['shopstar-slider-text-shadow'] = array(
		'id' => 'shopstar-slider-text-shadow',
		'label'   => __( 'Display a drop shadow on the slider / header image text.', 'shopstar' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0
	);

	$options['shopstar-heading-font'] = array(
		'id' => 'shopstar-heading-font',
		'label'   => __( 'Heading Font', 'shopstar' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $font_choices,
		'default' => 'Raleway'
	);
	$options['shopstar-heading-font-color'] = array(
		'id' => 'shopstar-heading-font-color',
		'label'   => __( 'Heading Font Color', 'shopstar' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $heading_font_color,
	);
	
    $options['shopstar-body-font'] = array(
        'id' => 'shopstar-body-font',
        'label'   => __( 'Body Font', 'shopstar' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $font_choices,
        'default' => 'Lato'
    );
    $options['shopstar-body-font-color'] = array(
        'id' => 'shopstar-body-font-color',
        'label'   => __( 'Body Font Color', 'shopstar' ),
        'section' => $section,
        'type'    => 'color',
        'default' => $body_font_color,
    );

    $options['shopstar-link-font-color'] = array(
    	'id' => 'shopstar-link-font-color',
    	'label'   => __( 'Link Font Color', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $link_font_color,
    );
    $options['shopstar-link-rollover-font-color'] = array(
    	'id' => 'shopstar-link-rollover-font-color',
    	'label'   => __( 'Link Rollover Font Color', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'color',
    	'default' => $link_rollover_font_color,
    );
    
    // Blog Settings
    $section = 'shopstar-blog';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Blog', 'shopstar' ),
        'priority' => '50'
    );
    
    $choices = array(
		'shopstar-blog-archive-layout-full' => 'Full Post',
		'shopstar-blog-archive-layout-excerpt' => 'Post Excerpt'
    );
    $options['shopstar-blog-archive-layout'] = array(
        'id' => 'shopstar-blog-archive-layout',
        'label'   => __( 'Archive Layout', 'shopstar' ),
        'section' => $section,
        'type'    => 'select',
        'choices' => $choices,
        'default' => 'shopstar-blog-archive-layout-full'
    );
    
    $options['shopstar-blog-excerpt-length'] = array(
    	'id' => 'shopstar-blog-excerpt-length',
    	'label'   => __( 'Excerpt Length', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => 55
    );
    
    $options['shopstar-blog-read-more-text'] = array(
    	'id' => 'shopstar-blog-read-more-text',
    	'label'   => __( 'Read More Text', 'shopstar' ),
    	'section' => $section,
    	'type'    => 'text',
    	'default' => 'Read More'
    );
    
    // Site Text Settings
    $section = 'shopstar-website-text';

    $sections[] = array(
        'id' => $section,
        'title' => __( 'Website Text', 'shopstar' ),
        'priority' => '50'
    );
    $options['shopstar-website-text-404-page-heading'] = array(
        'id' => 'shopstar-website-text-404-page-heading',
        'label'   => __( '404 Page Heading', 'shopstar' ),
        'section' => $section,
        'type'    => 'text',
        'default' => __( '404!', 'shopstar')
    );
    $options['shopstar-website-text-404-page-text'] = array(
        'id' => 'shopstar-website-text-404-page-text',
        'label'   => __( '404 Page Message', 'shopstar' ),
        'section' => $section,
        'type'    => 'textarea',
        'default' => __( 'The page you were looking for cannot be found!', 'shopstar')
    );

    
	// Adds the sections to the $options array
	$options['sections'] = $sections;

	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: customizer_library_remove_theme_mods();

}
add_action( 'init', 'shopstar_customizer_library_options' );
