<?php
/**
 *	Custom Row for this theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

// Deprecated "lab-full-width" frontend fallback
function laborator_vc_custom_row_output( $output, $object, $atts ) {
	// Applied to rows only
	if ( 'vc_row' == $object->settings( 'base' ) ) {
		$full_width = get_array_key( $atts, 'full_width' );
		
		// Deprecated: Replace deprecated "full_width" param value "lab-full-width"
		$is_lab_full_width = 'lab-full-width' == $full_width;
		$is_container_wrap = 'yes' == get_array_key( $atts, 'container_wrap' );
		
		if ( $is_lab_full_width ) {
			$atts['full_width'] = 'stretch_row_content';
			
			if ( $is_container_wrap ) {
				$atts['full_width'] = 'stretch_row';
			}
		}
	}

	return $output;
}

add_filter( 'vc_shortcode_output', 'laborator_vc_custom_row_output', 100, 3 );


// Deprecated "lab-full-width" backend fallback
function vc_form_fields_render_field_full_width_value( $value, $param, $settings, $atts ) {
	if ( 'lab-full-width' == $value ) {
		if ( 'yes' == get_array_key( $atts, 'container_wrap' ) ) {
			return 'stretch_row';
		}
		return 'stretch_row_content';
	}
	
	return $value;
}

add_filter( 'vc_form_fields_render_field_vc_row_full_width_param_value', 'vc_form_fields_render_field_full_width_value', 10, 4 );


/*

function laborator_vc_row_options() {
	
	# Parallax Attributes
	$parallax_attributes = array(
	   array(
			'type'           => 'checkbox',
			'heading'        => 'Laborator Parallax',
			'param_name'     => 'parallax_enable',
			'value'          => array( 'Yes' => 'yes' ),
			'description'    => 'Check this box if you want to enable parallax for this row.',
			'dependency' => array(
				'element'   => 'parallax',
				'is_empty' 	=> true,
			),
		),
		
		array(
			'type'           => 'textfield',
			'heading'        => 'Laborator Parallax Ratio',
			'param_name'     => 'parallax_ratio',
			'value'          => '0.8',
			'description'    => 'Recommended scale: from 0.00 to 1.00.',
			'dependency' => array(
				'element'   => 'parallax_enable',
				'value'     => array( 'yes' )
			),
		),
		
		array(
			'type'           => 'textfield',
			'heading'        => 'Laborator Parallax Opacity',
			'param_name'     => 'parallax_opacity',
			'value'          => '',
			'description'    => 'Opacity to reach while exiting the viewport. Recommended scale: from 0.00 to 1.00. (Optional)',
			'dependency' => array(
				'element'   => 'parallax_enable',
				'value'     => array( 'yes' )
			),
		),
	);
	
	vc_add_params( 'vc_row', $parallax_attributes );
}

function laborator_vc_row_full_width()  {
	
	# Full Width Param
	$param = WPBMap::getParam( 'vc_row', 'full_width' );
	
	$param['weight'] = 2;
	$param['value'][ 'Full width (Laborator)' ] = 'lab-full-width';

	vc_update_shortcode_param( 'vc_row', $param );
}

function laborator_vc_row_container_wrap() {
	
	vc_add_param( 'vc_row', array(
		'type'           => 'checkbox',
		'heading'        => 'Wrap within container',
		'param_name'     => 'container_wrap',
		'value'          => array( 'Yes' => 'yes' ),
		'description'    => 'Check this box if you want to wrap contents of this row within default container.',
		'dependency' => array(
			'element'   => 'full_width',
			'value'     => array( 'lab-full-width' )
		),
		'weight' => 1
	) );
}

add_action( 'vc_after_init', 'laborator_vc_row_options' );
add_action( 'vc_after_init', 'laborator_vc_row_full_width' );
add_action( 'vc_after_init', 'laborator_vc_row_container_wrap' );
//*/