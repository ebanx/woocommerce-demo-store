<?php 
$login_url = wp_login_url();
$logout_url = wp_logout_url();
$register_url = wp_registration_url();
if(defined('WOOCOMMERCE_VERSION')){
	$login_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
	$logout_url = wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
}
?>
<header id="header" class="header-container page-heading-<?php echo esc_attr($page_heading) ?> header-type-classic header-type-classic-full header-navbar-classic<?php if($menu_transparent):?> header-absolute header-transparent<?php endif?> header-scroll-resize" itemscope="itemscope" itemtype="<?php echo dh_get_protocol()?>://schema.org/Organization" role="banner">
	<?php if(dh_get_theme_option('show-topbar',1)):?>
		<div class="topbar">
			<div class="<?php dh_container_class() ?> topbar-wap">
				<div class="row">
					<div class="col-sm-6 col-left-topbar">
						<div class="left-topbar">
	            			<?php
	            			
	            				$left_topbar_content = dh_get_theme_option('left-topbar-content','info');
		            			if($left_topbar_content === 'info'): 
		            				echo '<div class="topbar-info">';
		            				if($topbar_phone = dh_get_theme_option('left-topbar-phone','(123) 456 789'))
		            					echo '<a href="#"><i class="fa fa-phone"></i> '.esc_html($topbar_phone).'</a>';
		            				if($topbar_email = dh_get_theme_option('left-topbar-email','info@example.com'))
		            					echo '<a href="mailto:'.esc_attr($topbar_email).'"><i class="fa fa-envelope-o"></i> '.esc_html($topbar_email).'</a>';
		            				if($topbar_skype = dh_get_theme_option('left-topbar-skype','skype.name'))
		            					echo '<a href="skype:'.esc_attr($topbar_skype).'?call"><i class="fa fa-skype"></i> '.esc_html($topbar_skype).'</a>';
		            				echo '</div>';
		            			elseif ($left_topbar_content === 'custom'):
		            				echo (dh_get_theme_option('left-topbar-custom-content',''));
		            			endif;
		            			?>
		            			<?php 
		            			if(($left_topbar_content == 'menu_social')):
		            			echo '<div class="topbar-social">';
		            			dh_social(dh_get_theme_option('left-topbar-social',array('facebook','twitter','google-plus','pinterest','rss','instagram')),true);
		            			echo '</div>';
		            			endif;
	            			
	            			?>
	            			
						</div>
					</div>
					<div class="col-sm-6 col-right-topbar">
						<div class="right-topbar">
		            		<?php if ( has_nav_menu( 'top' ) ) : ?>
	            				<div class="topbar-nav">
	            					<?php 
	            					wp_nav_menu( array(
	            						'theme_location'    => 'top',
	            						'depth'             => 2,
	            						'container'         => false,
	            						'menu_class'        => 'top-nav',
	            						'walker'            => new DH_Walker
	            					));
	            					?>
	            				</div>
	            			<?php endif; ?>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif;?>
	<div class="navbar-container">
		<div class="navbar navbar-default <?php if(dh_get_theme_option('sticky-menu',1)):?> navbar-scroll-fixed<?php endif;?>">
			<div class="navbar-default-container">
				<div class="navbar-default-wrap">
						<div class="row">
							<div class="navbar-default-col">
								<div class="navbar-wrap">
									<div class="navbar-header">
										<button type="button" class="navbar-toggle">
											<span class="sr-only"><?php echo esc_html__('Toggle navigation','forward')?></span>
											<span class="icon-bar bar-top"></span> 
											<span class="icon-bar bar-middle"></span> 
											<span class="icon-bar bar-bottom"></span>
										</button>
										<?php if(dh_get_theme_option('ajaxsearch',1)){ ?>
										<a class="navbar-search-button search-icon-mobile" href="#">
											<?php echo dh_serch_button_icon();?>
										</a>
										<?php } ?>
										<?php if(defined('WOOCOMMERCE_VERSION') && dh_get_theme_option('woo-cart-mobile',1)):?>
								     	<?php 
								     	global $woocommerce;
								     	if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
								     		$cart_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_cart_url() );
								     	}else{
								     		$cart_url = esc_url( $woocommerce->cart->get_cart_url() );
								     	}
								     	?>
										<a class="cart-icon-mobile" href="<?php echo esc_url($cart_url) ?>"><?php echo DH_Woocommerce::instance()->_get_minicart_icon2()?><span><?php echo absint($woocommerce->cart->cart_contents_count)?></span></a>
										<?php endif;?>
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
									
									<div class="header-right">
										<?php 
												if(dh_get_theme_option('ajaxsearch',1)){
											?>
												<div class="navbar-search">
													<a class="navbar-search-button" href="#">
														<?php echo dh_serch_button_icon();?>
													</a>
													<div class="search-form-wrap show-popup hide">
													<?php dh_get_search_form(); ?>
													</div>
												</div>
											<?php
											}
											?>
					            			<?php 
												if(class_exists('DH_Woocommerce') && defined( 'WOOCOMMERCE_VERSION' ) && dh_get_theme_option( 'woo-cart-nav', 1 )){
													echo '<div class="navbar-minicart navbar-minicart-topbar">'.DH_Woocommerce::instance()->get_minicart().'</div>';
												}
											?>
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
									<nav class="collapse navbar-collapse primary-navbar-collapse" itemtype="<?php echo dh_get_protocol() ?>://schema.org/SiteNavigationElement" itemscope="itemscope" role="navigation">
										<?php
										$page_menu = '' ;
										if(is_page() && ($selected_page_menu = dh_get_post_meta('main_menu'))){
											$page_menu = $selected_page_menu;
										}
										if(has_nav_menu('primary') || !empty($page_menu)):
											wp_nav_menu( array(
												'theme_location'    => 'primary',
												'container'         => false,
												'depth'				=> 3,
												'menu'				=> $page_menu,
												'menu_class'        => 'nav navbar-nav primary-nav',
												'walker' 			=> new DH_Mega_Walker
											) );
										else:
											echo '<ul class="nav navbar-nav primary-nav"><li><a href="' . home_url( '/' ) . 'wp-admin/nav-menus.php">' . esc_html__( 'No menu assigned!', 'forward' ) . '</a></li></ul>';
										endif;
										?>
									</nav>
								</div>
							</div>
						</div>
					
				</div>
			</div>
			
		</div>
	</div>
</header>

<div class="header-search-overlay hide">
	<div class="<?php echo dh_container_class()?>">
		<div class="header-search-overlay-wrap">
			<?php echo dh_get_search_form()?>
			<button type="button" class="close">
				<span aria-hidden="true" class="fa fa-times"></span><span class="sr-only"><?php echo esc_html__('Close','forward') ?></span>
			</button>
		</div>
	</div>
</div>