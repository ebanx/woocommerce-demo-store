<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

if ( ! is_shop_supported() ) {
	return;
}

if ( ! defined( 'WC_INSTALLED' ) ) {
	define( 'WC_INSTALLED', true );
}


// Remove WooCommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


// Remove Actions
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10, 0 );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10, 0 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 0 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5, 0 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10, 0 );

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

// Remove Link from Products
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Change the order of product details on single page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 29 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 21 );


// Enqueue Lightbox in Single Product Page
add_action( 'woocommerce_after_single_product', 'kalium_enqueue_lightbox_library' );

// WooCommerce Image Dimensions
add_action( 'admin_init', 'lab_wc_set_image_dimensions', 1 );

function lab_wc_set_image_dimensions() {
	$theme_id = sanitize_title( wp_get_theme() );
	$lab_wc_theme_dimensions = 'lab_wc_thumbnail_dimensions_' . $theme_id;
	
	if ( get_data( $lab_wc_theme_dimensions ) != 'true' || ! get_option( 'shop_catalog_image_size' ) ) {
		if ( ! isset( $_GET['override_shop_image_dimensions'] ) ) {
			return false;
		}
	}
	
	$catalog = array(
		'width' 	=> '550',
		'height'	=> '700',
		'crop'		=> 1
	);
	
	$single = array(
		'width' 	=> '550',
		'height'	=> '705',
		'crop'		=> 1
	);
	
	$thumbnail = array(
		'width' 	=> '220',
		'height'	=> '295',
		'crop'		=> 1
	);
	
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	
	// Disable Lightbox
	update_option( 'woocommerce_enable_lightbox', false );
	
	// Mark this task as complete, only once will be executed
	update_option( $lab_wc_theme_dimensions, 'true' );
	
	if ( isset( $_GET[ 'override_shop_image_dimensions' ] ) ) {
		die( 'Image dimensions have been reset!' );
	}
}


// Default Shop Category Thumbnail Size
$shop_category_image_size   = get_data( 'shop_category_image_size' );
$shop_category_thumb_width  = 500;
$shop_category_thumb_height = 290;
$shop_category_thumb_crop   = true;

if ( preg_match_all( "/^([0-9]+)x?([0-9]+)?x?(0|1)?$/", $shop_category_image_size, $shop_category_image_dims ) ) {	
	$shop_category_thumb_width     = intval( $shop_category_image_dims[1][0] );
	$shop_category_thumb_height    = intval( $shop_category_image_dims[2][0] );
	$shop_category_thumb_crop      = intval( $shop_category_image_dims[3][0] ) == 1;
	
	if ( $shop_category_thumb_width == 0 || $shop_category_thumb_height == 0 ) {
		$shop_category_thumb_crop = false;
	}
}

add_image_size( 'shop-category-thumb', $shop_category_thumb_width, $shop_category_thumb_height, $shop_category_thumb_crop );



// Shop Categories Thumbnail Size
add_action( 'single_product_small_thumbnail_size', 'lab_wc_single_product_small_thumbnail_size' );

function lab_wc_single_product_small_thumbnail_size( $size ) {
	// It's shop category thumb
	if ( $size == 'shop_catalog' ) {
		return 'shop-category-thumb';
	}
	
	return $size;
}


// Loop items per page
add_filter( 'loop_shop_per_page', 'lab_wc_loop_shop_per_page' );

function lab_wc_loop_shop_per_page() {
	$rows_count    = get_data( 'shop_products_per_page' );
	$rows_count	   = str_replace( 'rows-', '', $rows_count );
	$rows_count    = is_numeric( $rows_count ) && $rows_count > 0 ? $rows_count : 4;
	
	$shop_columns  = apply_filters( 'kalium_woocommerce_shop_columns', 3 );

	return $shop_columns * $rows_count;
}


// Page Title & Results Count Hide
if ( get_data( 'shop_title_show' ) == false) {
	add_filter( 'woocommerce_show_page_title', '__return_false' );
	add_filter( 'lab_wc_show_results_count', '__return_false' );
}


// Sorting Hide
if ( get_data( 'shop_sorting_show' ) == false ) {
	add_filter( 'lab_wc_show_product_sorting', '__return_false' );
}


