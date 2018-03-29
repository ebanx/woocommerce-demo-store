<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


// Add Do-shortcode for text widgets
function widget_text_do_shortcodes( $text ) {
	return do_shortcode( $text );
}

add_filter( 'widget_text', 'widget_text_do_shortcodes' );


// Date Shortcode
function laborator_shortcode_date( $atts = array(), $content = '' ) {
	return date_i18n( get_option( 'date_format' ) );
}

if ( ! shortcode_exists( 'date' ) ) {
	add_shortcode( 'date', 'laborator_shortcode_date' );
}


// Shortcode for Social Networks [lab_social_networks]
function shortcode_lab_social_networks( $atts = array(), $content = '' ) {
	$custom_icon 		= get_data( 'social_network_custom_link_icon' );
	
	$social_order		= get_data( 'social_order' );
	$social_order_list	= apply_filters( 'kalium_social_networks_array', array(
		'fb'      => array( 
			'title'  => 'Facebook',
			'icon'   => 'fa fa-facebook'
		),
		'tw'      => array(
			'title'  => 'Twitter',
			'icon'   => 'fa fa-twitter'
		),
		'lin'     => array(
			'title'  => 'LinkedIn',
			'icon'   => 'fa fa-linkedin'
		),
		'yt'      => array(
			'title'  => 'YouTube',
			'icon'   => 'fa fa-youtube-play'
		),
		'vm'      => array(
			'title'  => 'Vimeo',
			'icon'   => 'fa fa-vimeo'
		),
		'drb'     => array(
			'title'  => 'Dribbble',
			'icon'   => 'fa fa-dribbble'
		),
		'ig'      => array(
			'title'  => 'Instagram',
			'icon'   => 'fa fa-instagram' 
		),
		'pi'      => array(
			'title'  => 'Pinterest',
			'icon'   => 'fa fa-pinterest' 
		),
		'gp'      => array(
			'title'  => 'Google+',
			'icon'   => 'fa fa-google-plus' 
		),
		'vk'      => array(
			'title'  => 'VKontakte',
			'icon'   => 'fa fa-vk' 
		),
		'fl'      => array(
			'title'  => 'Flickr',
			'icon'   => 'fa fa-flickr'
		),
		'be'      => array(
			'title'  => 'Behance',
			'icon'   => 'fa fa-behance' 
		),
		'vi'      => array(
			'title'  => 'Vine',
			'icon'   => 'fa fa-vine'
		),
		'fs'      => array(
			'title'  => 'Foursquare',
			'icon'   => 'fa fa-foursquare'
		),
		'sk'      => array(
			'title'  => 'Skype',
			'icon'   => 'fa fa-skype'
		),
		'tu'      => array(
			'title'  => 'Tumblr',
			'icon'   => 'fa fa-tumblr'
		),
		'da'      => array(
			'title'  => 'DeviantArt',
			'icon'   => 'fa fa-deviantart'
		),
		'gh'      => array(
			'title'  => 'GitHub',
			'icon'   => 'fa fa-github'
		),
		'sc'      => array(
			'title'  => 'SoundCloud',
			'icon'   => 'fa fa-soundcloud'
		),
		'hz'      => array(
			'title'  => 'Houzz',
			'icon'   => 'fa fa-houzz'
		),
		'px'      => array(
			'title'  => '500px',
			'icon'   => 'fa fa-500px',
			'prefix' => 'social',
		),
		'xi'      => array(
			'title'  => 'Xing',
			'icon'   => 'fa fa-xing'
		),
		'sp'      => array(
			'title'  => 'Spotify',
			'icon'   => 'fa fa-spotify'
		),
		'sn'      => array(
			'title'  => 'Snapchat',
			'icon'   => 'fa fa-snapchat-ghost',
			'dark'	 => true
		),
		'em'      => array(
			'title'  => __( 'Email', 'kalium' ),
			'icon'   => 'fa fa-envelope-o'
		),
		
		'custom'  => array(
			'title'  => get_data( 'social_network_custom_link_title' ), 			
			'href'   => get_data( 'social_network_custom_link_link' ),
			'icon'   => 'fa ' . ( $custom_icon ? "fa-{$custom_icon}" : 'fa-plus' ),
		),
	) );

	// Social Networks Class
	$class = 'social-networks';
	
	if ( isset( $atts['class'] ) ) {
		$class .= ' ' . $atts['class'];
	}
	
	// Rounded Social Networks
	if ( is_array( $atts ) && in_array( 'rounded', $atts ) ) {
		$class .= ' rounded';
	} else {
		$class .= ' textual';
	}
	
	// Colored Text
	if ( is_array( $atts ) && ( in_array( 'colored', $atts ) || 'hover' == get_array_key( $atts, 'colored' ) ) ) {
		
		if ( is_array( $atts ) && 'hover' == get_array_key( $atts, 'colored' ) ) {
			$class .= ' colored-hover';
		} else {
			$class .= ' colored';	
		}
	}	
	// Colored Background
	else if ( is_array( $atts ) && ( in_array( 'colored-bg', $atts ) || 'hover' == get_array_key( $atts, 'colored-bg' ) ) ) {
		
		if ( is_array( $atts ) && 'hover' == get_array_key( $atts, 'colored-bg' ) ) {
			$class .= ' colored-bg-hover';
		} else {
			$class .= ' colored-bg';
		}
	}
	
	$html = '<ul class="' . esc_attr( $class ) . '">';

	foreach ( $social_order['visible'] as $key => $title ) {
		
		if ( $key == 'placebo' ) {
			continue;
		}

		$sn = $social_order_list[ $key ];
		
		$href = get_data( "social_network_link_{$key}" );
		$class = sanitize_title( $title );
		
		// Prefixed
		if ( isset( $sn['prefix'] ) ) {
			$class = "{$sn['prefix']}-" . $class;
		}
		
		if ( $key == 'custom' ) {
			$title   = $sn['title'];
			$href    = $sn['href'];
			$class 	 = 'custom';
		}
		
		$title_span = $title;
		
		if ( isset( $atts['class'] ) && strpos( $atts['class'], 'rounded' ) >= 0 ) {
			$title_span = $title;
		}
		
		$link_target = get_data( 'social_networks_target_attr', '_blank' );
		
		if ( is_email( $href ) ) {
			$link_target = '_self';
			$subject = get_data( 'social_network_link_em_subject' );
		
			$href = "mailto:{$href}";
			
			if ( $subject ) {
				$href .= '?subject=' . esc_attr( $subject );
			}
		}
		
		// Dark Class
		if ( ! empty( $sn['dark'] ) ) {
			$class .= ' dark';
		}
			
		$html .= '<li>';
			$html .= '<a href="' . $href . '" target="' . $link_target . '" class="' . $class . '" title="' . $title . '">';
				$html .= '<i class="' . $sn['icon'] . '"></i>';
				$html .= '<span class="name">' . apply_filters( 'kalium_social_networks_name' , $title_span, $title ) . '</span>';
			$html .= '</a>';
		$html .= '</li>';
	}

	$html .= '</ul>';


	return apply_filters( 'shortcode_social_networks_shortcode', $html );

}

