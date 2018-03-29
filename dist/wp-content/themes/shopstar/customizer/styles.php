<?php
/**
 * Implements styles set in the theme customizer
 *
 * @package Customizer Library Demo
 */

if ( ! function_exists( 'shopstar_customizer_library_build_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function shopstar_customizer_library_build_styles() {
	
	if ( wp_is_mobile() ) {
		$mobile_menu_breakpoint = 10000000;
	} else {
		$mobile_menu_breakpoint = 960;
	}
	
	// Background Color
	$color = 'background_color';
	$colormod = '#'.get_theme_mod( $color, get_background_color() );
	
	if ( $colormod !== get_background_color() ) {
	
		$sancolor = esc_html( $colormod );
	
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'#main-menu'
			),
			'declarations' => array(
				'background-color' => $sancolor
			)
		) );
	}
	
    // Primary Color
    $color = 'shopstar-primary-color';
    $colormod = get_theme_mod( $color, customizer_library_get_default( $color ) );
    
    if ( $colormod !== customizer_library_get_default( $color ) ) {
    
    	$sancolor = esc_html( $colormod );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.main-navigation .menu-toggle .fa.fa-bars'
    		),
    		'declarations' => array(
    			'color' => $sancolor
    		)
    	) );
    
    	Customizer_Library_Styles()->add( array(
	    	'selectors' => array(
    			'.site-header .top-bar,
				.site-footer .bottom-bar,
				.main-navigation .close-button'
    		),
    		'declarations' => array(
    			'background-color' => $sancolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'#main-menu.shopstar-mobile-menu-primary-color-scheme'
    		),
    		'declarations' => array(
    			'background-color' => $sancolor
    		),
    		'media' => '(max-width: ' .$mobile_menu_breakpoint. 'px)'
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.site-header .container.bottom-border,
				.site-header .main-navigation.bottom-border,
				.site-header .main-navigation .container.bottom-border,
				.home .site-header.bottom-border,
				.main-navigation ul ul'
    		),
    		'declarations' => array(
    			'border-bottom-color' => $sancolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.main-navigation ul ul'
    		),
    		'declarations' => array(
    			'border-top-color' => $sancolor
    		)
    	) );
    	
    }    
    
    // Site Title Font
    $font = 'shopstar-site-title-font';
    $fontmod = get_theme_mod( $font, customizer_library_get_default( $font ) );
    $fontstack = customizer_library_get_font_stack( $fontmod );
    
    if ( $fontmod != customizer_library_get_default( $font ) ) {
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.site-header .branding .title'
	    	),
    		'declarations' => array(
    			'font-family' => $fontstack
    		)
    	) );
    
    }

    // Site Title Font Color
    $fontcolor = 'shopstar-site-title-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.site-header .branding .title,
    			.site-header .branding .description'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
    }
    
    // Nav Menu Font Color
    $fontcolor = 'shopstar-nav-menu-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
	    	'selectors' => array(
	    		'.main-navigation a,
	    		.submenu-toggle'
	    	),
	    	'declarations' => array(
	    		'color' => $sanfontcolor
	    	)
    	) );
    	 
    }

    // Nav Menu Rollover Font Color
    $fontcolor = 'shopstar-nav-menu-rollover-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.main-navigation ul.menu > li > a:hover,
				.main-navigation ul.menu > li.current-menu-item > a,
				.main-navigation ul.menu > li.current_page_item > a,
				.main-navigation ul.menu > li.current-menu-parent > a,
				.main-navigation ul.menu > li.current_page_parent > a,
				.main-navigation ul.menu > li.current-menu-ancestor > a,
				.main-navigation ul.menu > li.current_page_ancestor > a,
				.site-header .search-button a:hover'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
	
    }

    // Slider Font Color
    $fontcolor = 'shopstar-slider-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.slider-container.default .slider .slide .overlay,
    			.slider-container.default .slider .slide .overlay h1,
    			.slider-container.default .slider .slide .overlay h2,
    			.slider-container.default .slider .slide .overlay h3,
    			.slider-container.default .slider .slide .overlay h4,
    			.slider-container.default .slider .slide .overlay h5,
    			.slider-container.default .slider .slide .overlay a,
				.header-image .overlay,
    			.header-image .overlay h1,
    			.header-image .overlay h2,
    			.header-image .overlay h3,
    			.header-image .overlay h4,
    			.header-image .overlay h5,
    			.header-image .overlay a'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
    }
    
    // Heading Font
    $font = 'shopstar-heading-font';
    $fontmod = get_theme_mod( $font, customizer_library_get_default( $font ) );
    $fontstack = customizer_library_get_font_stack( $fontmod );
    
    if ( $fontmod != customizer_library_get_default( $font ) ) {
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'h1, h2, h3, h4, h5, h6,
				h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
				h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited,
				.slider-container.default .slider .slide .overlay h2,
    			.slider-container.default .slider .slide .overlay h3,
    			.slider-container.default .slider .slide .overlay h4,
    			.slider-container.default .slider .slide .overlay h5,
    			.slider-container.default .slider .slide .overlay h6,
				.header-image .overlay h2,
    			.header-image .overlay h3,
    			.header-image .overlay h4,
    			.header-image .overlay h5,
    			.header-image .overlay h6,
				.widget_woocommerce_products .product-title,
				.main-navigation a,
				.content-area .widget-title,
				.widget-area .widget-title,
				.site-footer .widgets ul li h2.widgettitle,
				.woocommerce a.button,
				.woocommerce #respond input#submit,
				.woocommerce button.button,
				.woocommerce input.button,
				a.button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"]'
    		),
    		'declarations' => array(
    			'font-family' => $fontstack
    		)
    	) );
    
    }
    
    // Heading Font Color
    $fontcolor = 'shopstar-heading-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'h1, h2, h3, h4, h5, h6,
				h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
				h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited,
				.widget_woocommerce_products .product-title,
				.widget_woocommerce_products .widget-title,
				.content-area .widget-title,
				.widget-area .widget-title,
				.site-footer .widgets ul li h2.widgettitle'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
    }
    
    // Body Font
    $font = 'shopstar-body-font';
    $fontmod = get_theme_mod( $font, customizer_library_get_default( $font ) );
    $fontstack = customizer_library_get_font_stack( $fontmod );
    
    if ( $fontmod != customizer_library_get_default( $font ) ) {
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
	    		'body,
				input[type="text"],
				input[type="email"],
	    		input[type="tel"],
				input[type="url"],
				input[type="password"],
				input[type="search"],
				textarea,
				.slider-container.default .slider .slide .overlay,
				.header-image .overlay,
				.main-navigation ul ul a,
				.widget_woocommerce_products .amount,
				article .entry-meta,
				.woocommerce .quantity input.qty,
				.woocommerce-page #content .quantity input.qty,
				.woocommerce-page .quantity input.qty,
				.woocommerce form .form-row input.input-text,
				.woocommerce-page form .form-row input.input-text,
				.woocommerce form .form-row select,
				.woocommerce-page form .form-row select,
				.woocommerce #content div.product form.cart .variations select,
				.woocommerce div.product form.cart .variations select,
				.woocommerce-page #content div.product form.cart .variations select,
				.woocommerce-page div.product form.cart .variations select,
				.woocommerce .woocommerce-ordering select,
				.woocommerce-page .woocommerce-ordering select'
    		),
    		'declarations' => array(
    			'font-family' => $fontstack
    		)
    	) );
    
    }

    // Body Font Color
    $fontcolor = 'shopstar-body-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    	$sanfontcolor_rgb = customizer_library_hex_to_rgb( $sanfontcolor );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'body,
				input[type="text"],
				input[type="email"],
    			input[type="tel"],
				input[type="url"],
				input[type="password"],
				input[type="search"],
				textarea,
				article .entry-footer,
				.site-footer .widgets .widget a,
				.search-block .search-field,
				.select2-drop,
				.select2-container .select2-choice,
				.select2-results .select2-highlighted,
				.woocommerce .woocommerce-breadcrumb,
				.woocommerce-page .woocommerce-breadcrumb,
				.site-footer .widgets .widget ul li a,
				.site-footer .widgets .widget .social-icons a,
				.site-footer .mc4wp-form input[type=date],
				.site-footer .mc4wp-form input[type=email],
				.site-footer .mc4wp-form input[type=number],
				.site-footer .mc4wp-form input[type=tel],
				.site-footer .mc4wp-form input[type=text],
				.site-footer .mc4wp-form input[type=url],
				.site-footer .mc4wp-form select,
				.site-footer .mc4wp-form textarea,
				.widget_woocommerce_products .amount,
				.widget_woocommerce_products del,
				.woocommerce #reviews #comments ol.commentlist li .meta,
				.woocommerce-checkout #payment div.payment_box,
				.woocommerce .woocommerce-info,
				.woocommerce form .form-row input.input-text,
				.woocommerce-page form .form-row input.input-text,
				.woocommerce .woocommerce-ordering select,
				.woocommerce-page .woocommerce-ordering select,
    			.woocommerce ul.products li.product .price,
				.woocommerce #content ul.products li.product span.price,
				.woocommerce-page #content ul.products li.product span.price,
				.woocommerce div.product p.price del,
				.woocommerce table.cart input,
				.woocommerce-page #content table.cart input,
				.woocommerce-page table.cart input,
				.woocommerce #content .quantity input.qty,
				.woocommerce .quantity input.qty,
				.woocommerce-page #content .quantity input.qty,
				.woocommerce-page .quantity input.qty,
				article .entry-meta'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.select2-default'
    		),
    		'declarations' => array(
    			'color' => 'rgba(' .$sanfontcolor_rgb['r']. ',' .$sanfontcolor_rgb['g']. ',' .$sanfontcolor_rgb['b']. ', 0.7) !important'
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'::-webkit-input-placeholder'
    		),
    		'declarations' => array(
    			'color' => 'rgba(' .$sanfontcolor_rgb['r']. ',' .$sanfontcolor_rgb['g']. ',' .$sanfontcolor_rgb['b']. ', 0.7)'
    		)
    	) );
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			':-moz-placeholder'
    		),
    		'declarations' => array(
    			'color' => 'rgba(' .$sanfontcolor_rgb['r']. ',' .$sanfontcolor_rgb['g']. ',' .$sanfontcolor_rgb['b']. ', 0.7)'
    		)
    	) );
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'::-moz-placeholder'
    		),
    		'declarations' => array(
    			'color' => 'rgba(' .$sanfontcolor_rgb['r']. ',' .$sanfontcolor_rgb['g']. ',' .$sanfontcolor_rgb['b']. ', 0.7)'
    		)
    	) );
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			':-ms-input-placeholder'
    		),
    		'declarations' => array(
    			'color' => 'rgba(' .$sanfontcolor_rgb['r']. ',' .$sanfontcolor_rgb['g']. ',' .$sanfontcolor_rgb['b']. ', 0.7)'
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.site-footer .widgets .widget .social-icons a:hover'
    		),
    		'declarations' => array(
    			'color' => 'rgba(' .$sanfontcolor_rgb['r']. ',' .$sanfontcolor_rgb['g']. ',' .$sanfontcolor_rgb['b']. ', 0.6)'
    		)
    	) );
    	 
    }
    
    // Link Font Color
    $fontcolor = 'shopstar-link-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'a,
    			.woocommerce .woocommerce-breadcrumb a,
    			.woocommerce-page .woocommerce-breadcrumb a'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.main-navigation ul ul a'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		),
    		'media' => '(min-width: ' .$mobile_menu_breakpoint. 'px)'
    	) );
    
    }

    // Link Rollover Font Color
    $fontcolor = 'shopstar-link-rollover-font-color';
    $fontcolormod = get_theme_mod( $fontcolor, customizer_library_get_default( $fontcolor ) );
    
    if ( $fontcolormod !== customizer_library_get_default( $fontcolor ) ) {
    
    	$sanfontcolor = esc_html( $fontcolormod );
    
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'a:hover,
    			.woocommerce .woocommerce-breadcrumb a:hover,
				.woocommerce-page .woocommerce-breadcrumb a:hover'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.main-navigation ul ul a:hover,
				.main-navigation ul ul li.current-menu-item > a,
				.main-navigation ul ul li.current_page_item > a,
				.main-navigation ul ul li.current-menu-parent > a,
				.main-navigation ul ul li.current_page_parent > a,
				.main-navigation ul ul li.current-menu-ancestor > a,
				.main-navigation ul ul li.current_page_ancestor > a'
    		),
    		'declarations' => array(
    			'color' => $sanfontcolor
    		),
    		'media' => '(min-width: ' .$mobile_menu_breakpoint. 'px)'
    	) );
    
    }
    
    // Slider Control Button Color
    $color = 'shopstar-slider-control-button-color';
    $colormod = get_theme_mod( $color, customizer_library_get_default( $color ) );
    
    if ( $colormod !== customizer_library_get_default( $color ) ) {
    
    	$sancolor = esc_html( $colormod );
    	$sancolor_rgb = customizer_library_hex_to_rgb( $sancolor );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.slider-container.default .prev,
				.slider-container.default .next'
    		),
    		'declarations' => array(
    			'background-color' => $sancolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.slider-container.default .prev:hover,
				.slider-container.default .next:hover'
    		),
    		'declarations' => array(
    			'background-color' => 'rgba(' .$sancolor_rgb['r']. ',' .$sancolor_rgb['g']. ',' .$sancolor_rgb['b']. ', 0.6)'
    		)
    	) );
    
    }    
    
    // Button Color
    $color = 'shopstar-button-color';
    $colormod = get_theme_mod( $color, customizer_library_get_default( $color ) );
    
    if ( $colormod !== customizer_library_get_default( $color ) ) {
    
    	$sancolor = esc_html( $colormod );
    	$sancolor_rgb = customizer_library_hex_to_rgb( $sancolor );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'#back-to-top,
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.slider-container.default .slider a.button,
    			.header-image a.button,
				.site-footer .mc4wp-form button,
				.site-footer .mc4wp-form input[type=button],
				.site-footer .mc4wp-form input[type=submit],
				a.button,
				.woocommerce #respond input#submit,
				.woocommerce a.button,
				.woocommerce button.button,
				.woocommerce input.button,
				.woocommerce #review_form #respond .form-submit input,
				.woocommerce-page #review_form #respond .form-submit input,
				.woocommerce ul.products li.product a.add_to_cart_button,
				.woocommerce-page ul.products li.product a.add_to_cart_button,
				.woocommerce button.button.alt:disabled,
				.woocommerce button.button.alt:disabled:hover,
				.woocommerce button.button.alt:disabled[disabled],
				.woocommerce button.button.alt:disabled[disabled]:hover,
				.woocommerce div.product form.cart .button,
				.woocommerce table.cart input.button,
				.woocommerce-page #content table.cart input.button,
				.woocommerce-page table.cart input.button,
				.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
				.woocommerce input.button.alt,
				.woocommerce-page #content input.button.alt,
				.woocommerce button.button.alt,
				.woocommerce-page button.button.alt'
    		),
    		'declarations' => array(
    			'background-color' => $sancolor
    		)
    	) );
    	
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'button:hover,
				input[type="button"]:hover,
				input[type="reset"]:hover,
				input[type="submit"]:hover,
				a.button:hover,
				.slider-container.default .slider a.button:hover,
				.header-image a.button:hover,
				.site-footer .mc4wp-form button:hover,
				.site-footer .mc4wp-form input[type=button]:hover,
				.site-footer .mc4wp-form input[type=submit]:hover,
				.woocommerce #respond input#submit:hover,
				.woocommerce a.button:hover,
				.woocommerce button.button:hover,
				.woocommerce input.button:hover,
				.woocommerce #review_form #respond .form-submit input:hover,
				.woocommerce-page #review_form #respond .form-submit input:hover,
				.woocommerce ul.products li.product a.add_to_cart_button:hover,
				.woocommerce-page ul.products li.product a.add_to_cart_button:hover,
				.woocommerce button.button.alt:disabled,
				.woocommerce button.button.alt:disabled:hover,
				.woocommerce button.button.alt:disabled[disabled],
				.woocommerce button.button.alt:disabled[disabled]:hover,
				.woocommerce div.product form.cart .button:hover,
				.woocommerce table.cart input.button:hover,
				.woocommerce-page #content table.cart input.button:hover,
				.woocommerce-page table.cart input.button:hover,
				.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
				.woocommerce input.button.alt:hover,
				.woocommerce-page #content input.button.alt:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce-page button.button.alt:hover'
    		),
    		'declarations' => array(
    			'background-color' => 'rgba(' .$sancolor_rgb['r']. ',' .$sancolor_rgb['g']. ',' .$sancolor_rgb['b']. ', 0.6)'
    		)
    	) );
    	 
    }
    
    // Footer Color
    $color = 'shopstar-footer-color';
    $colormod = get_theme_mod( $color, customizer_library_get_default( $color ) );
    
    if ( $colormod !== customizer_library_get_default( $color ) ) {
    
    	$sancolor = esc_html( $colormod );
    	 
    	Customizer_Library_Styles()->add( array(
    		'selectors' => array(
    			'.site-footer .widgets'
    		),
    		'declarations' => array(
    			'background-color' => $sancolor
    		)
    	) );
    	    	
    }

}
endif;

add_action( 'customizer_library_styles', 'shopstar_customizer_library_build_styles' );

if ( ! function_exists( 'shopstar_customizer_library_styles' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
 * It is organized this way to ensure there is only one "style" tag.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function shopstar_customizer_library_styles() {

	do_action( 'customizer_library_styles' );

	// Echo the rules
	$css = Customizer_Library_Styles()->build();

	if ( ! empty( $css ) ) {
		echo "\n<!-- Begin Custom CSS -->\n<style type=\"text/css\" id=\"out-the-box-custom-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- End Custom CSS -->\n";
	}
}
endif;

add_action( 'wp_head', 'shopstar_customizer_library_styles', 11 );