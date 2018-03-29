<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package shopstar
 */
global $woocommerce;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( get_theme_mod( 'shopstar-header-layout', customizer_library_get_default( 'shopstar-header-layout' ) ) == 'shopstar-header-layout-centered' ) :
		get_template_part( 'library/template-parts/header', 'centered' );
	else :
		get_template_part( 'library/template-parts/header', 'left-aligned' );
    endif;
    ?>
	
	<script>
    var shopstarSliderTransitionSpeed = parseInt( <?php echo intval( get_theme_mod( 'shopstar-slider-transition-speed', customizer_library_get_default( 'shopstar-slider-transition-speed' ) ) ); ?> );
	</script>
	
	<?php
	if ( is_front_page() && get_theme_mod( 'shopstar-slider-type', customizer_library_get_default( 'shopstar-slider-type' ) ) != 'shopstar-no-slider' ) :
		get_template_part( 'library/template-parts/slider' );
	elseif ( is_front_page() && get_header_image() ) :
		get_template_part( 'library/template-parts/header-image' );
	endif;
	?>
		
	<div id="content" class="site-content">
		<div class="container">
			<div class="padder">