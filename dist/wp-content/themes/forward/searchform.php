<form method="GET" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="form">
	<label for="s" class="sr-only"><?php esc_html_e( 'Search', 'forward' ); ?></label>
	<input type="hidden" value="<?php echo apply_filters('dh_ajax_search_form_post_type', 'post')?>" name="post_type">
	<input type="search" id="s" name="s" class="form-control" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search', 'forward' ); ?>" />
	<input type="submit" id="searchsubmit" class="" name="submit" value="<?php esc_attr_e( 'Go', 'forward' ); ?>" />
</form>