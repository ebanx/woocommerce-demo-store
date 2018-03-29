<?php
vc_map( 
	array( 
		'base' => 'dh_client', 
		'name' => __( 'Client', 'forward' ), 
		'description' => __( 'Display list clients.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_client', 
		'icon' => 'dh-vc-icon-dh_client', 
		'show_settings_on_create' => true, 
		"category" => __( "Sitesao", 'forward' ), 
		'params' => array( 
			array( 
				'type' => 'attach_images', 
				'heading' => __( 'Images', 'forward' ), 
				'param_name' => 'images', 
				'value' => '', 
				'description' => __( 'Select images from media library.', 'forward' ) ), 
			array( 
				'type' => 'exploded_textarea', 
				'heading' => __( 'Custom links', 'forward' ), 
				'param_name' => 'custom_links', 
				'description' => __( 
					'Enter links for each image here. Divide links with linebreaks (Enter) . ', 
					'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Display type', 'forward' ), 
				'param_name' => 'display', 
				'value' => array( __( 'Slider', 'forward' ) => 'slider', __( 'Image grid', 'forward' ) => 'grid' ), 
				'description' => __( 'Select display type.', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Slide Pagination ?', 'forward' ), 
				'param_name' => 'hide_pagination', 
				'dependency' => array( 'element' => 'display', 'value' => array( 'slider' ) ), 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'param_name' => 'visible', 
				'heading' => __( 'The number of visible items on a slide or on a grid row', 'forward' ), 
				'type' => 'dropdown', 
				'value' => array( 2, 3, 4, 5, 6 ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Image style', 'forward' ), 
				'param_name' => 'style', 
				'value' => array( 
					__( 'Normal', 'forward' ) => 'normal', 
					__( 'Grayscale and Color on hover', 'forward' ) => 'grayscale' ), 
				'description' => __( 'Select image style.', 'forward' ) ), 
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

class WPBakeryShortCode_DH_Client extends DHWPBakeryShortcode {
}