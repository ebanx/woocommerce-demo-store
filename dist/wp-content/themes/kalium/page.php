<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */
 
global $post;

the_post();

get_header();

// Check if is default container
$is_vc_content = preg_match( "/\[vc_row.*?\]/i", $post->post_content );

// Password protected page doesn't use vc container
if ( post_password_required() ) {
	$is_vc_content = false;
}

// Page title (show or hide)
$show_title = false == $is_vc_content && is_singular();

// Do not show title on shop account page and checkout page
if ( is_shop_supported() && ( is_account_page() || is_checkout() ) ) {
	$show_title = false;
}

// Container start
?>
<div class="<?php when_match( $is_vc_content, 'vc-container', 'container default-margin post-formatting' ); ?>">
<?php


// Show page title
if ( false == defined( 'HEADING_TITLE_DISPLAYED' ) && apply_filters( 'kalium_page_title', $show_title ) ) {
	?>
	<h1 class="wp-page-title"><?php the_title(); ?></h1>
	<?php
} 

// Page content		
the_content();
		

// Container end
?>
</div>
<?php


get_footer();