add_shortcode( 'lab_social_networks', 'shortcode_lab_social_networks' );


// Excerpt Length & More
add_filter( 'excerpt_length', 'laborator_default_excerpt_length' );
add_filter( 'excerpt_more', 'laborator_default_excerpt_more' );

function laborator_default_excerpt_length() {
	return 55;
}

function laborator_short_excerpt_length() {
	return 32;
}

function laborator_supershort_excerpt_length() {
	return 18;
}

function laborator_default_excerpt_more() {
	return "&hellip;";
}


// Laborator Theme Options Translate
add_filter( 'admin_menu', 'laborator_add_menu_classes', 100 );

function laborator_add_menu_classes($items) {
	global $submenu;

	foreach ( $submenu as $menu_id => $sub ) {
		if ( $menu_id == 'laborator_options' ) {
			$submenu[ $menu_id ][0][0] = 'About';
		}
	}

	return $submenu;
}


// Replace Shop/Archive Page Settings
function kalium_replace_shop_archive_object( $post ) {
		
	// Replace Query Object for WooCommerce Shop Archive
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		$post = get_post( get_option( 'woocommerce_shop_page_id' ) );
	}
	
	return $post;
}

add_filter( 'kalium_replace_shop_archive_object', 'kalium_replace_shop_archive_object' );


// Body Class
function laborator_header_spacing() {
	global $wp_query;
	
	$qo = apply_filters( 'kalium_replace_shop_archive_object', get_queried_object() );
	
	$header_position = get_data( 'header_position' );
	$header_spacing = get_data( 'header_spacing' );
	
	if ( is_paged() ) {
		return;
	}
	
	if ( is_singular() ) {
		$post_id = get_the_ID();
	} else if ( $qo instanceof WP_Post ) {
		$post_id = $qo->ID;
	}
	
	// Custom Post
	if ( isset( $post_id ) ) {
		// Header Position
		$page_header_position = get_field( 'header_position', $post_id );
		$page_header_spacing = get_field( 'header_spacing', $post_id );
		
		if ( ! empty( $page_header_position ) && $page_header_position != 'inherit' ) {
			$header_position = $page_header_position;
			$header_spacing = $page_header_spacing;
			
			add_filter( 'get_data_header_position', laborator_immediate_return_fn( $header_position ) );
			add_filter( 'get_data_header_spacing', laborator_immediate_return_fn( $header_spacing ) );
		}
		
		// Footer Visibility
		$footer_visibility = get_field( 'footer_visibility', $post_id );
		
		if ( in_array( $footer_visibility, array( 'show', 'hide' ) ) ) {
			add_filter( 'kalium_show_footer', ( $footer_visibility == 'hide' ? '__return_false' : '__return_true' ), 10 );
		}
		
		// Fixed Footer
		$fixed_footer = get_field( 'fixed_footer', $post_id );
		
		if ( in_array( $fixed_footer, array( 'normal', 'fixed', 'fixed-fade', 'fixed-slide' ) ) ) {
			
			if ( $fixed_footer == 'normal' ) {
				$fixed_footer = '';
			}
			
			add_filter( 'get_data_footer_fixed', create_function( '', 'return "' . $fixed_footer . '";' ) );
		}
	}
	
	// Header Position
	if ( $header_position == 'absolute' && ! post_password_required( $qo ) ) {
		define( 'HEADER_ABSOLUTE_SPACING', intval( $header_spacing ) );
		add_filter( 'body_class', 'laborator_header_spacing_body_class' );
	}
}

