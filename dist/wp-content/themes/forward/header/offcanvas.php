<?php 
$login_url = wp_login_url();
$logout_url = wp_logout_url();
$register_url = wp_registration_url();
if(defined('WOOCOMMERCE_VERSION')){
	$login_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
	$logout_url = wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );
}
?>
<div class="offcanvas-overlay"></div>
<div <?php dh_offcanvas_class('offcanvas open') ?>>
	<div class="offcanvas-wrap">
		<?php if(dh_is_header_offcanvas_always_show()){?>
			<?php 
			dh_get_template('header/offcanvas-header-icon.php',array(
				'logo_url'						=>$logo_url,
				'logo_fixed_url'				=>$logo_fixed_url,
				'logo_mobile_url'				=>$logo_mobile_url,
			));
			?>
		<?php }?>
		<div class="offcanvas-user clearfix">
			<?php if(apply_filters('dh_use_user_link_in_mobile',true)):?>
				<?php if(defined('YITH_WCWL') && apply_filters('dh_show_wishlist_in_header', true)):?>
	            <a class="offcanvas-user-wishlist-link"  href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url());?>"><i class="fa fa-heart-o"></i> <?php esc_html_e('My Wishlist','forward')?></a>	            
	            <?php if(dh_get_theme_option('usericon',1)){?>
	            <a class="offcanvas-user-account-link" href="<?php echo esc_url($login_url) ?>"><i class="fa fa-user"></i> <?php if(!is_user_logged_in()): ?><?php esc_html_e('Login','forward')?><?php else:?><?php esc_html_e('Account','forward')?><?php endif;?></a>
				<?php }?>
				<?php endif;?>
			<?php endif;?>
		</div>
		<?php if($header_style == 'sidebar'):?>
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
		<?php endif;?>
		<nav class="offcanvas-navbar mobile-offcanvas-navbar" itemtype="<?php echo dh_get_protocol() ?>://schema.org/SiteNavigationElement" itemscope="itemscope" role="navigation">
			<?php
			if(has_nav_menu('mobile')):
				wp_nav_menu( array(
					'theme_location'    => 'mobile',
					'container'         => false,
					'depth'				=> 3,
					'menu_class'        => 'offcanvas-nav nav',
					'walker' 			=> new DH_Walker
				) );
			else:
				echo '<ul class="nav navbar-nav primary-nav"><li><a href="' . home_url( '/' ) . 'wp-admin/nav-menus.php">' . esc_html__( 'No menu assigned!', 'forward' ) . '</a></li></ul>';
			endif;
			?>
		</nav>
		<?php if($header_style == 'sidebar'):?>
		<?php if($header_style != 'overlay'){?>
		<div class="navbar-toggle-fixed">
			<button type="button" class="navbar-toggle x">
				<span class="sr-only"><?php echo esc_html__('Toggle navigation','forward')?></span>
				<span class="icon-bar bar-top"></span> 
				<span class="icon-bar bar-middle"></span> 
				<span class="icon-bar bar-bottom"></span>
			</button>
		</div>
		<?php }?>
		<div class="offcanvas-sidebar-wrap">
			<nav class="offcanvas-navbar offcanvas-sidebar-navbar" itemtype="<?php echo dh_get_protocol() ?>://schema.org/SiteNavigationElement" itemscope="itemscope" role="navigation">
				<?php
				$page_menu = '' ;
				$sidebar_theme_location = 'primary';
				if(is_page() && ($selected_page_menu = dh_get_post_meta('main_menu'))){
					$page_menu = $selected_page_menu;
				}
				if(has_nav_menu('primary') || !empty($page_menu)):
					wp_nav_menu( array(
						'theme_location'    => $sidebar_theme_location,
						'container'         => false,
						'depth'				=> 3,
						'menu'				=> $page_menu,
						'menu_class'        => 'offcanvas-nav',
						'walker' 			=> new DH_Mega_Walker
					) );
				else:
					echo '<ul class="nav navbar-nav primary-nav"><li><a href="' . home_url( '/' ) . 'wp-admin/nav-menus.php">' . esc_html__( 'No menu assigned!', 'forward' ) . '</a></li></ul>';
				endif;
				?>
			</nav>
		</div>
		<?php endif;?>
		
		<?php if(is_active_sidebar('sidebar-offcanvas')):?>
		<div class="offcanvas-widget hide-iphone">
			<?php dynamic_sidebar('sidebar-offcanvas')?>
		</div>
		<?php endif;?>
		<?php if($header_style == 'sidebar'):?>
			<div class="offcanvas-info">
				<?php $footer_bottom_social = dh_get_theme_option('footer-bottom-social',array())?>
				<?php if(!empty($footer_bottom_social)){?>
				<div class="offcanvas-social">
					<?php dh_social($footer_bottom_social,true,false,false); ?>
				</div>
				<?php }?>
				<?php if($footer_info = dh_get_theme_option('footer-info')):?>
					<div class="offcanvas-copyright"><?php echo ($footer_info) ?></div>
		    	<?php endif;?>
			</div>
			<?php do_action('dh_offcanvas')?>
		<?php endif;?>
	</div>
</div>