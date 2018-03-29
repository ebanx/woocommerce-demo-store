<?php
vc_map( 
	array( 
		'base' => 'dh_product_slider', 
		'name' => __( 'Product Slider', 'forward' ), 
		'description' => __( 'Animated products with carousel.', 'forward' ), 
		'as_parent' => array( 
			'only' => 'product_category,product_categories,dhwc_product_brands,dh_wc_product_sale_countdown,products,related_products,product_attribute,featured_products,top_rated_products,best_selling_products,sale_products,recent_products' ), 
		'content_element' => true, 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'js_view' => 'VcColumnView', 
		'show_settings_on_create' => true, 
		'params' => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Carousel Title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'Enter text which will be used as widget title. Leave blank if no title is needed.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'heading' => __( 'Title color', 'forward' ), 
				'param_name' => 'title_color', 
				'default', 
				'dependency' => array( 'element' => "title", 'not_empty' => true ), 
				'value' => array( 
					__( 'Default', 'forward' ) => 'default', 
					__( 'Primary', 'forward' ) => 'primary', 
					__( 'Success', 'forward' ) => 'success', 
					__( 'Info', 'forward' ) => 'info', 
					__( 'Warning', 'forward' ) => 'warning', 
					__( 'Danger', 'forward' ) => 'danger' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'heading' => __( 'Transition', 'forward' ), 
				'param_name' => 'fx', 
				'std' => 'scroll', 
				'value' => array( 
					'Scroll' => 'scroll', 
					'Directscroll' => 'directscroll', 
					'Fade' => 'fade', 
					'Cross fade' => 'crossfade', 
					'Cover' => 'cover', 
					'Cover fade' => 'cover-fade', 
					'Uncover' => 'cover-fade', 
					'Uncover fade' => 'uncover-fade' ), 
				'description' => __( 'Indicates which effect to use for the transition.', 'forward' ) ), 
			
			array( 
				'save_always' => true, 
				'param_name' => 'scroll_speed', 
				'heading' => __( 'Transition Scroll Speed (ms)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '700', 
				'data_min' => '100', 
				'data_step' => '100', 
				'data_max' => '3000' ), 
			
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Easing", 'forward' ), 
				"param_name" => "easing", 
				'std' => 'linear', 
				"value" => array( 
					'linear' => 'linear', 
					'swing' => 'swing', 
					'easeInQuad' => 'easeInQuad', 
					'easeOutQuad' => 'easeOutQuad', 
					'easeInOutQuad' => 'easeInOutQuad', 
					'easeInCubic' => 'easeInCubic', 
					'easeOutCubic' => 'easeOutCubic', 
					'easeInOutCubic' => 'easeInOutCubic', 
					'easeInQuart' => 'easeInQuart', 
					'easeOutQuart' => 'easeOutQuart', 
					'easeInOutQuart' => 'easeInOutQuart', 
					'easeInQuint' => 'easeInQuint', 
					'easeOutQuint' => 'easeOutQuint', 
					'easeInOutQuint' => 'easeInOutQuint', 
					'easeInExpo' => 'easeInExpo', 
					'easeOutExpo' => 'easeOutExpo', 
					'easeInOutExpo' => 'easeInOutExpo', 
					'easeInSine' => 'easeInSine', 
					'easeOutSine' => 'easeOutSine', 
					'easeInOutSine' => 'easeInOutSine', 
					'easeInCirc' => 'easeInCirc', 
					'easeOutCirc' => 'easeOutCirc', 
					'easeInOutCirc' => 'easeInOutCirc', 
					'easeInElastic' => 'easeInElastic', 
					'easeOutElastic' => 'easeOutElastic', 
					'easeInOutElastic' => 'easeInOutElastic', 
					'easeInBack' => 'easeInBack', 
					'easeOutBack' => 'easeOutBack', 
					'easeInOutBack' => 'easeInOutBack', 
					'easeInBounce' => 'easeInBounce', 
					'easeOutBounce' => 'easeOutBounce', 
					'easeInOutBounce' => 'easeInOutBounce' ), 
				"description" => __( 
					"Select the animation easing you would like for slide transitions <a href=\"http://jqueryui.com/resources/demos/effect/easing.html\" target=\"_blank\"> Click here </a> to see examples of these.", 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'checkbox', 
				'heading' => __( 'Item no Padding ?', 'forward' ), 
				'param_name' => 'no_padding', 
				'description' => __( 'Item No Padding', 'forward' ), 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'checkbox', 
				'heading' => __( 'Autoplay ?', 'forward' ), 
				'param_name' => 'auto_play', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Slide Pagination ?', 'forward' ), 
				'param_name' => 'hide_pagination', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Previous/Next Control ?', 'forward' ), 
				'param_name' => 'hide_control', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'heading' => __( 'Previous/Next Control Position', 'forward' ), 
				'param_name' => 'control_position', 
				'std' => 'default', 
				'dependency' => array( 'element' => "title", 'not_empty' => true ), 
				'value' => array( 
					__( 'Default', 'forward' ) => 'default', 
					__( 'Center with Title', 'forward' ) => 'center', 
					__( 'Right with Title', 'forward' ) => 'right' ) ), 
			array( 
				'save_always' => true, 
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
				'save_always' => true, 
				'param_name' => 'el_class', 
				'heading' => __( '(Optional) Extra class name', 'forward' ), 
				'type' => 'textfield', 
				
				"description" => __( 
					"If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'css_editor', 
				'heading' => __( 'Css', 'forward' ), 
				'param_name' => 'css', 
				'group' => __( 'Design options', 'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "Products Sales Countdown", 'forward' ), 
		"base" => "dh_wc_product_sale_countdown", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'List multiple products slider.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				"type" => "textfield", 
				"heading" => __( "Product Per Page", 'forward' ), 
				"param_name" => "posts_per_page", 
				"admin_label" => true, 
				"value" => 12 ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Columns", 'forward' ), 
				"param_name" => "columns", 
				"std" => 4, 
				"admin_label" => true, 
				"value" => array( 1, 2, 3, 4, 5, 6 ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Products Ordering", 'forward' ), 
				"param_name" => "orderby", 
				"value" => array( 
					__( 'Publish Date', 'forward' ) => 'date', 
					__( 'Modified Date', 'forward' ) => 'modified', 
					__( 'Random', 'forward' ) => 'rand', 
					__( 'Alphabetic', 'forward' ) => 'title', 
					__( 'Popularity', 'forward' ) => 'popularity', 
					__( 'Rate', 'forward' ) => 'rating', 
					__( 'Price', 'forward' ) => 'price' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				"heading" => __( "Ascending or Descending", 'forward' ), 
				"param_name" => "order", 
				"value" => array( __( 'Ascending', 'forward' ) => 'ASC', __( 'Descending', 'forward' ) => 'DESC' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "Product Masonry", 'forward' ), 
		"base" => "dh_wc_product_mansory", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'List products with Masonry layout.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'autocomplete', 
				"heading" => __( "Categories", 'forward' ), 
				'settings' => array( 'multiple' => true, 'sortable' => true ), 
				"param_name" => "category", 
				"admin_label" => true ), 
			array( 
				'save_always' => true, 
				"type" => "textfield", 
				"heading" => __( "Product Per Page", 'forward' ), 
				"param_name" => "per_page", 
				"admin_label" => true, 
				"value" => 12 ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Columns", 'forward' ), 
				"param_name" => "columns", 
				"std" => 4, 
				"admin_label" => true, 
				"value" => array( 2, 3, 4, 5, 6 ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'show', 
				'heading' => __( 'Show', 'forward' ), 
				
				'value' => array( 
					__( 'All Products', 'forward' ) => '', 
					__( 'Featured Products', 'forward' ) => 'featured', 
					__( 'On-sale Products', 'forward' ) => 'onsale' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'orderby', 
				'heading' => __( 'Order by', 'forward' ), 
				
				'std' => 'date', 
				'value' => array( 
					__( 'Date', 'forward' ) => 'date', 
					__( 'Price', 'forward' ) => 'price', 
					__( 'Random', 'forward' ) => 'rand', 
					__( 'Sales', 'forward' ) => 'sales' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'order', 
				'heading' => _x( 'Order', 'Sorting order', 'forward' ), 
				
				'std' => 'asc', 
				'value' => array( __( 'ASC', 'forward' ) => 'asc', __( 'DESC', 'forward' ) => 'desc' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'hide_all_filter', 
				'heading' => __( 'Hide All Filter Products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'hide_free', 
				'heading' => __( 'Hide free products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'show_hidden', 
				'heading' => __( 'Show hidden products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "Product Tab", 'forward' ), 
		"base" => "dh_wc_product_tab", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'List products with Tab layout.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'Enter text which will be used as widget title. Leave blank if no title is needed.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				"type" => "attach_image", 
				"heading" => __( "Title Badge", 'forward' ), 
				"param_name" => "title_badge", 
				"value" => "", 
				"description" => __( "Select image from media library.", 'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'colorpicker', 
				'heading' => __( 'Tab Color', 'forward' ), 
				'param_name' => 'tab_color', 
				'description' => __( 'Tab color.', 'forward' ) ), 
			array( 
				'save_always' => true, 
				"type" => "attach_image", 
				"heading" => __( "Tab Banner", 'forward' ), 
				"param_name" => "tab_banner", 
				"value" => "", 
				"description" => __( "Select image from media library.", 'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'href', 
				'dependency' => array( 'element' => 'tab_banner', 'not_empty' => true ), 
				'heading' => __( 'URL (Link)', 'forward' ), 
				'param_name' => 'href', 
				'description' => __( 'Banner link.', 'forward' ) ), 
			array( 
				'save_always' => true, 
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
				'save_always' => true, 
				'type' => 'autocomplete', 
				'heading' => __( 'Categories', 'forward' ), 
				'param_name' => 'category', 
				'admin_label' => true, 
				'settings' => array( 'multiple' => true, 'sortable' => true ), 
				'save_always' => true, 
				'description' => __( 'List of product categories', 'forward' ) ), 
			// array(
			// "type" => "product_category",
			// "heading" => __( "Categories", 'forward' ),
			// "param_name" => "category",
			// "admin_label" => true ),
			array( 
				'save_always' => true, 
				"type" => "textfield", 
				"heading" => __( "Product Per Page", 'forward' ), 
				"param_name" => "per_page", 
				"admin_label" => true, 
				"value" => 8 ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Columns", 'forward' ), 
				"param_name" => "columns", 
				"std" => 4, 
				"admin_label" => true, 
				"value" => array( 2, 3, 4, 5, 6 ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'show', 
				'heading' => __( 'Show', 'forward' ), 
				
				'value' => array( 
					__( 'All Products', 'forward' ) => '', 
					__( 'Featured Products', 'forward' ) => 'featured', 
					__( 'On-sale Products', 'forward' ) => 'onsale' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'orderby', 
				'heading' => __( 'Order by', 'forward' ), 
				
				'std' => 'date', 
				'value' => array( 
					__( 'Date', 'forward' ) => 'date', 
					__( 'Price', 'forward' ) => 'price', 
					__( 'Random', 'forward' ) => 'rand', 
					__( 'Sales', 'forward' ) => 'sales' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'order', 
				'heading' => _x( 'Order', 'Sorting order', 'forward' ), 
				
				'std' => 'asc', 
				'value' => array( __( 'ASC', 'forward' ) => 'asc', __( 'DESC', 'forward' ) => 'desc' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'hide_free', 
				'heading' => __( 'Hide free products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'show_hidden', 
				'heading' => __( 'Show hidden products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "Product Categories Grid", 'forward' ), 
		"base" => "dh_wc_product_categories_grid", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Display categories with grid layout.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				"type" => "product_category", 
				"heading" => __( "Categories", 'forward' ), 
				"param_name" => "ids", 
				'select_field' => 'id', 
				"admin_label" => true ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				'std' => '1', 
				"heading" => __( "Grid Style", 'forward' ), 
				"param_name" => "style", 
				'admin_label' => true, 
				"value" => array( 
					__( 'Style 1', 'forward' ) => '1', 
					__( 'Style 2', 'forward' ) => '2', 
					__( 'Style 3', 'forward' ) => '3', 
					__( 'Style 4', 'forward' ) => '4' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				'std' => '1', 
				"heading" => __( "Grid Gutter", 'forward' ), 
				"param_name" => "gutter", 
				"value" => array( __( 'Yes', 'forward' ) => '1', __( 'No', 'forward' ) => '0' ) ), 
			array( 
				'save_always' => true, 
				"type" => "textfield", 
				"heading" => __( "Number", 'forward' ), 
				"param_name" => "number", 
				"admin_label" => true, 
				'description' => __( 
					'You can specify the number of category to show (Leave blank to display all categories).', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Products Ordering", 'forward' ), 
				"param_name" => "orderby", 
				'std' => 'date', 
				"value" => array( 
					__( 'Category Order', 'forward' ) => 'order', 
					__( 'Name', 'forward' ) => 'name', 
					__( 'Term ID', 'forward' ) => 'term_id', 
					__( 'Taxonomy Count', 'forward' ) => 'count', 
					__( 'ID', 'forward' ) => 'id' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				'std' => 'ASC', 
				"heading" => __( "Ascending or Descending", 'forward' ), 
				"param_name" => "order", 
				"value" => array( __( 'Ascending', 'forward' ) => 'ASC', __( 'Descending', 'forward' ) => 'DESC' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				'std' => '1', 
				"heading" => __( "Hide Empty", 'forward' ), 
				"param_name" => "hide_empty", 
				"value" => array( __( 'Yes', 'forward' ) => '1', __( 'No', 'forward' ) => '0' ) ) ) ) );
if ( taxonomy_exists( 'product_lookbook' ) ) {
	vc_map( 
		array( 
			"name" => __( "Lookbooks", 'forward' ), 
			"base" => "dh_wc_lookbooks", 
			"category" => __( "WooCommerce", 'forward' ), 
			"icon" => "dh-vc-icon-dh_woo", 
			"class" => "dh-vc-element dh-vc-element-dh_woo", 
			'description' => __( 'List all lookbooks.', 'forward' ), 
			"params" => array( 
				array( 
					'save_always' => true, 
					'type' => 'autocomplete', 
					"heading" => __( "Look books", 'forward' ), 
					'settings' => array( 'multiple' => true, 'sortable' => true ), 
					"param_name" => "ids", 
					"admin_label" => true ), 
				array( 
					'type' => 'textfield', 
					'heading' => __( 'Extra class name', 'forward' ), 
					'param_name' => 'el_class', 
					'description' => __( 
						'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
						'forward' ) ), 
				array( 
					'type' => 'css_editor', 
					'heading' => __( 'Css', 'forward' ), 
					'param_name' => 'css', 
					'group' => __( 'Design options', 'forward' ) ) ) ) );
	vc_map( 
		array( 
			"name" => __( "Product Lookbooks", 'forward' ), 
			"base" => "dh_wc_product_lookbooks", 
			"category" => __( "WooCommerce", 'forward' ), 
			"icon" => "dh-vc-icon-dh_woo", 
			"class" => "dh-vc-element dh-vc-element-dh_woo", 
			'description' => __( 'List all products by lookbooks.', 'forward' ), 
			"params" => array( 
				array( 
					"type" => "dropdown", 
					"heading" => __( "Style", 'forward' ), 
					"param_name" => "style", 
					"std" => 'slider', 
					"admin_label" => true, 
					"value" => array( __( 'Slider','forward' ) => 'slider', __( 'Grid' ,'forward') => 'grid' ) ), 
				array( 
					'save_always' => true, 
					'type' => 'autocomplete', 
					"heading" => __( "Look books", 'forward' ), 
					'settings' => array( 'multiple' => true, 'sortable' => true ), 
					"param_name" => "ids", 
					"admin_label" => true ), 
				array( 
					'save_always' => true, 
					"type" => "dropdown", 
					"class" => "", 
					"heading" => __( "Products position", 'forward' ), 
					"param_name" => "thumbnail_position", 
					'std' => 'left', 
					"value" => array( __( 'Left', 'forward' ) => 'left', __( 'Right', 'forward' ) => 'right' ), 
					'description' => __( 'This setting only working when you select one Lookbooks', 'forward' ) ) ) ) );
}
if ( taxonomy_exists( 'product_brand' ) ) {
	vc_map( 
		array( 
			"name" => __( "Product Brands", 'forward' ), 
			"base" => "dhwc_product_brands", 
			"category" => __( "WooCommerce", 'forward' ), 
			"icon" => "dh-vc-icon-dh_woo", 
			"class" => "dh-vc-element dh-vc-element-dh_woo", 
			'description' => __( 'List all (or limited) product brands.', 'forward' ), 
			"params" => array( 
				array( 
					'save_always' => true, 
					"type" => "product_brand", 
					"heading" => __( "Brands", 'forward' ), 
					"param_name" => "ids", 
					"admin_label" => true ), 
				array( 
					'save_always' => true, 
					"type" => "textfield", 
					"heading" => __( "Number", 'forward' ), 
					"param_name" => "number", 
					"admin_label" => true, 
					'description' => __( 
						'You can specify the number of brand to show (Leave blank to display all brands).', 
						'forward' ) ), 
				array( 
					'save_always' => true, 
					"type" => "dropdown", 
					"heading" => __( "Columns", 'forward' ), 
					"param_name" => "columns", 
					"std" => 4, 
					"admin_label" => true, 
					"value" => array( 2, 3, 4, 5, 6 ) ), 
				array( 
					'save_always' => true, 
					"type" => "dropdown", 
					"heading" => __( "Products Ordering", 'forward' ), 
					"param_name" => "orderby", 
					'std' => 'date', 
					"value" => array( 
						__( 'Publish Date', 'forward' ) => 'date', 
						__( 'Modified Date', 'forward' ) => 'modified', 
						__( 'Random', 'forward' ) => 'rand', 
						__( 'Alphabetic', 'forward' ) => 'title', 
						__( 'Popularity', 'forward' ) => 'popularity', 
						__( 'Rate', 'forward' ) => 'rating', 
						__( 'Price', 'forward' ) => 'price' ) ), 
				array( 
					'save_always' => true, 
					"type" => "dropdown", 
					"class" => "", 
					'std' => 'ASC', 
					"heading" => __( "Ascending or Descending", 'forward' ), 
					"param_name" => "order", 
					"value" => array( __( 'Ascending', 'forward' ) => 'ASC', __( 'Descending', 'forward' ) => 'DESC' ) ), 
				array( 
					'save_always' => true, 
					"type" => "dropdown", 
					"class" => "", 
					'std' => '1', 
					"heading" => __( "Hide Empty", 'forward' ), 
					"param_name" => "hide_empty", 
					"value" => array( __( 'Yes', 'forward' ) => '1', __( 'No', 'forward' ) => '0' ) ) ) ) );
}
vc_map( 
	array( 
		"name" => __( "Add To Cart URL", 'forward' ), 
		"base" => "add_to_cart_url", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Show URL on the add to cart button.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				"type" => "products_ajax", 
				"heading" => __( "Select product", 'forward' ), 
				'single_select' => true, 
				'admin_label' => true, 
				"param_name" => "id" ) ) ) );
vc_map( 
	array( 
		"name" => __( "Products Grid", 'forward' ), 
		"base" => "dh_wc_products_grid", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'List multiple products grid shortcode.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textarea_html', 
				'holder' => 'div', 
				'heading' => __( 'Text Description', 'forward' ), 
				'param_name' => 'content', 
				'value' => __( 
					'<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				"type" => "attach_image", 
				"heading" => __( "Image Description", 'forward' ), 
				"param_name" => "image_desc", 
				"value" => "", 
				"description" => __( "Select image from media library.", 'forward' ) ), 
			array( 
				'save_always' => true, 
				"type" => "products_ajax", 
				"heading" => __( "Select products", 'forward' ), 
				"param_name" => "ids", 
				"admin_label" => true ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Products Ordering", 'forward' ), 
				"param_name" => "orderby", 
				'std' => 'date', 
				"value" => array( 
					__( 'Publish Date', 'forward' ) => 'date', 
					__( 'Modified Date', 'forward' ) => 'modified', 
					__( 'Random', 'forward' ) => 'rand', 
					__( 'Alphabetic', 'forward' ) => 'title', 
					__( 'Popularity', 'forward' ) => 'popularity', 
					__( 'Rate', 'forward' ) => 'rating', 
					__( 'Price', 'forward' ) => 'price' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				'std' => 'ASC', 
				"heading" => __( "Ascending or Descending", 'forward' ), 
				"param_name" => "order", 
				"value" => array( __( 'Ascending', 'forward' ) => 'ASC', __( 'Descending', 'forward' ) => 'DESC' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "Recent Products", 'forward' ), 
		"base" => "recent_products", 
		"category" => __( "WooCommerce", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Recent Products shortcode.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				"type" => "textfield", 
				"heading" => __( "Product Per Page", 'forward' ), 
				"param_name" => "per_page", 
				"admin_label" => true, 
				"value" => 12 ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Columns", 'forward' ), 
				"param_name" => "columns", 
				"std" => 4, 
				"admin_label" => true, 
				"value" => array( '', 1, 2, 3, 4, 5, 6 ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"heading" => __( "Products Ordering", 'forward' ), 
				"param_name" => "orderby", 
				'std' => 'date', 
				"value" => array( 
					__( 'Publish Date', 'forward' ) => 'date', 
					__( 'Modified Date', 'forward' ) => 'modified', 
					__( 'Random', 'forward' ) => 'rand', 
					__( 'Alphabetic', 'forward' ) => 'title', 
					__( 'Popularity', 'forward' ) => 'popularity', 
					__( 'Rate', 'forward' ) => 'rating', 
					__( 'Price', 'forward' ) => 'price' ) ), 
			array( 
				'save_always' => true, 
				"type" => "dropdown", 
				"class" => "", 
				'std' => 'ASC', 
				"heading" => __( "Ascending or Descending", 'forward' ), 
				"param_name" => "order", 
				"value" => array( __( 'Ascending', 'forward' ) => 'ASC', __( 'Descending', 'forward' ) => 'DESC' ) ) ) ) );

// Woocommerce Widgets
vc_map( 
	array( 
		"name" => __( "WC Cart", 'forward' ), 
		"base" => "dh_wc_cart", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Cart.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'hide_if_empty', 
				'heading' => __( 'Hide if cart is empty', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Layered Nav Filters", 'forward' ), 
		"base" => "dh_wc_layered_nav_filters", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Layered Nav Filters.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Active Filters', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );

$attribute_array = array();
$attribute_taxonomies = wc_get_attribute_taxonomies();
if ( $attribute_taxonomies )
	foreach ( $attribute_taxonomies as $tax )
		if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) )
			$attribute_array[$tax->attribute_name] = $tax->attribute_name;

vc_map( 
	array( 
		"name" => __( "WC Layered Nav", 'forward' ), 
		"base" => "dh_wc_layered_nav", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Layered Nav.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Filter by', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'attribute', 
				'heading' => __( 'Attribute', 'forward' ), 
				
				'value' => $attribute_array ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'display_type', 
				'std' => 'list', 
				'heading' => __( 'Display type', 'forward' ), 
				
				'value' => array( __( 'List', 'forward' ) => 'list', __( 'Dropdown', 'forward' ) => 'dropdown' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'query_type', 
				'heading' => __( 'Query type', 'forward' ), 
				
				'std' => 'and', 
				'value' => array( __( 'AND', 'forward' ) => 'and', __( 'OR', 'forward' ) => 'or' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Price Filter", 'forward' ), 
		"base" => "dh_wc_price_filter", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Price Filter.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Filter by price', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Product Categories", 'forward' ), 
		"base" => "dh_wc_product_categories", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Product Categories.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Product Categories', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'orderby', 
				'heading' => __( 'Order by', 'forward' ), 
				
				'std' => 'order', 
				'value' => array( __( 'Category Order', 'forward' ) => 'order', __( 'Name', 'forward' ) => 'name' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'dropdown', 
				'heading' => __( 'Show as dropdown', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'count', 
				'heading' => __( 'Show post counts', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'hierarchical', 
				'heading' => __( 'Show hierarchy', 'forward' ), 
				'type' => 'checkbox', 
				'std' => '1', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'show_children_only', 
				'heading' => __( 'Only show children of the current category', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Product Search", 'forward' ), 
		"base" => "dh_wc_product_search", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Product Search.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Search Products', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Product Tags", 'forward' ), 
		"base" => "dh_wc_product_tag_cloud", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Product Tags.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Product Tags', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Products", 'forward' ), 
		"base" => "dh_wc_products", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Products.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Products', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => 5, 
				'heading' => __( 'Number of products to show', 'forward' ), 
				'param_name' => 'number' ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'show', 
				'heading' => __( 'Show', 'forward' ), 
				
				'value' => array( 
					__( 'All Products', 'forward' ) => '', 
					__( 'Featured Products', 'forward' ) => 'featured', 
					__( 'On-sale Products', 'forward' ) => 'onsale' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'orderby', 
				'std' => 'date', 
				'heading' => __( 'Order by', 'forward' ), 
				
				'value' => array( 
					__( 'Date', 'forward' ) => 'date', 
					__( 'Price', 'forward' ) => 'price', 
					__( 'Random', 'forward' ) => 'rand', 
					__( 'Sales', 'forward' ) => 'sales' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'dropdown', 
				'param_name' => 'order', 
				'std' => 'asc', 
				'heading' => _x( 'Order', 'Sorting order', 'forward' ), 
				'value' => array( __( 'ASC', 'forward' ) => 'asc', __( 'DESC', 'forward' ) => 'desc' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'hide_free', 
				'heading' => __( 'Hide free products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'param_name' => 'show_hidden', 
				'heading' => __( 'Show hidden products', 'forward' ), 
				'type' => 'checkbox', 
				'value' => array( __( 'Yes,please', 'forward' ) => '1' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Recent Reviews", 'forward' ), 
		"base" => "dh_wc_recent_reviews", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Recent Reviews.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Recent Reviews', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => 5, 
				'heading' => __( 'Number of products to show', 'forward' ), 
				'param_name' => 'number' ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Recently Viewed", 'forward' ), 
		"base" => "dh_wc_recently_viewed_products", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Recently Viewed.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Recently Viewed Products', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => 5, 
				'heading' => __( 'Number of products to show', 'forward' ), 
				'param_name' => 'number' ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );
vc_map( 
	array( 
		"name" => __( "WC Top Rated Products", 'forward' ), 
		"base" => "dh_wc_top_rated_products", 
		"category" => __( "Woocommerce Widgets", 'forward' ), 
		"icon" => "dh-vc-icon-dh_woo", 
		"class" => "dh-vc-element dh-vc-element-dh_woo", 
		'description' => __( 'Woocommerce Widget Top Rated Products.', 'forward' ), 
		"params" => array( 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => __( 'Top Rated Products', 'forward' ), 
				'heading' => __( 'Widget title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'What text use as a widget title. Leave blank to use default widget title.', 
					'forward' ) ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'value' => 5, 
				'heading' => __( 'Number of products to show', 'forward' ), 
				'param_name' => 'number' ), 
			array( 
				'save_always' => true, 
				'type' => 'textfield', 
				'heading' => __( 'Extra class name', 'forward' ), 
				'param_name' => 'el_class', 
				'description' => __( 
					'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 
					'forward' ) ) ) ) );

class WPBakeryShortCode_DH_Product_Slider extends DHWPBakeryShortcodeContainer {
}

class WPBakeryShortCode_DH_WC_Cart extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Layered_Nav_Filters extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Layered_Nav extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Price_Filter extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Categories extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Lookbooks extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Lookbooks extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Search extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Tag_Cloud extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Mansory extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Tab extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Sale_Countdown extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Products extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Products_Grid extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Product_Categories_Grid extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Recent_Reviews extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Recently_Viewed_Products extends DHWPBakeryShortcode {
}

class WPBakeryShortCode_DH_WC_Top_Rated_Products extends DHWPBakeryShortcode {
}