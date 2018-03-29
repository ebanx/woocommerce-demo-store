<?php
vc_map( 
	array( 
		'base' => 'dh_post', 
		'name' => __( 'Post', 'forward' ), 
		'description' => __( 'Display post.', 'forward' ), 
		"category" => __( "Sitesao", 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_post', 
		'icon' => 'dh-vc-icon-dh_post', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Layout', 'forward' ), 
				'param_name' => 'layout', 
				'std' => 'default', 
				'admin_label' => true, 
				'value' => array( 
					__( 'Default', 'forward' ) => 'default', 
					__( 'Zigzag', 'forward' ) => 'zigzag', 
					__( 'Grid', 'forward' ) => 'grid', 
					__( 'Masonry', 'forward' ) => 'masonry', 
					__( 'Center', 'forward' ) => 'center' ), 
				'std' => 'default', 
				'description' => __( 'Select the layout for the blog shortcode.', 'forward' ) ), 
			array( 
				'param_name' => 'grid_first', 
				'type' => 'checkbox', 
				'dependency' => array( 'element' => "layout", 'value' => array( 'grid' ) ), 
				'heading' => __( 'Full First Item', 'forward' ), 
				'description' => __( 'Show full item in Grid layout', 'forward' ), 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'param_name' => 'grid_no_border', 
				'type' => 'checkbox', 
				'dependency' => array( 'element' => "layout", 'value' => array( 'grid' ) ), 
				'heading' => __( 'Grid Style no Border', 'forward' ), 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Columns', 'forward' ), 
				'param_name' => 'columns', 
				'std' => 2, 
				'value' => array( __( '2', 'forward' ) => '2', __( '3', 'forward' ) => '3', __( '4', 'forward' ) => '4' ), 
				'dependency' => array( 'element' => "layout", 'value' => array( 'grid', 'masonry' ) ), 
				'description' => __( 'Select whether to display the layout in 2, 3 or 4 column.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Posts Per Page', 'forward' ), 
				'param_name' => 'posts_per_page', 
				'value' => 5, 
				'description' => __( 'Select number of posts per page.Set "-1" to display all', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Order by', 'forward' ), 
				'param_name' => 'orderby', 
				'std' => 'latest', 
				'value' => array( 
					__( 'Recent First', 'forward' ) => 'latest', 
					__( 'Older First', 'forward' ) => 'oldest', 
					__( 'Title Alphabet', 'forward' ) => 'alphabet', 
					__( 'Title Reversed Alphabet', 'forward' ) => 'ralphabet' ) ), 
			array( 
				'type' => 'post_category', 
				'heading' => __( 'Categories', 'forward' ), 
				'param_name' => 'categories', 
				'admin_label' => true, 
				'description' => __( 'Select a category or leave blank for all', 'forward' ) ), 
			array( 
				'type' => 'post_category', 
				'heading' => __( 'Exclude Categories', 'forward' ), 
				'param_name' => 'exclude_categories', 
				'description' => __( 'Select a category to exclude', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Post no padding', 'forward' ), 
				'param_name' => 'no_padding', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'dependency' => array( 'element' => "layout", 'value' => array( 'grid' ) ), 
				'description' => __( 'Disable padding of posts', 'forward' ) ), 
			
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Post Title', 'forward' ), 
				'param_name' => 'hide_post_title', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide the post title below the featured', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Link Title To Post', 'forward' ), 
				'param_name' => 'link_post_title', 
				'std' => 'yes', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes', __( 'No', 'forward' ) => 'no' ), 
				'description' => __( 'Choose if the title should be a link to the single post page.', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Thumbnail', 'forward' ), 
				'param_name' => 'hide_thumbnail', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide the post featured', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Excerpt', 'forward' ), 
				'param_name' => 'hide_excerpt', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'dependency' => array( 
					'element' => "layout", 
					'value' => array( 'default', 'medium', 'grid', 'masonry', 'zigzag', 'center' ) ), 
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
				'heading' => __( 'Hide Date', 'forward' ), 
				'param_name' => 'hide_date', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide date in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Timeline Month', 'forward' ), 
				'param_name' => 'hide_month', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'dependency' => array( 'element' => "layout", 'value' => array( 'timeline' ) ), 
				'description' => __( 'Hide timeline month', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Comment', 'forward' ), 
				'param_name' => 'hide_comment', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide comment in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Category', 'forward' ), 
				'param_name' => 'hide_category', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'description' => __( 'Hide category in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Author', 'forward' ), 
				'param_name' => 'hide_author', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'dependency' => array( 
					'element' => "layout", 
					'value' => array( 'default', 'medium', 'grid', 'masonry', 'zigzag', 'center' ) ), 
				'description' => __( 'Hide author in post meta info', 'forward' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Read More Link', 'forward' ), 
				'param_name' => 'hide_readmore', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ), 
				'dependency' => array( 
					'element' => "layout", 
					'value' => array( 'default', 'medium', 'grid', 'masonry', 'zigzag', 'center' ) ), 
				'description' => __( 'Choose to hide the link', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'heading' => __( 'Show Tags', 'forward' ), 
				'param_name' => 'show_tag', 
				'std' => 'no', 
				'value' => array( __( 'No', 'forward' ) => 'no', __( 'Yes', 'forward' ) => 'yes' ), 
				'dependency' => array( 
					'element' => "layout", 
					'value' => array( 'default', 'medium', 'grid', 'masonry', 'zigzag', 'center' ) ), 
				'description' => __( 'Choose to show the tags', 'forward' ) ), 
			array( 
				'type' => 'dropdown', 
				'std' => 'page_num', 
				'heading' => __( 'Pagination', 'forward' ), 
				'param_name' => 'pagination', 
				'value' => array( 
					__( 'Page Number', 'forward' ) => 'page_num', 
					__( 'Load More Button', 'forward' ) => 'loadmore', 
					__( 'Infinite Scrolling', 'forward' ) => 'infinite_scroll', 
					__( 'No', 'forward' ) => 'no' ), 
				'description' => __( 'Choose pagination type.', 'forward' ) ), 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Load More Button Text', 'forward' ), 
				'param_name' => 'loadmore_text', 
				'dependency' => array( 'element' => "pagination", 'value' => array( 'loadmore' ) ), 
				'value' => __( 'Load More', 'forward' ) ), 
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

class WPBakeryShortCode_DH_Post extends DHWPBakeryShortcode {
}