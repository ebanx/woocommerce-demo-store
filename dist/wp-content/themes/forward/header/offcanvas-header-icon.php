<?php 
$login_url = wp_login_url();
$logout_url = wp_logout_url();
$register_url = wp_registration_url();
if(defined('WOOCOMMERCE_VERSION')){
	$login_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
	$logout_url = wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
}
?>
<div class="header-offcanvas-topbar">
	<div class="header-offcanvas-topbar-icons clearfix">
		<?php if(class_exists('DH_Woocommerce') && defined( 'WOOCOMMERCE_VERSION' ) && dh_get_theme_option( 'woo-cart-nav', 1 )){?>
		<div class="navcart">
			<div class="navcart-wrap navbar-minicart-topbar">
				<?php 
					echo '<div class="navbar-minicart navbar-minicart-topbar">'.DH_Woocommerce::instance()->get_minicart_icon_only().'</div>';
				?>
			</div>
		</div>
		<?php }?>
		<?php if(dh_get_theme_option('usericon',1)){?>
		<div class="navbar-user">
			<a title="<?php echo esc_attr__('My Account','forward'); ?>" rel="loginModal" href="<?php echo esc_url($login_url); ?>" class="navbar-user" href="#">
				<?php echo dh_user_icon()?>
				<span><?php echo esc_attr__('My Account','forward'); ?></span>
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
</div>