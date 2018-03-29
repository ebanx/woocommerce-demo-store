<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DH_Woocommerce' ) ) :
	class DH_Woocommerce {
	
		protected static $_instance = null;
	
		public function __construct() {
			global $pagenow;
			
			add_action( 'init', array( &$this, 'init' ) );
			if ( is_admin() && isset( $_GET['activated'] ) && $pagenow === 'themes.php' ) {
				add_action( 'init', array( &$this, 'update_product_image_size' ), 1 );
			}
			if(is_admin()){
				add_action( 'created_term', array(&$this,'product_cat_heading_save'), 10,3 );
				add_action( 'edit_term',array(&$this, 'product_cat_heading_save'), 10,3 );
				
				//cat heading
				add_action('product_cat_add_form_fields',array(&$this,'product_tax_add_heading_fields'),20,3);
				add_action('product_cat_edit_form_fields',array(&$this,'product_tax_edit_heading_fields'),20,3);
				
				//tag heading
				add_action('product_tag_add_form_fields',array(&$this,'product_tax_add_heading_fields'),20,3);
				add_action('product_tag_edit_form_fields',array(&$this,'product_tax_edit_heading_fields'),20,3);
				
				
				//brand heading
				add_action('product_brand_add_form_fields',array(&$this,'product_tax_add_heading_fields'),20,3);
				add_action('product_brand_edit_form_fields',array(&$this,'product_tax_edit_heading_fields'),20,3);
			}
			add_action( 'wp_ajax_dh_json_search_products', array( &$this, 'json_search_products' ) );
		}

		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		
		public function init() {
			if ( ! defined( 'WOOCOMMERCE_VERSION' ) ) {
				return;
			}
			
			add_action( 'loop_shop_post_in', array($this,'filter_product_by_category'), 11 );
			
			if(dh_get_theme_option('woo-minicart-style','side') == 'side'){
				add_action('wp_footer', array(&$this,'get_minicart_side'));
			}
			
			add_filter('dh_get_theme_option', array(&$this,'dh_get_theme_option_shop_filter'),10,2);
			
			
			if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
				// WooCommerce 2.1 or above is active
				add_filter( 'woocommerce_enqueue_styles', '__return_false' );
			} else {
				// WooCommerce is less than 2.1
				define( 'WOOCOMMERCE_USE_CSS', false );
			}
			
			add_filter('dh_use_feature_product_image_in_single', '__return_true');
			
			// remove wrapper
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
			
			//remove result count
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			
			// remove page title
			add_filter( 'woocommerce_show_page_title', '__return_false' );
			
			// remove default loop price
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			
			// Loop shop per page
			add_filter( 'loop_shop_per_page', array( &$this, 'loop_shop_per_page' ) );
			
			//WooCommerce 2.6 hooks
			remove_filter( 'post_class', 'wc_product_post_class', 20, 3 );
				
			
			//woocommerce 2.5 action
			remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
			remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
				
			remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
			add_action( 'woocommerce_before_subcategory_title', array(&$this,'subcategory_thumbnail'), 10 );
			
			// Loop thumbnail
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', array( &$this, 'template_loop_product_thumbnail' ), 10 );
			
			if(apply_filters('dh_use_template_loop_product_frist_thumbnail', true)){
				add_action( 'woocommerce_before_shop_loop_item_title', array( &$this, 'template_loop_product_frist_thumbnail' ), 11 );
			}
			// Loop actions
			//add_action( 'woocommerce_after_shop_loop_item', array( &$this, 'template_loop_quickview' ), 11 );
			
			//wishlist
			// add_action( 'woocommerce_before_shop_loop_item_title', array( &$this, 'template_loop_wishlist' ), 12 );
			
			// price Html
			add_filter( 'woocommerce_get_price_html', array( &$this, 'get_price_html' ) );
			
			//Tab product
			add_action( 'wp_ajax_dh_get_product_tab', array( &$this, 'get_product_tab_content' ) );
			add_action( 'wp_ajax_nopriv_dh_get_product_tab', array( &$this, 'get_product_tab_content' ) );
			
			// Quick view
			add_action( 'wp_ajax_wc_loop_product_quickview', array( &$this, 'quickview' ) );
			add_action( 'wp_ajax_nopriv_wc_loop_product_quickview', array( &$this, 'quickview' ) );
			
			// Remove minicart
			add_action( 'wp_ajax_wc_minicart_remove_item', array( &$this, 'minicart_remove_item' ) );
			add_action( 'wp_ajax_nopriv_wc_minicart_remove_item', array( &$this, 'minicart_remove_item' ) );
			// add_to_cart_fragments
			add_filter( 'add_to_cart_fragments', array( &$this, 'add_to_cart_fragments' ) );
			
			// Upsell products
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			add_action( 'woocommerce_after_single_product_summary', array( &$this, 'upsell_display' ), 15 );
			
			// Related products
			add_filter( 'woocommerce_output_related_products_args', array( &$this, 'related_products_args' ) );
			
			// Cross sell products
			remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
			// add_action( 'woocommerce_cart_collaterals', array( &$this, 'cross_sell_display' ), 15 );

			
			add_action('template_redirect', array(&$this,'single_fullwidth_layout'),99);
			add_action('pre_get_posts', array($this,'search_by_cat'));
			
			add_action( 'woocommerce_single_product_summary', array( &$this, 'single_sharing' ), 50 );
			
			remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
			remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		}
		
		public static function countdown_html(){
			global $product,$post, $woocommerce_loop;
			?>
			<?php if(isset($woocommerce_loop['show_countdown']) && $woocommerce_loop['show_countdown'] && $product->is_on_sale()){?>
				<?php 
				if ( $product->product_type != 'variable' ) {
					$sales_price_to = get_post_meta($post->ID, '_sale_price_dates_to', true);
				}else{
					$product_variables = $product->get_available_variations();
					if ( count( array_filter( $product_variables ) ) > 0 ) {
						$product_variables = array_filter( $product_variables );
						foreach ( $product_variables as $product_variable ) {
							$end_date   = get_post_meta( $product_variable['variation_id'], '_sale_price_dates_to', true );
							if ( $end_date != '' ) {
								$sales_price_to = $end_date;
							}
						}
					
					}
				}
				$sales_price_to = apply_filters('dh_woocommerce_sales_price_to', $sales_price_to,$product);
				
				if(empty($sales_price_to) || defined('DH_PREVIEW')){
					$sales_price_to = time() + 7 * 24 * 60 * 60;
				}
				$sales_price_to = date_i18n('Y/m/d', $sales_price_to);
				$html = '
				<div class="countdown-item">
					<div class="countdown-item-value">%D</div>
					<div class="countdown-item-label">'.esc_html__('Day','forward').'</div>
				</div>
				<div class="countdown-item">
					<div class="countdown-item-value">%H</div>
					<div class="countdown-item-label">'.esc_html__('Hours','forward').'</div>
				</div>
				<div class="countdown-item">
					<div class="countdown-item-value">%M</div>
					<div class="countdown-item-label">'.esc_html__('Mins','forward').'</div>
				</div>
				<div class="countdown-item">
					<div class="countdown-item-value">%S</div>
					<div class="countdown-item-label">'.esc_html__('Secs','forward').'</div>
				</div>';
				?>
				<div class="product-sale-date" data-html="<?php echo esc_attr($html)?>" data-toggle="countdown" data-end="<?php echo esc_attr($sales_price_to)?>" data-now="<?php echo strtotime("now") ?>">
					<div class="countdown-content"></div>
				</div>
				<?php
				}
				?>
			<?php
		}
		
		public function filter_product_by_category($filtered_posts){
			global $woocommerce, $_chosen_attributes;
			if ( is_active_widget( false, false, 'dh_woocommerce_category_filter', true ) && ! is_admin() ) {
				if ( ! empty( $_GET[ 'filter_product_cat' ] ) ) {
					$terms 	= explode( ',', $_GET[ 'filter_product_cat' ] );
					if ( sizeof( $terms ) > 0 ) {
			
						$_chosen_attributes['product_cat']['terms'] = $terms;
						$_chosen_attributes['product_cat']['query_type'] = 'and';
			
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
										'taxonomy' 	=> 'product_cat',
										'terms' 	=> $terms,
										'field' 	=> 'id'
									)
								)
							)
						);
						if(isset($woocommerce->query->layered_nav_post__in)){
							$woocommerce->query->layered_nav_post__in = array_merge( $woocommerce->query->layered_nav_post__in, $matched_products );
							$woocommerce->query->layered_nav_post__in[] = 0;
						}
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
		
		public function search_by_cat($query) {
			global $wp_query;
			if (is_admin() || !is_search())
				return false;
			if ( $query->is_main_query() && $query->is_search() && $product_cat = $query->get( 'category' ) ) {
				$query->set(
					'tax_query',
					array(
						array(
							'taxonomy' => 'product_cat',
							'field' => 'slug',
							'terms' => $product_cat,
							'include_children' => false ) ) );
			}
		}
		
		public function dh_get_theme_option_shop_filter($value, $option){
			if($option == 'woo-shop-filter'){
				switch ($value){
					case 'shop':
						if(is_shop())
							return true;
							else
								return false;
							break;
					case 'taxonomy':
						if(is_product_taxonomy())
							return true;
							else
								return false;
							break;
					case 'all':
						if(is_shop() || is_product_taxonomy())
							return true;
							else
								return false;
							break;
				}
			}
			return $value;
		}

		public function single_fullwidth_layout(){
			
		}
		

		public static function content($is_ajax = false){
			global $wp_query;
			?>
			<?php
			if ( is_singular( 'product' ) ) {
	
				while ( have_posts() ) : the_post();
	
					wc_get_template_part( 'content', 'single-product' );
	
				endwhile;
	
			} else { ?>
				<?php 
				
				/**
				 * script
				 * {{
				 */
				if(!$is_ajax)
					wp_enqueue_script('carouFredSel');
				?>
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
	
					<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
	
				<?php endif; ?>
				
				<?php do_action( 'woocommerce_archive_description' ); ?>
				<?php 
				$current_view_mode = dh_get_theme_option('dh_woocommerce_view_mode','grid');
				if(isset($_GET['mode']) && in_array($_GET['mode'], array('grid','list'))){
					$current_view_mode =  $_GET['mode'];
				}
				$grid_mode_href= ($current_view_mode == 'list' ? ' href="'.esc_url(add_query_arg('mode','grid')).'"' :'');
				$list_mode_href= ($current_view_mode == 'grid' ? ' href="'.esc_url(add_query_arg('mode','list')).'"' :'');
				
				$dh_ul_product_class = '';
				$woo_products_pagination = dh_get_theme_option('woo-products-pagination','page_num');
				if($woo_products_pagination === 'infinite_scroll'){
					$dh_ul_product_class = 'infinite-scroll-wrap';
				}elseif ($woo_products_pagination === 'loadmore'){
					$dh_ul_product_class = 'loadmore-wrap';
				}
				?>
				<?php if ( $wp_query->found_posts && woocommerce_products_will_display() ) {?>
					<?php if(!dh_get_theme_option('woo-shop-filter',0)):?>
					<div class="shop-toolbar">
						<div class="view-mode">
							<a class="grid-mode<?php echo ($current_view_mode == 'grid' ? ' active' :'')?>" title="<?php esc_attr_e('Grid','forward')?>" <?php echo ($grid_mode_href)?>><i class="fa fa-th"></i></a>
							<a class="list-mode<?php echo ($current_view_mode == 'list' ? ' active' :'')?>" title="<?php esc_attr_e('List','forward')?>" <?php echo ($list_mode_href) ?>><i class="fa fa-list"></i></a>
						</div>
						<?php woocommerce_catalog_ordering() ?>
					</div>
					<?php endif;?>
					<?php if(dh_get_theme_option('woo-shop-filter',0) && is_active_sidebar('sidebar-shop-filter')) :?>
					<div class="sidebar-shop-filter clearfix" data-toggle="shop-filter-ajax">
						<label><?php esc_html_e('Filter By:','forward')?></label>
						<?php 
						$sidebars_widgets = wp_get_sidebars_widgets();
						$count = count( (array) $sidebars_widgets[ 'sidebar-shop-filter' ] );
						$count = absint($count);
						?>
						<div class="sidebar-shop-filter-wrap sidebar-shop-filter-<?php echo esc_attr($count)?>">
							<?php
							dynamic_sidebar('sidebar-shop-filter')
							?>
						</div>
					</div>
					<?php endif;?>
				<?php }?>
				<div class="shop-loop-wrap <?php echo $dh_ul_product_class?>">
					<div class="filter-ajax-loading">
						<div class="fade-loading"><i></i><i></i><i></i><i></i></div>
					</div>
					<div class="shop-loop <?php echo esc_attr($current_view_mode)?>">
						<?php if(is_search() && is_post_type_archive( 'product' )):?>
							<h3 class="woocommerce-search-text"><?php dh_page_title() ?></h3>
						<?php endif;?>
						<?php if ( have_posts() ) : ?>
						<?php woocommerce_product_loop_start(); ?>
							<?php woocommerce_product_subcategories(); ?>
							<?php while ( have_posts() ) : the_post(); ?>
		
								<?php wc_get_template_part( 'content', 'product' ); ?>
		
							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
						<?php do_action('woocommerce_after_shop_loop'); ?>
		
						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
		
							<?php wc_get_template( 'loop/no-products-found.php' ); ?>
		
						<?php endif;?>
					</div>
				</div>
				<?php 
			}
		}
		
		public function subcategory_thumbnail($category){
			$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'dh-full' );
			$dimensions    			= wc_get_image_size( $small_thumbnail_size );
			$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
			
			if ( $thumbnail_id ) {
				$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
				$image = $image[0];
			} else {
				$image = wc_placeholder_img_src();
			}
			
			if ( $image ) {
				// Prevent esc_url from breaking spaces in urls for image embeds
				// Ref: http://core.trac.wordpress.org/ticket/23605
				$image = str_replace( ' ', '%20', $image );
			
				echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
			}
		}
		
		public function cross_sell_display() {
			woocommerce_cross_sell_display( 2, 2 );
		}

		public function upsell_display() {
			woocommerce_upsell_display( 12, 4 );
		}

		public function related_products_args() {
			$args = array( 'posts_per_page' => 12, 'columns' => 4 );
			return $args;
		}
		
		// Number of products per page
		public function loop_shop_per_page() {
			$per_page = dh_get_theme_option( 'woo-per-page', 12 );
			if ( isset( $_GET['per_page'] ) )
				$per_page = absint( $_GET['per_page'] );
			return $per_page;
		}

		public function removeprettyPhoto() {
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'prettyPhoto' );
		}

		public function update_product_image_size() {
			if ( ! defined( 'WOOCOMMERCE_VERSION' ) ) {
				return;
			}
			$catalog = array( 'width' => '300', 'height' => '350', 'crop' => 1 );
			$single = array( 'width' => '800', 'height' => '850', 'crop' => 1 );
			$thumbnail = array( 'width' => '100', 'height' => '100', 'crop' => 1 );
			
			update_option( 'shop_catalog_image_size', $catalog );
			update_option( 'shop_single_image_size', $single );
			update_option( 'shop_thumbnail_image_size', $thumbnail );
		}
		
		public function get_product_tab_content(){
			global $woocommerce_loop;
			$cat_slug = isset($_POST['cat_slug']) ? $_POST['cat_slug'] : '';
			$columns = isset($_POST['columns']) ? absint($_POST['columns']) : 4;
			$query = isset($_POST['query']) ? $_POST['query'] : '';
			$response = array(
				'status'=>0,
				'content'=>'',
			);
			if(!empty($cat_slug) && !empty($query)){
				$query['tax_query'] = array(
					array(
						'taxonomy' 		=> 'product_cat',
						'terms' 		=> array($cat_slug),
						'field' 		=> 'slug',
					)
				);
				$products = new WP_Query($query);
				
				$columns                     = absint( $columns );
				$woocommerce_loop['columns'] = $columns;
				ob_start();
				if($products->have_posts()):
				?>
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
	
						<?php wc_get_template_part( 'content', 'product' ); ?>
	
					<?php endwhile; // end of the loop. ?>
	
				<?php woocommerce_product_loop_end(); ?>
				<?php

				$response['status'] = 1;
				
				endif;
				woocommerce_reset_loop();
				wp_reset_postdata();
				$response['content'] = trim(ob_get_clean());
				
			}
			wp_send_json($response);
		}

		protected function _cart_items_text( $count ) {
			$product_item_text = "";
			
			if ( $count > 1 ) {
				$product_item_text = str_replace( '%', number_format_i18n( $count ), __( '% items', 'forward' ) );
			} elseif ( $count == 0 ) {
				$product_item_text = __( '0 items', 'forward' );
			} else {
				$product_item_text = __( '1 item', 'forward' );
			}
			
			return $product_item_text;
		}

		public function add_to_cart_fragments( $fragments ) {
			if(dh_get_theme_option('header-style','classic') != 'toggle-offcanvas' && dh_get_theme_option('header-offcanvas','click') != 'always'){
				$fragments['div.minicart'] = $this->_get_minicart( true, true );
			}
			$fragments['span.minicart-icon'] = $this->_get_minicart_icon();
			$fragments['a.cart-icon-mobile'] = $this->_get_minicart_mobile();
			return $fragments;
		}

		public function navbar_minicart( $items, $args ) {
			if ( $args->theme_location == 'primary' 
					&& defined( 'WOOCOMMERCE_VERSION' ) 
					&& dh_get_theme_option( 'woo-cart-nav', 1 )
				) {
				$items .= '<li class="navbar-minicart navbar-minicart-nav"></a>'.$this->_get_minicart(false,false,false).'</li>';
			}
			return $items;
		}

		public function minicart_remove_item() {
			global $woocommerce;
			$response = array();
			if ( ! isset( $_GET['item'] ) && ! isset( $_GET['_wpnonce'] ) ) {
				exit();
			}
			$woocommerce->cart->set_quantity( $_GET['item'], 0 );
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = absint($woocommerce->cart->cart_contents_count);
			$response['minicart_text'] = $cart_count;
			$response['minicart'] = $this->_get_minicart( true );
			// widget cart update
			ob_start();
			woocommerce_mini_cart();
			$mini_cart = ob_get_clean();
			$response['widget'] = '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>';
			
			echo json_encode( $response );
			exit();
		}

		protected function _get_minicart_mobile() {
			global $woocommerce;
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = $woocommerce->cart->cart_contents_count;
			$cart_output = '<a href="' . $woocommerce->cart->get_cart_url() . '" title="' . __( 'View Cart', 'forward' ) . '"  class="cart-icon-mobile">'.$this->_get_minicart_icon2().' '.( ! empty( $cart_count ) ? '<span>' . $cart_count . '</span>' : '' ) . '</a>';
			return $cart_output;
		}

		protected function _get_minicart_icon() {
			global $woocommerce;
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = absint( $woocommerce->cart->cart_contents_count );
			$cart_has_item = '';
			if ( ! empty( $cart_count ) ) {
				$cart_has_item = ' has-item';
			}
			
			return '<span class="minicart-icon' . $cart_has_item . '">'.$this->_get_minicart_icon2().'<span>'.$cart_count.'</span></span>';
		}
		
		public function get_topbar_minicart(){
			return $this->_get_minicart(false,false,true);
		}

		public function get_minicart(){
			return '<div class="navbar-minicart">'.$this->_get_minicart().'</div>';	
		}
		
		public function get_minicart_side(){
			echo '<div class="minicart-side"><div class="minicart-side-title"><h4>'.esc_html__('Shopping Cart','forward').'</h4></div><div class="minicart-side-content">'.$this->_get_minicart(true,true).'</div></div>';
			return;
		}
		
		public function get_minicart_icon_only(){
			global $woocommerce;
			if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
				$cart_url = WC()->cart->get_cart_url();
			} else {
				$cart_url = esc_url( $woocommerce->cart->get_cart_url() );
			}
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = absint( $woocommerce->cart->cart_contents_count );
			$cart_has_item = '';
			if ( ! empty( $cart_count ) ) {
				$cart_has_item = ' has-item';
			}
			$html = '<div class="navbar-minicart">';
			$html .= '<a class="minicart-link" href="' . $cart_url . '"><span class="minicart-icon '.$cart_has_item.'">'.$this->_get_minicart_icon2() . '<span>'.$cart_count.'</span></span></a>';
			$html .='</div>';
			return $html;
		}
		
		protected function _get_minicart( $content = false, $_flag = false ,$topbar=false) {
			global $woocommerce;
			$cart_total = $woocommerce->cart->get_cart_total();
			$cart_count = absint( $woocommerce->cart->cart_contents_count );
			$cart_count_text = $this->_cart_items_text( $cart_count );
			
			if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
				$cart_url = WC()->cart->get_cart_url();
			} else {
				$cart_url = esc_url( $woocommerce->cart->get_cart_url() );
			}
			$cart_has_item = '';
			
			if ( ! empty( $cart_count ) ) {
				$cart_has_item = ' has-item';
			}
			$minicart = '';
			if ( ! $content ) {
				$minicart .= '<a class="minicart-link" href="' . $cart_url . '"><span class="minicart-icon '.$cart_has_item.'">'.$this->_get_minicart_icon2() . '<span>'.$cart_count.'</span></span>'.($topbar ? __('My Cart','forward'):'').'</a>';
				if(dh_get_theme_option('woo-minicart-style','side') == 'mini'){
					$minicart .= '<div class="minicart" style="display:none">';
				}
			}
			if ( $content && $_flag ) {
				$minicart .= '<div class="minicart'.$cart_has_item.'" style="display:none">';
			}
			if( ((dh_get_theme_option('woo-minicart-style','side') == 'mini') ||  $content)){
				if (! empty( $cart_count ) ) {
					$minicart .= '<div class="minicart-header">' . $cart_count_text . ' ' . sprintf(__( 'in the <a href="%1$s">shopping cart</a>', 'forward' ),$cart_url) . '</div>';
					$minicart .= '<div class="minicart-body"><div class="minicart-body-wrap">';
					foreach ( $woocommerce->cart->cart_contents as $cart_item_key => $cart_item ) {
						
						$cart_product = $cart_item['data'];
						$product_title = $cart_product->get_title();
						$product_short_title = ( strlen( $product_title ) > 25 ) ? substr( $product_title, 0, 22 ) . '...' : $product_title;
						
						if ( $cart_product->exists() && $cart_item['quantity'] > 0 ) {
							$minicart .= '<div class="cart-product clearfix">';
							$minicart .= '<div class="cart-product-image"><a class="cart-product-img" href="' .get_permalink( $cart_item['product_id'] ) . '">' . $cart_product->get_image() . '</a></div>';
							$minicart .= '<div class="cart-product-details">';
							$minicart .= '<div class="cart-product-title"><a href="' .get_permalink( $cart_item['product_id'] ) . '">' . apply_filters( 'woocommerce_cart_widget_product_title', $product_short_title, $cart_product ) . '</a></div>';
							$minicart .= '<div class="cart-product-quantity-price">' . $cart_item['quantity'] . ' x ' .woocommerce_price( $cart_product->get_price() ) . '</div>';
							// $minicart .= '<div class="cart-product-quantity">' . __('Quantity:', 'forward') . ' ' .
							// $cart_item['quantity'] . '</div>';
							$minicart .= '</div>';
							$minicart .= apply_filters( 'woocommerce_cart_item_remove_link',sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'forward' ) ), $cart_item_key );
							$minicart .= '</div>';
						}
					}
					$minicart .= '</div></div>';
					$minicart .= '<div class="minicart-footer">';
					$minicart .= '<div class="minicart-total">' . __( 'Cart Subtotal:', 'forward' ) . ' ' . $cart_total . '</div>';
					$minicart .= '<div class="minicart-actions clearfix">';
					$minicart_action = '';
					if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
	 					$cart_url = WC()->cart->get_cart_url();
						$checkout_url = WC()->cart->get_checkout_url();
						
						$minicart_action .= '<a class="viewcart-button button" href="' . esc_url( $cart_url ) . '"><span class="text">' . __( 'View Cart', 'forward' ) . '</span></a>';
						$minicart_action .= '<a class="checkout-button button" href="' . esc_url( $checkout_url ) .'"><span class="text">' . __( 'Checkout', 'forward' ) . '</span></a>';
					} else {
						$minicart_action .= '<a class="viewcart-button button" href="' . esc_url( $woocommerce->cart->get_cart_url() ) . '"><span class="text">' . __( 'View Cart', 'forward' ) . '</span></a>';
						$minicart_action .= '<a class="checkout-button button" href="' . esc_url( $woocommerce->cart->get_checkout_url() ) . '"><span class="text">' . __( 'Checkout', 'forward' ) . '</span></a>';
					}
					$minicart_action = apply_filters('dh_minicart_action', $minicart_action);
					$minicart .= $minicart_action;
					$minicart .= '</div>';
					$minicart .= '</div>';
				} else {
					$minicart .= '<div class="minicart-header no-items show">' . __( 'Your shopping bag is empty.', 'forward' ) . '</div>';
					$shop_page_url = "";
					if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
						$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
					} else {
						$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
					}
					
					$minicart .= '<div class="minicart-footer">';
					$minicart .= '<div class="minicart-actions clearfix">';
					$minicart .= '<a class="button no-item-button" href="' . esc_url( $shop_page_url ) . '"><span class="text">' . __( 'Go to the shop', 'forward' ) . '</span></a>';
					$minicart .= '</div>';
					$minicart .= '</div>';
				}
			}
			if ( $content && $_flag ) {
				$minicart .= '</div>';
			}
			if ( ! $content ) {
				if(dh_get_theme_option('woo-minicart-style','side') == 'mini'){
				$minicart .= '</div>';
				}
			}
			
			return $minicart;
		}

		public function single_sharing() {
			if ( dh_get_theme_option( 'show-woo-share', 1 ) ) {
				dh_share( 
					'', 
					dh_get_theme_option( 'woo-fb-share', 1 ), 
					dh_get_theme_option( 'woo-tw-share', 1 ), 
					dh_get_theme_option( 'woo-go-share', 1 ), 
					dh_get_theme_option( 'woo-pi-share', 0 ), 
					dh_get_theme_option( 'woo-li-share', 1 ));
			}
		}

		public function template_loop_wishlist() {
			if ( $this->_yith_wishlist_is_active() ) {
				echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
			}
			return;
		}

		public function yith_wishlist_do_shortcode(){
			if ( $this->_yith_wishlist_is_active() ) {
				echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
			}
			return false;
		}
		
		public function yith_wishlist_is_active(){
			return $this->_yith_wishlist_is_active();
		}

		protected function _yith_wishlist_is_active() {
			return apply_filters('dh_yith_wishlist_is_active',defined( 'YITH_WCWL' ));
		}
		
		/**
		 * 
		 */
		public function template_loop_quickview() {
			global $product;
			if(apply_filters('dh_woocommerce_quickview', true))
				echo '<div class="shop-loop-quickview"><a data-product_id ="' . $product->id . '" title="' .esc_attr__( 'Quick view', 'forward' ) . '" href="' . esc_url( $product->get_permalink() ) . '"><i class="elegant_icon_zoom-in_alt"></i></a></div>';
		}

		public function quickview() {
			global $woocommerce, $post, $product;
			$product_id = $_POST['product_id'];
			$product = get_product( $product_id );
			$post = get_post( $product_id );
			$output = '';
			
			ob_start();
			woocommerce_get_template( 'content-quickview.php' );
			$output = ob_get_contents();
			ob_end_clean();
			
			echo trim($output);
			die();
		}
		
		public function the_product_video(){
			/**
			 * script
			 * {{
			 */
			wp_enqueue_style('vendor-magnific-popup');
			wp_enqueue_script('vendor-magnific-popup');
		
			$video_args = array();
			if($mp4 = dh_get_post_meta('video_mp4'))
				$video_args['mp4'] = $mp4;
			if ( $ogv = dh_get_post_meta('video_ogv') )
				$video_args['ogv'] = $ogv;
			if($webm = dh_get_post_meta('video_webm'))
				$video_args['webm'] = $webm;
		
			$video = '';
			$video_id = uniqid('video-featured-');
			if(!empty($video_args)):
			wp_enqueue_style( 'mediaelement' );
			wp_enqueue_script('mediaelement');
			$video .= '<video controls="controls" preload="0" class="video-embed video-embed-popup">';
			$source = '<source type="%s" src="%s" />';
			foreach ( $video_args as $video_type => $video_src ) {
				$video_type = wp_check_filetype( $video_src, wp_get_mime_types() );
				$video .= sprintf( $source, $video_type['type'], esc_url( $video_src ) );
			}
			$video .= '</video>';
		
			elseif($embed = dh_get_post_meta('video_embed')):
			if(!empty($embed)){
				$video .= apply_filters('dh_embed_video', $embed);
			}
			endif;
			if(!empty($video)){
				$html = '<div class="video-embed-shortcode mfp-hide">';
				$html .= '<div id="'.esc_attr($video_id).'" class="embed-wrap">';
				$html .= $video;
				$html .= '</div>';
				$html .= '</div>';
				echo ($html);
				echo '<a class="video-embed-action" data-container="body" data-trigger="hover" data-toggle="tooltip" title="'.esc_attr__('Watch Video','forward').'" data-video-inline="'.esc_attr($video).'" href="#'.esc_attr($video_id).'" data-rel="magnific-popup-video"><i class="elegant_arrow_triangle-right_alt2"></i></a>';
			}
		}
		
		public function template_loop_product_thumbnail() {
			$frist = $this->_product_get_frist_thumbnail();
			$thumbnail_size = 'shop_catalog';
			echo '<div class="shop-loop-thumbnail'.(apply_filters('dh_use_template_loop_product_frist_thumbnail', true) && $frist != '' ? ' shop-loop-front-thumbnail':'').'">' . woocommerce_get_product_thumbnail($thumbnail_size) . '</div>';
		}

		public function template_loop_product_frist_thumbnail() {
			if ( ( $frist = $this->_product_get_frist_thumbnail() ) != '' ) {
				echo '<div class="shop-loop-thumbnail shop-loop-back-thumbnail">' . $frist . '</div>';
			}
		}

		protected function _product_get_frist_thumbnail() {
			global $product, $post;
			$image = '';
			$thumbnail_size = 'shop_catalog';
			if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
				$attachment_ids = $product->get_gallery_attachment_ids();
				$image_count = 0;
				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {
						if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image' ) )
							continue;
						
						$image = wp_get_attachment_image( $attachment_id, $thumbnail_size );
						
						$image_count++;
						if ( $image_count == 1 )
							break;
					}
				}
			} else {
				$attachments = get_posts( 
					array( 
						'post_type' => 'attachment', 
						'numberposts' => - 1, 
						'post_status' => null, 
						'post_parent' => $post->ID, 
						'post__not_in' => array( get_post_thumbnail_id() ), 
						'post_mime_type' => 'image', 
						'orderby' => 'menu_order', 
						'order' => 'ASC' ) );
				$image_count = 0;
				if ( $attachments ) {
					foreach ( $attachments as $attachment ) {
						
						if ( get_post_meta( $attachment->ID, '_woocommerce_exclude_image' ) == 1 )
							continue;
						
						$image = wp_get_attachment_image( $attachment->ID, $thumbnail_size );
						
						$image_count++;
						
						if ( $image_count == 1 )
							break;
					}
				}
			}
			return $image;
		}

		public function json_search_products() {
			$term = (string) sanitize_text_field( stripslashes( $_GET['term'] ) );
			if ( empty( $term ) )
				die();
			$post_types = array( 'product', 'product_variation' );
			if ( is_numeric( $term ) ) {
				
				$args = array( 
					'post_type' => $post_types, 
					'post_status' => 'publish', 
					'posts_per_page' => - 1, 
					'post__in' => array( 0, $term ), 
					'fields' => 'ids' );
				$args2 = array( 
					'post_type' => $post_types, 
					'post_status' => 'publish', 
					'posts_per_page' => - 1, 
					'post_parent' => $term, 
					'fields' => 'ids' );
				$args3 = array( 
					'post_type' => $post_types, 
					'post_status' => 'publish', 
					'posts_per_page' => - 1, 
					'meta_query' => array( 
						array( 'key' => '_sku', 'value' => $term, 'compare' => 'LIKE' ) ), 
					'fields' => 'ids' );
				$posts = array_unique( array_merge( get_posts( $args ), get_posts( $args2 ), get_posts( $args3 ) ) );
			} else {
				$args = array( 
					'post_type' => $post_types, 
					'post_status' => 'publish', 
					'posts_per_page' => - 1, 
					's' => $term, 
					'fields' => 'ids' );
				$args2 = array( 
					'post_type' => $post_types, 
					'post_status' => 'publish', 
					'posts_per_page' => - 1, 
					'meta_query' => array( 
						array( 'key' => '_sku', 'value' => $term, 'compare' => 'LIKE' ) ), 
					'fields' => 'ids' );
				$posts = array_unique( array_merge( get_posts( $args ), get_posts( $args2 ) ) );
			}
			$found_products = array();
			if ( $posts )
				foreach ( $posts as $post ) {
					$product = get_product( $post );
					$found_products[$post] = $this->_formatted_name( $product );
				}
			wp_send_json( $found_products );
		}

		protected function _formatted_name( WC_Product $product ) {
			if ( $product->get_sku() ) {
				$identifier = $product->get_sku();
			} else {
				$identifier = '#' . $product->id;
			}
			
			return sprintf( __( '%s &ndash; %s', 'forward' ), $identifier, $product->get_title() );
		}
		
		public function _get_minicart_icon2(){
			return apply_filters('dh_woocommerce_minicart_icon','<img src="'.get_template_directory_uri().'/assets/images/icon-cart.png" alt="'.esc_attr__('Shopping Cart','forward').'">');
		}
		
		public function get_price_html( $content ) {
			$content = str_replace( '<del><span class="amount">', '<del><span class="amount">', $content );
			$content = str_replace( '</span></del>', '</span></del>[dh_price_break]', $content );
			$content = str_replace( '<ins><span class="amount">', '<ins><span class="amount">', $content );
			$content = str_replace( '</span></ins>', '</span></ins>', $content );
				
			$content = explode( '[dh_price_break]', $content );
				
			$price = '';
			if ( ! empty( $content[1] ) )
				$price .= $content[1];
			if ( ! empty( $content[0] ) )
				$price .= $content[0];
			return $price;
		}
		
		public function product_tax_add_heading_fields($taxonomy){
			if('product_cat' === $taxonomy):
			?>
			<div class="form-field">
				<label for="product_cat_short_description"><?php _e('Short Description','forward')?></label>
				<input id="product_cat_short_description" type="text" aria-required="true" size="40" value="" name="product_cat_short_description">
			</div>
			<?php endif;?>
			<div class="form-field">
				<label><?php _e( 'Heading Background', 'forward' ); ?></label>
				<div id="product_cat_heading_thumbnail" style="float:left;margin-right:10px;">
					<img src="<?php echo woocommerce_placeholder_img_src(); ?>" width="60px" height="60px" />
				</div>
				<div style="line-height:60px;">
					<input type="hidden" id="product_cat_heading_thumbnail_id" name="product_cat_heading_thumbnail_id" />
					<button type="submit" class=" button product_cat_heding_upload"><?php _e('Upload/Add image', 'forward'); ?></button>
					<button type="submit" class=" button product_cat_heding_remove"><?php _e('Remove image', 'forward'); ?></button>
				</div>
				<script type="text/javascript">
			
					 // Only show the "remove image" button when needed
					 if ( ! jQuery('#product_cat_heading_thumbnail_id').val() )
						 jQuery('.product_cat_heding_remove').hide();
			
					// Uploading files
					var product_cat_heading_file_frame;
			
					jQuery(document).on( 'click', '.product_cat_heding_upload', function( event ){
			
						event.preventDefault();
			
						// If the media frame already exists, reopen it.
						if ( product_cat_heading_file_frame ) {
							product_cat_heading_file_frame.open();
							return;
						}
			
						// Create the media frame.
						product_cat_heading_file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php echo esc_js(__( 'Choose an image', 'forward' )); ?>',
							button: {
								text: '<?php echo esc_js(__( 'Use image', 'forward' )); ?>',
							},
							multiple: false
						});
			
						// When an image is selected, run a callback.
						product_cat_heading_file_frame.on( 'select', function() {
							attachment = product_cat_heading_file_frame.state().get('selection').first().toJSON();
			
							jQuery('#product_cat_heading_thumbnail_id').val( attachment.id );
							jQuery('#product_cat_heading_thumbnail img').attr('src', attachment.url );
							jQuery('.product_cat_heding_remove').show();
						});
			
						// Finally, open the modal.
						product_cat_heading_file_frame.open();
					});
			
					jQuery(document).on( 'click', '.product_cat_heding_remove', function( event ){
						jQuery('#product_cat_heading_thumbnail img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
						jQuery('#product_cat_heading_thumbnail_id').val('');
						jQuery('.product_cat_heding_remove').hide();
						return false;
					});
			
				</script>
				<div class="clear"></div>
			</div>
			<div class="form-field">
				<label for="product_cat_heading_title"><?php _e('Heading Title','forward')?></label>
				<input id="product_cat_heading_title" type="text" aria-required="true" size="40" value="" name="product_cat_heading_title">
			</div>
			<div class="form-field">
				<label for="product_cat_heading_sub_title"><?php _e('Heading Sub Title','forward')?></label>
				<input id="product_cat_heading_sub_title" type="text" aria-required="true" size="40" value="" name="product_cat_heading_sub_title">
			</div>
			<div class="form-field">
				<label for="product_cat_heading_button_text"><?php _e('Heading Button Text','forward')?></label>
				<input id="product_cat_heading_button_text" type="text" aria-required="true" size="40" value="" name="product_cat_heading_button_text">
			</div>
			<div class="form-field">
				<label for="product_cat_heading_button_link"><?php _e('Heading Sub Link','forward')?></label>
				<input id="product_cat_heading_button_link" type="text" aria-required="true" size="40" value="" name="product_cat_heading_button_link">
			</div>
			<?php
		}
		
		public function product_tax_edit_heading_fields($term, $taxonomy){
			global $woocommerce;
			$image 			= '';
			$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'product_cat_heading_thumbnail_id', true );
			if ($thumbnail_id) :
				$image = wp_get_attachment_url( $thumbnail_id );
			else :
				$image = woocommerce_placeholder_img_src();
			endif;
			$product_cat_short_description = get_woocommerce_term_meta( $term->term_id, 'product_cat_short_description', true );
			$product_cat_heading_title = get_woocommerce_term_meta( $term->term_id, 'product_cat_heading_title', true );
			$product_cat_heading_sub_title = get_woocommerce_term_meta( $term->term_id, 'product_cat_heading_sub_title', true );
			$product_cat_heading_button_text = get_woocommerce_term_meta( $term->term_id, 'product_cat_heading_button_text', true );
			$product_cat_heading_button_link = get_woocommerce_term_meta( $term->term_id, 'product_cat_heading_button_link', true );
			
			
			if('product_cat' === $taxonomy):
			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="product_cat_short_description"><?php _e('Short Description','forward')?></label>
				</th>
				<td>
					<input id="product_cat_short_description" type="text" aria-required="true" size="40" value="<?php echo esc_attr($product_cat_short_description)?>" name="product_cat_short_description">
				</td>
			</tr>
			<?php endif;?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label><?php _e( 'Heading Background', 'forward' ); ?></label>
				</th>
				<td>
					<div id="product_cat_heading_thumbnail" style="float:left;margin-right:10px;">
						<img src="<?php echo $image; ?>" width="60px" height="60px" />
					</div>
					<div style="line-height:60px;">
						<input type="hidden" value="<?php echo esc_attr($thumbnail_id)?>" id="product_cat_heading_thumbnail_id" name="product_cat_heading_thumbnail_id" />
						<button type="submit" class="button product_cat_heding_upload"><?php _e('Upload/Add image', 'forward'); ?></button>
						<button type="submit" class="button product_cat_heding_remove"><?php _e('Remove image', 'forward'); ?></button>
					</div>
					<script type="text/javascript">
				
						 // Only show the "remove image" button when needed
						 if ( ! jQuery('#product_cat_heading_thumbnail_id').val() )
							 jQuery('.product_cat_heding_remove').hide();
				
						// Uploading files
						var product_cat_heading_file_frame;
				
						jQuery(document).on( 'click', '.product_cat_heding_upload', function( event ){
				
							event.preventDefault();
				
							// If the media frame already exists, reopen it.
							if ( product_cat_heading_file_frame ) {
								product_cat_heading_file_frame.open();
								return;
							}
				
							// Create the media frame.
							product_cat_heading_file_frame = wp.media.frames.downloadable_file = wp.media({
								title: '<?php echo esc_js(__( 'Choose an image', 'forward' )); ?>',
								button: {
									text: '<?php echo esc_js(__( 'Use image', 'forward' )); ?>',
								},
								multiple: false
							});
				
							// When an image is selected, run a callback.
							product_cat_heading_file_frame.on( 'select', function() {
								attachment = product_cat_heading_file_frame.state().get('selection').first().toJSON();
				
								jQuery('#product_cat_heading_thumbnail_id').val( attachment.id );
								jQuery('#product_cat_heading_thumbnail img').attr('src', attachment.url );
								jQuery('.product_cat_heding_remove').show();
							});
				
							// Finally, open the modal.
							product_cat_heading_file_frame.open();
						});
				
						jQuery(document).on( 'click', '.product_cat_heding_remove', function( event ){
							jQuery('#product_cat_heading_thumbnail img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
							jQuery('#product_cat_heading_thumbnail_id').val('');
							jQuery('.product_cat_heding_remove').hide();
							return false;
						});
				
					</script>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="product_cat_heading_title"><?php _e('Heading Title','forward')?></label></th>
				<td><input id="product_cat_heading_title" type="text" aria-required="true" size="40" value="<?php echo esc_attr($product_cat_heading_title)?>" name="product_cat_heading_title"></td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="product_cat_heading_sub_title"><?php _e('Heading Sub Title','forward')?></label></th>
				<td><input id="product_cat_heading_sub_title" type="text" aria-required="true" size="40" value="<?php echo esc_attr($product_cat_heading_sub_title)?>" name="product_cat_heading_sub_title"></td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="product_cat_heading_button_text"><?php _e('Heading Button Text','forward')?></label></th>
				<td><input id="product_cat_heading_button_text" type="text" aria-required="true" size="40" value="<?php echo esc_attr($product_cat_heading_button_text)?>" name="product_cat_heading_button_text"></td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="product_cat_heading_button_link"><?php _e('Heading Sub Link','forward')?></label></th>
				<td><input id="product_cat_heading_button_link" type="text" aria-required="true" size="40" value="<?php echo esc_attr($product_cat_heading_button_link)?>" name="product_cat_heading_button_link"></td>
			</tr>
			<?php
		}
		
		public function product_cat_heading_save( $term_id, $tt_id, $taxonomy ) {
			$fields = array(
				'product_cat_short_description',
				'product_cat_heading_thumbnail_id',
				'product_cat_heading_title',
				'product_cat_heading_sub_title',
				'product_cat_heading_button_text',
				'product_cat_heading_button_link',
			);
			foreach ($fields as $field){
				if(isset($_POST[$field])){
					$value = !empty($_POST[$field]) ? wp_kses_post($_POST[$field]):'';
					update_woocommerce_term_meta( $term_id, $field, $value );
				}
			}
		}
	}
	new DH_Woocommerce();
endif;
