<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package shopstar
 */

get_header(); ?>

	<section id="primary" class="content-area <?php echo !is_active_sidebar( 'sidebar-1' ) ? 'full-width' : ''; ?>">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>
		
			<?php if ( function_exists( 'bcn_display' ) ) : ?>
				<div class="breadcrumbs">
					<?php bcn_display(); ?>
				</div>
			<?php endif; ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'shopstar' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'library/template-parts/content', 'search' );
				?>

			<?php endwhile; ?>

			<?php
			// Prevent weirdness
			wp_reset_postdata();
			?>
			
			<?php the_posts_navigation(); ?>

		<?php else : ?>
		
			<?php if ( function_exists( 'bcn_display' ) ) : ?>
				<div class="breadcrumbs">
					<?php bcn_display(); ?>
				</div>
			<?php endif; ?>
		
			<header class="page-header">
				<h1 class="page-title"><?php echo wp_kses_post( get_theme_mod( 'shopstar-search-no-search-results-heading', customizer_library_get_default( 'shopstar-search-no-search-results-heading' ) ) ); ?></h1>
			</header><!-- .page-header -->

			<?php get_template_part( 'library/template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
