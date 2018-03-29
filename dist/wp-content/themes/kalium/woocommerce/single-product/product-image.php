<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

// start: modified by Arlind
$attachment_ids = $product->get_gallery_attachment_ids();
$shop_single_product_images_layout = get_data( 'shop_single_product_images_layout' );

$images_container_classes = array( 'images' );
$images_container_classes[] = "images-layout-type-{$shop_single_product_images_layout}";

// Images Carousel
$images_carousel_classes = array( 'product-images-carousel' );

if ( in_array( $shop_single_product_images_layout, array( 'plain', 'plain-sticky' ) ) ) {
	$images_carousel_classes[] = 'plain';
	
	// Stretch images to browser edge	
	if ( 'yes' == get_data( 'shop_single_plain_image_stretch' ) ) {
		$images_carousel_classes[] = 'right' == get_data( 'shop_single_image_alignment' ) ? 'right-edge-sticked' : 'left-edge-sticked';
	}
}

if ( 'plain-sticky' == $shop_single_product_images_layout ) {
	$images_carousel_classes[] = 'sticky';
}
// end: modified by Arlind

?>
<div class="<?php echo esc_attr( implode( ' ', $images_container_classes ) ); ?>">
	
	<div class="<?php echo esc_attr( implode( ' ', $images_carousel_classes ) ); ?>">
	<?php
		if ( has_post_thumbnail() ) {
			$attachment_count = count( $product->get_gallery_attachment_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			
			echo apply_filters(
				'woocommerce_single_product_image_html',
				sprintf(
					'<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( $props['caption'] ),
					$gallery,
					$image
				),
				$post->ID
			);
			
			// start: modified by Arlind
			if ( $attachment_ids ) {
				// Remove featured image from attachments
				if ( ( $key = array_search( get_post_thumbnail_id(), $attachment_ids ) ) !== false ) {
					unset( $attachment_ids[ $key ] );
				}
				
				// Show gallery items
				foreach ( $attachment_ids as $attachment_id ) {
					$props = wc_get_product_attachment_props( $attachment_id );
					$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), null, array(
						'title'	 => $props['title'],
						'alt'    => $props['alt'],
					) );
					
					echo apply_filters(
						'woocommerce_single_product_image_html',
						sprintf(
							'<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>',
							esc_url( $props['url'] ),
							esc_attr( $props['caption'] ),
							$gallery,
							$image
						),
						$attachment_id,
						true // Added by Arlind
					);
				}
			}
			// end: modified by Arlind
			
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}
	?>
	</div>
	
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	
</div>
