
<div class="page-header">
	<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'forward' ); ?></h2>
</div>
<div class="page-content">
	<?php if ( is_search() ) : ?>

		<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'forward' ); ?></p>
		<?php get_search_form(); ?>

	<?php else : ?>

		<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'forward' ); ?></p>
		<?php get_search_form(); ?>

	<?php endif; ?>
</div>
