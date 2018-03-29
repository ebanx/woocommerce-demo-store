<?php
/**
 *
 */
define( 'DHVC_ADD_ITEM_TITLE', __( "Add Item", 'forward' ) );
/**
 *
 */
define( 'DHVC_ITEM_TITLE', __( "Item", 'forward' ) );
/**
 *
 */
define( 'DHVC_MOVE_TITLE', __( 'Move', 'forward' ) );
/**
 *
 */
define( 'DHVC_ASSETS_URL', DHINC_URL . '/vc/assets' );

if(!class_exists('DHVC_Init')){
class DHVC_Init {
	
	private static $_instance;

	public function __construct() {
		
		add_action( 'init', array(&$this, 'init' ));
		add_action( 'init', array( &$this, 'includes' ), 20 );
		add_action( 'init', array( &$this, 'add_params' ), 50 );
		
		
		add_filter( 'vc_autocomplete_dh_wc_product_tab_category_callback', array(&$this,'productCategoryCategoryAutocompleteSuggester'), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_dh_wc_product_tab_category_render', array(&$this,'productCategoryCategoryRenderByIdExact'), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		
		add_filter( 'vc_autocomplete_dh_wc_product_mansory_category_callback', array(&$this,'productCategoryCategoryAutocompleteSuggester'), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_dh_wc_product_mansory_category_render', array(&$this,'productCategoryCategoryRenderByIdExact'), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		
		add_filter( 'vc_autocomplete_dh_wc_product_lookbooks_ids_callback', array(&$this,'productLookbooksAutocompleteSuggester'), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_dh_wc_product_lookbooks_ids_render', array(&$this,'productLookbooksRenderByIdExact'), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		add_filter( 'vc_autocomplete_dh_wc_lookbooks_ids_callback', array(&$this,'productLookbooksAutocompleteSuggester'), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_dh_wc_lookbooks_ids_render', array(&$this,'productLookbooksRenderByIdExact'), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		
		
		if ( is_admin() ) {
			add_filter( 'vc_iconpicker-type-elegant', array( &$this, 'iconpicker_type_elegant' ) );
			add_action( 'vc_backend_editor_render', array( &$this, 'enqueue_scripts' ), 100 );
			add_action( 'vc_backend_editor_enqueue_js_css',  array( &$this,'iconpicker_type_elegant_css' ));
			// add_action( 'admin_print_scripts-post-new.php', array( &$this, 'enqueue_scripts' ), 100 );
			
			$vc_params_js = DHVC_ASSETS_URL . '/js/vc-params.js';
			vc_add_shortcode_param( 'nullfield', array( &$this, 'nullfield_param' ), $vc_params_js );
			vc_add_shortcode_param( 'product_attribute_filter', array( &$this, 'product_attribute_filter_param' ), $vc_params_js );
			vc_add_shortcode_param( 'product_attribute', array( &$this, 'product_attribute_param' ), $vc_params_js );
			vc_add_shortcode_param( 'products_ajax', array( &$this, 'products_ajax_param' ), $vc_params_js );
			vc_add_shortcode_param( 'product_brand', array( &$this, 'product_brand_param' ), $vc_params_js );
			vc_add_shortcode_param( 'product_lookbook', array( &$this, 'product_lookbook_param' ), $vc_params_js );
			vc_add_shortcode_param( 'product_category', array( &$this, 'product_category_param' ), $vc_params_js );
			vc_add_shortcode_param( 'ui_datepicker', array( &$this, 'ui_datepicker_param' ) );
			vc_add_shortcode_param( 'post_category', array( &$this, 'post_category_param' ), $vc_params_js );
			vc_add_shortcode_param( 'ui_slider', array( &$this, 'ui_slider_param' ) );
			vc_add_shortcode_param( 'dropdown_group', array( &$this, 'dropdown_group_param' ) );
		}
	}
	
	public function productLookbooksAutocompleteSuggester($query, $slug = false){
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT a.term_id AS id, b.name as name, b.slug AS slug
				FROM {$wpdb->term_taxonomy} AS a
				INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
				WHERE a.taxonomy = 'product_lookbook' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
				$cat_id > 0 ? $cat_id : - 1,
				stripslashes( $query ),
				stripslashes( $query ) ),
				ARRAY_A );
			
		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = __( 'Id', 'forward' ) . ': ' . $value['id'] .
				( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'forward' ) . ': ' . $value['name'] : '' ) .
				( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'forward' ) . ': ' . $value['slug'] : '' );
				$result[] = $data;
			}
		}
			
		return $result;
	}
	
	public function productLookbooksRenderByIdExact($query){
		$query = $query['value'];
		$slug = $query;
		$term = get_term_by( 'id', $slug, 'product_lookbook' );
		return $this->_productTermOutput( $term,false);
	}
	
	public function includes( ) {
		$dir = dirname(__FILE__);
		include_once ($dir.'/shortcodes.php');
		
		$shortcode_dir = $dir.'/shortcodes';
		$maps = include ($dir.'/map.php');
		foreach ($maps as $map)
			include_once ($shortcode_dir.'/'.$map); 
		
		
		if(class_exists('WooCommerce'))
			include_once ($dir.'/woocommerce.php');
	}
	
	public static function getInstance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}
	
		return self::$_instance;
	}
	
	public function init(){
		if ( ! class_exists( 'WPBakeryShortCode_VC_Tabs', false ) )
			require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-tabs.php' );
		
		if ( ! class_exists( 'WPBakeryShortCode_VC_Column', false ) )
			require_once vc_path_dir( 'SHORTCODES_DIR', 'vc-column.php' );
		
		add_filter(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, array(&$this,'shortcode_custom_css'),10,3);
	}
	
	public function shortcode_custom_css( $class_to_filter, $shortcode, $atts ){
		if('vc_icon' === $shortcode && isset($atts['icon_custom_style']) && !empty($atts['icon_custom_style']))
			$class_to_filter .=' icon-custom-'.esc_attr($atts['icon_custom_style']);
		elseif ('vc_separator' === $shortcode  && isset($atts['style']) && $atts['style'] === 'inherit_theme')
			$class_to_filter .=' separator-inherit-theme';
		
		
		return $class_to_filter;
	}
	
	public function add_params() {
		
		vc_update_shortcode_param(
			'vc_separator',
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'forward' ),
				'param_name' => 'style',
				'value' => array_merge(getVcShared( 'separator styles' ),array( __( 'Inherit from Theme', 'forward' ) => 'inherit_theme' ) ),
				'description' => __( 'Separator display style.', 'forward' ),
		));
		vc_add_param(
			"vc_icon",
			array(
				'weight' => 9998,
				'type' => 'iconpicker',
				'heading' => __( 'Icon', 'forward' ),
				'param_name' => 'icon_elegant',
				'value' => 'elegant_arrow_up',
				'settings' => array( 'emptyIcon' => false, 'type' => 'elegant', 'iconsPerPage' => 4000 ),
				'dependency' => array( 'element' => 'type', 'value' => 'elegant' ),
				'description' => __( 'Select icon from library.', 'forward' ) ) );
		$vc_icon_lib_params = WPBMap::getParam('vc_icon', 'type');
		if(!empty($vc_icon_lib_params) && isset($vc_icon_lib_params['value'])){
			$vc_icon_lib = $vc_icon_lib_params['value'];
			$vc_icon_lib[__( 'Elegant', 'forward' )] = 'elegant';
			vc_update_shortcode_param(
				'vc_icon',
				array(
					'weight' => 9999,
					'type' => 'dropdown',
					'heading' => __( 'Icon library', 'forward' ),
					'value' => $vc_icon_lib,
					'admin_label' => true,
					'param_name' => 'type',
					'description' => __( 'Select icon library.', 'forward' ) ) );
		}
		
		vc_add_param("vc_row", array(
				"type" => "dropdown",
				"group" => __( 'Row Type', 'forward' ),
				"class" => "",
				"heading" => "Type",
				'std' => 'full_width',
				"param_name" => "wrap_type",
				"value" => array(
					__( "Full Width", 'forward' ) => "full_width",
					__( "In Container", 'forward' ) => "in_container" ) ) );
			
		vc_add_param("vc_row_inner",array(
				"type" => "dropdown",
				"group" => __( 'Row Type', 'forward' ),
				"class" => "",
				"heading" => "Type",
				"param_name" => "wrap_type",
				'std' => 'full_width',
				"value" => array(
					__( "Full Width", 'forward' ) => "full_width",
					__( "In Container", 'forward' ) => "in_container" ) ) );
		
		vc_add_param("vc_icon",array(
			"type" => "dropdown",
			"group" => __( 'Styles', 'forward' ),
			"class" => "",
			"heading" => "Style",
			"param_name" => "icon_custom_style",
			'std' => '',
			'admin_label'=>true,
			"value" => array(
				__( "Default", 'forward' ) => "",
				__( "Style 1", 'forward' ) => "style-1" ) ) );
	}

	public function post_category_param( $settings, $value ) {
		$dependency = vc_generate_dependencies_attributes( $settings );
		$categories = get_categories( array( 'orderby' => 'NAME', 'order' => 'ASC' ) );
		
		$class = 'dh-chosen-multiple-select';
		$selected_values = explode( ',', $value );
		$html = array();
		$html[] = '<div class="post_category_param">';
		$html[] = '<select id="' . $settings['param_name'] . '" ' .
			 ( isset( $settings['single_select'] ) ? '' : 'multiple="multiple"' ) . ' class="' . $class . '" ' .
			 $dependency . '>';
		$r = array();
		$r['pad_counts'] = 1;
		$r['hierarchical'] = 1;
		$r['hide_empty'] = 1;
		$r['show_count'] = 0;
		$r['selected'] = $selected_values;
		$r['menu_order'] = false;
		$html[] = dh_walk_category_dropdown_tree( $categories, 0, $r );
		$html[] = '</select>';
		$html[] = '<input id= "' . $settings['param_name'] .
			 '" type="hidden" class="wpb_vc_param_value dh-chosen-value wpb-textinput" name="' . $settings['param_name'] .
			 '" value="' . $value . '" />';
		$html[] = '</div>';
		
		return implode( "\n", $html );
	}

	public function dropdown_group_param( $param, $param_value ) {
		$css_option = vc_get_dropdown_option( $param, $param_value );
		$param_line = '';
		$param_line .= '<select name="' . $param['param_name'] .
			 '" class="dh-chosen-select wpb_vc_param_value wpb-input wpb-select ' . $param['param_name'] . ' ' .
			 $param['type'] . ' ' . $css_option . '" data-option="' . $css_option . '">';
		foreach ( $param['optgroup'] as $text_opt => $opt ) {
			if ( is_array( $opt ) ) {
				$param_line .= '<optgroup label="' . $text_opt . '">';
				foreach ( $opt as $text_val => $val ) {
					if ( is_numeric( $text_val ) && ( is_string( $val ) || is_numeric( $val ) ) ) {
						$text_val = $val;
					}
					$selected = '';
					if ( $param_value !== '' && (string) $val === (string) $param_value ) {
						$selected = ' selected="selected"';
					}
					$param_line .= '<option class="' . $val . '" value="' . $val . '"' . $selected . '>' .
						 htmlspecialchars( $text_val ) . '</option>';
				}
				$param_line .= '</optgroup>';
			} elseif ( is_string( $opt ) ) {
				if ( is_numeric( $text_opt ) && ( is_string( $opt ) || is_numeric( $opt ) ) ) {
					$text_opt = $opt;
				}
				$selected = '';
				if ( $param_value !== '' && (string) $opt === (string) $param_value ) {
					$selected = ' selected="selected"';
				}
				$param_line .= '<option class="' . $opt . '" value="' . $opt . '"' . $selected . '>' .
					 htmlspecialchars( $text_opt ) . '</option>';
			}
		}
		$param_line .= '</select>';
		return $param_line;
	}

	public function nullfield_param( $settings, $value ) {
		return '';
	}

	public function product_attribute_param( $settings, $value ) {
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) )
			return '';
		
		$output = '';
		$attributes = wc_get_attribute_taxonomies();
		$output .= '<select name= "' . $settings['param_name'] . '" data-placeholder="' .
			 __( 'Select Attibute', 'forward' ) .
			 '" class="dh-product-attribute dh-chosen-select wpb_vc_param_value wpb-input wpb-select ' .
			 $settings['param_name'] . ' ' . $settings['type'] . '">';
		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $attr ) :
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $attr->attribute_name ) ) ) {
					if ( $name = wc_attribute_taxonomy_name( $attr->attribute_name ) ) {
						$output .= '<option value="' . esc_attr( $name ) . '"' . selected( $value, $name, false ) . '>' .
							 $attr->attribute_name . '</option>';
					}
				}
			endforeach
			;
		}
		$output .= '</select>';
		return $output;
	}

	public function product_attribute_filter_param( $settings, $value ) {
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) )
			return '';
		
		$output = '';
		$args = array( 'orderby' => 'name', 'hide_empty' => false );
		$filter_ids = explode( ',', $value );
		$attributes = wc_get_attribute_taxonomies();
		$output .= '<select id= "' . $settings['param_name'] . '" multiple="multiple"  data-placeholder="' .
			 __( 'Select Attibute Filter', 'forward' ) .
			 '" class="dh-product-attribute-filter dh-chosen-multiple-select dh-chosen-select wpb_vc_param_value wpb-input wpb-select ' .
			 $settings['param_name'] . ' ' . $settings['type'] . '">';
		if ( ! empty( $attributes ) ) {
			foreach ( $attributes as $attr ) :
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $attr->attribute_name ) ) ) {
					if ( $name = wc_attribute_taxonomy_name( $attr->attribute_name ) ) {
						$terms = get_terms( $name, $args );
						if ( ! empty( $terms ) ) {
							foreach ( $terms as $term ) {
								$v = $term->slug;
								$output .= '<option data-attr="' . esc_attr( $name ) . '" value="' . esc_attr( $v ) . '"' .
									 selected( in_array( $v, $filter_ids ), true, false ) . '>' . esc_html( 
										$term->name ) . '</option>';
							}
						}
					}
				}
			endforeach
			;
		}
		$output .= '</select>';
		$output .= '<input id= "' . $settings['param_name'] .
			 '" type="hidden" class="wpb_vc_param_value wpb-textinput" name="' . $settings['param_name'] . '" value="' .
			 $value . '" />';
		return $output;
	}

	public function product_brand_param( $settings, $value ) {
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) )
			return '';
		$output = '';
		$brands_slugs = explode( ',', $value );
		$args = array( 'orderby' => 'name', 'hide_empty' => true );
		$brands = get_terms( 'product_brand', $args );
		$output .= '<select id= "' . $settings['param_name'] . '" multiple="multiple" data-placeholder="' .
			 __( 'Select brands', 'forward' ) . '" class="dh-chosen-multiple-select dh-chosen-select-nostd ' .
			 $settings['param_name'] . ' ' . $settings['type'] . '">';
		if ( ! empty( $brands ) ) {
			foreach ( $brands as $brand ) :
				$output .= '<option value="' . esc_attr( $brand->term_id ) . '"' .
					 selected( in_array( $brand->term_id, $brands_slugs ), true, false ) . '>' . esc_html( 
						$brand->name ) . '</option>';
			endforeach
			;
		}
		$output .= '</select>';
		$output .= '<input id= "' . $settings['param_name'] .
			 '" type="hidden" class="wpb_vc_param_value wpb-textinput" name="' . $settings['param_name'] . '" value="' .
			 $value . '" />';
		return $output;
	}

	public function product_lookbook_param( $settings, $value ) {
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) )
			return '';
		$output = '';
		$lookbook_slugs = explode( ',', $value );
		$args = array( 'orderby' => 'name', 'hide_empty' => false );
		$lookbooks = get_terms( 'product_lookbook', $args );
		$output .= '<select id= "' . $settings['param_name'] . '" multiple="multiple" data-placeholder="' .
			 __( 'Select lookbooks', 'forward' ) . '" class="dh-chosen-multiple-select dh-chosen-select-nostd ' .
			 $settings['param_name'] . ' ' . $settings['type'] . '">';
		if ( ! empty( $lookbooks ) ) {
			foreach ( $lookbooks as $lookbook ) :
				$output .= '<option value="' . esc_attr( $lookbook->term_id ) . '"' .
					 selected( in_array( $lookbook->term_id, $lookbook_slugs ), true, false ) . '>' .
					 esc_html( $lookbook->name ) . '</option>';
			endforeach
			;
		}
		$output .= '</select>';
		$output .= '<input id= "' . $settings['param_name'] .
			 '" type="hidden" class="wpb_vc_param_value wpb-textinput" name="' . $settings['param_name'] . '" value="' .
			 $value . '" />';
		return $output;
	}

	public function product_category_param( $settings, $value ) {
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) )
			return '';
		$output = '';
		$category_slugs = explode( ',', $value );
		$args = array( 'orderby' => 'name', 'hide_empty' => true );
		$categories = get_terms( 'product_cat', $args );
		$output .= '<select id= "' . $settings['param_name'] . '" multiple="multiple" data-placeholder="' .
			 __( 'Select categories', 'forward' ) . '" class="dh-chosen-multiple-select dh-chosen-select-nostd ' .
			 $settings['param_name'] . ' ' . $settings['type'] . '">';
		if ( ! empty( $categories ) ) {
			foreach ( $categories as $cat ) :
				$s = isset( $settings['select_field'] ) ? $cat->term_id : $cat->slug;
				$output .= '<option value="' . esc_attr( $s ) . '"' .
					 selected( in_array( $s, $category_slugs ), true, false ) . '>' . esc_html( $cat->name ) .
					 '</option>';
			endforeach
			;
		}
		$output .= '</select>';
		$output .= '<input id= "' . $settings['param_name'] .
			 '" type="hidden" class="wpb_vc_param_value wpb-textinput" name="' . $settings['param_name'] . '" value="' .
			 $value . '" />';
		return $output;
	}

	public function products_ajax_param( $settings, $value ) {
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) )
			return '';
		
		$product_ids = array();
		if ( ! empty( $value ) )
			$product_ids = array_map( 'absint', explode( ',', $value ) );
		
		$output = '<select data-placeholder="' . __( 'Search for a product...', 'forward' ) . '" id= "' .
			 $settings['param_name'] . '" ' . ( isset( $settings['single_select'] ) ? '' : 'multiple="multiple"' ) .
			 ' class="dh-chosen-multiple-select dh-chosen-ajax-select-product ' . $settings['param_name'] . ' ' .
			 $settings['type'] . '">';
		if ( isset( $settings['single_select'] ) ) {
			$output .= '<option value=""></option>';
		}
		if ( ! empty( $product_ids ) ) {
			foreach ( $product_ids as $product_id ) {
				$product = get_product( $product_id );
				if ( $product->get_sku() ) {
					$identifier = $product->get_sku();
				} else {
					$identifier = '#' . $product->id;
				}
				
				$product_name = sprintf( __( '%s &ndash; %s', 'forward' ), $identifier, $product->get_title() );
				
				$output .= '<option value="' . esc_attr( $product_id ) . '" selected="selected">' .
					 esc_html( $product_name ) . '</option>';
			}
		}
		$output .= '</select>';
		$output .= '<input id= "' . $settings['param_name'] .
			 '" type="hidden" class="wpb_vc_param_value wpb-textinput" name="' . $settings['param_name'] . '" value="' .
			 $value . '" />';
		
		return $output;
	}

	public function ui_datepicker_param( $param, $param_value ) {
		global $wp_scripts;
		$jquery_version = isset( $wp_scripts->registered['jquery-ui-core']->ver ) ? $wp_scripts->registered['jquery-ui-core']->ver : '1.9.2';
		
		
		$param_line = '';
		$value = $param_value;
		$value = htmlspecialchars( $value );
		$param_line .= '<input id="' . $param['param_name'] . '" name="' . $param['param_name'] .
			 '" readonly class="wpb_vc_param_value wpb-textinput ' . $param['param_name'] . ' ' . $param['type'] .
			 '" type="text" value="' . $value . '"/>';
		if ( ! defined( 'DH_UISLDER_PARAM' ) ) {
			define( 'DH_UISLDER_PARAM', 1 );
			$param_line .= '<link media="all" type="text/css" href="//code.jquery.com/ui/' . $jquery_version . '/themes/smoothness/jquery-ui.css" rel="stylesheet" />';
		}
		$param_line .= '<script>
					jQuery(function() {
					jQuery( "#' . $param['param_name'] . '" ).datepicker({showButtonPanel: true});
					});</script>
				';
		return $param_line;
	}

	public function ui_slider_param( $settings, $value ) {
		$data_min = ( isset( $settings['data_min'] ) && ! empty( $settings['data_min'] ) ) ? 'data-min="' .
			 absint( $settings['data_min'] ) . '"' : 'data-min="0"';
		$data_max = ( isset( $settings['data_max'] ) && ! empty( $settings['data_max'] ) ) ? 'data-max="' .
			 absint( $settings['data_max'] ) . '"' : 'data-max="100"';
		$data_step = ( isset( $settings['data_step'] ) && ! empty( $settings['data_step'] ) ) ? 'data-step="' .
			 absint( $settings['data_step'] ) . '"' : 'data-step="1"';
		
		return '<input name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' .
			 $settings['param_name'] . ' ' . $settings['type'] . '" type="text" value="' . $value . '"/>';
	}

	public function productCategoryCategoryAutocompleteSuggester( $query, $slug = true ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT a.term_id AS id, b.name as name, b.slug AS slug
				FROM {$wpdb->term_taxonomy} AS a
				INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
				WHERE a.taxonomy = 'product_cat' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
				$cat_id > 0 ? $cat_id : - 1,
				stripslashes( $query ),
				stripslashes( $query ) ),
				ARRAY_A );
	
		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = __( 'Id', 'forward' ) . ': ' . $value['id'] .
				( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'forward' ) . ': ' . $value['name'] : '' ) .
				( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'forward' ) . ': ' . $value['slug'] : '' );
				$result[] = $data;
			}
		}
	
		return $result;
	}
	
	public function productCategoryCategoryRenderByIdExact( $query ) {
		$query = $query['value'];
		$slug = $query;
		$term = get_term_by( 'slug', $slug, 'product_cat' );
		return $this->_productTermOutput( $term );
	}
	
	protected function _productTermOutput( $term,$use_slug = true) {
		$term_slug = $term->slug;
		$term_title = $term->name;
		$term_id = $term->term_id;
	
		$term_slug_display = '';
		if ( ! empty( $term_slug ) ) {
			$term_slug_display = ' - ' . __( 'Sku', 'forward' ) . ': ' . $term_slug;
		}
	
		$term_title_display = '';
		if ( ! empty( $term_title ) ) {
			$term_title_display = ' - ' . __( 'Title', 'forward' ) . ': ' . $term_title;
		}
	
		$term_id_display = __( 'Id', 'forward' ) . ': ' . $term_id;
	
		$data = array();
		$data['value'] = $use_slug ? $term_slug : $term_id;
		$data['label'] = $term_id_display . $term_title_display . $term_slug_display;
	
		return ! empty( $data ) ? $data : false;
	}

	public function iconpicker_type_elegant( $icons ) {
		$elegant_icons = array( 
			'elegant_arrow_up' => '&#x21;', 
			'elegant_arrow_down' => '&#x22;', 
			'elegant_arrow_left' => '&#x23;', 
			'elegant_arrow_right' => '&#x24;', 
			'elegant_arrow_left-up' => '&#x25;', 
			'elegant_arrow_right-up' => '&#x26;', 
			'elegant_arrow_right-down' => '&#x27;', 
			'elegant_arrow_left-down' => '&#x28;', 
			'elegant_arrow-up-down' => '&#x29;', 
			'elegant_arrow_up-down_alt' => '&#x2a;', 
			'elegant_arrow_left-right_alt' => '&#x2b;', 
			'elegant_arrow_left-right' => '&#x2c;', 
			'elegant_arrow_expand_alt2' => '&#x2d;', 
			'elegant_arrow_expand_alt' => '&#x2e;', 
			'elegant_arrow_condense' => '&#x2f;', 
			'elegant_arrow_expand' => '&#x30;', 
			'elegant_arrow_move' => '&#x31;', 
			'elegant_arrow_carrot-up' => '&#x32;', 
			'elegant_arrow_carrot-down' => '&#x33;', 
			'elegant_arrow_carrot-left' => '&#x34;', 
			'elegant_arrow_carrot-right' => '&#x35;', 
			'elegant_arrow_carrot-2up' => '&#x36;', 
			'elegant_arrow_carrot-2down' => '&#x37;', 
			'elegant_arrow_carrot-2left' => '&#x38;', 
			'elegant_arrow_carrot-2right' => '&#x39;', 
			'elegant_arrow_carrot-up_alt2' => '&#x3a;', 
			'elegant_arrow_carrot-down_alt2' => '&#x3b;', 
			'elegant_arrow_carrot-left_alt2' => '&#x3c;', 
			'elegant_arrow_carrot-right_alt2' => '&#x3d;', 
			'elegant_arrow_carrot-2up_alt2' => '&#x3e;', 
			'elegant_arrow_carrot-2down_alt2' => '&#x3f;', 
			'elegant_arrow_carrot-2left_alt2' => '&#x40;', 
			'elegant_arrow_carrot-2right_alt2' => '&#x41;', 
			'elegant_arrow_triangle-up' => '&#x42;', 
			'elegant_arrow_triangle-down' => '&#x43;', 
			'elegant_arrow_triangle-left' => '&#x44;', 
			'elegant_arrow_triangle-right' => '&#x45;', 
			'elegant_arrow_triangle-up_alt2' => '&#x46;', 
			'elegant_arrow_triangle-down_alt2' => '&#x47;', 
			'elegant_arrow_triangle-left_alt2' => '&#x48;', 
			'elegant_arrow_triangle-right_alt2' => '&#x49;', 
			'elegant_arrow_back' => '&#x4a;', 
			'elegant_icon_minus-06' => '&#x4b;', 
			'elegant_icon_plus' => '&#x4c;', 
			'elegant_icon_close' => '&#x4d;', 
			'elegant_icon_check' => '&#x4e;', 
			'elegant_icon_minus_alt2' => '&#x4f;', 
			'elegant_icon_plus_alt2' => '&#x50;', 
			'elegant_icon_close_alt2' => '&#x51;', 
			'elegant_icon_check_alt2' => '&#x52;', 
			'elegant_icon_zoom-out_alt' => '&#x53;', 
			'elegant_icon_zoom-in_alt' => '&#x54;', 
			'elegant_icon_search' => '&#x55;', 
			'elegant_icon_box-empty' => '&#x56;', 
			'elegant_icon_box-selected' => '&#x57;', 
			'elegant_icon_minus-box' => '&#x58;', 
			'elegant_icon_plus-box' => '&#x59;', 
			'elegant_icon_box-checked' => '&#x5a;', 
			'elegant_icon_circle-empty' => '&#x5b;', 
			'elegant_icon_circle-slelected' => '&#x5c;', 
			'elegant_icon_stop_alt2' => '&#x5d;', 
			'elegant_icon_stop' => '&#x5e;', 
			'elegant_icon_pause_alt2' => '&#x5f;', 
			'elegant_icon_pause' => '&#x60;', 
			'elegant_icon_menu' => '&#x61;', 
			'elegant_icon_menu-square_alt2' => '&#x62;', 
			'elegant_icon_menu-circle_alt2' => '&#x63;', 
			'elegant_icon_ul' => '&#x64;', 
			'elegant_icon_ol' => '&#x65;', 
			'elegant_icon_adjust-horiz' => '&#x66;', 
			'elegant_icon_adjust-vert' => '&#x67;', 
			'elegant_icon_document_alt' => '&#x68;', 
			'elegant_icon_documents_alt' => '&#x69;', 
			'elegant_icon_pencil' => '&#x6a;', 
			'elegant_icon_pencil-edit_alt' => '&#x6b;', 
			'elegant_icon_pencil-edit' => '&#x6c;', 
			'elegant_icon_folder-alt' => '&#x6d;', 
			'elegant_icon_folder-open_alt' => '&#x6e;', 
			'elegant_icon_folder-add_alt' => '&#x6f;', 
			'elegant_icon_info_alt' => '&#x70;', 
			'elegant_icon_error-oct_alt' => '&#x71;', 
			'elegant_icon_error-circle_alt' => '&#x72;', 
			'elegant_icon_error-triangle_alt' => '&#x73;', 
			'elegant_icon_question_alt2' => '&#x74;', 
			'elegant_icon_question' => '&#x75;', 
			'elegant_icon_comment_alt' => '&#x76;', 
			'elegant_icon_chat_alt' => '&#x77;', 
			'elegant_icon_vol-mute_alt' => '&#x78;', 
			'elegant_icon_volume-low_alt' => '&#x79;', 
			'elegant_icon_volume-high_alt' => '&#x7a;', 
			'elegant_icon_quotations' => '&#x7b;', 
			'elegant_icon_quotations_alt2' => '&#x7c;', 
			'elegant_icon_clock_alt' => '&#x7d;', 
			'elegant_icon_lock_alt' => '&#x7e;', 
			'elegant_icon_lock-open_alt' => '&#xe000;', 
			'elegant_icon_key_alt' => '&#xe001;', 
			'elegant_icon_cloud_alt' => '&#xe002;', 
			'elegant_icon_cloud-upload_alt' => '&#xe003;', 
			'elegant_icon_cloud-download_alt' => '&#xe004;', 
			'elegant_icon_image' => '&#xe005;', 
			'elegant_icon_images' => '&#xe006;', 
			'elegant_icon_lightbulb_alt' => '&#xe007;', 
			'elegant_icon_gift_alt' => '&#xe008;', 
			'elegant_icon_house_alt' => '&#xe009;', 
			'elegant_icon_genius' => '&#xe00a;', 
			'elegant_icon_mobile' => '&#xe00b;', 
			'elegant_icon_tablet' => '&#xe00c;', 
			'elegant_icon_laptop' => '&#xe00d;', 
			'elegant_icon_desktop' => '&#xe00e;', 
			'elegant_icon_camera_alt' => '&#xe00f;', 
			'elegant_icon_mail_alt' => '&#xe010;', 
			'elegant_icon_cone_alt' => '&#xe011;', 
			'elegant_icon_ribbon_alt' => '&#xe012;', 
			'elegant_icon_bag_alt' => '&#xe013;', 
			'elegant_icon_creditcard' => '&#xe014;', 
			'elegant_icon_cart_alt' => '&#xe015;', 
			'elegant_icon_paperclip' => '&#xe016;', 
			'elegant_icon_tag_alt' => '&#xe017;', 
			'elegant_icon_tags_alt' => '&#xe018;', 
			'elegant_icon_trash_alt' => '&#xe019;', 
			'elegant_icon_cursor_alt' => '&#xe01a;', 
			'elegant_icon_mic_alt' => '&#xe01b;', 
			'elegant_icon_compass_alt' => '&#xe01c;', 
			'elegant_icon_pin_alt' => '&#xe01d;', 
			'elegant_icon_pushpin_alt' => '&#xe01e;', 
			'elegant_icon_map_alt' => '&#xe01f;', 
			'elegant_icon_drawer_alt' => '&#xe020;', 
			'elegant_icon_toolbox_alt' => '&#xe021;', 
			'elegant_icon_book_alt' => '&#xe022;', 
			'elegant_icon_calendar' => '&#xe023;', 
			'elegant_icon_film' => '&#xe024;', 
			'elegant_icon_table' => '&#xe025;', 
			'elegant_icon_contacts_alt' => '&#xe026;', 
			'elegant_icon_headphones' => '&#xe027;', 
			'elegant_icon_lifesaver' => '&#xe028;', 
			'elegant_icon_piechart' => '&#xe029;', 
			'elegant_icon_refresh' => '&#xe02a;', 
			'elegant_icon_link_alt' => '&#xe02b;', 
			'elegant_icon_link' => '&#xe02c;', 
			'elegant_icon_loading' => '&#xe02d;', 
			'elegant_icon_blocked' => '&#xe02e;', 
			'elegant_icon_archive_alt' => '&#xe02f;', 
			'elegant_icon_heart_alt' => '&#xe030;', 
			'elegant_icon_star_alt' => '&#xe031;', 
			'elegant_icon_star-half_alt' => '&#xe032;', 
			'elegant_icon_star' => '&#xe033;', 
			'elegant_icon_star-half' => '&#xe034;', 
			'elegant_icon_tools' => '&#xe035;', 
			'elegant_icon_tool' => '&#xe036;', 
			'elegant_icon_cog' => '&#xe037;', 
			'elegant_icon_cogs' => '&#xe038;', 
			'elegant_arrow_up_alt' => '&#xe039;', 
			'elegant_arrow_down_alt' => '&#xe03a;', 
			'elegant_arrow_left_alt' => '&#xe03b;', 
			'elegant_arrow_right_alt' => '&#xe03c;', 
			'elegant_arrow_left-up_alt' => '&#xe03d;', 
			'elegant_arrow_right-up_alt' => '&#xe03e;', 
			'elegant_arrow_right-down_alt' => '&#xe03f;', 
			'elegant_arrow_left-down_alt' => '&#xe040;', 
			'elegant_arrow_condense_alt' => '&#xe041;', 
			'elegant_arrow_expand_alt3' => '&#xe042;', 
			'elegant_arrow_carrot_up_alt' => '&#xe043;', 
			'elegant_arrow_carrot-down_alt' => '&#xe044;', 
			'elegant_arrow_carrot-left_alt' => '&#xe045;', 
			'elegant_arrow_carrot-right_alt' => '&#xe046;', 
			'elegant_arrow_carrot-2up_alt' => '&#xe047;', 
			'elegant_arrow_carrot-2dwnn_alt' => '&#xe048;', 
			'elegant_arrow_carrot-2left_alt' => '&#xe049;', 
			'elegant_arrow_carrot-2right_alt' => '&#xe04a;', 
			'elegant_arrow_triangle-up_alt' => '&#xe04b;', 
			'elegant_arrow_triangle-down_alt' => '&#xe04c;', 
			'elegant_arrow_triangle-left_alt' => '&#xe04d;', 
			'elegant_arrow_triangle-right_alt' => '&#xe04e;', 
			'elegant_icon_minus_alt' => '&#xe04f;', 
			'elegant_icon_plus_alt' => '&#xe050;', 
			'elegant_icon_close_alt' => '&#xe051;', 
			'elegant_icon_check_alt' => '&#xe052;', 
			'elegant_icon_zoom-out' => '&#xe053;', 
			'elegant_icon_zoom-in' => '&#xe054;', 
			'elegant_icon_stop_alt' => '&#xe055;', 
			'elegant_icon_menu-square_alt' => '&#xe056;', 
			'elegant_icon_menu-circle_alt' => '&#xe057;', 
			'elegant_icon_document' => '&#xe058;', 
			'elegant_icon_documents' => '&#xe059;', 
			'elegant_icon_pencil_alt' => '&#xe05a;', 
			'elegant_icon_folder' => '&#xe05b;', 
			'elegant_icon_folder-open' => '&#xe05c;', 
			'elegant_icon_folder-add' => '&#xe05d;', 
			'elegant_icon_folder_upload' => '&#xe05e;', 
			'elegant_icon_folder_download' => '&#xe05f;', 
			'elegant_icon_info' => '&#xe060;', 
			'elegant_icon_error-circle' => '&#xe061;', 
			'elegant_icon_error-oct' => '&#xe062;', 
			'elegant_icon_error-triangle' => '&#xe063;', 
			'elegant_icon_question_alt' => '&#xe064;', 
			'elegant_icon_comment' => '&#xe065;', 
			'elegant_icon_chat' => '&#xe066;', 
			'elegant_icon_vol-mute' => '&#xe067;', 
			'elegant_icon_volume-low' => '&#xe068;', 
			'elegant_icon_volume-high' => '&#xe069;', 
			'elegant_icon_quotations_alt' => '&#xe06a;', 
			'elegant_icon_clock' => '&#xe06b;', 
			'elegant_icon_lock' => '&#xe06c;', 
			'elegant_icon_lock-open' => '&#xe06d;', 
			'elegant_icon_key' => '&#xe06e;', 
			'elegant_icon_cloud' => '&#xe06f;', 
			'elegant_icon_cloud-upload' => '&#xe070;', 
			'elegant_icon_cloud-download' => '&#xe071;', 
			'elegant_icon_lightbulb' => '&#xe072;', 
			'elegant_icon_gift' => '&#xe073;', 
			'elegant_icon_house' => '&#xe074;', 
			'elegant_icon_camera' => '&#xe075;', 
			'elegant_icon_mail' => '&#xe076;', 
			'elegant_icon_cone' => '&#xe077;', 
			'elegant_icon_ribbon' => '&#xe078;', 
			'elegant_icon_bag' => '&#xe079;', 
			'elegant_icon_cart' => '&#xe07a;', 
			'elegant_icon_tag' => '&#xe07b;', 
			'elegant_icon_tags' => '&#xe07c;', 
			'elegant_icon_trash' => '&#xe07d;', 
			'elegant_icon_cursor' => '&#xe07e;', 
			'elegant_icon_mic' => '&#xe07f;', 
			'elegant_icon_compass' => '&#xe080;', 
			'elegant_icon_pin' => '&#xe081;', 
			'elegant_icon_pushpin' => '&#xe082;', 
			'elegant_icon_map' => '&#xe083;', 
			'elegant_icon_drawer' => '&#xe084;', 
			'elegant_icon_toolbox' => '&#xe085;', 
			'elegant_icon_book' => '&#xe086;', 
			'elegant_icon_contacts' => '&#xe087;', 
			'elegant_icon_archive' => '&#xe088;', 
			'elegant_icon_heart' => '&#xe089;', 
			'elegant_icon_profile' => '&#xe08a;', 
			'elegant_icon_group' => '&#xe08b;', 
			'elegant_icon_grid-2x2' => '&#xe08c;', 
			'elegant_icon_grid-3x3' => '&#xe08d;', 
			'elegant_icon_music' => '&#xe08e;', 
			'elegant_icon_pause_alt' => '&#xe08f;', 
			'elegant_icon_phone' => '&#xe090;', 
			'elegant_icon_upload' => '&#xe091;', 
			'elegant_icon_download' => '&#xe092;', 
			'elegant_social_facebook' => '&#xe093;', 
			'elegant_social_twitter' => '&#xe094;', 
			'elegant_social_pinterest' => '&#xe095;', 
			'elegant_social_googleplus' => '&#xe096;', 
			'elegant_social_tumblr' => '&#xe097;', 
			'elegant_social_tumbleupon' => '&#xe098;', 
			'elegant_social_wordpress' => '&#xe099;', 
			'elegant_social_instagram' => '&#xe09a;', 
			'elegant_social_dribbble' => '&#xe09b;', 
			'elegant_social_vimeo' => '&#xe09c;', 
			'elegant_social_linkedin' => '&#xe09d;', 
			'elegant_social_rss' => '&#xe09e;', 
			'elegant_social_deviantart' => '&#xe09f;', 
			'elegant_social_share' => '&#xe0a0;', 
			'elegant_social_myspace' => '&#xe0a1;', 
			'elegant_social_skype' => '&#xe0a2;', 
			'elegant_social_youtube' => '&#xe0a3;', 
			'elegant_social_picassa' => '&#xe0a4;', 
			'elegant_social_googledrive' => '&#xe0a5;', 
			'elegant_social_flickr' => '&#xe0a6;', 
			'elegant_social_blogger' => '&#xe0a7;', 
			'elegant_social_spotify' => '&#xe0a8;', 
			'elegant_social_delicious' => '&#xe0a9;', 
			'elegant_social_facebook_circle' => '&#xe0aa;', 
			'elegant_social_twitter_circle' => '&#xe0ab;', 
			'elegant_social_pinterest_circle' => '&#xe0ac;', 
			'elegant_social_googleplus_circle' => '&#xe0ad;', 
			'elegant_social_tumblr_circle' => '&#xe0ae;', 
			'elegant_social_stumbleupon_circle' => '&#xe0af;', 
			'elegant_social_wordpress_circle' => '&#xe0b0;', 
			'elegant_social_instagram_circle' => '&#xe0b1;', 
			'elegant_social_dribbble_circle' => '&#xe0b2;', 
			'elegant_social_vimeo_circle' => '&#xe0b3;', 
			'elegant_social_linkedin_circle' => '&#xe0b4;', 
			'elegant_social_rss_circle' => '&#xe0b5;', 
			'elegant_social_deviantart_circle' => '&#xe0b6;', 
			'elegant_social_share_circle' => '&#xe0b7;', 
			'elegant_social_myspace_circle' => '&#xe0b8;', 
			'elegant_social_skype_circle' => '&#xe0b9;', 
			'elegant_social_youtube_circle' => '&#xe0ba;', 
			'elegant_social_picassa_circle' => '&#xe0bb;', 
			'elegant_social_googledrive_alt2' => '&#xe0bc;', 
			'elegant_social_flickr_circle' => '&#xe0bd;', 
			'elegant_social_blogger_circle' => '&#xe0be;', 
			'elegant_social_spotify_circle' => '&#xe0bf;', 
			'elegant_social_delicious_circle' => '&#xe0c0;', 
			'elegant_social_facebook_square' => '&#xe0c1;', 
			'elegant_social_twitter_square' => '&#xe0c2;', 
			'elegant_social_pinterest_square' => '&#xe0c3;', 
			'elegant_social_googleplus_square' => '&#xe0c4;', 
			'elegant_social_tumblr_square' => '&#xe0c5;', 
			'elegant_social_stumbleupon_square' => '&#xe0c6;', 
			'elegant_social_wordpress_square' => '&#xe0c7;', 
			'elegant_social_instagram_square' => '&#xe0c8;', 
			'elegant_social_dribbble_square' => '&#xe0c9;', 
			'elegant_social_vimeo_square' => '&#xe0ca;', 
			'elegant_social_linkedin_square' => '&#xe0cb;', 
			'elegant_social_rss_square' => '&#xe0cc;', 
			'elegant_social_deviantart_square' => '&#xe0cd;', 
			'elegant_social_share_square' => '&#xe0ce;', 
			'elegant_social_myspace_square' => '&#xe0cf;', 
			'elegant_social_skype_square' => '&#xe0d0;', 
			'elegant_social_youtube_square' => '&#xe0d1;', 
			'elegant_social_picassa_square' => '&#xe0d2;', 
			'elegant_social_googledrive_square' => '&#xe0d3;', 
			'elegant_social_flickr_square' => '&#xe0d4;', 
			'elegant_social_blogger_square' => '&#xe0d5;', 
			'elegant_social_spotify_square' => '&#xe0d6;', 
			'elegant_social_delicious_square' => '&#xe0d7;', 
			'elegant_icon_printer' => '&#xe103;', 
			'elegant_icon_calulator' => '&#xe0ee;', 
			'elegant_icon_building' => '&#xe0ef;', 
			'elegant_icon_floppy' => '&#xe0e8;', 
			'elegant_icon_drive' => '&#xe0ea;', 
			'elegant_icon_search-2' => '&#xe101;', 
			'elegant_icon_id' => '&#xe107;', 
			'elegant_icon_id-2' => '&#xe108;', 
			'elegant_icon_puzzle' => '&#xe102;', 
			'elegant_icon_like' => '&#xe106;', 
			'elegant_icon_dislike' => '&#xe0eb;', 
			'elegant_icon_mug' => '&#xe105;', 
			'elegant_icon_currency' => '&#xe0ed;', 
			'elegant_icon_wallet' => '&#xe100;', 
			'elegant_icon_pens' => '&#xe104;', 
			'elegant_icon_easel' => '&#xe0e9;', 
			'elegant_icon_flowchart' => '&#xe109;', 
			'elegant_icon_datareport' => '&#xe0ec;', 
			'elegant_icon_briefcase' => '&#xe0fe;', 
			'elegant_icon_shield' => '&#xe0f6;', 
			'elegant_icon_percent' => '&#xe0fb;', 
			'elegant_icon_globe' => '&#xe0e2;', 
			'elegant_icon_globe-2' => '&#xe0e3;', 
			'elegant_icon_target' => '&#xe0f5;', 
			'elegant_icon_hourglass' => '&#xe0e1;', 
			'elegant_icon_balance' => '&#xe0ff;', 
			'elegant_icon_rook' => '&#xe0f8;', 
			'elegant_icon_printer-alt' => '&#xe0fa;', 
			'elegant_icon_calculator_alt' => '&#xe0e7;', 
			'elegant_icon_building_alt' => '&#xe0fd;', 
			'elegant_icon_floppy_alt' => '&#xe0e4;', 
			'elegant_icon_drive_alt' => '&#xe0e5;', 
			'elegant_icon_search_alt' => '&#xe0f7;', 
			'elegant_icon_id_alt' => '&#xe0e0;', 
			'elegant_icon_id-2_alt' => '&#xe0fc;', 
			'elegant_icon_puzzle_alt' => '&#xe0f9;', 
			'elegant_icon_like_alt' => '&#xe0dd;', 
			'elegant_icon_dislike_alt' => '&#xe0f1;', 
			'elegant_icon_mug_alt' => '&#xe0dc;', 
			'elegant_icon_currency_alt' => '&#xe0f3;', 
			'elegant_icon_wallet_alt' => '&#xe0d8;', 
			'elegant_icon_pens_alt' => '&#xe0db;', 
			'elegant_icon_easel_alt' => '&#xe0f0;', 
			'elegant_icon_flowchart_alt' => '&#xe0df;', 
			'elegant_icon_datareport_alt' => '&#xe0f2;', 
			'elegant_icon_briefcase_alt' => '&#xe0f4;', 
			'elegant_icon_shield_alt' => '&#xe0d9;', 
			'elegant_icon_percent_alt' => '&#xe0da;', 
			'elegant_icon_globe_alt' => '&#xe0de;', 
			'elegant_icon_clipboard' => '&#xe0e6;' );
		$elegant_icon_arr = array();
		foreach ( $elegant_icons as $key => $elegant_icon ) {
			$label = str_replace( 'elegant_', '', $key );
			$label = str_replace( '_', ' ', $label );
			$elegant_icon_arr[] = array($key=>$label);
		}
		return array_merge( $icons, $elegant_icon_arr );
	}
	
	public function iconpicker_type_elegant_css(){
		wp_enqueue_style('elegant-icon');
	}

	public function enqueue_scripts() {
		$pricing_table_feature_tmpl = '';
		$pricing_table_feature_tmpl .= '<tr><td><textarea id="content"></textarea></td><td align="left" style="padding:5px;"><a href="#" class="pricing-table-feature-remove" onclick="return pricing_table_feature_remove(this);"  title="' .esc_attr__( 'Remove', 'forward' ) . '">-</a></td></tr>';
		wp_enqueue_style( 'dh-vc-admin', DHVC_ASSETS_URL . '/css/vc-admin.css', array( 'font-awesome', 'elegant-icon', 'chosen' ), '1.0.0' );
		wp_register_script( 'dh-vc-custom', DHVC_ASSETS_URL . '/js/vc-custom.js', array( 'jquery', 'jquery-ui-datepicker' ), '1.0.0', true );
		$dhvcL10n = array( 
			'pricing_table_max_item_msg' => esc_attr__( 'Pricing Table element only support display 5 item', 'forward' ), 
			'item_title' => DHVC_ITEM_TITLE, 
			'add_item_title' => DHVC_ADD_ITEM_TITLE, 
			'move_title' => DHVC_MOVE_TITLE, 
			'pricing_table_feature_tmpl' => $pricing_table_feature_tmpl );
		wp_localize_script( 'dh-vc-custom', 'dhvcL10n', $dhvcL10n );
		wp_enqueue_script( 'dh-vc-custom' );
	}
}

new DHVC_Init();
}
