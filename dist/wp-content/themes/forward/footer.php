<?php 
	$footer_area_bg = dh_get_theme_option('footer-area-columns-bg',0);
?>
</div>
<?php if(!dh_get_post_meta('hide_footer',0)):?>
	<footer id="footer" class="footer <?php echo dh_get_theme_option('footer-style','style-1')?>" role="contentinfo">
		<?php if(dh_get_theme_option('footer-instagram',0)){?>
		<div class="footer-instagram">
			<?php if($footer_instagram_title = dh_get_theme_option('footer-instagram-title','Instagram')){?>
			<h3 class="heading-center-custom"><span><?php echo esc_html( $footer_instagram_title ); ?></span></h3>
			<?php }?>
			<?php echo do_shortcode('[dh_instagram style="grid" images_number="6" grid_column="6" username="'.dh_get_theme_option('footer-instagram-user','Sitesao_fashion').'"]')?>
		</div>
		<?php } ?>
		<?php if(dh_get_theme_option('footer-top',1)):?>
		<div class="footer-top">
			<div class="<?php dh_container_class() ?>">
				<div class="row">
					<div class="col-lg-6 footer-social">
						<?php $footer_social = dh_get_theme_option('footer-top-social',array())?>
						<?php if(!empty($footer_social)){?>
							<h4><?php echo esc_html__( 'Stay connected:', 'forward' )?></h4>
							<?php dh_social($footer_social,true,false,false); ?>
						<?php }?>
					</div>
					<div class="col-lg-6 footer-newsletter">
						<h4><?php echo esc_html__( 'Get the latest news!', 'forward' )?></h4>
						<?php dh_mailchimp_form();?>
					</div>
				</div>
			</div>
		</div>
	 	<?php endif;?>
		<?php if(dh_get_theme_option('footer-area',1)):?>
			<div class="footer-widget" <?php if(!empty($footer_area_bg)) echo 'style="background-image:url('.esc_attr($footer_area_bg).')"'; ?>>
				<div class="<?php dh_container_class() ?>">
					<div class="footer-widget-wrap">
						<div class="row">
							<?php 
							$area_columns = dh_get_theme_option('footer-area-columns',4);
							if($area_columns == '5'):
								?>
								<?php if(is_active_sidebar('sidebar-footer-1')):?>
								<div class="footer-widget-col col-md-2 col-sm-6">
									<?php dynamic_sidebar('sidebar-footer-1')?>
								</div>
								<?php endif;?>
								<?php if(is_active_sidebar('sidebar-footer-2')):?>
								<div class="footer-widget-col col-md-2 col-sm-6">
									<?php dynamic_sidebar('sidebar-footer-2')?>
								</div>
								<?php endif;?>
								<?php if(is_active_sidebar('sidebar-footer-3')):?>
								<div class="footer-widget-col col-md-2 col-sm-6">
									<?php dynamic_sidebar('sidebar-footer-3')?>
								</div>
								<?php endif;?>
								<?php if(is_active_sidebar('sidebar-footer-4')):?>
								<div class="footer-widget-col col-md-2 col-sm-6">
									<?php dynamic_sidebar('sidebar-footer-4')?>
								</div>
								<?php endif;?>
								<?php if(is_active_sidebar('sidebar-footer-5')):?>
								<div class="footer-widget-col col-md-4 col-sm-6">
									<?php dynamic_sidebar('sidebar-footer-5')?>
								</div>
								<?php endif;?>
								<?php
							else:
							$area_class = '';
								if($area_columns == '2'){
									$area_class = 'col-md-6 col-sm-6';
								}elseif ($area_columns == '3'){
									$area_class = 'col-md-4 col-sm-6';
								}elseif ($area_columns == '4'){
									$area_class = 'col-md-3 col-sm-6';
								}
								?>
								<?php for ( $i = 1; $i <= $area_columns ; $i ++ ) :?>
									<?php if(is_active_sidebar('sidebar-footer-'.$i)):?>
									<div class="footer-widget-col <?php echo esc_attr($area_class) ?>">
										<?php dynamic_sidebar('sidebar-footer-'.$i)?>
									</div>
									<?php endif;?>
								<?php endfor;?>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		<?php endif;?>
		<?php if(dh_get_theme_option('footer-bottom',1)):?>
			<div class="footer-bottom">
				<div class="<?php dh_container_class() ?>">
					<div class="row">
						<div class="col-sm-6">
							<div class="footer-menu">
								<?php 
								if(has_nav_menu('footer')):
									wp_nav_menu( array(
											'theme_location'    => 'footer',
											'container'         => false,
											'depth'				=> 1,
											'menu_class'        => 'footer-nav',
											'items_wrap'	 	=> '<ul id="%1$s" class="%2$s">%3$s</ul>',
											'walker' 			=> new DH_Walker
									) );
								endif;
								?>
							</div>
						</div>
						<?php $footer_bottom_social = dh_get_theme_option('footer-bottom-social',array())?>
						<?php if(!empty($footer_bottom_social)){?>
							<div class="col-sm-6">
								<div class="footer-bottom-social">
								<?php 
									dh_social($footer_bottom_social,true,false,false);
								?>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		<?php endif;?>
		<?php if(dh_get_theme_option('footer-info-switch',1)):?>
			<div class="footer-info clearfix">
				<div class="<?php dh_container_class() ?>">
					<div class="row">
						<div class="col-sm-12">
							<?php if($footer_info = dh_get_theme_option('footer-info')):?>
								<div class="footer-copyright"><?php echo ($footer_info) ?></div>
					    	<?php endif;?>
						</div>
					</div>
		    	</div>
	    	</div>
	    <?php endif;?>
	</footer>
<?php endif;?>
</div>
<?php if(dh_get_theme_option('header-style','classic') == 'sidebar' && dh_get_theme_option('newsletter-footer',1)):?>
<div class="footer-newsletter offcanvas-footer-newsletter<?php if(isset($_COOKIE['offcanvas_newsletter'])) { echo ' off'; }?>">
	<div class="footer-newsletter-wrap">
		<div class="inner">
			<h3><?php echo esc_html__( 'Get the latest news!', 'forward' )?></h3>
			<?php dh_mailchimp_form();?>
		</div>
	</div>
	<button type="button" class="close">
		<span aria-hidden="true" class="elegant_icon_close"></span><span class="sr-only"><?php echo esc_html__('Close','forward') ?></span>
	</button>
</div>
<?php endif;?>
<?php wp_footer(); ?>
<?php echo dh_get_theme_option('space-body',''); ?>
</body>
</html>
