<?php
$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
$menu_options[''] = '';
foreach ( $menus as $menu ) {
	$menu_options[$menu->term_id] = $menu->name;
}
vc_map( 
	array( 
		'base' => 'dh_menu', 
		'name' => __( 'Menu', 'forward' ), 
		'description' => __( 'Display custom Menu menu.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_menu', 
		'icon' => 'dh-vc-icon-dh_menu', 
		'show_settings_on_create' => true, 
		"category" => __( "Sitesao", 'forward' ), 
		'params' => array( 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Menu Title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'Enter text which will be used as widget title. Leave blank if no title is needed.', 
					'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Menu', 'forward' ), 
				'param_name' => 'menu', 
				'value' => $menu_options ) ) ) );

class WPBakeryShortCode_DH_Menu extends DHWPBakeryShortcode {
}