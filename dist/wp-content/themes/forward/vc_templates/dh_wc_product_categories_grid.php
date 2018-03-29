<?php
$atts = shortcode_atts( array(
	'number'     	=> null,
	'style'		 	=>'1',
	'gutter'		=>'1',
	'orderby'    	=> 'order',
	'order'      	=> 'ASC',
	'hide_empty' 	=> 0,
	'parent'     	=> '',
	'ids'        	=> ''
), $atts );
	
if ( isset( $atts['ids'] ) ) {
	$ids = explode( ',', $atts['ids'] );
	$ids = array_map( 'trim', $ids );
} else {
	$ids = array();
}
$hide_empty = ( $atts['hide_empty'] == true || $atts['hide_empty'] == 1 ) ? 1 : 0;

// get terms and workaround WP bug with parents/pad counts
$args = array(
	'orderby'    => $atts['orderby'],
	'order'      => $atts['order'],
	'hide_empty' => $hide_empty,
	'include'    => $ids,
	'pad_counts' => true,
	'child_of'   => $atts['parent']
);

if ( $atts['orderby'] == 'order' ) {
	$args['menu_order'] = 'ASC';
	$args['orderby'] 	= 'name';
} else {
	$args['orderby']    = $atts['orderby'];
}
$product_categories = get_terms( 'product_cat', $args );

if ( '' !== $atts['parent'] ) {
	$product_categories = wp_list_filter( $product_categories, array( 'parent' => $atts['parent'] ) );
}

if ( $hide_empty ) {
	foreach ( $product_categories as $key => $category ) {
		if ( $category->count == 0 ) {
			unset( $product_categories[ $key ] );
		}
	}
}

if ( $atts['number'] ) {
	$product_categories = array_slice( $product_categories, 0, $atts['number'] );
}
ob_start();
if ( $product_categories ) {
	?>
<div class="product-categories-grid grid-style-<?php echo esc_attr($atts['style']) ?><?php echo ($atts['gutter'] == '1' ? ' grid-gutter':'') ?>">
	<div class="product-categories-grid-wrap row">
		<?php 
		$w=0;
		foreach ($product_categories as $category):
		?>
			<?php 
			// Wall layout
			$w++;
			$wall_open_row=false;
			?>
			<?php if ($atts['style'] == '1' && ($w == '4' || $w == '10')): $wall_open_row = true;?>
			<div class="product-category-wall wall-row">
			<?php endif;?>
			
			<?php if ($atts['style'] == '3' && ($w == '1' || $w == '3')) echo '<div class="col-sm-6"><div class="row">';?>
			
			<div class="wall-col <?php 
			if($atts['style'] == '1'){
				if($w == '1' || $w == '7'): 
					echo 'col-md-6 col-sm-12 title-in'; 
				elseif ($w=='2' || $w=='3' || $w=='8' || $w=='9'):
					echo 'col-md-6 col-sm-12 title-out';
				elseif ($w=='4' || $w=='5' || $w=='6' || $w == '10' || $w == '11' || $w == '12'): 
					echo 'col-sm-4 title-out height-auto'; 
				endif;
				if($w == '4' || $w == '6' || $w == '10' || $w == '12'){
					echo ' wall-bg';
				}
				if($w == '7'){
					echo ' pull-right';
				}
				if ($w !='4' || $w != '10'){
					echo ' product-category-wall';
				}
			}elseif ($atts['style'] == '2'){
				if($w == '1' || $w == '4'):
					echo 'col-md-6 col-sm-12 title-in';
				elseif ($w=='2' || $w=='3' || $w=='5' || $w=='6'):
					echo 'col-md-6 col-sm-12 title-out';
				endif;
				if ($w =='4' || $w =='5' || $w =='6'){
					echo ' pull-right';
				}
				if ($w =='3' || $w =='6'){
					echo ' last-right';
				}
				if($w == '4'){
					echo ' out-right';
				}
			}elseif ($atts['style'] == '3'){
				if($w == '1' || $w == '4'):
					echo 'col-sm-12 title-in';
				elseif ($w=='2' || $w=='3'):
					echo 'col-sm-12 title-out';
				endif;
			}elseif ($atts['style'] == '4'){
				echo 'col-sm-6 title-in';
			}
			?>">
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<div class="product-category-grid-item">
					<div class="product-category-grid-item-wrap">
						<?php 
						$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );
						if ( $thumbnail_id ) {
							$image = wp_get_attachment_url( $thumbnail_id  );
						} else {
							$image = wc_placeholder_img_src();
						}
						?>
						<div class="product-category-grid-featured-wrap">
							<div class="product-category-grid-featured" <?php if(!empty($image)):?> style="background-image: url(<?php echo esc_url($image)?>)"<?php endif;?>></div>
						</div>
						<div class="product-category-grid-featured-summary">
							<div class="product-category-grid-featured-summary-wrap">
								<h3>
									<?php if($atts['style'] == '2'){?>
										<?php
											echo $category->name;
										?>
										<?php if($short_desc = get_woocommerce_term_meta( $category->term_id, 'product_cat_short_description', true )):?>
										<small><?php echo esc_html($short_desc)?></small>
										<?php endif;?>
									<?php }else{?>
										<?php if($short_desc = get_woocommerce_term_meta( $category->term_id, 'product_cat_short_description', true )):?>
										<small><?php echo esc_html($short_desc)?></small>
										<?php endif;?>
										<?php
											echo $category->name;
										?>
									<?php }?>
									
								</h3>
								<?php if ($atts['style'] == '2' && ($w == '1' || $w == '4')){?>
								<span class="btn btn-outline product-category-grid-btn"><?php esc_html_e('Shop Now','forward')?></span>
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</a>
			</div>
		<?php if ($atts['style'] == '1'){?>
			<?php if ($w == '6' || $w == '12'): ?>
			</div>
			<?php elseif ($w > 3 && $w < 6 && $w == count($product_categories)):?>
				<?php echo '</div>'?>
			<?php elseif ($w >= 10 && $w < 12 && $w == count($product_categories)):?>
				<?php echo '</div>'?>
			<?php
			endif;
		}
		?>
		<?php if ($atts['style'] == '3' && ($w == '2' || $w == '4' || $w ==  count($product_categories) )) echo '</div></div>';?>
		<?php 
		if ($atts['style'] == '1'){
			if($w == '12') $w = 0;
		}elseif ($atts['style'] == '2'){
			if($w == '6') $w = 0;
		}elseif ($atts['style'] == '2'){
			if($w == '4') $w = 0;
		}
		?>
		<?php 
		endforeach;
		?>
	</div>
</div>
<?php
}
echo ob_get_clean();