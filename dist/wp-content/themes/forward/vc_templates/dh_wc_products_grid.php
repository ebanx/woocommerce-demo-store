<?php
$atts = shortcode_atts( array(
	'columns' => '4',
	'image_desc'=>'',
	'orderby' => 'title',
	'order'   => 'asc',
	'ids'     => '',
	'skus'    => ''
), $atts );

$query_args = array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'orderby'             => $atts['orderby'],
	'order'               => $atts['order'],
	'posts_per_page'      => -1,
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

$products                    = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
$columns                     = absint( $atts['columns'] );
$woocommerce_loop['columns'] = $columns;

ob_start();
$image_src = wp_get_attachment_url($atts['image_desc']);
if ( $products->have_posts() ) : ?>
<div class="wc-product-grid-desc col-md-6">
	<div class="wc-product-grid-desc-wrap">
		<div class="wc-product-grid-desc-text">
			<?php echo wpb_js_remove_wpautop($content)?>
		</div>
		<?php if(!empty($image_src)):?>
			<div class="wc-product-grid-desc-img">
				<img src="<?php echo esc_attr($image_src)?>" alt="">
			</div>
		<?php endif;?>
	</div>
</div>
<?php woocommerce_product_loop_start(); ?>

	<?php while ( $products->have_posts() ) : $products->the_post(); ?>

		<?php wc_get_template_part( 'content', 'product' ); ?>

	<?php endwhile; // end of the loop. ?>

<?php woocommerce_product_loop_end(); ?>
<?php endif;

woocommerce_reset_loop();
wp_reset_postdata();

echo '<div class="woocommerce wc-product-grid columns-' . $columns . '">' . ob_get_clean() . '</div>';
