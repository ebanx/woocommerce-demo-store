<?php
vc_map( 
	array( 
		'base' => 'dh_carousel', 
		"category" => __( "Sitesao", 'forward' ), 
		'name' => __( 'Carousel Content', 'forward' ), 
		'description' => __( 'Animated carousel with carousel', 'forward' ), 
		'class' => 'dh-vc-element dh-vc-element-dh_carousel', 
		'icon' => 'dh-vc-icon-dh_carousel', 
		'show_settings_on_create' => true, 
		'is_container' => true, 
		'js_view' => 'DHVCCarousel', 
		'params' => array( 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Carousel Title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 
					'Enter text which will be used as widget title. Leave blank if no title is needed.', 
					'forward' ) ), 
			array( 
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
				'param_name' => 'visible', 
				'heading' => __( 'The number of visible items', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '1', 
				'data_min' => '1', 
				'data_max' => '6' ), 
			array( 
				'param_name' => 'scroll_speed', 
				'heading' => __( 'Transition Scroll Speed (ms)', 'forward' ), 
				'type' => 'ui_slider', 
				'value' => '700', 
				'data_min' => '100', 
				'data_step' => '100', 
				'data_max' => '3000' ), 
			
			array( 
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
				'type' => 'checkbox', 
				'heading' => __( 'Item no Padding ?', 'forward' ), 
				'param_name' => 'no_padding', 
				'description' => __( 'Item No Padding', 'forward' ), 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Autoplay ?', 'forward' ), 
				'param_name' => 'auto_play', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Slide Pagination ?', 'forward' ), 
				'param_name' => 'hide_pagination', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
			array( 
				'type' => 'checkbox', 
				'heading' => __( 'Hide Previous/Next Control ?', 'forward' ), 
				'param_name' => 'hide_control', 
				'value' => array( __( 'Yes,please', 'forward' ) => 'yes' ) ), 
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
					'forward' ) ) ), 
		"custom_markup" => '<div class="wpb_tabs_holder wpb_holder clearfix vc_container_for_children">
						  <ul class="tabs_controls">
						  </ul>
						  %content%
						  </div>', 
		'default_content' => '
					  [dh_carousel_item title="' .
			 __( 'Item 1', 'forward' ) . '" tab_id="' . time() . '-1-' . rand( 0, 100 ) .
			 '"][/dh_carousel_item]
					  [dh_carousel_item title="' .
			 __( 'Item 2', 'forward' ) . '" tab_id="' . time() . '-2-' . rand( 0, 100 ) .
			 '"][/dh_carousel_item]
					  [dh_carousel_item title="' .
			 __( 'Item 3', 'forward' ) . '" tab_id="' . time() . '-3-' . rand( 0, 100 ) . '"][/dh_carousel_item]
					  ' ) );
vc_map( 
	array( 
		'name' => __( 'Carousel Item', 'forward' ), 
		'base' => 'dh_carousel_item', 
		"category" => __( "Sitesao", 'forward' ), 
		'allowed_container_element' => 'vc_row', 
		'is_container' => true, 
		'content_element' => false, 
		'params' => array( 
			array( 
				'type' => 'textfield', 
				'heading' => __( 'Title', 'forward' ), 
				'param_name' => 'title', 
				'description' => __( 'Item title.', 'forward' ) ) ), 
		'js_view' => 'DHVCCarouselItem' ) );

class WPBakeryShortCode_DH_Carousel extends WPBakeryShortCode_VC_Tabs {

	static $filter_added = false;

	public function __construct( $settings ) {
		parent::__construct( $settings );
		// WPBakeryVisualComposer::getInstance()->addShortCode( array( 'base' => 'vc_tab' ) );
		if ( ! self::$filter_added ) {
			$this->addFilter( 'vc_inline_template_content', 'setCustomTabId' );
			self::$filter_added = true;
		}
	}

	protected $predefined_atts = array( 'tab_id' => DHVC_ITEM_TITLE, 'title' => '' );

	public function contentAdmin( $atts, $content = null ) {
		$width = $custom_markup = '';
		$shortcode_attributes = array( 'width' => '1/1' );
		foreach ( $this->settings['params'] as $param ) {
			if ( $param['param_name'] != 'content' ) {
				if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
					$shortcode_attributes[$param['param_name']] = $param['value'];
				} elseif ( isset( $param['value'] ) ) {
					$shortcode_attributes[$param['param_name']] = $param['value'];
				}
			} else 
				if ( $param['param_name'] == 'content' && $content == NULL ) {
					$content = $param['value'];
				}
		}
		extract( shortcode_atts( $shortcode_attributes, $atts ) );
		
		// Extract tab titles
		
		preg_match_all( 
			'/dh_carousel_item title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', 
			$content, 
			$matches, 
			PREG_OFFSET_CAPTURE );
		
		$output = '';
		$tab_titles = array();
		
		if ( isset( $matches[0] ) ) {
			$tab_titles = $matches[0];
		}
		$tmp = '';
		if ( count( $tab_titles ) ) {
			$tmp .= '<ul class="clearfix tabs_controls">';
			foreach ( $tab_titles as $tab ) {
				preg_match( 
					'/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', 
					$tab[0], 
					$tab_matches, 
					PREG_OFFSET_CAPTURE );
				if ( isset( $tab_matches[1][0] ) ) {
					$tmp .= '<li><a href="#tab-' .
						 ( isset( $tab_matches[3][0] ) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) .
						 '">' . $tab_matches[1][0] . '</a></li>';
				}
			}
			$tmp .= '</ul>' . "\n";
		} else {
			$output .= do_shortcode( $content );
		}
		$elem = $this->getElementHolder( $width );
		
		$iner = '';
		foreach ( $this->settings['params'] as $param ) {
			$custom_markup = '';
			$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
			if ( is_array( $param_value ) ) {
				// Get first element from the array
				reset( $param_value );
				$first_key = key( $param_value );
				$param_value = $param_value[$first_key];
			}
			$iner .= $this->singleParamHtmlHolder( $param, $param_value );
		}
		if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
			if ( $content != '' ) {
				$custom_markup = str_ireplace( "%content%", $tmp . $content, $this->settings["custom_markup"] );
			} else 
				if ( $content == '' && isset( $this->settings["default_content_in_template"] ) &&
					 $this->settings["default_content_in_template"] != '' ) {
					$custom_markup = str_ireplace( 
						"%content%", 
						$this->settings["default_content_in_template"], 
						$this->settings["custom_markup"] );
				} else {
					$custom_markup = str_ireplace( "%content%", '', $this->settings["custom_markup"] );
				}
			$iner .= do_shortcode( $custom_markup );
		}
		$elem = str_ireplace( '%wpb_element_content%', $iner, $elem );
		$output = $elem;
		
		return $output;
	}

	/**
	 * Find html template for shortcode output.
	 */
	protected function findShortcodeTemplate() {
		// Check template path in shortcode's mapping settings
		if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
			return $this->setTemplate( $this->settings['html_template'] );
		}
		// Check template in theme directory
		$user_template = vc_manager()->getShortcodesTemplateDir( $this->getFilename() . '.php' );
		if ( is_file( $user_template ) ) {
			return $this->setTemplate( $user_template );
		}
	}

	protected function getFileName() {
		return $this->shortcode;
	}

	public function getTabTemplate() {
		return '<div class="wpb_template">' .
			 do_shortcode( '[dh_carousel_item title="' . DHVC_ITEM_TITLE . '" tab_id=""][/dh_carousel_item]' ) . '</div>';
	}
}

