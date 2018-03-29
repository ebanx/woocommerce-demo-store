<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package shopstar
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : ''; ?>">
		<main id="main" class="site-main" role="main">
		
	    <?php if ( function_exists( 'bcn_display' ) ) : ?>
	        <div class="breadcrumbs">
	            <?php bcn_display(); ?>
	        </div>
	    <?php endif; ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'library/template-parts/content', 'single' ); ?>
			
			<?php shopstar_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		<?php
		// Prevent weirdness
		wp_reset_postdata();
		?>
		
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
