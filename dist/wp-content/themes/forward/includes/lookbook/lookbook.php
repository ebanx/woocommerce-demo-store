<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


include_once dirname(__FILE__).'/includes/functions.php';

if (dhwc_is_active() && !class_exists('DHWCLookbook')){
	class DHWCLookbook {
		
		public function __construct(){
			if(taxonomy_exists('product_lookbook'))
				return;
			
			add_action( 'woocommerce_register_taxonomy',array($this,'register_taxonomy'));
			
			
			if (is_admin()){
				include_once dirname(__FILE__).'/includes/admin.php';
			}else{
				add_shortcode('product_lookbook', array(&$this,'product_lookbook_shortcode'));
			}

			add_filter( 'template_include',array($this,'template_include'));
			
		}
		
		public function register_taxonomy(){
			if(taxonomy_exists('product_lookbook'))
				return;
			
			global $woocommerce;
			
			$permalinks 	= get_option( 'woocommerce_permalinks' );
			$shop_page_id = woocommerce_get_page_id('shop');
			$base_slug 		= $shop_page_id > 0 && get_post( $shop_page_id ) ? get_page_uri( $shop_page_id ) : 'shop';
		
			$product_lookbok_slug = empty( $permalinks['lookbok_base'] ) ? _x( 'product-lookbok', 'slug', 'forward' ) : $permalinks['lookbok_base'];
		
			register_taxonomy ( 'product_lookbook', 
				apply_filters ( 'dhwc_taxonomy_objects_product_lookbok', array ('product' ) ), 
				apply_filters ( 'dhwc_taxonomy_args_product_lookbok', array (
					'hierarchical' => true,
					'update_count_callback' => '_update_post_term_count',
					'label' => __ ( 'Product Lookbooks', 'forward' ),
					'labels' => array (
							'name' => __ ( 'Product Lookbooks', 'forward' ),
							'singular_name' => __ ( 'Product Lookbook', 'forward' ),
							'menu_name' => _x ( 'Lookbooks', 'Admin menu name', 'forward' ),
							'search_items' => __ ( 'Search Product Lookbooks', 'forward' ),
							'all_items' => __ ( 'All Product Lookbooks', 'forward' ),
							'parent_item' => __ ( 'Parent Product Lookbook', 'forward' ),
							'parent_item_colon' => __ ( 'Parent Product Lookbook:', 'forward' ),
							'edit_item' => __ ( 'Edit Product Lookbook', 'forward' ),
							'update_item' => __ ( 'Update Product Lookbook', 'forward' ),
							'add_new_item' => __ ( 'Add New Product Lookbook', 'forward' ),
							'new_item_name' => __ ( 'New Product Lookbook Name', 'forward' ) 
					),
					'show_ui' => true,
					'show_in_nav_menus' => true,
					'query_var' => true,
					'capabilities' => array (
							'manage_terms' => 'manage_product_terms',
							'edit_terms' => 'edit_product_terms',
							'delete_terms' => 'delete_product_terms',
							'assign_terms' => 'assign_product_terms' 
					),
					'rewrite' => array (
							'slug' => $product_lookbok_slug,
							'with_front' => false,
							'hierarchical' => true 
					) 
			) ) );
		}
		
		
		/**
		 * Filter product by brand
		 *
		 * @param $filtered_posts
		*/
		function dhwc_loop_shop_post_in_brand($filtered_posts){
			global $woocommerce, $_chosen_attributes;
			if ( is_active_widget( false, false, 'dhwc_widget_layered_nav', true ) && ! is_admin() ) {
				if ( ! empty( $_GET[ 'filter_product_brand' ] ) ) {
					$terms 	= explode( ',', $_GET[ 'filter_product_brand' ] );
		
					if ( sizeof( $terms ) > 0 ) {
		
						$_chosen_attributes['product_brand']['terms'] = $terms;
						$_chosen_attributes['product_brand']['query_type'] = 'and';
		
						$matched_products = get_posts(
								array(
										'post_type' 	=> 'product',
										'numberposts' 	=> -1,
										'post_status' 	=> 'publish',
										'fields' 		=> 'ids',
										'no_found_rows' => true,
										'tax_query' => array(
												'relation' => 'AND',
												array(
														'taxonomy' 	=> 'product_brand',
														'terms' 	=> $terms,
														'field' 	=> 'id'
												)
										)
								)
						);
		
						$woocommerce->query->layered_nav_post__in = array_merge( $woocommerce->query->layered_nav_post__in, $matched_products );
						$woocommerce->query->layered_nav_post__in[] = 0;
		
						if ( sizeof( $filtered_posts ) == 0 ) {
							$filtered_posts = $matched_products;
							$filtered_posts[] = 0;
						} else {
							$filtered_posts = array_intersect( $filtered_posts, $matched_products );
							$filtered_posts[] = 0;
						}
					}
				}
			}
			return (array) $filtered_posts;
		}
		
		
		/**
		 * Load a template.
		 *
		 * Handles template usage so that we can use our own templates instead of the themes.
		 *
		 * Templates are in the 'templates' folder. woocommerce looks for theme
		 * overrides in /theme/woocommerce/ by default
		 *
		 * For beginners, it also looks for a woocommerce.php template first. If the user adds
		 * this to the theme (containing a woocommerce() inside) this will be used for all
		 * woocommerce templates.
		 *
		 * @access public
		 * @param mixed $template
		 * @return string
		 */
		function template_include($template){
			$template_url = apply_filters( 'woocommerce_template_url', 'woocommerce/' );
			$find = array( 'woocommerce.php' );
			$file = '';
			if ( is_tax( 'product_lookbook' ) ) {
				$term = get_queried_object();
	
				$file 		= 'taxonomy-' . $term->taxonomy . '.php';
				$find[] 	= 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
				$find[] 	= $template_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
				$find[] 	= $file;
				$find[] 	= $template_url . $file;
	
			}
			if ( $file ) {
				$template = locate_template( $find );
				if ( ! $template ) $template = untrailingslashit(dirname( __FILE__ )) . '/templates/' . $file;
			}
			return $template;
		}
		
		
	    
	    public function product_lookbook_shortcode($atts,$content=null){
	    	global $woocommerce_loop;
	    	
	    	$atts = shortcode_atts( array(
	    		'number'     => null,
	    		'orderby'    => 'name',
	    		'order'      => 'ASC',
	    		'columns'    => '4',
	    		'hide_empty' => 1,
	    		'parent'     => '',
	    		'ids'        => ''
	    	), $atts );
	    	
	    	if ( isset( $atts['ids'] ) ) {
	    		$ids = explode( ',', $atts['ids'] );
	    		$ids = array_map( 'trim', $ids );
	    	} else {
	    		$ids = array();
	    	}
	    	
	    	$hide_empty = ( $atts['hide_empty'] == true || $atts['hide_empty'] == 1 ) ? 1 : 0;
	    	
	    	// get terms and workaround WP bug with parents/pad counts
	    	$args = array(
	    		'orderby'    => $atts['orderby'],
	    		'order'      => $atts['order'],
	    		'hide_empty' => $hide_empty,
	    		'include'    => $ids,
	    		'pad_counts' => true,
	    		'child_of'   => $atts['parent']
	    	);
	    	
	    	$product_brands = get_terms( 'product_brand', $args );
	    	
	    	if ( '' !== $atts['parent'] ) {
	    		$product_brands = wp_list_filter( $product_brands, array( 'parent' => $atts['parent'] ) );
	    	}
	    	
	    	if ( $hide_empty ) {
	    		foreach ( $product_brands as $key => $brand ) {
	    			if ( $brand->count == 0 ) {
	    				unset( $product_brands[ $key ] );
	    			}
	    		}
	    	}
	    	
	    	if ( $atts['number'] ) {
	    		$product_brands = array_slice( $product_brands, 0, $atts['number'] );
	    	}
	    	
	    	$woocommerce_loop['columns'] = $atts['columns'];
	    	
	    	ob_start();
	    	
	    	// Reset loop/columns globals when starting a new loop
	    	$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';
	    	
	    	if ( $product_brands ) {
	    	
	    		woocommerce_product_loop_start();
	    	
	    		foreach ( $product_brands as $brand ) {
	    	
	    			wc_get_template( 'content-product_brand.php', array(
	    			'brand' => $brand
	    			) );
	    	
	    		}
	    	
	    		woocommerce_product_loop_end();
	    	
	    	}
	    	
	    	woocommerce_reset_loop();
	    	
	    	return '<div class="woocommerce columns-' . $atts['columns'] . '">' . ob_get_clean() . '</div>';
	    }
	}
	new DHWCLookbook();
}