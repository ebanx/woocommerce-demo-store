<?php
vc_map( 
	array( 
		'base' => 'dh_menu_anchor', 
		'name' => __( 'Menu Anchor', 'forward' ), 
		'description' => __( 'Add a menu anchor points.', 'forward' ), 
		'category' => 'Sitesao', 
		'class' => 'dh-vc-element dh-vc-element-menu_anchor', 
		'icon' => 'dh-vc-icon-menu_anchor', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'param_name' => 'name', 
				'heading' => __( 'Name Of Menu Anchor', 'forward' ), 
				'type' => 'textfield', 
				'admin_label' => true, 
				"description" => __( "This name will be the id you will have to use in your one page menu.", 'forward' ) ) ) ) );

class WPBakeryShortCode_DH_Menu_Anchor extends DHWPBakeryShortcode {
}