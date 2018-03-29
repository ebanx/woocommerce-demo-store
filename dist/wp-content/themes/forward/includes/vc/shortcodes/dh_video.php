<?php
vc_map( 
	array( 
		'base' => 'dh_video', 
		'name' => __( 'Video Player', 'forward' ), 
		"category" => __( "Sitesao", 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_video', 
		'icon' => 'dh-vc-icon-dh_video', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'param_name' => 'type', 
				'heading' => __( 'Video Type', 'forward' ), 
				'type' => 'dropdown', 
				'admin_label' => true, 
				'std' => 'inline', 
				'value' => array( __( 'Iniline', 'forward' ) => 'inline', __( 'Popup', 'forward' ) => 'popup' ) ), 
			array( 
				'type' => 'attach_image', 
				'heading' => __( 'Background', 'forward' ), 
				'param_name' => 'background', 
				'dependency' => array( 'element' => "type", 'value' => array( 'popup' ) ), 
				'description' => __( 'Video Background.', 'forward' ) ), 
			array( 
				'type' => 'colorpicker', 
				'heading' => __( 'Icon Play color', 'forward' ), 
				'param_name' => 'icon_color', 
				'dependency' => array( 'element' => "type", 'value' => array( 'popup' ) ),
				'description' => __( 'Select Icon Play color.', 'forward' ) ), 
			array( 
				'param_name' => 'video_embed', 
				'heading' => __( 'Embedded Code', 'forward' ), 
				'type' => 'textfield', 
				'value' => '', 
				'description' => __( 
					'Used when you select Video format. Enter a Youtube, Vimeo, Soundcloud, etc URL. See supported services at <a href="http://codex.wordpress.org/Embeds" target="_blank">http://codex.wordpress.org/Embeds</a>.', 
					'forward' ) ) ) ) );

class WPBakeryShortCode_DH_Video extends DHWPBakeryShortcode {
}
