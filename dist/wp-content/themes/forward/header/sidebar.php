<?php 
$login_url = wp_login_url();
$logout_url = wp_logout_url();
$register_url = wp_registration_url();
if(defined('WOOCOMMERCE_VERSION')){
	$login_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
	$logout_url = wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
}
?>
<header id="header" class="header-container header-type-toggle-offcanvas header-navbar-toggle-offcanvas <?php if($menu_transparent):?> header-absolute header-transparent<?php endif?>" itemscope="itemscope" itemtype="<?php echo dh_get_protocol()?>://schema.org/Organization" role="banner">
	<div class="navbar-container">
		<div class="navbar navbar-default <?php if(dh_get_theme_option('sticky-menu',1)):?> navbar-scroll-fixed<?php endif;?>">
			<div class="navbar-default-container">
				<div class="navbar-default-wrap">
					<div class="container">
						<div class="row">
							<div class="col-md-12 navbar-default-col">
								<div class="navbar-toggle-right">
									<?php if(dh_get_theme_option('woo-cart-nav',1)){?>
									<div class="navcart">
										<div class="navcart-wrap navbar-minicart-topbar">
											<?php 
											if(class_exists('DH_Woocommerce') && defined( 'WOOCOMMERCE_VERSION' )){
												echo '<div class="navbar-minicart navbar-minicart-topbar">'.DH_Woocommerce::instance()->get_minicart().'</div>';
											}
											?>
										</div>
									</div>
									<?php }?>
									<?php if(dh_get_theme_option('ajaxsearch',1)){?>
									<div class="navbar-toggle-search">
										<div class="navbar-search">
											<a class="navbar-search-button" href="#">
												<?php echo dh_serch_button_icon()?>
											</a>
										</div>
									</div>
									<?php }?>
									<?php if(dh_get_theme_option('usericon',1)){?>
									<div class="navbar-user">
										<a title="<?php echo esc_attr__('My Account','forward'); ?>" rel="loginModal" href="<?php echo esc_url($login_url); ?>" class="navbar-user" href="#">
											<?php echo dh_user_icon()?>
										</a>
										<ul  class="dropdown-menu">
											<?php if(defined('YITH_WCWL') && apply_filters('dh_show_wishlist_in_header', true)):?>
					            			<li>
					            				<a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url());?>"><i class="fa fa-heart-o"></i> <?php esc_html_e('My Wishlist','forward')?></a>
					            			</li>
					            			<?php endif;?>
											<?php
											if(is_user_logged_in()):
											?>
											<li>
												<a href="<?php echo esc_url($logout_url) ?>"><i class="fa fa-sign-out"></i> <?php esc_html_e('Logout', 'forward'); ?></a>
											</li>
											<?php
											endif;
											?>
										</ul>
									</div>
									<?php }?>
								</div>
								<div class="navbar-header">
									<a class="navbar-brand" itemprop="url" title="<?php esc_attr(bloginfo( 'name' )); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>">
										<?php if(!empty($logo_url)):?>
											<img class="logo" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url($logo_url)?>">
										<?php else:?>
											<?php echo bloginfo( 'name' ) ?>
										<?php endif;?>
										<img class="logo-fixed" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url($logo_fixed_url)?>">
										<img class="logo-mobile" alt="<?php bloginfo( 'name' ); ?>" src="<?php echo esc_url($logo_mobile_url)?>">
										<meta itemprop="name" content="<?php bloginfo('name')?>">
									</a>
								</div>
								<div class="navbar-toggle-fixed">
									<button type="button" class="navbar-toggle">
										<span class="sr-only"><?php echo esc_html__('Toggle navigation','forward')?></span>
										<span class="icon-bar bar-top"></span> 
										<span class="icon-bar bar-middle"></span> 
										<span class="icon-bar bar-bottom"></span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-search-overlay hide">
				<div class="<?php echo dh_container_class()?>">
					<div class="header-search-overlay-wrap">
						<?php echo dh_get_search_form()?>
						<button type="button" class="close">
								<span aria-hidden="true">&times;</span><span class="sr-only"><?php echo esc_html__('Close','forward') ?></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>