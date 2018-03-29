<?php
vc_map( 
	array( 
		'base' => 'dh_member', 
		'name' => __( 'Team Member', 'forward' ), 
		'description' => __( 'Display team member.', 'forward' ), 
		"category" => __( "Sitesao", 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_member', 
		'icon' => 'dh-vc-icon-dh_member', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'type' => 'dropdown', 
				'param_name' => 'style', 
				'heading' => __( 'Style', 'forward' ), 
				'std'=>'below',
				'value' => array( 
					__( 'Default', 'forward' ) => 'default',
					__( 'Meta below', 'forward' ) => 'below', 
					__( 'Meta overlay', 'forward' ) => 'overlay', 
					__( 'Meta right', 'forward' ) => 'right' ), 
				"description" => __( "Team Member Stlye.", 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Name', 'forward' ), 
				'param_name' => 'name', 
				'admin_label' => true, 
				"description" => __( "Enter the name of team member.", 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Job Position', 'forward' ), 
				'param_name' => 'job', 
				"description" => __( "Enter the job position for team member.", 'forward' ) ), 
			array( 
				'type' => 'attach_image', 
				'heading' => __( 'Avatar', 'forward' ), 
				'param_name' => 'avatar', 
				"description" => __( "Select avatar from media library.", 'forward' ) ), 
			array( 
				'type' => 'textarea_safe', 
				'heading' => __( 'Description', 'forward' ), 
				'param_name' => 'description', 
				"description" => __( "Enter the description for team member.", 'forward' ) ), 
			
			array( 'type' => 'href', 'heading' => __( 'Facebook URL', 'forward' ), 'param_name' => 'facebook' ), 
			
			array( 'type' => 'href', 'heading' => __( 'Twitter URL', 'forward' ), 'param_name' => 'twitter' ), 
			array( 'type' => 'href', 'heading' => __( 'Google+ URL', 'forward' ), 'param_name' => 'google' ), 
			array( 'type' => 'href', 'heading' => __( 'LinkedIn URL', 'forward' ), 'param_name' => 'linkedin' ) ) ) );

class WPBakeryShortCode_DH_Member extends DHWPBakeryShortcode {
}