function laborator_header_spacing_body_class( $classes ) {
	
	if ( defined( 'HEADER_ABSOLUTE_SPACING' ) ) {
		$classes[] = 'header-absolute';
		
		$header_spacing = str_replace( 'px', '', HEADER_ABSOLUTE_SPACING );
		generate_custom_style( '.wrapper', "padding-top: {$header_spacing}px !important", '', true );
	}
	
	return $classes;
}

add_action( 'wp', 'laborator_header_spacing' );

// Full-width Header
function kalium_header_footer_fullwidth() {
	
	$qo = apply_filters( 'kalium_replace_shop_archive_object', get_queried_object() );
	
	if ( $qo instanceof WP_Post ) {
		$post_id = $qo->ID;
		$header_fullwidth = get_field( 'header_fullwidth', $post_id );
		$footer_fullwidth = get_field( 'footer_fullwidth', $post_id );
		
		if ( in_array( $header_fullwidth, array( 'yes', 'no' ) ) ) {
			add_filter( 'get_data_header_fullwidth', $header_fullwidth == 'yes' ? '__return_true' : '__return_false' );
		}
		
		if ( in_array( $footer_fullwidth, array( 'yes', 'no' ) ) ) {
			add_filter( 'get_data_footer_fullwidth', $footer_fullwidth == 'yes' ? '__return_true' : '__return_false' );
		}
	}
}

add_action( 'wp', 'kalium_header_footer_fullwidth' );


// Comments Open/Close
function laborator_list_comments_open( $comment, $args, $depth ) {
	global $post, $wpdb, $comment_index;

	$comment_ID 			= $comment->comment_ID;
	$comment_author 		= $comment->comment_author;
	$comment_author_url		= $comment->comment_author_url;
	$comment_author_email	= $comment->comment_author_email;
	$comment_date 			= $comment->comment_date;
	$comment_parent_ID 		= $comment->comment_parent;

	$avatar					= get_avatar( $comment );

	$comment_time 			= strtotime( $comment_date );
	$comment_timespan 		= human_time_diff( $comment_time, time() );

	$link 					= '<a href="' . esc_url( $comment_author_url ) . '" target="_blank">';

	$comment_classes = array( 'comment-holder' );

	$comment_classes[] = 'col-xs-12';

	if ($depth > 3) {
		$comment_classes[] = 'col-sm-9';
	} elseif ( $depth > 2 ) {
		$comment_classes[] = 'col-sm-10';
	} elseif ( $depth > 1 ) {
		$comment_classes[] = 'col-sm-11';
	}

	// In reply to Get
	$parent_comment = null;

	if ( $comment_parent_ID ) {
		$parent_comment = get_comment( $comment_parent_ID );
	}

?>
<div <?php echo comment_class( $comment_classes ); ?> id="comment-<?php echo esc_attr( $comment_ID ); ?>"<?php echo $depth > 1 && $parent_comment ? ( " data-replied-to=\"comment-" . esc_attr( $comment_parent_ID ) . "\"" ) : ''; ?>>
	<div class="row">
		<div class="commenter-image">
			<?php echo $comment_author_url ? ( "{$link}{$avatar}</a>" ) : $avatar; ?>

			<?php if ( $parent_comment ) : ?>
			<div class="comment-connector"></div>
			<?php endif; ?>
		</div>
		<div class="commenter-details col-xs-10">
			<div class="name">
				<?php

				// Comment Author
				echo esc_html( $comment_author );

				// Reply Link
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => __( 'reply', 'kalium' ),
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'before' => ''
						)
					),
					$comment,
					$post
				);
				?>
			</div>

			<div class="date">
				<?php echo sprintf( __( '%s at %s', 'kalium' ), date_i18n( 'l', $comment_time ), date_i18n( 'h:m A', $comment_time ) ); ?>

				<?php if ( $parent_comment ) : ?>
				<div class="in-reply-to">
					&ndash; <?php echo sprintf( __( 'In reply to: %s', 'kalium' ), '<span class="replied-to">' . $parent_comment->comment_author . '</span>' ); ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="comment-text post-formatting">
				<?php comment_text(); ?>
			</div>
		</div>
	</div>
</div>
<?php
}

function laborator_list_comments_close() {
}


// Comment Form
add_action( 'comment_form_top', 'laborator_comment_form_top' );
add_action( 'comment_form_after', 'laborator_comment_form_after' );
add_filter( 'comment_form_default_fields', 'laborator_comment_form_default_fields' );
add_filter( 'comment_form_logged_in', 'laborator_comment_form_logged_in' );


function laborator_comment_form_top() {
	?>
	<div class="message-form">
		<div class="row">
	<?php
}

function laborator_comment_form_after() {
	?>
		</div>
	</div>
	<?php
}

function laborator_comment_form_default_fields( $fields ) {
	foreach ( $fields as $field => $field_markup ) {
		$field_markup = preg_replace( '/(<label(.*?)<\/label>)/i', '<div class="placeholder">\1</div>', $field_markup ); // Wrap label with kalium style markup
		$field_markup = preg_replace( '/<p.*?>(.*?)<\/p>/i', '\1', $field_markup ); // Remove Paragraph tag

		$fields[$field] = '<div class="col-sm-4"><div class="form-group absolute">' . $field_markup . '</div></div>';
	}
	return $fields;
}

function laborator_comment_form_logged_in( $html ) {
	$html = '<div class="col-xs-12 section-sub-title">' . $html . '</div>';
	return $html;
}


