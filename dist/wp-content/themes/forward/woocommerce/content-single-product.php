<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wp_enqueue_script('carouFredSel');

if(dh_get_theme_option('single-product-popup','popup') == 'easyzoom'){
	wp_enqueue_script('easyzoom');
}else{
	wp_enqueue_style('magnific-popup');
	wp_enqueue_script('magnific-popup');
}


?>
<?php
	if (dh_get_theme_option('single-product-style','style-1') == 'style-3'){
		echo '<div class="container"><div class="row"><div class="col-sm-12">';
	}
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
	 if (dh_get_theme_option('single-product-style','style-1') == 'style-3'){
	 	echo '</div></div></div>';
	 }
?>
<?php 
$style = dh_get_theme_option('single-product-style','style-1');
$entry_image_col = 'col-md-6';
$entry_summary = 'col-md-6';
if($style == 'style-3'){
	$entry_image_col = 'col-md-6';
	$entry_summary = 'col-md-6';
}
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class($style); ?>>
	<div class="row summary-container">
		<div class="<?php echo esc_attr($entry_image_col)?> entry-image">
			<div class="single-product-images">
			<?php
				/**
				 * woocommerce_before_single_product_summary hook
				 *
				 * @hooked woocommerce_show_product_sale_flash - 10
				 * @hooked woocommerce_show_product_images - 20
				 */
				do_action( 'woocommerce_before_single_product_summary' );
			?>
			</div>
		</div>
		<div class="<?php echo esc_attr($entry_summary)?> entry-summary">
			<div class="summary">
		
				<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					if ( !dh_get_theme_option( 'show-woo-meta', 1 )) {
						remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
					}
					do_action( 'woocommerce_single_product_summary' );
				?>
		
			</div><!-- .summary -->
		</div>
	</div>
	<?php if($style == 'style-3'){?>
	<div class="<?php dh_container_class();?>">
	<?php }?>
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	<?php if($style == 'style-3'){?>
	</div>
	<?php }?>
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

