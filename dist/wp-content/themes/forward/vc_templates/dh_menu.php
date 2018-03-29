<?php
$output = '';
extract(shortcode_atts(array(
	'title'				=>'',
	'menu'			    =>'',
	'theme_location'	=>'',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));
if(!empty($menu) || !empty($theme_location)){
	if(!empty($theme_location))
		$menu = '';
	else 
		$theme_location = 'primary';
	echo '<div class="dh-menu">';
	echo '<div class="dh-menu-wrap">';
	echo !empty($title) ? '<div class="dh-menu-title"><h3>'.$title.'</h3></div>':'';
	wp_nav_menu( array(
		'theme_location'    => $theme_location,
		'container'         => false,
		'depth'				=> 3,
		'menu'				=> $menu,
		'menu_class'        => 'nav navbar-nav primary-nav',
		'walker' 			=> new DH_Mega_Walker
	) );
	echo '</div>';
	echo '</div>';
}