// Skin Compiler
add_filter( 'of_options_before_save', 'laborator_custom_skin_generate' );

function laborator_custom_skin_generate( $data ) {
	if ( ! defined( 'DOING_AJAX' ) ) {
		return $data;
	} elseif ( ! in_array( $_REQUEST['action'], array( 'of_ajax_post_action', 'lab_1cl_demo_install_package_content' ) ) ) {
		return $data;
	}
	
	if ( isset( $data['use_custom_skin'] ) && $data['use_custom_skin'] ) {
		update_option( 'kalium_skin_custom_css', '' );
	
		$colors = array();
		
		$custom_skin_bg_color         = $data['custom_skin_bg_color'];
		$custom_skin_link_color       = $data['custom_skin_link_color'];
		$custom_skin_headings_color   = $data['custom_skin_headings_color'];
		$custom_skin_paragraph_color  = $data['custom_skin_paragraph_color'];
		$custom_skin_footer_bg_color  = $data['custom_skin_footer_bg_color'];
		$custom_skin_borders_color    = $data['custom_skin_borders_color'];
		
		$custom_skin_bg_color         = $custom_skin_bg_color 			? 	$custom_skin_bg_color 			: '#FFFFFF';
		$custom_skin_link_color       = $custom_skin_link_color 		? 	$custom_skin_link_color 		: '#F6364D';
		$custom_skin_headings_color   = $custom_skin_headings_color 	? 	$custom_skin_headings_color 	: '#F6364D';
		$custom_skin_paragraph_color  = $custom_skin_paragraph_color 	? 	$custom_skin_paragraph_color	: '#777777';
		$custom_skin_footer_bg_color  = $custom_skin_footer_bg_color	? 	$custom_skin_footer_bg_color	: '#FAFAFA';
		$custom_skin_borders_color    = $custom_skin_borders_color 		? 	$custom_skin_borders_color		: '#EEEEEE';
		
		$files = array(
			kalium()->locateFile( "assets/less/other-less/lesshat.less" ) => "include",
			kalium()->locateFile( "assets/less/skin-generator.less" )     => "parse",
		);
		
		$vars = array(
			'bg-color'   => $custom_skin_bg_color,
			'link-color' => $custom_skin_link_color,
			'heading'    => $custom_skin_headings_color,
			'paragraph'  => $custom_skin_paragraph_color,
			'footer'     => $custom_skin_footer_bg_color,
			'border'     => $custom_skin_borders_color,
		);
		
		$css_style = kalium_generate_less_style( $files, $vars );
		
		update_option( 'kalium_skin_custom_css', $css_style );
		kalium_generate_custom_skin_file();
	}
	
	return $data;
}


// Font Compiler
add_filter( 'of_options_before_save', 'laborator_custom_font_generate' );

function laborator_custom_font_generate( $data ) {
	if ( ! defined( 'DOING_AJAX' ) )
	{
		return $data;
	} elseif ( ! in_array( $_REQUEST['action'], array( 'of_ajax_post_action', 'lab_1cl_demo_install_package_content' ) ) ) {
		return $data;
	}
	
	if ( isset( $data['use_custom_font'] ) && $data['use_custom_font'] ) {
		update_option( 'kalium_font_custom_css', '' );
		
		$default_font_family = '"Karla", Arial, sans-serif';
		
		$font_primary             = $data['font_primary'];
		$font_primary_weight      = $data['font_primary_weight'];
		$font_primary_transform   = $data['font_primary_transform'];
		
		$font_heading             = $data['font_heading'];
		$font_heading_weight      = $data['font_heading_weight'];
		$font_heading_transform   = $data['font_heading_transform'];
		
		$font_primary   = in_array( $font_primary, array( 'none' ) ) ? $default_font_family : "'{$font_primary}', sans-serif";
		$font_heading   = in_array( $font_heading, array( 'none' ) ) ? $default_font_family : "'{$font_heading}', sans-serif";
		
		$files = array(
			kalium()->locateFile( "assets/less/typo-generator.less" ) => "parse",
		);
		
		// Custom Fonts 
		if ( $data['custom_primary_font_url'] && $data['custom_primary_font_name'] ) {
			$font_primary            = $data['custom_primary_font_name'];
			$font_primary_weight     = $data['custom_primary_font_weight'];
			$font_primary_transform  = $data['custom_primary_font_transform'];
		}
		
		if ( $data['custom_heading_font_url'] && $data['custom_heading_font_name'] ) {
			$font_heading              = $data['custom_heading_font_name'];
			$font_heading_weight       = $data['custom_heading_font_weight'];
			$font_heading_transform    = $data['custom_heading_font_transform'];
		}
		
		$vars = array(
			'primary-font'           => $font_primary,
			'primary-font-weight'    => $font_primary_weight,
			'primary-transform'      => $font_primary_transform,
			
			'heading-font'           => $font_heading,
			'heading-font-weight'    => $font_heading_weight,
			'heading-transform'      => $font_heading_transform,
		);
		
		$css_style = kalium_generate_less_style( $files, $vars );
		
		update_option( 'kalium_font_custom_css', $css_style );
	}
	
	return $data;
}


// Remove Plugin Notices
add_filter( 'pre_option_revslider-valid', create_function( '', 'return "true";' ) );

