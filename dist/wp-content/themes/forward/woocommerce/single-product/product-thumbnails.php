<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;
$selected = false;
$attachment_ids = $product->get_gallery_attachment_ids();
$style = dh_get_theme_option('single-product-style','style-1');
if ( $attachment_ids ) {
?>
<div class="single-product-thumbnails" data-item_template = "<?php echo esc_attr('<li class="caroufredsel-item'.($style != 'style-1' ? ' col-sm-3 col-xs-6':'').'"><div class="thumb"><a href="#" title="__image_title__">__image__</a></div></li>'); ?>">
	<div class="caroufredsel product-thumbnails-slider<?php if($attachment_ids && count($attachment_ids) < 3){ ?> caroufredsel-fixed<?php } ?>" data-visible-max="4" data-visible-min="2" data-scrollduration="500"  <?php if($style == 'style-1'){?> data-direction="up" data-height="100%" data-responsive="0" data-circular="1" <?php }else{?> data-circular="0" data-scroll-fx="scroll" data-responsive="1" <?php }?>>
		<div class="caroufredsel-wrap">
			<ul class="single-product-images-slider-synchronise caroufredsel-items">
				<?php if(apply_filters('dh_use_feature_product_image_in_single', false) && has_post_thumbnail()):?>
				<?php 
				$selected = true;
				$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array('title' => $image_title) );
				?>
				<li class="caroufredsel-item selected <?php if($style != 'style-1'):?> col-sm-3 col-xs-6<?php endif?> ">
					<div class="thumb">
						<a href="#" data-rel="0" title="<?php echo esc_attr($image_title)?>">
							<?php echo dh_print_string($image)?>
						</a>
					</div>
				</li>
				<?php endif;?>
			    <?php
			    $loop=1;
				foreach ( $attachment_ids as $attachment_id ) {
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );	
				?>
				<li class="caroufredsel-item<?php if($style != 'style-1'):?> col-sm-3 col-xs-6<?php endif?> <?php if(!$selected && $loop==1): echo ' selected';endif;?>">
					<div class="thumb">
						<a href="#" data-rel="<?php echo esc_attr($loop)?>" title="<?php echo esc_attr($image_title)?>">
							<?php echo dh_print_string($image)?>
						</a>
					</div>
				</li>
				<?php
				$loop ++;
				}
				?>
			</ul>
		</div>
	</div>
</div>
<?php }?>