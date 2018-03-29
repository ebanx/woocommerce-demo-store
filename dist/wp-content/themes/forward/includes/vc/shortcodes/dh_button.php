<?php
vc_map( 
	array( 
		'base' => 'dh_button', 
		'name' => __( 'Button', 'forward' ), 
		'description' => __( 'Eye catching button.', 'forward' ), 
		"category" => __( "Sitesao", 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_button', 
		'icon' => 'dh-vc-icon-dh_button', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Text', 'forward' ), 
				'holder' => 'button', 
				'class' => 'wpb_button', 
				'admin_label' => true, 
				'param_name' => 'title', 
				'value' => __( 'Button', 'forward' ), 
				'description' => __( 'Text on the button.', 'forward' ) ), 
			
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon library', 'forward' ),
				'std'=>'',
				'value' => array(
					__( 'None', 'forward' ) => '',
					__( 'Font Awesome', 'forward' ) => 'fontawesome',
					__( 'Open Iconic', 'forward' ) => 'openiconic',
					__( 'Typicons', 'forward' ) => 'typicons',
					__( 'Entypo', 'forward' ) => 'entypo',
					__( 'Linecons', 'forward' ) => 'linecons',
				),
				'param_name' => 'btn_icon_type',
				'description' => __( 'Select icon library.', 'forward' ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Button Icon Alignment', 'forward' ),
				'param_name' => 'btn_icon_align',
				'dependency' => array(
					'element' => 'btn_icon_type',
					'not_empty' => true
				),
				'std' => 'left',
				'value' => array(
					__( 'Left', 'forward' ) => 'left',
					__( 'Right', 'forward' ) => 'right' ),
				'description' => __( 'Button Icon alignment', 'forward' ) ),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Button icon Slide In', 'forward' ),
				'param_name' => 'btn_icon_slide_in',
				'dependency' => array(
					'element' => 'btn_icon_type',
					'value' => 'right',
				),
				'dependency' => array(
					'element' => 'btn_icon_type',
					'not_empty' => true
				),
				'value' => array( __( 'Yes, please', 'forward' ) => 'yes' ),
				'description' => __( 'Use button icon slide in', 'forward' ) ),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'forward' ),
				'param_name' => 'icon_fontawesome',
				'value' => 'fa fa-adjust', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false,
					// default true, display an "EMPTY" icon?
					'iconsPerPage' => 4000,
					// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
				),
				'dependency' => array(
					'element' => 'btn_icon_type',
					'value' => 'fontawesome',
				),
				'description' => __( 'Select icon from library.', 'forward' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'forward' ),
				'param_name' => 'icon_openiconic',
				'value' => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'openiconic',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'btn_icon_type',
					'value' => 'openiconic',
				),
				'description' => __( 'Select icon from library.', 'forward' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'forward' ),
				'param_name' => 'icon_typicons',
				'value' => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'typicons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'btn_icon_type',
					'value' => 'typicons',
				),
				'description' => __( 'Select icon from library.', 'forward' ),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'forward' ),
				'param_name' => 'icon_entypo',
				'value' => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'entypo',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'btn_icon_type',
					'value' => 'entypo',
				),
			),
			array(
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'forward' ),
				'param_name' => 'icon_linecons',
				'value' => 'vc_li vc_li-heart', // default value to backend editor admin_label
				'settings' => array(
					'emptyIcon' => false, // default true, display an "EMPTY" icon?
					'type' => 'linecons',
					'iconsPerPage' => 4000, // default 100, how many icons per/page to display
				),
				'dependency' => array(
					'element' => 'btn_icon_type',
					'value' => 'linecons',
				),
				'description' => __( 'Select icon from library.', 'forward' ),
			),
			array( 
				'type' => 'href', 
				'heading' => __( 'URL (Link)', 'forward' ), 
				'param_name' => 'href', 
				'description' => __( 'Button link.', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Target', 'forward' ), 
				'param_name' => 'target', 
				'std' => '_self', 
				'value' => array( __( 'Same window', 'forward' ) => '_self', __( 'New window', 'forward' ) => "_blank" ), 
				'dependency' => array( 
					'element' => 'href', 
					'not_empty' => true, 
					'callback' => 'vc_button_param_target_callback' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Style', 'forward' ), 
				'param_name' => 'style', 
				'value' => array( 'Default' => '', 'Outlined' => 'outline' ), 
				'description' => __( 'Button style.', 'forward' ) ), 
			array(
				'type' => 'checkbox',
				'heading' => __( 'Button Round', 'forward' ),
				'param_name' => 'btn_round',
				'value' => array( __( 'Yes, please', 'forward' ) => 'yes' ),
				'description' => __( 'Use button round', 'forward' ) ),
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Size', 'forward' ), 
				'param_name' => 'size', 
				'std' => '', 
				'value' => array( 
					__( 'Default', 'forward' ) => '', 
					__( 'Large', 'forward' ) => 'lg', 
					__( 'Small', 'forward' ) => 'sm', 
					__( 'Extra small', 'forward' ) => 'xs', 
					__( 'Custom size', 'forward' ) => 'custom' ), 
				'description' => __( 'Button size.', 'forward' ) ), 
			array( 
				'param_name' => 'font_size', 
				'heading' => __( 'Font Size (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '14', 
				'data_min' => '0', 
				'dependency' => array( 'element' => "size", 'value' => array( 'custom' ) ), 
				'data_max' => '50' ), 
			array( 
				'param_name' => 'border_width', 
				'heading' => __( 'Border Width (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '1', 
				'data_min' => '0', 
				'dependency' => array( 'element' => "size", 'value' => array( 'custom' ) ), 
				'data_max' => '20' ), 
			array( 
				'param_name' => 'padding_top', 
				'heading' => __( 'Padding Top (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '6', 
				'data_min' => '0', 
				'dependency' => array( 'element' => "size", 'value' => array( 'custom' ) ), 
				'data_max' => '100' ), 
			array( 
				'param_name' => 'padding_right', 
				'heading' => __( 'Padding Right (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '30', 
				'data_min' => '0', 
				'dependency' => array( 'element' => "size", 'value' => array( 'custom' ) ), 
				'data_max' => '100' ), 
			array( 
				'param_name' => 'padding_bottom', 
				'heading' => __( 'Padding Bottom (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '6', 
				'data_min' => '0', 
				'dependency' => array( 'element' => "size", 'value' => array( 'custom' ) ), 
				'data_max' => '100' ), 
			array( 
				'param_name' => 'padding_left', 
				'heading' => __( 'Padding Right (px)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '30', 
				'data_min' => '0', 
				'dependency' => array( 'element' => "size", 'value' => array( 'custom' ) ), 
				'data_max' => '100' ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Color', 'forward' ), 
				'param_name' => 'color', 
				'std' => 'default', 
				'value' => array( 
					__( 'Default', 'forward' ) => 'default', 
					__( 'Primary', 'forward' ) => 'primary', 
					__( 'Success', 'forward' ) => 'success', 
					__( 'Info', 'forward' ) => 'info', 
					__( 'Warning', 'forward' ) => 'warning', 
					__( 'Danger', 'forward' ) => 'danger', 
					__( 'White', 'forward' ) => 'white', 
					__( 'Black', 'forward' ) => 'black', 
					__( 'Custom', 'forward' ) => 'custom' ), 
				'description' => __( 'Button color.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Background Color', 'forward' ), 
				'param_name' => 'background_color', 
				'dependency' => array( 'element' => "color", 'value' => array( 'custom' ) ), 
				'description' => __( 'Select background color for button.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Border Color', 'forward' ), 
				'param_name' => 'border_color', 
				'dependency' => array( 'element' => "color", 'value' => array( 'custom' ) ), 
				'description' => __( 'Select border color for button.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Text Color', 'forward' ), 
				'param_name' => 'text_color', 
				'dependency' => array( 'element' => "color", 'value' => array( 'custom' ) ), 
				'description' => __( 'Select text color for button.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Hover Background Color', 'forward' ), 
				'param_name' => 'hover_background_color', 
				'dependency' => array( 'element' => "color", 'value' => array( 'custom' ) ), 
				'description' => __( 'Select background color for button when hover.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Hover Border Color', 'forward' ), 
				'param_name' => 'hover_border_color', 
				'dependency' => array( 'element' => "color", 'value' => array( 'custom' ) ), 
				'description' => __( 'Select border color for button when hover.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Hover Text Color', 'forward' ), 
				'param_name' => 'hover_text_color', 
				'dependency' => array( 'element' => "color", 'value' => array( 'custom' ) ), 
				'description' => __( 'Select text color for button when hover.', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Button Full Width', 'forward' ), 
				'param_name' => 'block_button', 
				'value' => array( __( 'Yes, please', 'forward' ) => 'yes' ), 
				'description' => __( 'Button full width of a parent', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Alignment', 'forward' ), 
				'param_name' => 'alignment', 
				'std' => 'left', 
				'value' => array( 
					__( 'Left', 'forward' ) => 'left', 
					__( 'Center', 'forward' ) => 'center', 
					__( 'Right', 'forward' ) => 'right' ), 
				'description' => __( 'Button alignment (Not use for Button full width)', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Show Tooltip/Popover', 'forward' ), 
				'param_name' => 'tooltip', 
				'value' => array( 
					__( 'No', 'forward' ) => '', 
					__( 'Tooltip', 'forward' ) => 'tooltip', 
					__( 'Popover', 'forward' ) => 'popover' ), 
				'description' => __( 'Display a tooltip or popover with descriptive text.', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Tip position', 'forward' ), 
				'param_name' => 'tooltip_position', 
				'std' => 'top', 
				'value' => array( 
					__( 'Top', 'forward' ) => 'top', 
					__( 'Bottom', 'forward' ) => 'bottom', 
					__( 'Left', 'forward' ) => 'left', 
					__( 'Right', 'forward' ) => 'right' ), 
				'dependency' => array( 'element' => "tooltip", 'value' => array( 'tooltip', 'popover' ) ), 
				'description' => __( 'Choose the display position.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Popover Title', 'forward' ), 
				'param_name' => 'tooltip_title', 
				'dependency' => array( 'element' => "tooltip", 'value' => array( 'popover' ) ) ), 
			array( 
				'type' => 'textarea', 
				'heading' => __( 'Tip/Popover Content', 'forward' ), 
				'param_name' => 'tooltip_content', 
				'dependency' => array( 'element' => "tooltip", 'value' => array( 'tooltip', 'popover' ) ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Tip/Popover trigger', 'forward' ), 
				'param_name' => 'tooltip_trigger', 
				'std' => 'hover', 
				'value' => array( __( 'Hover', 'forward' ) => 'hover', __( 'Click', 'forward' ) => 'click' ), 
				'dependency' => array( 'element' => "tooltip", 'value' => array( 'tooltip', 'popover' ) ), 
				'description' => __( 'Choose action to trigger the tooltip.', 'forward' ) ), 
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

class WPBakeryShortCode_DH_Button extends DHWPBakeryShortcode {
}