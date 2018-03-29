<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package shopstar
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<header class="entry-header">
				<h1 class="entry-title page-not-found"><?php echo wp_kses_post( get_theme_mod( 'shopstar-website-text-404-page-heading', customizer_library_get_default( 'shopstar-website-text-404-page-heading' ) ) ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p class="centered">
					<?php echo wp_kses_post( get_theme_mod( 'shopstar-website-text-404-page-text', customizer_library_get_default( 'shopstar-website-text-404-page-text' ) ) ); ?>
				</p>
				
				<p class="centered">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php _e( 'Back to Homepage', 'shopstar' ); ?></a>
				</p>
			</div><!-- .page-content -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
