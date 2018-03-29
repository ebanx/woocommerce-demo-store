<?php
/**
 * Template part for displaying posts.
 *
 * @package shopstar
 */

$classes = 'blog-post-side-layout ';
if ( !has_post_thumbnail() ) {
	$classes = 'post-no-img ';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
    
    <?php
    $thumbnail_id = get_post_thumbnail_id($post->ID);
    $args = array(
		'p' => $thumbnail_id,
		'post_type' => 'attachment'
    );
    
    $thumbnail = get_posts( $args );
 	$thumbnail_image = wp_get_attachment_image_src( $thumbnail_id, 'shopstar_blog_img_side' );
	?>
    <div class="post-loop-images">
        
        <div class="post-loop-images-carousel-wrapper post-loop-images-carousel-wrapper-remove">
            <div class="post-loop-images-carousel post-loop-images-carousel-remove">	
				<div>
					<img src="<?php echo $thumbnail_image[0]; ?>" alt="<?php echo $thumbnail[0]->post_title; ?>" />
				</div>
            </div>
            
        </div>
        
    </div>				
    
    <div class="post-loop-content">
    
    	<header class="entry-header">
    		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

    		<?php if ( 'post' == get_post_type() ) : ?>
    		<div class="entry-meta">
    			<?php shopstar_posted_on(); ?>
    		</div><!-- .entry-meta -->
    		<?php endif; ?>
    	</header><!-- .entry-header -->

    	<div class="entry-content">
    		<?php
				if ( get_theme_mod( 'shopstar-blog-archive-layout', customizer_library_get_default( 'shopstar-blog-archive-layout' ) ) == 'shopstar-blog-archive-layout-full' ) :
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'shopstar' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
				else :
	    			/* translators: %s: Name of current post */
	                the_excerpt();
				endif;
    		?>
    		
    		<?php
    			wp_link_pages( array(
    				'before' => '<div class="page-links">' . __( 'Pages:', 'shopstar' ),
    				'after'  => '</div>',
    			) );
    		?>
    	</div><!-- .entry-content -->

    	<footer class="entry-footer">
    		<?php shopstar_entry_footer(); ?>
    	</footer><!-- .entry-footer -->
    
    </div>
    
    <div class="clearboth"></div>
</article><!-- #post-## -->
