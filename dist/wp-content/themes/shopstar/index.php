<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopstar
 */

get_header(); ?>

	<div id="primary" class="content-area <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : ''; ?>">
		<main id="main" class="site-main" role="main">
		
	    <?php if ( ! is_front_page() ) : ?>
	        
	        <?php if ( function_exists( 'bcn_display' ) ) : ?>
	        <div class="breadcrumbs">
	            <?php bcn_display(); ?>
	        </div>
	        <?php endif; ?>
	    
	    <?php endif; ?>
        
        <?php get_template_part( 'library/template-parts/page-title' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				get_template_part( 'library/template-parts/content' );
				?>

			<?php endwhile; ?>
			
			<?php
			// Prevent weirdness
			wp_reset_postdata();
			?>

			<?php shopstar_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'library/template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