if ( defined( 'LS_PLUGIN_BASE' ) ) {
	remove_action( 'after_plugin_row_' . LS_PLUGIN_BASE, 'layerslider_plugins_purchase_notice', 10, 3 );
}


// General Body Class Filter
add_filter( 'body_class', 'laborator_body_class' );

function laborator_body_class( $classes ) {
	if ( get_data( 'theme_borders' ) ) {
		$classes[] = 'has-page-borders';
	}
	
	if ( get_data( 'footer_fixed' ) ) {
		$classes[] = 'has-fixed-footer';
	}
	
	return $classes;
}


// Widget sidebar Visual Composer
add_filter( 'vc_shortcodes_css_class', 'lab_wc_vc_shortcodes_css_class_widgets_sidebar', 10, 3 );

function lab_wc_vc_shortcodes_css_class_widgets_sidebar( $el_class, $base = '', $atts = array() ) {
	if ( $base == 'vc_widget_sidebar' ) {
		$el_class .= ' blog-sidebar shop-sidebar';
	}
	
	return $el_class;
}



// Portfolio Like Share Options
add_shortcode( 'lab_portfolio_like_share', 'shortcode_lab_portfolio_like_share' );

function shortcode_lab_portfolio_like_share() {
	ob_start();
	include locate_template( 'tpls/portfolio-single-like-share.php' );
	return ob_get_clean();
}




// Title Parts
add_filter( 'wp_title', 'lab_wp_title_parts', 10, 3 );

function lab_wp_title_parts( $title, $sep, $seplocation ) {
	
	$kalium_separator = apply_filters( 'kalium_wp_title_separator', ' &ndash; ' );
	
	if ( empty( $sep ) ) {
		return $title;
	}
	
	$title_sep = explode( $sep, $title );
	
	if ( ! is_array( $title_sep ) ) {
		return $title;
	}
	
	if ( $seplocation == 'right' ) {
		$title = str_replace( $sep . end( $title_sep ), $kalium_separator . end( $title_sep ), $title );
	} else {
		$title = str_replace( reset( $title_sep ) . $sep, reset( $title_sep ) . $kalium_separator, $title );
	}
	
	return $title;
}


// Current Portfolio Menu Item Highlight (Bug fix)
function portfolio_current_nav_class( $classes, $item ) {
	
	if ( ! isset( $item->url ) ) {
		return $item;
	}
	
	$path_info = pathinfo( $item->url );
	
	if ( $path_info['filename'] == get_data( 'portfolio_prefix_url_slug', 'portfolio' ) ) {
		$classes[] = 'current-menu-item current_page_item';
	}
	
    return $classes;
}

if ( ! empty( $_SERVER['REQUEST_URI'] ) ) {
	$req_path_info = pathinfo( $_SERVER['REQUEST_URI'] );
	
	if ( ! empty( $req_path_info['filename'] ) && $req_path_info['filename'] == get_data( 'portfolio_prefix_url_slug', 'portfolio' ) ) {
		add_filter( 'nav_menu_css_class', 'portfolio_current_nav_class', 10, 2 );
	}
}

// Portfolio Post Type Args
add_filter( 'portfolioposttype_args', 'portfolio_posttype_args', 1000 );

function portfolio_posttype_args( $args ) {
	
	// URL Slug for Portfolio Works
	$portfolio_prefix_url_slug = sanitize_title( get_data( 'portfolio_prefix_url_slug' ) );
	
	if ( $portfolio_prefix_url_slug ) {
		$args['rewrite']['slug'] = $portfolio_prefix_url_slug;
	}
	
	return $args;
}


// Portfolio Category Args
add_filter( 'portfolioposttype_category_args', 'portfolio_category_tax_args', 1000 );
	
function portfolio_category_tax_args( $args ) {
	
	// URL Slug for Portfolio Category
	$portfolio_category_prefix_url_slug = sanitize_title( get_data( 'portfolio_category_prefix_url_slug' ) );
	
	if ( $portfolio_category_prefix_url_slug ) {
		$args['rewrite']['slug'] = $portfolio_category_prefix_url_slug;
	} else {
		$args['rewrite']['slug'] = 'portfolio-category';
	}
	
	return $args;
}


// Proportional Image Height on Blog
function kalium_blog_thumbnail_size_proportional( $size ) {
	return 'large';
}


// Ninja Forms Support
add_filter( 'ninja_forms_display_field_class', 'kalium_ninja_forms_display_field_class', 10, 3 );

function kalium_ninja_forms_display_field_class( $field_class, $field_id, $field_row ) {
	global $ninja_forms_fields;
	
	switch( $field_row['type'] ) {
		
		case '_submit':
		case '_timed_submit':
			$field_class .= ' btn btn-default';
			break;
		
		// Break Rule
		case '_hr':
			break;
			
		// Text Description
		case '_desc':
			break;
		
		// Checkbox & Radio
		case '_checkbox':
		case '_radio':
			break;
			
		// Text inputs
		default:
			$field_class .= ' form-control';
	}
	
	return $field_class;
}

// Footer Visibility
$footer_visibility = get_data( 'footer_visibility', true );

add_filter( 'kalium_show_footer', ( $footer_visibility ? '__return_true' : '__return_false' ), 1 );



// Video & Audio Shortcodes Replacement
add_filter( 'wp_video_shortcode', 'kalium_wp_video_shortcode_output', 100, 5 ); 
add_filter( 'wp_audio_shortcode', 'kalium_wp_audio_shortcode_output', 100, 5 ); 

