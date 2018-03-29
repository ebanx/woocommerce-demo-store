<?php
vc_map( 
	array( 
		'base' => 'dh_post_slider', 
		'name' => __( 'Post Slider', 'forward' ), 
		'description' => __( 'Display posts with slider.', 'forward' ), 
		"category" => __( "Sitesao", 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_post_slider', 
		'icon' => 'dh-vc-icon-dh_post_slider', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Columns', 'forward' ), 
				'param_name' => 'columns', 
				'std' => 2, 
				'value' => array( 
					__( '1', 'forward' ) => '1', 
					__( '2', 'forward' ) => '2', 
					__( '3', 'forward' ) => '3', 
					__( '4', 'forward' ) => '4' ), 
				'description' => __( 'Select whether to display the layout in 1, 2, 3 or 4 column.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Posts Per Page', 'forward' ), 
				'param_name' => 'posts_per_page', 
				'value' => 12, 
				'description' => __( 'Select number of posts per page.Set "-1" to display all', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Order by', 'forward' ), 
				'param_name' => 'orderby', 
				'value' => array( 
					__( 'Recent First', 'forward' ) => 'latest', 
					__( 'Older First', 'forward' ) => 'oldest', 
					__( 'Title Alphabet', 'forward' ) => 'alphabet', 
					__( 'Title Reversed Alphabet', 'forward' ) => 'ralphabet' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Pagination', 'forward' ), 
				'param_name' => 'hide_pagination', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide pagination of slider', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Previous/Next Control ?', 'forward' ), 
				'param_name' => 'hide_nav', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Date', 'forward' ), 
				'param_name' => 'hide_date', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide date in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Author', 'forward' ), 
				'param_name' => 'hide_author', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide author in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Category', 'forward' ), 
				'param_name' => 'hide_category', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide category in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Comment', 'forward' ), 
				'param_name' => 'hide_comment', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide comment in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Excerpt', 'forward' ), 
				'param_name' => 'hide_excerpt', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide excerpt', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Number of words in Excerpt', 'forward' ), 
				'param_name' => 'excerpt_length', 
				'value' => 30, 
				'dependency' => array( 'element' => 'hide_excerpt', 'is_empty' => true ), 
				'description' => __( 'The number of words', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Read More Link', 'forward' ), 
				'param_name' => 'hide_readmore', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Choose to hide the link', 'forward' ) ), 
			array( 
				'type' => 'post_category', 
				'heading' => __( 'Categories', 'forward' ), 
				'param_name' => 'categories', 
				'admin_label' => true, 
				'description' => __( 'Select a category or leave blank for all', 'forward' ) ), 
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

class WPBakeryShortCode_DH_Post_Slider extends DHWPBakeryShortcode {
}