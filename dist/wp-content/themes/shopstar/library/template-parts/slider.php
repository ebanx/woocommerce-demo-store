<?php
if ( get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) ) == 'shopstar-slider-plugin' ) :
?>
    <div class="slider-container">
		<?php
		if ( get_theme_mod( 'shopstar-slider-plugin-shortcode', customizer_library_get_default( 'shopstar-slider-plugin-shortcode' ) ) != '' ) {
			echo do_shortcode( get_theme_mod( 'shopstar-slider-plugin-shortcode' ) );
		}
		?>
	</div>
<?php    
else :
    
    $slider_categories = '';

    if ( get_theme_mod( 'shopstar-slider-categories' ) != '' ) {
        $slider_categories = get_theme_mod( 'shopstar-slider-categories' );

        $slider_query = new WP_Query( 'cat=' . implode(',', $slider_categories) . '&posts_per_page=-1&orderby=date&order=DESC&id=slider' );
         
        if ( $slider_query->have_posts() ) :
?>
	
			<div class="slider-container default loading <?php echo ( get_theme_mod( 'shopstar-slider-text-shadow', customizer_library_get_default( 'shopstar-slider-text-shadow' ) ) ) ? 'text-shadow' : ''; ?>">
	            <div class="prev"></div>
	            <div class="next"></div>
			            				
				<ul class="slider">
					                    
					<?php 
					while ( $slider_query->have_posts() ) : $slider_query->the_post(); 
					?>
			                    
					<li class="slide">
						<?php
						if ( has_post_thumbnail() ) :
							the_post_thumbnail( 'full', array( 'class' => '' ) );
						endif;
						?>
			                            
						<div class="overlay">
							<?php
								the_content();
							?>
						</div>
					</li>
			                    
					<?php
					endwhile;
					?>
			                    
				</ul>
				
				<div class="pagination"></div>
				
			</div>
	
<?php
		endif;
		wp_reset_query();
	}
    
endif;
?>