function kalium_wp_video_shortcode_output( $html, $atts, $video, $post_id, $library ) {
	global $pagenow;
	
	if ( isset( $pagenow ) && $pagenow == 'post.php' ) {
		return $html;
	}
	
	// Enqueue VideoJS library
	wp_enqueue_script( 'video-js' );
	wp_enqueue_style( 'video-js' );
	
	// Prepare Atts
	$video_atts = array(
		'data-vsetup' => '',
		'preload'    => apply_filters( 'kalium_preload_media_src', 'auto' ),
		'poster' 	 => apply_filters( 'kalium_default_media_poster', '' ),
	);
	
	// Execute Filters
	$video_atts = apply_filters( 'kalium_video_shortcode_container_atts', $video_atts, $post_id );
	
	
	// Build Params
	$video_atts_html = '';
	
	foreach ( $video_atts as $key => $val ) {
		if ( empty( $val ) ) {
			continue;
		}
				
		if ( is_array( $val ) ) {
			$video_atts_html .= sanitize_title( $key ) . "='" . esc_attr( json_encode( $val ) ) . "' ";
		} else {
			$video_atts_html .= sanitize_title( $key ) . '="' . esc_attr( $val ) . '" ';
		}
	}
	
	$html = preg_replace( '/ preload=("|\').*?("|\')/', '', $html );
	$html = preg_replace( '/<video /', '<video ' . $video_atts_html, $html );
	
	return kalium_video_aspect_ratio_holder( $html, $atts['width'], $atts['height'] );
}

function kalium_wp_audio_shortcode_output( $html, $atts, $audio, $post_id, $library ) {
	
	// Enqueue VideoJS library
	wp_enqueue_script( array( 'video-js' ) );
	wp_enqueue_style( 'video-js' );
	
	// Prepare Atts
	$audio_atts = array(
		'data-vsetup' => '{}',
		'preload'    => apply_filters( 'kalium_preload_media_src', 'auto' ),
		'poster' 	 => apply_filters( 'kalium_default_media_poster', kalium()->assetsUrl( 'images/placeholder.png' ) )
	);
	
	// Execute Filters
	$audio_atts = apply_filters( 'kalium_audio_shortcode_container_atts', $audio_atts, $post_id );
	
	
	// Build Params
	$audio_atts_html = '';
	
	foreach ( $audio_atts as $key => $val ) {
		if ( empty( $val ) ) {
			continue;
		}
		
		if ( is_array( $val ) ) {
			$audio_atts_html .= sanitize_title( $key ) . "='" . esc_attr( json_encode( $val ) ) . "' ";
		} else {
			$audio_atts_html .= sanitize_title( $key ) . '="' . esc_attr( $val ) . '" ';
		}
	}
	
	$html = preg_replace( '/ preload=("|\').*?("|\')/', '', $html );
	$html = preg_replace( '/<audio /', '<audio ' . $audio_atts_html, $html );
	
	return $html;
}


// YouTube HTML Embed
add_filter( 'embed_oembed_html', 'kalium_embed_handler_html_replace_youtube', 1000, 3 );

function kalium_embed_handler_html_replace_youtube( $return, $url, $attr ) {

	if ( defined( 'DOING_AJAX' ) && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'parse-embed' ) {
		return $return;
	}
	
	// Width and height (Used to generate aspect ratio element)
	if ( isset( $attr['width'] ) && is_numeric( $attr['width'] ) ) {
		$width = $attr['width']; 
	}
	
	if ( isset( $attr['height'] ) && is_numeric( $attr['height'] ) ) {
		$height = $attr['height']; 
	}
		
	// Maintain Aspect Ratio
	$maintain_aspect_ratio = apply_filters( 'kalium_video_as_holder_maintain_aspect_ratio', true );

	// YouTube Videos
	if ( true == preg_match( "/(https?:\/\/(www\.)?youtube.com[^\s]+)/s", $url ) ) {
		
		// Enqueue VideoJS library including YouTube Extension
		wp_enqueue_script( array( 'video-js', 'video-js-youtube' ) );
		wp_enqueue_style( 'video-js' );
				
		// Prepare Atts
		$video_atts = array(
			'preload'    => apply_filters( 'kalium_preload_media_src', 'auto' ),
			'poster'     => apply_filters( 'kalium_default_media_poster', '' ),
			'width'      => $width,
			'height'     => $height,
			'data-vsetup' => array(
				'techOrder' => array( 'youtube' ),
				'sources' => array(
					array(
						'type' => 'video/youtube',
						'src' => $url
					)
				),
				'Youtube' => array(
					'iv_load_policy' => 1,
					'ytControls' => 3,
				)
			),
		);
		
		if ( in_array( 'realsize', array_keys( $attr ) ) ) {
			$maintain_aspect_ratio = false;
		}
	
		// Execute Filters
		$video_atts = apply_filters( 'kalium_video_shortcode_container_atts', $video_atts, 0 ); // Save as [video] shortcode
	
		// Build Params
		$video_atts_html = '';
		
		foreach( $video_atts as $key => $val ) {
			if ( empty( $val ) ) {
				continue;
			}
			
			if ( is_array( $val ) ) {
				$video_atts_html .= sanitize_title( $key ) . "='" . esc_attr( json_encode( $val ) ) . "' ";
			} else {
				$video_atts_html .= sanitize_title( $key ) . '="' . esc_attr( $val ) . '" ';
			}
		}
		
		ob_start();

?><video class="<?php echo apply_filters( 'wp_video_shortcode_class', '' ); ?>" controls <?php echo trim( $video_atts_html ); ?>></video><?php
		
		$return = ob_get_clean();
	}
	
	return kalium_video_aspect_ratio_holder( $return, $width, $height, $maintain_aspect_ratio );
}


