<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

the_post();

get_header();

if ( post_password_required() ) {
	?>
	<div class="container">
		<h1 class="password-protected-title"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	</div>
	<?php
} else {
	get_template_part( 'tpls/post-single' );
}

get_footer();