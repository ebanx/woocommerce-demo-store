<?php
vc_map( 
	array( 
		'base' => 'dh_box_feature', 
		"category" => __( "Sitesao", 'forward' ), 
		'name' => __( 'Box Feature', 'forward' ), 
		'description' => __( 'Box Feature.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_box_feature', 
		'icon' => 'dh-vc-icon-dh_box_feature', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Style', 'forward' ), 
				'param_name' => 'style', 
				'std' => '1', 
				'value' => array( 
					__( 'Style 1', 'forward' ) => '1', 
					__( 'Style 2', 'forward' ) => "2", 
					__( 'Style 3', 'forward' ) => "3", 
					__( 'Style 4', 'forward' ) => "4",
					__( 'Style 5', 'forward' ) => "5" ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Content Position', 'forward' ), 
				'param_name' => 'content_position', 
				'std' => 'default', 
				'dependency' => array( 'element' => 'style', 'value' => array( '5' ) ), 
				'value' => array( 
					__( 'Default', 'forward' ) => 'default', 
					__( 'Top', 'forward' ) => "top", 
					__( 'Bottom', 'forward' ) => "bottom", 
					__( 'Left', 'forward' ) => "left", 
					__( 'Right', 'forward' ) => "right", 
					__( 'Full Box', 'forward' ) => "full-box" ) ), 
			array( 
						'param_name' => 'link_title', 
						'heading' => __( 'Button Text', 'forward' ), 
						'type' => 'textfield', 
						'value' => '', 
						'dependency' => array( 'element' => 'style', 'value' => array( '5' ) ), 
						'description' => __( 'Button link text', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Full Box with Primary Soild Background ?', 'forward' ), 
				'param_name' => 'primary_background', 
				'dependency' => array( 'element' => 'content_position', 'value' => array( 'full-box' ) ), 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Text color', 'forward' ), 
				'param_name' => 'text_color', 
				'dependency' => array( 'element' => 'style', 'value' => array( '5' ) ), 
				'std' => 'white', 
				'value' => array( __( 'White', 'forward' ) => "white", __( 'Black', 'forward' ) => "black" ) ), 
			array( 
				'type' => 'attach_image', 
				'heading' => __( 'Image Background', 'forward' ), 
				'param_name' => 'bg', 
				'description' => __( 'Image Background.', 'forward' ) ), 
			array( 
				'type' => 'href', 
				'heading' => __( 'Image URL (Link)', 'forward' ), 
				'param_name' => 'href', 
				'description' => __( 'Image Link.', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Target', 'forward' ), 
				'param_name' => 'target', 
				'std' => '_self', 
				'value' => array( __( 'Same window', 'forward' ) => '_self', __( 'New window', 'forward' ) => "_blank" ), 
				'dependency' => array( 'element' => 'href', 'not_empty' => true ) ), 
			
			array( 
				'param_name' => 'title', 
				'heading' => __( 'Title', 'forward' ), 
				'admin_label' => true, 
				'type' => 'textfield', 
				'value' => '', 
				'description' => __( 'Box Title', 'forward' ) ), 
			array( 
				'param_name' => 'sub_title', 
				'heading' => __( 'Sub Title', 'forward' ), 
				'type' => 'textfield', 
				'value' => '', 
				'description' => __( 'Box Sub Title', 'forward' ) ), 
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

class WPBakeryShortCode_DH_Box_Feature extends DHWPBakeryShortcode {
}