// Video & Audio Processing Library
add_filter( 'wp_video_shortcode_library', 'kalium_wp_video_shortcode_library' );
add_filter( 'wp_audio_shortcode_library', 'kalium_wp_video_shortcode_library' );

function kalium_wp_video_shortcode_library( $library ) {
	return "video-js";
}


// Video & Audio Container Class
add_filter( 'wp_video_shortcode_class', 'kalium_wp_video_shortcode_class' );
add_filter( 'wp_audio_shortcode_class', 'kalium_wp_video_shortcode_class' );

function kalium_wp_video_shortcode_class( $classes ) {
	
	$classes .= ' video-js video-js-el';
	
	// VideoJS Skin (default)
	$classes .= ' vjs-default-skin';
	
	// Minimal Skin
	if ( get_data( 'videojs_player_skin' ) == 'minimal' ) {
		$classes .= ' vjs-minimal-skin';
	}
	
	return trim( $classes );
}


// Generate Aspect Ratio Container for YouTube Videos
function kalium_video_aspect_ratio_holder( $html, $width = 0, $height = 0, $enabled = true ) {
	
	if ( is_numeric( $width ) && is_numeric( $height ) && $width > 0 ) {
		$uniqueid = laborator_unique_id();
		$padding = $height / $width * 100 . "";
		
		if( strlen( $padding ) > 5 ) {
			$padding = substr( $padding, 0, 6 );
		}
		
		generate_custom_style( "#{$uniqueid} .video-aspect-ratio", "padding-bottom: {$padding}%" );
		
		$html = '<div id="' . $uniqueid . '" class="video-as-holder' . ( $enabled ? ' enabled' : '' ) . '"><div class="image-placeholder video-aspect-ratio">' . kalium_image_placeholder_preloader_icon( false ) . '</div>' . $html . '</div>';
	}
	
	return $html;
}


// Embed Defaults for Kalium Theme
add_filter( 'embed_defaults', 'kalium_embed_defaults', 10 );

function kalium_embed_defaults() {
	// Default player size
	$width     = 560;
	$height    = 315;
	
	return compact( 'width', 'height' );
}

// Video Preloading
#add_filter( 'kalium_preload_media_src', 'kalium_preload_media_src_filter' );

function kalium_preload_media_src_filter( $preload ) {
	return get_data( 'videojs_player_preload', 'auto' );
}


// Video Auto Play
add_filter( 'kalium_video_shortcode_container_atts', 'kalium_video_shortcode_container_atts_autoplay_filter' );
add_filter( 'kalium_audio_shortcode_container_atts', 'kalium_video_shortcode_container_atts_autoplay_filter' );

function kalium_video_shortcode_container_atts_autoplay_filter( $atts ) {
	
	$autoplay = get_data( 'videojs_player_autoplay', 'no' );
	
	if ( $autoplay == 'yes' ) {
		$atts['autoplay'] = 'yes';
	} else if ( $autoplay == 'on-viewport' ) {
		$atts['data-autoplay'] = 'on-viewport';
	}
	
	return $atts;
}


// Video Loop
#add_filter( 'kalium_video_shortcode_container_atts', 'kalium_video_shortcode_container_atts_loop_filter' );

function kalium_video_shortcode_container_atts_loop_filter( $atts ) {
	
	if ( get_data( 'videojs_player_loop', 'no' ) == 'yes' ) {
		$atts['loop'] = 'yes';
	}
	
	return $atts;
}


// LayerSlider hide Notice
add_filter( 'option_layerslider-authorized-site', '__return_true', 1000 );


// File Based Custom Skin
add_filter( 'kalium_use_filebased_custom_skin', 'kalium_use_filebased_custom_skin_filter', 10 );

function kalium_use_filebased_custom_skin_filter( $use ) {
	// Generate Skin Hash (Prevent Cache Issues)
	if ( $use ) {
		$skin_colors_vars = array( 'custom_skin_bg_color', 'custom_skin_link_color', 'custom_skin_link_color', 'custom_skin_headings_color', 'custom_skin_paragraph_color', 'custom_skin_footer_bg_color', 'custom_skin_borders_color' );
		$skin_colors_hash = '';
		
		foreach ( $skin_colors_vars as $var ) {
			$skin_colors_hash .= get_data( $var );
		}
		
		$skin_colors_hash = md5( kalium()->getVersion() . $skin_colors_hash );
		

		// Eneuque skin		
		$custom_skin_filename = kalium_get_custom_skin_filename();
		
		if ( is_child_theme() ) {
			wp_enqueue_style( 'custom-skin', get_stylesheet_directory_uri() . '/' . $custom_skin_filename, null, $skin_colors_hash );
		} else {
			wp_enqueue_style( 'custom-skin', get_stylesheet_directory_uri() . '/assets/css/' . $custom_skin_filename, null, $skin_colors_hash );
		}
	}
}


