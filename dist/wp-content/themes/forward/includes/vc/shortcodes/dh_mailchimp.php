<?php
vc_map( 
	array( 
		'base' => 'dh_mailchimp', 
		"category" => __( "Sitesao", 'forward' ), 
		'name' => __( 'Mailchimp Subscribe', 'forward' ), 
		'description' => __( 'Widget Mailchimp Subscribe.', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_mailchimp', 
		'icon' => 'dh-vc-icon-dh_mailchimp', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'Enter text which will be used as widget title. Leave blank if no title is needed.', 
					'forward' ) ) ) ) );

class WPBakeryShortCode_DH_Mailchimp extends DHWPBakeryShortcode {
}