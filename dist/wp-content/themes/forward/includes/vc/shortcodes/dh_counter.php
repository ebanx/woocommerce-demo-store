<?php
vc_map( 
	array( 
		'base' => 'dh_counter', 
		'name' => __( 'Counter', 'forward' ), 
		'description' => __( 'Display Counter.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_counter', 
		'icon' => 'dh-vc-icon-dh_counter', 
		'show_settings_on_create' => true, 
		"category" => __( "Sitesao", 'forward' ), 
		'params' => array( 
			array( 
				'param_name' => 'speed', 
				'heading' => __( 'Counter Speed', 'forward' ), 
				'type' => 'textfield', 
				'value' => '2000' ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Number', 'forward' ), 
				'param_name' => 'number', 
				'description' => __( 'Enter the number.', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Format number displayed ?', 'forward' ), 
				'dependency' => array( 'element' => "number", 'not_empty' => true ), 
				'param_name' => 'format', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Thousand Separator', 'forward' ), 
				'param_name' => 'thousand_sep', 
				'dependency' => array( 'element' => "format", 'not_empty' => true ), 
				'value' => ',', 
				'description' => __( 'This sets the thousand separator of displayed number.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Decimal Separator', 'forward' ), 
				'param_name' => 'decimal_sep', 
				'dependency' => array( 'element' => "format", 'not_empty' => true ), 
				'value' => '.', 
				'description' => __( 'This sets the decimal separator of displayed number.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Number of Decimals', 'forward' ), 
				'param_name' => 'num_decimals', 
				'dependency' => array( 'element' => "format", 'not_empty' => true ), 
				'value' => 0, 
				'description' => __( 'This sets the number of decimal points shown in displayed number.', 'forward' ) ), 
			
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Custom Number Color', 'forward' ), 
				'param_name' => 'number_color', 
				'dependency' => array( 'element' => "number", 'not_empty' => true ), 
				'description' => __( 'Select color for number.', 'forward' ) ), 
			array( 
				'param_name' => 'number_font_size', 
				'heading' => __( 'Custom Number Font Size (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '40', 
				'data_min' => '10', 
				'dependency' => array( 'element' => "number", 'not_empty' => true ), 
				'data_max' => '120' ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Units', 'forward' ), 
				'param_name' => 'units', 
				'description' => __( 
					'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 
					'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Custom Units Color', 'forward' ), 
				'param_name' => 'units_color', 
				'dependency' => array( 'element' => "units", 'not_empty' => true ), 
				'description' => __( 'Select color for number.', 'forward' ) ), 
			array( 
				'param_name' => 'units_font_size', 
				'heading' => __( 'Custom Units Font Size (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '30', 
				'data_min' => '10', 
				'dependency' => array( 'element' => "units", 'not_empty' => true ), 
				'data_max' => '120' ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Icon', 'forward' ), 
				'param_name' => 'icon', 
				"param_holder_class" => 'dh-font-awesome-select', 
				"value" => dh_font_awesome_options(), 
				'description' => __( 'Button icon.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Custom Icon Color', 'forward' ), 
				'param_name' => 'icon_color', 
				'dependency' => array( 'element' => "icon", 'not_empty' => true ), 
				'description' => __( 'Select color for icon.', 'forward' ) ), 
			array( 
				'param_name' => 'icon_font_size', 
				'heading' => __( 'Custom Icon Size (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '40', 
				'data_min' => '10', 
				'dependency' => array( 'element' => "icon", 'not_empty' => true ), 
				'data_max' => '120' ), 
			array( 
				'type' => 'dropdown', 
				'std' => 'top', 
				'heading' => __( 'Icon Postiton', 'forward' ), 
				'param_name' => 'icon_position', 
				'dependency' => array( 'element' => "icon", 'not_empty' => true ), 
				'value' => array( __( 'Top', 'forward' ) => 'top', __( 'Left', 'forward' ) => 'left' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Title', 'forward' ), 
				'param_name' => 'text', 
				'admin_label' => true ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Custom Title Color', 'forward' ), 
				'param_name' => 'text_color', 
				'dependency' => array( 'element' => "text", 'not_empty' => true ), 
				'description' => __( 'Select color for title.', 'forward' ) ), 
			array( 
				'param_name' => 'text_font_size', 
				'heading' => __( 'Custom Title Font Size (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '18', 
				'data_min' => '10', 
				'dependency' => array( 'element' => "text", 'not_empty' => true ), 
				'data_max' => '120' ), 
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

class WPBakeryShortCode_DH_Counter extends DHWPBakeryShortcode {
}