// SVG Logo Generate Height
function kalium_fix_svg_width_and_height( $image, $attachment_id, $size, $icon ) {
	if ( is_array( $image ) && 'svg' == strtolower( pathinfo( $image[0], PATHINFO_EXTENSION ) ) && function_exists( 'simplexml_load_file' ) ) {
		$svgfile = @simplexml_load_file( str_replace( get_bloginfo( 'url' ), rtrim( ABSPATH, '/' ), $image[0] ) );
		
		if ( $svgfile ) {	
			if ( isset( $svgfile->attributes()->width ) && isset( $svgfile->attributes()->height ) ) {
				$image[1] = (int) $svgfile->attributes()->width;
				$image[2] = (int) $svgfile->attributes()->height;
			} else if ( isset( $svgfile->rect ) ) {
				$width = reset( $svgfile->rect['width'] );
				$height = reset( $svgfile->rect['height'] );
				
				$image = array( $image[0], $width, $height );
			}
		}
	}
	
	return $image;
}

add_filter( 'wp_get_attachment_image_src', 'kalium_fix_svg_width_and_height', 10, 4 );


// Portfolio Loop Thumbnail Custom Sizes
function kalium_portfolio_loop_custom_thumbnail_size( $size, $type ) {
	if ( 'type-1' == $type && ( $custom_size = get_data( 'portfolio_thumbnail_size_1' ) ) ) {
		return $custom_size;
	} elseif ( 'type-2' == $type && ( $custom_size = get_data( 'portfolio_thumbnail_size_2' ) ) ) {
		return $custom_size;
	}
	
	return $size;
}

// Portfolio Head Title Meta Tag
function portfolioposttype_args_head_title( $args ) {
	$args['labels']['name'] = get_data( 'portfolio_title' );
	return $args;
}

if ( get_data( 'portfolio_title' ) ) {
	add_filter( 'portfolioposttype_args', 'portfolioposttype_args_head_title' );
}

// Disabled comments on blog posts
if ( 'hide' == get_data( 'blog_comments' ) ) {
	add_filter( 'kalium_blog_enable_comments', '__return_false' );
}

// Prevent highlighting of homepage URL HASH
function kalium_homepage_url_hash_fix( $classes, $item, $args, $depth ) {
	if ( $item instanceof WP_Post ) {
		$url = $item->url;
		
		if ( false !== strpos( $url, home_url( '#' ) ) ) {
			$current_menu_item = get_array_key( $GLOBALS, 'currentItemAlreadySet' );
			
			if ( ! $current_menu_item ) {
				$GLOBALS['currentItemAlreadySet'] = $item;
			} else {
				$remove_classes = array( 'current_page_item', 'current-menu-item', 'current-menu-ancestor', 'current_page_ancestor' );
				
				foreach ( $remove_classes as $class_to_remove ) {
					$current_item_index = array_search( $class_to_remove, $classes );
					
					if ( false !== $current_item_index ) {
						unset( $classes[ $current_item_index ] );
					}
				}
			}
		}
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'kalium_homepage_url_hash_fix', 100, 4 );


/** DEPRECATED **/

// Remove Dot from Social Networks
function kalium_social_networks_name_remove_dot( $name ) {
	return preg_replace( '/\.$/', '', $name );
}

// Default Font
function kalium_set_default_default_font( $fonts, $valid_fonts, $published_fonts ) {
	$use_default_font = ! get_data( 'use_custom_font' ) && empty( $fonts ) && ! is_admin() && ! defined( 'DOING_AJAX' ) && $valid_fonts && $published_fonts;
	
	if ( $use_default_font ) {
		/*
		$roboto = reset( $roboto_unserialized['fontFaces'] );
		$roboto['id'] = 'default-font';
		
		unset( $roboto['options']['data']->files );
		unset( $roboto['options']['data']->lastModified );
		unset( $roboto['options']['data']->version );
		unset( $roboto['options']['data']->kind );
		unset( $roboto['options']['data']->category );
		unset( $roboto['options']['conditional_loading'] );
		unset( $roboto['options']['created_time'] );
		*/
		
		$default_font = array(
			'id' => 'default-font',
			'source' => 'google',
			'options' => array(
				'data' => ( (object) array(
					 'family' => 'Roboto',
					 'variants' =>  array( '100', '100italic', '300', '300italic', 'regular', 'italic', '500', '500italic', '700', '700italic', '900', '900italic', ),
					 'subsets' => array( 'greek', 'latin-ext', 'cyrillic', 'vietnamese', 'latin', 'greek-ext', 'cyrillic-ext', ),
				) ),
				'selectors' => array(
					array(
						'selector' => 'h1, h2, h3, h4, h5, h6',
						'variant' => '300',
						'font-sizes' => array( 'general' => '', 'desktop' => '', 'tablet' => '', 'mobile' => '', 'unit' => 'px', ),
					),
					array(
						'selector' => 'body, p',
						'variant' => '300',
						'font-sizes' => array( 'general' => '', 'desktop' => '', 'tablet' => '', 'mobile' => '', 'unit' => 'px', ),
					),
				),
			),
			'valid'          => true,
			'family'         => 'Roboto',
			'variants'       => array( '300', '300italic', ),
			'subsets'        => array( 'latin', ),
			'font_status'    => 'published',
			'font_placement' => '',
		);
		
		$fonts[] = $default_font;
	}
	
	return $fonts;
}

add_filter( 'typolab_get_fonts', 'kalium_set_default_default_font', 10, 3 );