class WPBakeryShortCode_DH_Carousel_Item extends WPBakeryShortCode_VC_Column {

	protected $controls_css_settings = 'tc vc_control-container';

	protected $controls_list = array( 'add', 'edit', 'clone', 'delete' );

	protected $predefined_atts = array( 'tab_id' => DHVC_ITEM_TITLE, 'title' => '' );

	protected $controls_template_file = 'editors/partials/backend_controls_tab.tpl.php';

	public function __construct( $settings ) {
		parent::__construct( $settings );
	}

	public function customAdminBlockParams() {
		return ' id="tab-' . $this->atts['tab_id'] . '"';
	}

	public function mainHtmlBlockParams( $width, $i ) {
		return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] .
			 ' wpb_sortable wpb_content_holder"' . $this->customAdminBlockParams();
	}

	public function containerHtmlBlockParams( $width, $i ) {
		return 'class="wpb_column_container vc_container_for_children"';
	}

	public function getColumnControls( $controls, $extended_css = '' ) {
		return $this->getColumnControlsModular( $extended_css );
	}

	/**
	 * Find html template for shortcode output.
	 */
	protected function findShortcodeTemplate() {
		// Check template path in shortcode's mapping settings
		if ( ! empty( $this->settings['html_template'] ) && is_file( $this->settings( 'html_template' ) ) ) {
			return $this->setTemplate( $this->settings['html_template'] );
		}
		// Check template in theme directory
		$user_template = vc_manager()->getShortcodesTemplateDir( $this->getFilename() . '.php' );
		if ( is_file( $user_template ) ) {
			return $this->setTemplate( $user_template );
		}
	}

	protected function getFileName() {
		return $this->shortcode;
	}
}