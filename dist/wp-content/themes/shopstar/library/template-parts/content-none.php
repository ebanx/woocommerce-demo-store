<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopstar
 */

?>

<article>
	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
				<?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'shopstar' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p class="centered">
				<?php echo wp_kses_post( get_theme_mod( 'shopstar-search-no-search-results-text', customizer_library_get_default( 'shopstar-search-no-search-results-text' ) ) ) ?>
			</p>
			
			<p class="centered">			
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php _e( 'Back to Homepage', 'shopstar' ); ?></a>
			</p>

		<?php else : ?>

			<p>
				<?php echo wp_kses_post( get_theme_mod( 'shopstar-search-no-search-results-text', customizer_library_get_default( 'shopstar-search-no-search-results-text' ) ) ) ?>
			</p>
			
			<p>			
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="button"><?php _e( 'Back to Homepage', 'shopstar' ); ?></a>
			</p>

		<?php endif; ?>
	</div><!-- .page-content -->
</article><!-- .no-results -->
