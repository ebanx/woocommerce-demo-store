<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Script
 */
wp_enqueue_script('carouFredSel');
wp_enqueue_script( 'wc-add-to-cart-variation' );

global $product,$post, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array('product');
if(dh_get_theme_option('woo-lazyload',1))
	$classes[] ='unveil-image';

if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

if (dh_get_theme_option('woo-grid-product-style','style-1') =='style-1')
	$classes[] = 'style-1';
elseif (dh_get_theme_option('woo-grid-product-style','style-1') =='style-2')
	$classes[] = 'style-2';
elseif (dh_get_theme_option('woo-grid-product-style','style-1') =='style-3')
	$classes[] = 'style-3';
?>
<li <?php post_class( $classes ); ?>>
	<div class="product-container">
		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<figure>
			<div class="product-wrap">
				<div class="product-images">
					<a href="<?php the_permalink(); ?>">
						<?php if ( !$product->is_in_stock() ) : ?>            
			            	<span class="out_of_stock"><?php esc_html_e( 'Out of stock', 'forward' ); ?></span>            
						<?php endif; ?>
						<?php
							/**
							 * woocommerce_before_shop_loop_item_title hook
							 *
							 * @hooked woocommerce_show_product_loop_sale_flash - 10
							 * @hooked woocommerce_template_loop_product_thumbnail - 10
							 */
							do_action( 'woocommerce_before_shop_loop_item_title' );
						?>
					</a>
					<div class="loop-action">
						<div class="loop-add-to-cart" data-toggle="tooltip" data-container="body" title="<?php echo esc_attr($product->add_to_cart_text())?>">
							<?php woocommerce_template_loop_add_to_cart();?>
						</div>
						<?php 
							if(class_exists('DH_Woocommerce'))
							DH_Woocommerce::instance()->template_loop_quickview();
						?>
						<?php if(class_exists('DH_Woocommerce')):?>
							<div class="loop-add-to-wishlist">
								<?php DH_Woocommerce::instance()->template_loop_wishlist()?>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>
			<figcaption>
				<div class="shop-loop-product-info">

					<h3 class="product_title"><a href="<?php the_permalink()?>"><?php the_title(); ?></a></h3>
					<?php if(dh_get_theme_option('woo-list-cat',1)):?>
					<div class="product_category">
						<?php echo $product->get_categories()?>
					</div>
					<?php endif;?>
					<?php if (dh_get_theme_option('woo-list-rating',1) =='1') :?>
						<div class="info-meta clearfix">
							<?php woocommerce_template_loop_rating(); ?>
						</div>
					<?php endif;?>
					<div class="info-price">
						<?php woocommerce_template_loop_price(); ?>
					</div>
					<?php //DH_Woocommerce::countdown_html()?>
					<div class="info-excerpt">
						<?php echo wp_trim_words($post->post_excerpt,30)?>
					</div>
					<div class="list-info-meta clearfix">
						<div class="list-action clearfix">
							<div class="loop-add-to-cart">
								<?php woocommerce_template_loop_add_to_cart();?>
							</div>
							<?php 
								DH_Woocommerce::instance()->template_loop_quickview();
							?>
							<div class="loop-add-to-wishlist">
								<?php DH_Woocommerce::instance()->template_loop_wishlist()?>
							</div>
						</div>
					</div>
				</div>
			</figcaption>
		</figure>
	</div>
</li>