// Single Product Main Image
function kalium_wc_single_product_image_html( $output, $attachment_id, $is_additional = false ) {
	global $post;
	
	// Shop single product page image layout
	$images_layout = get_data( 'shop_single_product_images_layout' );
	
	// In case this is a post ID
	if ( $post_thumbnail_id = get_post_thumbnail_id( $attachment_id ) ) {
		$post_id = $attachment_id;
		$attachment_id = $post_thumbnail_id;
	}
	
	// Image info
	$props = wc_get_product_attachment_props( $attachment_id, $post );
	
	// Image
	$image = kalium_get_image_placeholder( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
	
	// If image doesn't exists, show given output
	if ( ! $image ) {
		return $output;
	}
	
	// Image Classes
	$image_classes = array( 'woocommerce-main-image zoom' );
	
	// Hide image when set to carousel mode and its not the first image
	if ( $is_additional && 'default' == $images_layout ) {
		$image_classes[] = 'hidden';
	}
	
	if ( 'plain' == $images_layout || 'plain-sticky' == $images_layout ) {
		$image_classes[] = 'wow fadeInLab';
	}
	
	return sprintf(
		'<a href="%s" itemprop="image" class="%s" title="%s" data-lightbox-gallery="shop-gallery">%s</a>',
		esc_url( $props['url'] ),
		esc_attr( implode( ' ', $image_classes ) ),
		esc_attr( $props['caption'] ),
		$image
	);
}

add_filter( 'woocommerce_single_product_image_html', 'kalium_wc_single_product_image_html', 10, 3 );


// Single Product Gallery Image
function kalium_wc_single_product_image_thumbnail_html( $output, $attachment_id, $post_id, $image_class ) {
	global $post;
	
	// Image Info
	$props = wc_get_product_attachment_props( $attachment_id, $post );
	
	// Image
	$image = kalium_get_image_placeholder( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
	
	// Image Classes
	$image_classes = explode( ' ', $image_class );
	
	// Attribute available for Additional Variation Images Plugin
	$original_image_attr = '';
	
	if ( defined( 'DOING_AJAX' ) &&  kalium()->post( 'ajaxImageSwapNonce' ) ) {
		$original_image_attr = ' data-main-image="' . esc_attr( apply_filters( 'woocommerce_single_product_image_html', '', $attachment_id ) ) . '"';
	}

	return sprintf(
		'<a href="%s" class="%s" title="%s" data-lightbox-gallery="shop-gallery"%s>%s</a>',
		esc_url( $props['url'] ),
		esc_attr( $image_class ),
		esc_attr( $props['caption'] ),
		$original_image_attr,
		$image
	);
}

add_filter( 'woocommerce_single_product_image_thumbnail_html', 'kalium_wc_single_product_image_thumbnail_html', 10, 4 );


// Shop Image
add_action( 'woocommerce_before_shop_loop_item_title', 'lab_wc_shop_loop_thumb', 10 );

function lab_wc_shop_loop_thumb() {
	global $post, $product;
	
	$shop_catalog_layout   = get_data( 'shop_catalog_layout' );
	
	$thumb_size            = apply_filters( 'lab_wc_shop_loop_thumb', 'shop_catalog' );
	$post_thumb_id         = get_post_thumbnail_id();
	
	$item_preview_type     = get_data( 'shop_item_preview_type' );
	
	
	// Product Gallery
	$product_images    = $product->get_gallery_attachment_ids();
	
	//$post_cloned       = $post;
	//$product_cloned    = $product;
	
	//$post              = $post_cloned;
	//$product           = $product_cloned;
	
	if ( in_array( get_data( 'shop_catalog_layout' ), array( 'full-bg', 'distanced-centered', 'transparent-bg' ) ) ) {
		$item_preview_type = 'none';
	}
	
	?>
	<div class="item-images preview-type-<?php echo esc_attr( $item_preview_type ); ?>">
		<a href="<?php the_permalink(); ?>" class="main-thumbnail">
			<?php laborator_show_image_placeholder( $post_thumb_id, $thumb_size ); ?>
		</a>
		
		<?php if ( is_array( $product_images ) && count( $product_images ) ) : ?>
		
			<?php
			// Show Second Image on Hover
			if ( $item_preview_type == 'fade' ) : 
			
				$first_image = array_shift( $product_images );
				
				// Remove Duplicate Image
				if ( $first_image == $post_thumb_id ) {
					$first_image = array_shift( $product_images );
				}
				
				?>
				<a href="<?php the_permalink(); ?>" class="second-hover-image">
					<?php laborator_show_image_placeholder( $first_image, $thumb_size ); ?>
				</a>
				<?php 
			
			// Product Image Gallery
			elseif ( $item_preview_type == 'gallery' && ! empty( $product_images ) ) :
				
				$index = 1;
				
				foreach( $product_images as $attachment_id ) :
				
					if ( $attachment_id != $post_thumb_id ) :
					
						?>
						<a href="<?php the_permalink(); ?>" class="product-gallery-image" data-index="<?php echo esc_attr( $index ); ?>">
							<?php laborator_show_image_placeholder( $attachment_id, $thumb_size ); ?>
						</a>
						<?php
							
						$index++;

					endif;
					
				endforeach;
			
				?>
				<div class="product-gallery-navigation">
					<a href="#" class="gallery-prev">
						<i class="flaticon-arrow427"></i>
					</a>
					
					<a href="#" class="gallery-next">
						<i class="flaticon-arrow413"></i>
					</a>
				</div>
				<?php
				
			endif; 
			?>
		
		<?php endif; ?>
		
		<?php if ( in_array( get_data( 'shop_catalog_layout' ), array( 'full-bg', 'distanced-centered', 'transparent-bg' ) ) ) : ?>
		<div class="product-internal-info">
			
			<?php lab_wc_product_loop_item_info(); ?>
			
		</div>
		<?php endif; ?>
	</div>
	<?php
}


// Pagination Next & Prev Labeling
add_filter( 'woocommerce_pagination_args', 'lab_bc_pagination_args_filter' );

function lab_bc_pagination_args_filter($args) {
	$args['prev_text'] = '<i class="flaticon-arrow427"></i> ';
	$args['prev_text'] .= __( 'Previous', 'kalium' );
	
	$args['next_text'] = __( 'Next', 'kalium' );
	$args['next_text'] .= ' <i class="flaticon-arrow413"></i>';
	
	return $args;
}


// Add to cart
if ( ! in_array( get_data( 'shop_catalog_layout' ), array( 'full-bg', 'distanced-centered', 'transparent-bg' ) ) ) {
	add_action( 'woocommerce_after_shop_loop_item', 'lab_wc_product_loop_item_info', 25 );
}

function lab_wc_product_loop_item_info() {
	global $woocommerce, $product;
	
	$shop_catalog_layout = get_data( 'shop_catalog_layout' );
	
	#$cart_url = $woocommerce->cart->get_cart_url();
	$cart_url = wc_get_page_permalink( 'cart' );
	$show_price = get_data( 'shop_product_price_listing' );
	
	$shop_product_category = get_data( 'shop_product_category_listing' );
	
	// Full + Transparent Background Layout Type
	if ( in_array( $shop_catalog_layout, array( 'full-bg', 'transparent-bg' ) ) ) :
	
		?>
		<div class="item-info">
			
			<h3 <?php if ( $shop_catalog_layout == 'transparent-bg' && $shop_product_category == false ) : ?> class="no-category-present"<?php endif; ?>>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>
			
			<?php if ( $shop_product_category ) : ?>
			<div class="product-category">
				<?php echo $product->get_categories(); ?>
			</div>
			<?php endif; ?>
			
			
			<div class="product-bottom-details">
				
				<?php if ( $show_price ) : woocommerce_template_loop_price(); endif; ?>
				
				<?php woocommerce_template_loop_add_to_cart(); ?>
				
			</div>
			
		</div>
		<?php
			
	// Centered – Distanced Background Layout Type
	elseif ( in_array( $shop_catalog_layout, array( 'distanced-centered' ) ) ) :
	
		?>		
		<div class="item-info">
			
			<div class="title-and-price">
				
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				
				<?php if ( $show_price ) : woocommerce_template_loop_price(); endif; ?>
				
			</div>
			
			<?php woocommerce_template_loop_add_to_cart(); ?>
			
		</div>
		<?php
	
	else :
	
	?>
	<div class="item-info">
		
		<div class="row custom-margin">
			<div class="col-xs-<?php echo $show_price ? 9 : 12; ?>">
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				
				<?php /*<a class="add-to-card-button" href="#">+ Add to cart</a>*/ ?>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
			
			<?php if ( $show_price ) : ?>
			<div class="col-xs-3 product-price-col">
				<?php woocommerce_template_loop_price(); ?>
			</div>
			<?php endif; ?>
		</div>
		
	</div>
	
				
	<div class="added-to-cart-button">
		<a href="<?php echo $cart_url; ?>"><i class="icon icon-ecommerce-bag-check"></i></a>
	</div>
	<?php
		
	endif;
}


// Shop Columns
function kalium_woocommerce_shop_columns( $columns, $type = '' ) {
	global $woocommerce_loop;
	
	$category_columns  = get_data( 'shop_category_columns' );
	$shop_columns      = get_data( 'shop_product_columns' );
	
	$columns_str       = 'shop_category_columns' == $type ? $category_columns : $shop_columns;
	
	switch ( $columns_str ) {
		case 'six': 
			$columns = 6; 
			break;
		case 'five':
			$columns = 5;
			break;
		case 'four':
			$columns = 4;
			break;
		case 'three': 
			$columns = 3;
			break;
		case 'two': 
			$columns = 2;
			break;
		
		default:
			
			if ( get_data( 'shop_sidebar' ) == 'hide' ) {
				$columns = 4;
			}
	}
	
	// Inherit Columns Number from WooCommerce Loop Variable
	if ( isset( $woocommerce_loop['columns'] ) && false == ( is_shop() || is_product_category() || is_product_tag() || is_ajax() || is_tax() ) ) {
		$columns = $woocommerce_loop['columns'];
	}
	
	return $columns;
}

add_filter( 'kalium_woocommerce_shop_columns', 'kalium_woocommerce_shop_columns', 10, 2 );


// Shop Sidebar
add_action( 'woocommerce_before_shop_loop', 'lab_wc_shop_products_container_before' );
add_action( 'woocommerce_after_shop_loop', 'lab_wc_shop_products_container_after' );

function lab_wc_shop_products_container_before() {
	$shop_sidebar = get_data( 'shop_sidebar' );
	
	?>
	<div class="shop-container<?php echo $shop_sidebar != 'hide' ? ' sidebar-is-present' : ''; ?> row">
	<?php
	
	switch( $shop_sidebar )
	{
		case 'left':
		case 'right':
			?>
			<div class="col-md-9<?php echo $shop_sidebar == 'left' ? ' pull-right-md' : ''; ?>">
			<?php
			break;
		
		default:
			?>
			<div class="col-md-12">
			<?php
	}
}

function lab_wc_shop_products_container_after() {
	$shop_sidebar = get_data( 'shop_sidebar' );
	
	?>
		</div><!-- close of products container -->
		
		<?php if ( $shop_sidebar != 'hide' ) : ?>
		<div class="col-md-3">
			
			<div class="blog-sidebar shop-sidebar shop-sidebar-<?php echo esc_attr( $shop_sidebar ); ?>">
				
				<?php dynamic_sidebar( 'shop_sidebar' ); ?>
				
			</div>
			
		</div>
		<?php endif; ?>
		
	</div>
	<?php
}


// Thumbnail Loop Size
if ( get_data( 'shop_loop_thumb_proportional' ) ) {
	add_filter( 'lab_wc_shop_loop_thumb', 'lab_wc_shop_loop_proportional_thumb_size' );
	
	function lab_wc_shop_loop_proportional_thumb_size( $size ) {
		return get_data( 'shop_loop_thumb_proportional_size' );
	}
}


// Shop Products Pagination (Endless)
add_action( 'wp_ajax_laborator_get_paged_shop_products', 'lab_wc_get_paged_products' );
add_action( 'wp_ajax_nopriv_laborator_get_paged_shop_products', 'lab_wc_get_paged_products' );

function lab_wc_get_paged_products() {	
	global $woocommerce_loop;
	
	$resp = array(
		'content' => ''
	);

	// Query Meta Vars
	$page  = kalium()->post( 'page' );
	$opts  = kalium()->post( 'opts' );
	$pp    = kalium()->post( 'pp' );
	$q 	   = $opts['q'];
	
	$meta_query = WC()->query->get_meta_query();
	
	$atts = array(
		'columns' => '4',
		'orderby' => 'title',
		'order'   => 'asc',
		'ids'     => '',
		'skus'    => ''
	);
	
	// Min/Max Price Filter
	if ( kalium()->get( 'min_price', true ) || kalium()->get( 'max_price', true ) ) {
		$min = isset( $_REQUEST['min_price'] ) ? floatval( $_REQUEST['min_price'] ) : 0;
		$max = isset( $_REQUEST['max_price'] ) ? floatval( $_REQUEST['max_price'] ) : 9999999999;
		
		$meta_query[] = array(
			'key'          => '_price',
			'value'        => array( $min, $max ),
			'compare'      => 'BETWEEN',
			'type'         => 'DECIMAL',
			'price_filter' => true,
		);
	}
		
	$resp['meta'] = $meta_query;
	
	$query_args = array(
		
		'post_type'           => 'product',
		'post_status'         => 'publish',
		
		'paged'           	  => $page,
		'posts_per_page'      => $pp,
		
		'ignore_sticky_posts' => 1,
		'orderby'             => $atts['orderby'],
		'order'               => $atts['order'],
		'meta_query'          => $meta_query
	);
	
	// Ignore Shown Ids
	$ignore = kalium()->post( 'ignore' );
	
	if ( is_array( $ignore ) && count( $ignore ) ) {
		$query_args['post__not_in'] = $ignore;
		add_filter( 'post_limits', create_function( '$limit, $query', 'return "LIMIT ' . $pp . '";' ), 10, 2 );
	}

	if ( $q ) {
		$query_args = array_merge( $q, $query_args );
	}
	
	$resp['qs'] = $query_args;

	
	// Collect posts
	ob_start();
	
	// Init query
	$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
	
	if ( $products->have_posts() ) :
	
		while( $products->have_posts() ) :
		
			$products->the_post();
				
			wc_get_template_part( 'content', 'product' );
		
		endwhile;
		
	endif;
	
	wp_reset_postdata();

	$content = ob_get_clean();

	// Set up content
	$resp['content'] = $content;
	$resp['defCols'] = apply_filters( 'kalium_woocommerce_shop_columns', 3 );

	echo json_encode( $resp );

	die();
}


// Single Product Enqueue
add_action( 'wp_enqueue_scripts', 'lab_wc_single_product_enqueue_scripts' );

function lab_wc_single_product_enqueue_scripts() {
	if ( is_woocommerce() && is_single() ) {
		wp_enqueue_script( array( 'slick', 'nivo-lightbox' ) );
		wp_enqueue_style( array( 'slick', 'nivo-lightbox-default' ) );
	}
}

// Remove Product Description
add_filter( 'woocommerce_product_description_heading', create_function( '', 'return "";' ) );


// Render Rating
function lab_wc_show_rating( $average ) {
	$shop_single_rating_style = get_data( 'shop_single_rating_style' );
	?>
	<div class="star-rating-icons" data-toggle="tooltip" data-placement="right" title="<?php echo sprintf( __( '%s out of 5', 'kalium' ), $average ); ?>">
	<?php
	
	$average_int = intval( $average );	
	$average_floated = $average - $average_int;
	
	for ( $i = 1; $i <= 5; $i++ ) :

		if ( in_array( $shop_single_rating_style, array( 'circles', 'rectangles' ) ) ) :
			
			$fill = 100;
			
			if ( $i > $average ) {
				$fill = 0;
				
				if ( $average_int + 1 == $i ) {
					$fill = $average_floated * 100;
				}
			}
			?>
			<span class="circle<?php echo $shop_single_rating_style == 'circles' ? ' rounded' : ''; ?>">
				<i style="width: <?php echo esc_attr( $fill ); ?>%"></i>
			</span>
			<?php
		else:
			?>
			<i class="fa fa-star<?php echo round( $average ) >= $i ? ' filled' : ''; ?>"></i>
			<?php
		endif;
		
	endfor;
	
	?>
	</div>
	<?php
}


// Single Product Images Column Size
add_filter( 'lab_wc_single_product_image_column_size', 'lac_wc_single_product_image_columns' );

function lac_wc_single_product_image_columns( $column_size ) {
	return get_data( 'shop_single_image_column_size' );
}


// Single Product Image Size
if ( get_data( 'shop_single_image_size' ) != 'default' ) {
	add_filter( 'single_product_large_thumbnail_size', 'lab_wc_custom_single_product_image_size' );
	
	function lab_wc_custom_single_product_image_size( $size ) {	
		$product_single_img_size = get_data( 'shop_single_image_size' );
		
		switch( $product_single_img_size ) {
			case 'large':
			case 'full':
				return $product_single_img_size;
				break;
		}
		
		return $size;
	}
}


// Product Sharing
if ( get_data( 'shop_single_share_product' ) ) {
	add_action( 'woocommerce_single_product_summary', 'laborator_woocommerce_share', 50 );
}

function laborator_woocommerce_share() {
	global $product;

	?>
	<div class="share-product-container">
		<h3><?php _e( 'Share this item:', 'kalium' ); ?></h3>
		
		<div class="share-product social-links">
		<?php
		$share_product_networks = get_data( 'shop_share_product_networks' );

		if ( is_array( $share_product_networks ) ) :

			foreach ( $share_product_networks['visible'] as $network_id => $network ) :

				if ( $network_id == 'placebo' ) {
					continue;
				}

				share_story_network_link( $network_id, $product->id, '', true );

			endforeach;

		endif;
		?>
		</div>
	</div>
	<?php
}



// Related Product Count
add_filter( 'woocommerce_related_products_args', 'laborator_woocommerce_related_products_args' );

function laborator_woocommerce_related_products_args( $args ) {
	$args['posts_per_page'] = get_data( 'shop_related_products_per_page' );
	
	return $args;
}


// Catalog Mode
if ( get_data( 'shop_catalog_mode' ) )  {
	add_filter( 'get_data_shop_add_to_cart_listing', create_function( '', 'return false;' ) );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	
	if ( get_data( 'shop_catalog_mode_hide_prices' ) )
	{
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 29 );
		add_filter( 'get_data_shop_product_price_listing', create_function( '', 'return false;' ) );
	}
}


// WooCommerce Fields
add_filter( 'woocommerce_form_field_args', 'lab_wc_woocommerce_form_field_args', 10, 3 );

function lab_wc_woocommerce_form_field_args( $args ) {
	// Default Input Class
	$args['input_class'][] = 'form-control';
	
	// Replace Input Labels with Placeholder (text, password, etc)
	if ( in_array( $args['type'], array( 'text', 'password', 'state', 'country', 'email', 'tel' ) ) ) {
		$args['placeholder'] = $args['label'];
		$args['label_class'][] = 'hidden';
	} 
	elseif ( in_array( $args['type'], array( 'checkbox', 'radio' ) ) ) {
		if ( $args['type'] == 'checkbox' )
		{
			$args['input_class'][] = 'replaced-checkboxes';
		}
	}
	
	return $args;
}


// Login Form Wrapper
add_action( 'woocommerce_login_form_start', 'lab_wc_my_account_login_form_start' );
add_action( 'woocommerce_login_form_end', 'lab_wc_my_account_login_form_end' );

add_action( 'woocommerce_register_form_start', 'lab_wc_my_account_login_form_start' );
add_action( 'woocommerce_register_form_end', 'lab_wc_my_account_login_form_end' );

function lab_wc_my_account_login_form_start() {
	if ( is_page( get_option( 'woocommerce_myaccount_page_id' ) ) ) :
?>
<div class="bordered-block with-form-labels" data-mh="my-account-blocks">
<?php
	endif;
}

function lab_wc_my_account_login_form_end() {
	if ( is_page( get_option( 'woocommerce_myaccount_page_id' ) ) ) :
?>
</div>
<?php	
	endif;
}



// My Account Wrapper
add_action( 'woocommerce_before_my_account', 'lab_wc_before_my_account' );
add_action( 'woocommerce_after_my_account', 'lab_wc_after_my_account' );

function lab_wc_before_my_account() {
?>
<div class="my-account">
<?php	
}

function lab_wc_after_my_account() {
?>
</div>
<?php	
}


// Bacs Details
add_action( 'woocommerce_thankyou_bacs', 'lab_wc_bacs_details_before', 1 );
add_action( 'woocommerce_thankyou_bacs', 'lab_wc_bacs_details_after', 100 );

function lab_wc_bacs_details_before() {
?>
<div class="bacs-details-container">
<?php
}

function lab_wc_bacs_details_after() {
?>
</div>
<?php
}


// Get Columns Class
function lab_wc_get_columns_class( $columns_count ) {

	switch ( $columns_count ) {
		case 2:
			$columns_bs_class = 'col-xs-6';
			break;
		
		case 4:
			$columns_bs_class = 'col-md-3 col-sm-6 col-xs-6';
			break;
		
		case 5:
			$columns_bs_class = 'col-md-2-4 col-xs-6';
			break;
		
		case 6:
			$columns_bs_class = 'col-md-2 col-xs-6';
			break;
			
		// including 3 columns as well
		default: 
			$columns_bs_class = 'col-md-4 col-xs-6';
			
	}
	
	// Two columns per mobile
	if ( 'two' == get_data( 'shop_product_columns_mobile' ) ) {
		$columns_bs_class .= ' mobile-2-cols';
	}
	
	return $columns_bs_class;
}


// Cart Menu Icon
function lab_wc_cart_menu_icon( $skin ) {
	if ( ! get_data( 'shop_cart_icon_menu' ) ) {
		return false;
	}
	
	$icon                  = get_data( 'shop_cart_icon' );
	$hide_empty            = get_data( 'shop_cart_icon_menu_hide_empty' );
	$show_cart_contents    = get_data( 'shop_cart_contents' );
	$cart_items_counter    = get_data( 'shop_cart_icon_menu_count' );
	$ajax_mode             = get_data( 'shop_cart_icon_menu_ajax' );
	
	$cart_items = WC()->cart->cart_contents_count;
	
	
	?>
	<div class="menu-cart-icon-container <?php 
		
		echo esc_attr( $skin ); 
		when_match( $hide_empty && $cart_items == 0, 'hidden' );
		when_match( $ajax_mode, 'ajax-mode' );
		when_match( $show_cart_contents == 'show-on-hover', 'hover-show' );

	?>">
	
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart-icon-link icon-type-<?php echo esc_attr( $icon ); ?>">
			<i class="icon-<?php echo esc_attr( $icon ); ?>"></i>
			
			<?php if ( $cart_items_counter ) : ?>
			<span class="items-count<?php when_match( $ajax_mode, 'hide-notification' ); ?> cart-items-<?php echo esc_attr( $cart_items ); ?>"><?php echo $ajax_mode ? '0' : $cart_items; ?></span>
			<?php endif; ?>
		</a>
		
		
		<?php if ( $show_cart_contents != 'hide' ) : ?>
		<div class="lab-wc-mini-cart-contents">
		<?php get_template_part( 'tpls/wc-mini-cart' ); ?>
		</div>
		<?php endif; ?>
	</div>
	<?php
}

function lab_wc_cart_menu_icon_mobile() {
	if ( ! get_data( 'shop_cart_icon_menu' ) || ! function_exists( 'WC' ) ) {
		return;
	}
	
	$icon                  = get_data( 'shop_cart_icon' );
	$hide_empty            = get_data( 'shop_cart_icon_menu_hide_empty' );
	$show_cart_contents    = get_data( 'shop_cart_contents' );
	$cart_items_counter    = get_data( 'shop_cart_icon_menu_count' );
	$ajax_mode             = get_data( 'shop_cart_icon_menu_ajax' );
	
	$cart_items = WC()->cart->cart_contents_count;
	
	?>
	<div class="cart-icon-link-mobile-container">
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="cart-icon-link-mobile icon-type-<?php echo esc_attr( $icon ); ?>">
			<i class="icon icon-<?php echo esc_attr( $icon ); ?>"></i>
			
			<?php _e( 'Cart', 'kalium' ); ?>
			
			<?php if ( $cart_items_counter ) : ?>
			<span class="items-count<?php when_match( $ajax_mode, 'hide-notification' ); ?> cart-items-<?php echo esc_attr( $cart_items ); ?>"><?php echo $ajax_mode ? '...' : $cart_items; ?></span>
			<?php endif; ?>
		</a>
	</div>
	<?php
}


// Cart Fragments for Minicart
add_filter( 'woocommerce_add_to_cart_fragments', 'lab_wc_woocommerce_add_to_cart_fragments' );

function lab_wc_woocommerce_add_to_cart_fragments( $fragments_arr ) {
	ob_start();
	get_template_part( 'tpls/wc-mini-cart' ); 
	$cart_contents = ob_get_clean();
	
	$fragments_arr['labMiniCart'] = $cart_contents;
	$fragments_arr['labMiniCartCount'] = WC()->cart->cart_contents_count;
	
	return $fragments_arr;
}


// Get Mini Cart Contents
add_action( 'wp_ajax_lab_wc_get_mini_cart_fragments', 'lab_wc_get_mini_cart_fragments' );
add_action( 'wp_ajax_nopriv_lab_wc_get_mini_cart_fragments', 'lab_wc_get_mini_cart_fragments' );

function lab_wc_get_mini_cart_fragments() {
	ob_start();
	get_template_part( 'tpls/wc-mini-cart' ); 
	$cart_contents = ob_get_clean();
	
	$fragments_arr = array();
	
	$fragments_arr['labMiniCart'] = $cart_contents;
	$fragments_arr['labMiniCartCount'] = WC()->cart->cart_contents_count;
	
	echo json_encode( $fragments_arr );
	die();
}


// Shop Description
add_action( 'woocommerce_before_main_content', 'lab_wc_before_main_content' );

function lab_wc_before_main_content() {	
	
	$shop_page_id = get_option( 'woocommerce_shop_page_id' );
	$page_content = get_post( $shop_page_id )->post_content;
	
	$is_vc_container = preg_match( '/\[vc_row.*?\]/i', $page_content );
	
	if ( is_shop() && $is_vc_container ) {
		remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
		?>
		<div class="shop-vc-content-container">
			<?php echo apply_filters( 'the_content', $page_content ); ?>
		</div>
		<?php
	}
}

// Account Navigation
function kalium_woocommerce_before_account_navigation() {
	global $current_user;
	
	$account_page_id    = wc_get_page_id( 'myaccount' );
	$account_url        = get_permalink( $account_page_id );
	$logout_url         = wp_logout_url( $account_url );
	
	?>
	<div class="wc-my-account-tabs">
		
		<div class="user-profile">
			<a class="image">
				<?php echo get_avatar( $current_user->ID, 128 ); ?>
			</a>
			<div class="user-info">
				<a class="name" href="<?php echo the_author_meta( 'user_url', $current_user->ID ); ?>"><?php echo $current_user->display_name; ?></a>
				<a class="logout" href="<?php echo $logout_url; ?>"><?php _e( 'Logout', 'kalium' ); ?></a>
			</div>
		</div>
	<?php
}

function kalium_woocommerce_after_account_navigation() {
	?>
	</div>
	<?php
}

add_action( 'woocommerce_before_account_navigation', 'kalium_woocommerce_before_account_navigation' );
add_action( 'woocommerce_after_account_navigation', 'kalium_woocommerce_after_account_navigation' );


// My Orders Page Title
function kalium_woocommerce_before_account_orders( $has_orders ) {
	
	?>
	<div class="section-title">
		<h1><?php _e( 'My Orders', 'kalium' ); ?></h1>
		<p><?php _e( 'Your recent orders are displayed in the table below.', 'kalium' ); ?></p>
	</div>
	<?php
}

add_action( 'woocommerce_before_account_orders', 'kalium_woocommerce_before_account_orders' );

// My Downloads Page Title
function kalium_woocommerce_before_account_downloads( $has_orders ) {
	
	?>
	<div class="section-title">
		<h1><?php _e( 'My Downloads', 'kalium' ); ?></h1>
		<p><?php _e( 'Your digital downloads are displayed in the table below.', 'kalium' ); ?></p>
	</div>
	<?php
}

add_action( 'woocommerce_before_account_downloads', 'kalium_woocommerce_before_account_downloads' );



// Shop Loop Clearing
function kalium_woocommerce_shop_loop_clear_row( $shop_columns ) {
	global $woocommerce_loop;
	
	if ( $shop_columns ) {
		echo $woocommerce_loop['loop'] % $shop_columns == 0 ? '<div class="clear-md"></div>' : '';
		echo $woocommerce_loop['loop'] % 2 == 0 ? '<div class="clear-sm"></div>' : '';
	}
}

add_action( 'kalium_woocommerce_shop_loop_clear_row', 'kalium_woocommerce_shop_loop_clear_row', 10, 2 );


// Kalium Shop Translations
function kalium_woocmmerce_get_i18n_str( $str_id, $echo = false ) {
	
	$found_string = 'kalium_woocmmerce_get_i18n_str::notFoundString';
	
	$strings = array(
		'Login'                                               => __( 'Login', 'kalium' ),
		'&laquo; Go back'                                     => __( '&laquo; Go back', 'kalium' ),
		'Payment Method'                                      => __( 'Payment Method', 'kalium' ),
		'Added to cart'                                       => __( 'Added to cart', 'kalium' ),
		'Out of stock'                                        => __( 'Out of stock', 'kalium' ),
		'Featured'                                            => __( 'Featured', 'kalium' ),
		'Loading products...'                                 => __( 'Loading products...', 'kalium' ),
		'No more products to show'                            => __( 'No more products to show', 'kalium' ),
		'Edit information for this address type'              => __( 'Edit information for this address type', 'kalium' ),
		'Reset Password'                                      => __( 'Reset Password', 'kalium' ),
		'Lost Password'                                       => __( 'Lost Password', 'kalium' ),
		'Login or Register'                                   => __( 'Login or Register', 'kalium' ),
		'Manage your account and see your orders'             => __( 'Manage your account and see your orders', 'kalium' ),
		'Go'                                                  => esc_attr_x( 'Go', 'submit button', 'kalium' ),
		'My Account'                                          => __( 'My Account', 'kalium' ),
		'Edit your account details or change your password'   => __( 'Edit your account details or change your password', 'kalium' ),
		'Password Change'                                     => __( 'Password Change', 'kalium' ),
		'(leave blank to leave unchanged)'                    => __( '(leave blank to leave unchanged)', 'kalium' ),
		'Current Password'                                    => __( 'Current Password', 'kalium' ),
		'New Password'                                        => __( 'New Password', 'kalium' ),
	);
	
	if ( isset( $strings[ $str_id ] ) ) {
		$found_string = $strings[ $str_id ];
	}
	
	if ( ! $echo ) {
		return $found_string;
	}
	
	echo $found_string;
}

// WooCommerce Single Product Thumbnails Carousel Setup
function kalium_shop_single_product_images_carousel_setup() {
	
	$shop_single_product_images_layout = get_data( 'shop_single_product_images_layout' );
	$shop_single_auto_rotate_image     = get_data( 'shop_single_auto_rotate_image' );
	$shop_product_image_columns        = apply_filters( 'lab_wc_single_product_image_column_size', 'small' );
	
	if ( '' == $shop_single_auto_rotate_image ) {
		$shop_single_auto_rotate_image = 5;
	}
	
	$shop_single_auto_rotate_image = absint( $shop_single_auto_rotate_image );
	
	if ( ! in_array( $shop_single_product_images_layout, array( 'plain', 'plain-sticky' ) ) ) {
		$image_carousel_options = array();
		
		// Thumbnails to Show
		if ( 'large' == $shop_product_image_columns ) {
			$image_carousel_options['thumbnailsToShow'] = 4;
		} else {
			$image_carousel_options['thumbnailsToShow'] = 3;
		}
		
		// Auto Rotate Images
		$image_carousel_options['autoRotateImage'] = $shop_single_auto_rotate_image * 1000;
		
		// Image Transition Type
		$image_carousel_options['carouselFade'] = 'slide' == get_data( 'shop_single_image_carousel_transition' ) ? false : true;
		
		// Parse options to JSON
		?>
		<script type="text/javascript">
			window.singleShopProductCarouselOptions = <?php echo json_encode( $image_carousel_options ); ?>
		</script>
		<?php
	}
}

add_action( 'woocommerce_before_single_product_summary', 'kalium_shop_single_product_images_carousel_setup' );

// Show mini cart icon and contents in header
function kalium_wc_header_mini_cart( $skin ) {
	if ( is_shop_supported() ) {	
		lab_wc_cart_menu_icon( $skin ); 
	}
}

// Sidebar wrapper
function kalium_wc_single_product_sidebar_wrapper_start() {
	$sidebar_position = get_data( 'shop_single_sidebar_position' );
	
	?>
	<div class="row">
		<div class="col-md-9<?php when_match( 'left' == $sidebar_position, 'pull-right-md' ); ?>">
	<?php
}

function kalium_wc_single_product_sidebar_wrapper_end() {
	$sidebar_position = get_data( 'shop_single_sidebar_position' );
	?>
		</div>
		<div class="single-product-sidebar-container sidebar-position-<?php echo esc_attr( $sidebar_position ); ?> col-md-3">
			<div class="blog-sidebar shop-sidebar">
			<?php
			if ( false === dynamic_sidebar( 'shop_sidebar_single' ) ) {
				dynamic_sidebar( 'shop_sidebar' );
			}
			?>
			</div>
		</div>
	</div>
	<?php
}

// Single Product Sidebar
if ( in_array( get_data( 'shop_single_sidebar_position' ), array( 'left', 'right' ) ) ) {
	add_action( 'woocommerce_before_single_product', 'kalium_wc_single_product_sidebar_wrapper_start' );
	add_action( 'woocommerce_after_single_product', 'kalium_wc_single_product_sidebar_wrapper_end' );
}


// Variation Image Implementation
function kalium_wc_variation_image_handler( $variation_arr, $variable_product, $variation ) {
	$attachment_id = get_post_thumbnail_id( $variation->get_variation_id() );
	
	$variation_arr['kalium_image'] = $variation_arr['kalium_image_thumbnail'] = '';
	
	if ( $attachment_id ) {
			
		// Main image
		$variation_arr['kalium_image'] =  apply_filters( 'woocommerce_single_product_image_html', '', $attachment_id );
		
		// Gallery image
		$variation_arr['kalium_image_thumbnail'] = apply_filters( 'woocommerce_single_product_image_thumbnail_html', '', $attachment_id, $variable_product->post->ID, 'zoom' );
		
		
	}
	
	return $variation_arr;
}

add_filter( 'woocommerce_available_variation', 'kalium_wc_variation_image_handler', 10, 3 );

// WooCommerce Additional Variation Images Handler
function kalium_wc_additional_variation_images_handler( $output, $attachment_id ) {
	return $output;
}

add_filter( 'woocommerce_single_product_image_html', 'kalium_wc_additional_variation_images_handler', 10, 2 );