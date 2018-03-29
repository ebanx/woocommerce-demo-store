
<header id="masthead" class="site-header left-aligned <?php echo ( get_theme_mod( 'shopstar-show-header-top-bar', customizer_library_get_default( 'shopstar-show-header-top-bar' ) ) ) ? 'has-top-bar' : ''; ?>" role="banner">

	<?php
	if( get_theme_mod( 'shopstar-show-header-top-bar', customizer_library_get_default( 'shopstar-show-header-top-bar' ) ) ) :
		get_template_part( 'library/template-parts/top-bar' );
	endif;
	
	$logo = '';
	
	if ( function_exists( 'has_custom_logo' ) ) {
		if ( has_custom_logo() ) {
			$logo = get_custom_logo();
		}
	} else if ( get_theme_mod( 'shopstar-logo' ) != '' ) {
		$logo = "<a href=\"". esc_url( home_url( '/' ) ) ."\" title=\"". esc_attr( get_bloginfo( 'name', 'display' ) ) ."\"><img src=\"". esc_url( get_theme_mod( 'shopstar-logo' ) ) ."\" alt=\"". esc_attr( get_bloginfo( 'name' ) ) ."\" /></a>";
	}
	?>

	<div class="container">
	    <div class="padder">
	
		    <div class="branding">
		        <?php
		        if( $logo ) :
					echo $logo;
		        else :
		        ?>
		            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="title"><?php bloginfo( 'name' ); ?></a>
		            <div class="description"><?php bloginfo( 'description' ); ?></div>
				<?php
				endif;
				?>
		    </div><!-- .site-branding -->

		</div>
	</div>
	
	<nav id="site-navigation" class="main-navigation <?php echo ( !is_front_page() || ( get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) ) == 'shopstar-no-slider' && !get_header_image() ) ) ? 'bottom-border mobile' : 'bottom-border'; ?>" role="navigation">
		<span class="menu-toggle">
			<i class="fa fa-bars"></i>
		</span>
		
		<div id="main-menu" class="container shopstar-mobile-menu-primary-color-scheme <?php echo ( !is_front_page() || ( get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) ) == 'shopstar-no-slider' && !get_header_image() ) ) ? 'bottom-border' : ''; ?>">
		    <div class="padder">
		
				<div class="close-button"><i class="fa fa-angle-right"></i><i class="fa fa-angle-left"></i></div>
				<div class="main-navigation-inner">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
				</div>
		        <?php if( get_theme_mod( 'shopstar-header-search', customizer_library_get_default( 'shopstar-header-search' ) ) ) : ?>
		        <span class="search-button">
		        	<a href=""><?php echo __( 'Search', 'shopstar' ); ?> <i class="fa fa-search search-btn"></i></a>
		        </span>
		        <?php endif; ?>
		
				<div class="search-slidedown">
					<div class="container">
						<div class="padder">
							<div class="search-block">
							<?php if( get_theme_mod( 'shopstar-header-search', customizer_library_get_default( 'shopstar-header-search' ) ) ) : ?>
								<?php get_search_form(); ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			
			</div>	        
		</div>
	</nav><!-- #site-navigation -->
	
</header><!-- #masthead -->
