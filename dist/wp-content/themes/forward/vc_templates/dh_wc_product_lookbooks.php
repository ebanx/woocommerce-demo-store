<?php
extract( shortcode_atts( array(
	'ids'=>'',
	'style'=> 'slider',
	'thumbnail_position'=>'',
), $atts ) );
ob_start();
$select_lookbooks = array_filter(explode(',', $ids));
$flag = false;
if(!empty($select_lookbooks)){
	$lookbooks = $select_lookbooks;
	$flag = true;
}else{
	$lookbooks = get_terms('product_lookbook',array('hide_empty'=>0,'orderby'=>'name','menu_order'=>'DESC'));
}
if($style == 'slider')
	wp_enqueue_script('carouFredSel');
?>
<?php if(!empty($lookbooks)):?>
	<div class="lookbooks lookbooks-<?php echo esc_attr($style) ?>">
		<?php 
		$i = 0;
		?>
		<?php foreach ((array)$lookbooks as $lb): $i++;?>
			<?php
			if($flag)
				$lookbook = get_term_by('id', $lb,'product_lookbook');
			else
				$lookbook = $lb;
			if(!$lookbook || is_wp_error($lookbook))
				continue;
			$thumbnail_id  			= get_woocommerce_term_meta( $lookbook->term_id, 'thumbnail_id', true  );
			$thumbnail_align 		= (count($select_lookbooks) == 1 ? $thumbnail_position : ($i % 2 == 0 ? 'right':'left'));
			$small_title 			= get_woocommerce_term_meta( $lookbook->term_id, 'small_title', true  );
			$image 					= wp_get_attachment_url( $thumbnail_id  );
			if(empty($image))
				$image = wc_placeholder_img_src();
			?>
			<div id="lookbook_<?php echo esc_attr($lookbook->term_id) ?>" data-id="<?php echo esc_attr($lookbook->term_id) ?>" class="lookbook lookbook-<?php echo esc_attr($thumbnail_align) ?> clearfix">
			<?php if($image):?>
				<div class="loobook-wrap clearfix">
					<div class="lookbook-info">
						<div class="lookbook-info-wrap" style="background: url(<?php echo esc_attr($image)?>) no-repeat scroll center center">
							<div class="lookbook-info-wrap-border"></div>
							<div class="lookbook-info-sumary">
								<?php if(!empty($small_title)):?>
								<span class="lookbook-small-title"><?php echo esc_html($small_title )?></span>
								<?php endif;?>
								<h3>
									<a href="<?php echo get_term_link($lookbook,'product_lookbook') ?>">
										<?php echo esc_html($lookbook->name)?>
									</a>
								</h3>
								<?php if($description = $lookbook->description):?>
								<div class="lookbook-description"><?php echo ($description)?></div>
								<?php endif;?>
								<a class="btn btn-primary lookbook-action" href="<?php echo get_term_link($lookbook,'product_lookbook') ?>"><span><?php esc_html_e('Shop Now','forward')?></span></a>
							</div>
						</div>	
					</div>
					<div class="lookbook-thumb">
						<?php 
						$columns = 2;
						$posts_per_page = 4;
						if($style == 'slider'){
							$posts_per_page = 12;
							$columns = 3;
						}
						$query_args = array(
							'posts_per_page' => $posts_per_page,
							'post_status'    => 'publish',
							'post_type'      => 'product',
							'no_found_rows'  => 1,
							'order'          => "DESC",
							'orderby'		 =>'date',
							'meta_query'     => WC()->query->get_meta_query(),
							'tax_query' 			=> array(
								array(
									'taxonomy' 		=> 'product_lookbook',
									'terms' 		=> array($lookbook->slug),
									'field' 		=> 'slug',
								)
							)
						);
						global $woocommerce_loop;
						
						$products                    = new WP_Query( $query_args );
						$woocommerce_loop['columns'] = $columns;
						
						ob_start();
						
						if ( $products->have_posts() ) : ?>
				
							<?php woocommerce_product_loop_start(); ?>
				
								<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				
									<?php wc_get_template_part( 'content', 'product' ); ?>
				
								<?php endwhile; // end of the loop. ?>
				
							<?php woocommerce_product_loop_end(); ?>
				
				
						<?php endif;
				
						wp_reset_postdata();
						$output = '';
						if($style == 'slider'){
						$output .='<div class="caroufredsel product-slider"  data-height="variable" data-scroll-fx="scroll" data-scroll-item="1" data-visible-min="1" data-visible-max="3"  data-responsive="1" data-infinite="1" data-autoplay="0" data-circular="1">';
						$output .='<div class="caroufredsel-wrap">';
						$output .= '<div class="woocommerce woocommerce-lookbok columns-' . $columns . '">' . ob_get_clean() . '</div>';
						$output .='<a href="#" class="caroufredsel-prev"></a>';
						$output .='<a href="#" class="caroufredsel-next"></a>';
						$output .='</div>';
						$output .='</div>';
						}elseif ($style=='grid'){
							$output .= '<div class="woocommerce woocommerce-lookbok columns-' . $columns . '">' . ob_get_clean() . '</div>';
						}
						print $output;
						?>
					</div>
				</div>
			<?php endif;?>
			</div>
		<?php endforeach;?>
	</div>
	<?php endif;?>
<?php
echo ob_get_clean();