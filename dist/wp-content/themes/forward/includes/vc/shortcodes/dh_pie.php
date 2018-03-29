<?php

vc_map(array(
	'name' => __( 'DH Pie Chart', 'forward' ),
	'base' => 'dh_pie',
	'class' => '',
	'class' => 'dh-vc-element dh-vc-element-dh_pie',
	'icon' => 'dh-vc-icon-dh_pie',
	'category' => __( 'Sitesao', 'forward' ),
	'description' => __( 'Animated pie chart', 'forward' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'forward' ),
			'param_name' => 'title',
			'description' => __( 'Enter text used as widget title (Note: located above content element).', 'forward' ),
			'admin_label' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Value', 'forward' ),
			'param_name' => 'value',
			'description' => __( 'Enter value for graph (Note: choose range from 0 to 100).', 'forward' ),
			'value' => '50',
			'admin_label' => true,
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Label value', 'forward' ),
			'param_name' => 'label_value',
			'description' => __( 'Enter label for pie chart (Note: leaving empty will set value from "Value" field).', 'forward' ),
			'value' => '',
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Label font size (px)', 'forward' ),
			'param_name' => 'label_font_size',
			'description' => __( 'Enter label font size for pie chart', 'forward' ),
			'value' => '30px',
			'admin_label' => true,
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Label color', 'forward' ),
			'param_name' => 'label_color',
			'description' => __( 'Select label color.', 'forward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Units', 'forward' ),
			'param_name' => 'units',
			'description' => __( 'Enter measurement units (Example: %, px, points, etc. Note: graph value and units will be appended to graph title).', 'forward' ),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Border width', 'forward' ),
			'param_name' => 'border_w',
			'description' => __( 'Enter border width for graph', 'forward' ),
			'value' => '10',
			'admin_label' => true,
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Color', 'forward' ),
			'param_name' => 'color',
			'value' => getVcShared( 'colors-dashed' ) + array( __( 'Custom', 'forward' ) => 'custom' ),
			'description' => __( 'Select pie chart color.', 'forward' ),
			'admin_label' => true,
			'param_holder_class' => 'vc_colored-dropdown',
			'std' => 'grey',
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Custom color', 'forward' ),
			'param_name' => 'custom_color',
			'description' => __( 'Select custom color.', 'forward' ),
			'dependency' => array(
				'element' => 'color',
				'value' => array( 'custom' ),
			),
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'forward' ),
			'param_name' => 'el_class',
			'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'forward' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'forward' ),
			'param_name' => 'css',
			'group' => __( 'Design Options', 'forward' ),
		),
	),
));

class WPBakeryShortCode_DH_Pie extends DHWPBakeryShortcode {
	public function __construct( $settings ) {
		parent::__construct( $settings );
	}

	/**
	 * Convert old color names to new ones for BC
	 *
	 * @param array $atts
	 *
	 * @return array
	 */
	public static function convertOldColorsToNew( $atts ) {
		$map = array(
			'btn-primary' => '#0088cc',
			'btn-success' => '#6ab165',
			'btn-warning' => '#ff9900',
			'btn-inverse' => '#555555',
			'btn-danger' => '#ff675b',
			'btn-info' => '#58b9da',
			'primary' => '#0088cc',
			'success' => '#6ab165',
			'warning' => '#ff9900',
			'inverse' => '#555555',
			'danger' => '#ff675b',
			'info' => '#58b9da',
			'default' => '#f7f7f7',
		);

		if ( isset( $atts['color'] ) && isset( $map[ $atts['color'] ] ) ) {
			$atts['custom_color'] = $map[ $atts['color'] ];
			$atts['color'] = 'custom';
		}

		return $atts;
	}
}
