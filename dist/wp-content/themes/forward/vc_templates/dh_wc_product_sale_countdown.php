<?php
$output ='';
$atts = shortcode_atts( array(
	'columns' 			=>'4',
	'orderby' 			=> 'title',
	'order'   			=> 'asc',
	'posts_per_page'    =>'12',
	'ids'     			=> '',
	'skus'    			=> ''
), $atts );

/**
 * script
 * {{
 */
wp_enqueue_script( 'wc-add-to-cart-variation' );
wp_enqueue_script('carouFredSel');

$query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'orderby'             => $atts['orderby'],
	'order'               => $atts['order'],
	'posts_per_page'      => $atts['posts_per_page'],
	'meta_query'          => WC()->query->get_meta_query()
);

if ( ! empty( $atts['skus'] ) ) {
	$query_args['meta_query'][] = array(
		'key'     => '_sku',
		'value'   => array_map( 'trim', explode( ',', $atts['skus'] ) ),
		'compare' => 'IN'
	);
}

if ( ! empty( $atts['ids'] ) ) {
	$query_args['post__in'] = array_map( 'trim', explode( ',', $atts['ids'] ) );
}

global $woocommerce_loop;
$product_ids_on_sale    		= wc_get_product_ids_on_sale();
$product_ids_on_sale[]  		= 0;
$query_args['post__in'] 		= $product_ids_on_sale;
$products                   	= new WP_Query($query_args );
$columns                     	= absint( $atts['columns'] );
$woocommerce_loop['columns']    = $columns;
$woocommerce_loop['show_countdown'] = true;
/**
 * script
 * {{
 */
wp_enqueue_script('countdown');

?>
<?php if ( $products->have_posts() ) : ?>
	
	<div class="woocommerce product-sale-countdown">	
			
	<?php woocommerce_product_loop_start(); ?>

		<?php while ( $products->have_posts() ) : $products->the_post(); ?>

			<?php wc_get_template_part( 'content','product' ); ?>

		<?php endwhile; // end of the loop. ?>

	<?php woocommerce_product_loop_end(); ?>
	
	</div>
	 
<?php endif;?> 
<?php $woocommerce_loop['show_countdown'] =false;?>
<?php wp_reset_postdata(); woocommerce_reset_loop();?>
