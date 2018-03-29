<?php 
global $wp_query;
$woo_products_pagination = dh_get_theme_option('woo-products-pagination','page_num');
if($woo_products_pagination === 'infinite_scroll'){
	wp_enqueue_script('infinitescroll');
}
$main_class = dh_get_main_class();
if(dh_is_ajax() && isset($_POST['dh_shop_ajax_filter'])){
	if(!dh_get_theme_option('woo-shop-filter',0)){
		if(is_active_sidebar('sidebar-shop'))
			dynamic_sidebar('sidebar-shop');
	}
	if(class_exists('DH_Woocommerce'))
		DH_Woocommerce::content(true);
	die;
}
?>
<?php get_header('shop') ?>
	<div class="content-container">
		<div class="<?php if (is_singular('product') && dh_get_theme_option('single-product-style','style-1') == 'style-3') echo 'container-full'; else dh_container_class() ?>">
			<div class="row">
				<?php do_action('dh_left_sidebar')?>
				<?php do_action('dh_left_sidebar_extra')?>
				<div class="<?php echo esc_attr($main_class) ?>" role="main" itemprop="mainContentOfPage">
					<div class="main-content">
						<?php if(is_shop() || is_product_taxonomy()){?>					
						<div class="woo-content" data-msgtext="<?php esc_attr_e('Loading products','forward')?>" data-finishedmsg="<?php esc_attr_e('All products loaded','forward')?>" data-contentselector=".woo-content .shop-loop > ul.products"  data-paginate="<?php echo esc_attr($woo_products_pagination) ?>"  data-itemselector=".woo-content li.product">
						<?php }?>
						<?php 
						if(class_exists('DH_Woocommerce'))
							DH_Woocommerce::content();
						?>
						<?php if(is_shop() || is_product_taxonomy()){?>	
							<?php if($woo_products_pagination === 'loadmore' && 1 < $wp_query->max_num_pages ):?>
							<div class="loadmore-action">
								<div class="loadmore-loading"><div class="fade-loading"><i></i><i></i><i></i><i></i></div></div>
								<button type="button" class="btn-loadmore"><?php echo esc_html(dh_get_theme_option('woo-products-loadmore-text','Load More')) ?></button>
							</div>
							<?php endif;?>
							</div>
						<?php }?>
					</div>
				</div>
				<?php do_action('dh_right_sidebar_extra')?>
				<?php do_action('dh_right_sidebar')?>
			</div>
		</div>
	</div>
<?php get_footer('shop') ?>