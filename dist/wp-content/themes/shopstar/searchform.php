<?php
/**
 * The template for displaying search forms
 *
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( get_theme_mod( 'shopstar-search-placeholder-text', customizer_library_get_default( 'shopstar-search-placeholder-text' ) ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php _ex( 'Search for:', 'label', 'shopstar' ); ?>" />
	</label>		
	<button type="submit" class="search-submit">
		<i class="fa fa-search"></i>
	</button>
</form>

<div class="clearboth"></div>