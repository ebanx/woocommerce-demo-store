<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;
$attachment_ids = $product->get_gallery_attachment_ids();
$style = dh_get_theme_option('single-product-style','style-1');
?>
<?php
$attachment_ids = $product->get_gallery_attachment_ids();
$placeholder = false;
if ( has_post_thumbnail() ) {
	$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
	$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
		'title' => $image_title
		) );
	$image_full = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
}else{
	$image_title = get_the_title($product->id);
	$image =  apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );
	$image_full = array(wc_placeholder_img_src());
	$placeholder = true;
}
?>
<?php $shop_single = wc_get_image_size( 'shop_single' );?>
<div class="single-product-images-slider<?php echo ($attachment_ids ? ' product-has-thumbnails-gallery':'') ?>"  data-product_images="<?php echo esc_attr(DH_Woocommerce_Product_Variable::instance()->get_product_image($product)) ?>"  data-dh_disable_variation_gallery="<?php echo esc_attr(get_post_meta(get_the_ID(),'_dh_disable_variation_gallery',true)) ?>" data-item_template = "<?php echo esc_attr('<li class="caroufredsel-item" style="__width__"><div class="thumb'.(dh_get_theme_option('single-product-popup','popup') == 'easyzoom' && $style != 'style-2' ? ' easyzoom':'').'"><a href="__image_full__" data-rel="magnific-popup-verticalfit" title="__image_title__">__image__</a></div></li>'); ?>">
	<?php DH_Woocommerce::instance()->the_product_video()?>
	<div class="caroufredsel product-images-slider" data-synchronise=".single-product-images-slider-synchronise" data-scroll-fx="directscroll" data-scrollduration="500" data-height="variable" data-scroll-fx="none" data-visible="1" data-circular="1" data-responsive="1">
		<div class="caroufredsel-wrap">
			<ul class="caroufredsel-items">
				<?php if(apply_filters('dh_use_feature_product_image_in_single', false)):?>
				<li class="caroufredsel-item">
					<div class="thumb<?php if(dh_get_theme_option('single-product-popup','popup') == 'easyzoom'){?> easyzoom<?php }?>">
						<a itemprop="image" href="<?php echo esc_attr(@$image_full[0])?>"  <?php if(dh_get_theme_option('single-product-popup','popup') == 'popup'){?>data-rel="magnific-popup"<?php }?>  title="<?php echo esc_attr($image_title)?>">
							<?php echo dh_print_string($image)?>
						</a>
					</div>
				</li>
				<?php endif;?>
				<?php if ( $attachment_ids ) {?>
					<?php  $loop=1; ?>
					<?php foreach ( $attachment_ids as $attachment_id ) {?>
					<?php 
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					$image_full = wp_get_attachment_image_src($attachment_id,'full');
					?>
					<li class="caroufredsel-item">
						<div class="thumb<?php if(dh_get_theme_option('single-product-popup','popup') == 'easyzoom'){?> easyzoom<?php }?>">
							<a href="<?php echo esc_attr(@$image_full[0])?>" <?php if(dh_get_theme_option('single-product-popup','popup') == 'popup'){?>data-rel="magnific-popup"<?php }?> title="<?php echo esc_attr($image_title)?>">
								<?php echo dh_print_string($image)?>
							</a>
						</div>
					</li>
					<?php
						$loop ++; 
						}
					 ?>
				<?php } ?>
			</ul>
			<a href="#" class="caroufredsel-prev"></a>
			<a href="#" class="caroufredsel-next"></a>
		</div>
	</div>
</div>
<?php
if($attachment_ids)
	do_action( 'woocommerce_product_thumbnails' );
?>
