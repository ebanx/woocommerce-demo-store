<?php
vc_map( 
	array( 
		'base' => 'dh_instagram', 
		"category" => __( "Sitesao", 'forward' ), 
		'name' => __( 'Instagram', 'forward' ), 
		'description' => __( 'Instagram.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_instagram', 
		'icon' => 'dh-vc-icon-dh_instagram', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'param_name' => 'username', 
				'heading' => __( 'Instagram Username', 'forward' ), 
				'description' => '', 
				'type' => 'textfield', 
				'admin_label' => true ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Style', 'forward' ), 
				'param_name' => 'style', 
				'std' => 'slider', 
				'value' => array( __( 'Slider', 'forward' ) => 'slider', __( 'Grid', 'forward' ) => 'grid' ) ), 
			array( 
				'param_name' => 'grid_column', 
				'heading' => __( 'Grid Columns', 'forward' ), 
				'type' => 'dropdown', 
				'std' => '4', 
				'value' => array( 
					__( '2', 'forward' ) => '2', 
					__( '3', 'forward' ) => '3', 
					__( '4', 'forward' ) => '4', 
					__( '5', 'forward' ) => '5', 
					__( '6', 'forward' ) => '6' ), 
				'dependency' => array( 'element' => "style", 'value' => array( 'grid' ) ) ), 
			array( 
				'param_name' => 'images_number', 
				'heading' => __( 'Number of Images to Show', 'forward' ), 
				'type' => 'textfield', 
				'value' => '12' ), 
			array( 
				'param_name' => 'refresh_hour', 
				'heading' => __( 'Check for new images on every (hours)', 'forward' ), 
				'type' => 'textfield', 
				'value' => '5' ), 
			array( 
				'param_name' => 'visibility', 
				'heading' => __( 'Visibility', 'forward' ), 
				'type' => 'dropdown', 
				'std' => 'all', 
				'value' => array( 
					__( 'All Devices', 'forward' ) => "all", 
					__( 'Hidden Phone', 'forward' ) => "hidden-phone", 
					__( 'Hidden Tablet', 'forward' ) => "hidden-tablet", 
					__( 'Hidden PC', 'forward' ) => "hidden-pc", 
					__( 'Visible Phone', 'forward' ) => "visible-phone", 
					__( 'Visible Tablet', 'forward' ) => "visible-tablet", 
					__( 'Visible PC', 'forward' ) => "visible-pc" ) ), 
			array( 
				'param_name' => 'el_class', 
				'heading' => __( '(Optional) Extra class name', 'forward' ), 
				'type' => 'textfield', 
				'value' => '', 
				"description" => __( 
					"If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 
					'forward' ) ) ) ) );

class WPBakeryShortCode_DH_Instagram extends DHWPBakeryShortcode {
}