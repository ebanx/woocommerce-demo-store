<?php
/**
 * Variable Product Add to Cart
 */
global $woocommerce, $product, $post;

$variation_params = woocommerce_swatches_get_variation_form_args();

do_action('woocommerce_before_add_to_cart_form');
?>
 <div class="product-actions res-color-attr">
<form action="<?php echo esc_url($product->add_to_cart_url()); ?>" 
      class="variations_form cart swatches" 
      method="post" 
      enctype='multipart/form-data' 
      data-product_id="<?php echo $post->ID; ?>" 
      data-product_variations="<?php echo esc_attr(json_encode($available_variations)) ?>"
      data-product_attributes="<?php echo esc_attr(json_encode($variation_params['attributes_renamed'])); ?>"
      data-product_variations_flat="<?php echo esc_attr(json_encode($variation_params['available_variations_flat'])); ?>"
      data-variations_map="<?php echo esc_attr(json_encode($variation_params['variations_map'])); ?>"
      >
	<div class="product-options-outer">
	<div class="variation_form_section">
	<div class="product-options icons-lg">
		<?php
		$woocommerce_variation_control_output = new WC_Swatch_Picker($product->id, $attributes, $variation_params['selected_attributes']);
		$woocommerce_variation_control_output->picker();
		?>

		<div class="clear"></div><a id="variations_clear" href="#reset" style="display:none;"><?php esc_html_e('Reset selection', 'forward'); ?></a>

	</div>
	</div>
	</div>
	<?php do_action('woocommerce_before_add_to_cart_button'); ?>
	<div class="single_variation_wrap" style="display:none;">
		<?php do_action( 'woocommerce_before_single_variation' ); ?>

		<div class="single_variation"></div>

		<div class="variations_button">
			<?php woocommerce_quantity_input(); ?>
			<button type="submit" class="single_add_to_cart_button button alt"><?php echo dh_print_string($product->single_add_to_cart_text()); ?></button>
		</div>
		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>" />
		<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="" />

		<?php do_action( 'woocommerce_after_single_variation' ); ?>
	</div>
	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

</form>
</div>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>
