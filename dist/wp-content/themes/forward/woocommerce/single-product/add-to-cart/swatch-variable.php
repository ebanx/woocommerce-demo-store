<?php
/**
 * SWatch Variable product add to cart
 *
 */
global $product, $post;
?>
<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<div class="swatch-variations">
	<form action="<?php echo esc_url($product->add_to_cart_url()); ?>" class="variations_form cart swatch_variations_form" method="post" enctype='multipart/form-data' 
		data-product_id="<?php echo esc_attr($post->ID); ?>" 
		data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>"
		data-product_attributes="<?php echo esc_attr(json_encode($variation_params['attributes_renamed'])); ?>"
      	data-product_variations_available="<?php echo esc_attr(json_encode($variation_params['available_variations_flat'])); ?>"
      	data-variations_map="<?php echo esc_attr(json_encode($variation_params['variations_map'])); ?>"
		>
		<?php if ( ! empty( $available_variations ) ) : ?>
		<table class="variations variations-table" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++;  ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title( $name ); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value">
							<div class="woocommerce-variation-select swatch-select-wrap">
							<?php 
							$slug = sanitize_title( $name );
							$taxonomies = taxonomy_exists( $slug ) ? $slug : (taxonomy_exists( $name ) ? $name : $slug);
							$option_array = false;
							if ( is_array( $options ) ) {
								$option_array = true;
								if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
									$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
								} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
									$selected_value = $selected_attributes[ sanitize_title( $name ) ];
								} else {
									$selected_value = '';
								}
							}
							?>
							<input type="hidden" name="<?php echo 'attribute_' . $slug; ?>" id="<?php echo 'attribute_' . $slug; ?>" value="<?php echo $selected_value; ?>" />
							<?php
							if ( taxonomy_exists( $taxonomies ) ) :
								$terms = wc_get_product_terms( $post->ID, $taxonomies, array( 'fields' => 'all' ) );
								foreach ($terms as $term){
									if ( ! in_array( $term->slug, $options ) ) {
										continue;
									}
									?>
									<?php
									if($option_array){
										$type = get_woocommerce_term_meta($term->term_id, 'dhwooswatches_type',true);
										?>
										<div class="swatch-select"<?php echo ($selected_value == $term->slug ?'data-default="true"':'')?>>
											<?php 
											if($type == 'color'){
												$color = get_woocommerce_term_meta( $term->term_id, 'dhwooswatches_color', true );
												if(empty($color))
													$color = '#fff';
												echo '<a title="'.$term->name.'" style="background-color:'.$color.';text-indent: -9999em;" href="#">'.$term->name.'</a>';
											}elseif ($type == 'image'){
												$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'dhwooswatches_thumbnail_id', true );
												if ($thumbnail_id) :
													$image = wp_get_attachment_url( $thumbnail_id );
												else :
													$image = woocommerce_placeholder_img_src();
												endif;
												echo '<a title="'.$term->name.'" href="#"><img alt="'.$term->name.'" src="'.$image.'" /></a>';
											}?>
										</div>
										<?php
									}
								}
							endif;
							?>
							
						</div><?php
							if ( sizeof( $attributes ) === $loop ) {
								echo '<a class="reset_variations" href="#reset">' . esc_html__( 'Clear selection', 'forward' ) . '</a>';
							}
						?>
						</td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

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
		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	<?php else : ?>
		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'forward' ); ?></p>
	<?php endif; ?>
	</form>
</div>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>