<?php
vc_map( 
	array( 
		'base' => 'dh_countdown', 
		'name' => __( 'Coundown', 'forward' ), 
		'description' => __( 'Display Countdown.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_countdown', 
		'icon' => 'dh-vc-icon-dh_countdown', 
		'show_settings_on_create' => true, 
		"category" => __( "Sitesao", 'forward' ), 
		'params' => array( 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Style', 'forward' ), 
				'param_name' => 'style', 
				'admin_label' => true, 
				'value' => array( __( 'White', 'forward' ) => 'white', __( 'Black', 'forward' ) => 'black' ), 
				'description' => __( 'Select style.', 'forward' ) ), 
			array( 
				'type' => 'ui_datepicker', 
				'heading' => __( 'Countdown end', 'forward' ), 
				'param_name' => 'end', 
				'description' => __( 'Please select day to end.', 'forward' ), 
				'value' => '' ), 
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

class WPBakeryShortCode_DH_Countdown extends DHWPBakeryShortcode {
}