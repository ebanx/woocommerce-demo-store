<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="upsells products">
		<div class="upsells-title">
			<h3><span><?php esc_html_e( 'You may also like&hellip;', 'forward' ) ?></span></h3>
		</div>
		<div class="<?php if($products->post_count > 4){?>caroufredsel<?php }?> product-slider caroufredsel-item-no-padding" data-scroll-item="1" data-height="variable" data-visible-min="1" data-visible-max="4" data-scroll-item="1"  data-responsive="1" data-infinite="1">
			<div class="caroufredsel-wrap">
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
				<a href="#" class="caroufredsel-prev"></a>
				<a href="#" class="caroufredsel-next"></a>
			</div>
		</div>

	</div>

<?php endif;

wp_reset_postdata();
