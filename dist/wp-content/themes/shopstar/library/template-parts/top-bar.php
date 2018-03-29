<?php global $woocommerce; ?>

    <div class="top-bar">
		<div class="container">
        
			<div class="padder">
            
				<div class="left">
            
					<?php get_template_part( 'library/template-parts/social-links' ); ?>
                
				</div>
            
            	<div class="right">
				
	                <?php
	                if ( shopstar_is_woocommerce_activated() && get_theme_mod( 'shopstar-header-shop-links', customizer_library_get_default( 'shopstar-header-shop-links' ) ) ) {
					?>
	                
	                	<div class="account-link">
			            <?php if ( is_user_logged_in() ) { ?>
			            	<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','shopstar'); ?>"><?php _e('My Account','shopstar'); ?></a>
			            <?php } else { ?>
			            	<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login','shopstar'); ?>"><?php _e('Sign In / Register','shopstar'); ?></a>
			            <?php } ?>
			            </div>
			            
	                    <div class="header-cart">
	                        <a class="header-cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'shopstar'); ?>">
	                            <span class="header-cart-amount">
	                                <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'shopstar'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?>
	                            </span>
	                            <span class="header-cart-checkout<?php echo ( $woocommerce->cart->cart_contents_count > 0 ) ? ' cart-has-items' : ''; ?>">
	                                <span><?php _e('Checkout', 'shopstar'); ?></span> <i class="fa fa-shopping-cart"></i>
	                            </span>
	                        </a>
	                    </div>
	                    
	                <?php
	                } else {
	                ?>
	                	<div class="info-text"><?php echo wp_kses_post( get_theme_mod( 'shopstar-header-info-text', customizer_library_get_default( 'shopstar-header-info-text' ) ) ) ?></div>
	                <?php 
	                }
	                ?>
				</div>
            
				<div class="clearboth"></div>
            
			</div>
            
		</div>
	</div>
