<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('DH_Woocommerce_Product_Variable')):
class DH_Woocommerce_Product_Variable {
	
	protected static $_instance = null;
	
	public function __construct(){
		add_action( 'init', array( &$this, 'init' ) );
		
	}
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function init(){
		//woocommerce_available_variation
		add_filter( 'woocommerce_available_variation', array(&$this, 'available_variation' ), 10, 3 );
		
		
		if ( ! defined( 'WOOCOMMERCE_VERSION' ) ) {
			return;
		}
		if(is_admin()){
			add_action( 'wp_ajax_dh_load_variable_gallery', array( &$this, 'ajax_load_variable_gallery' ) );
			
			add_action( 'admin_print_scripts-post.php', array( &$this, 'admin_enqueue_scripts' ) );
			add_action( 'admin_print_scripts-post-new.php', array( &$this, 'admin_enqueue_scripts' ) );
			
			add_action( 'woocommerce_product_options_general_product_data',     array( &$this, 'add_product_fields' ) );
			add_action( 'woocommerce_process_product_meta',                     array( &$this, 'save_product_fields' ) );
			
			add_action( 'woocommerce_process_product_meta', array($this,'save_meta_boxes'), 10, 2 );
		}
			
	}
	
	public function add_product_fields() {
	
		global $woocommerce, $post;
	
		echo '<div class="options_group show_if_variable">';
		woocommerce_wp_checkbox(
			array(
				'id'            => '_dh_disable_variation_gallery',
				'label'         => __('Disable Variation Gallery ?', 'forward')
			)
		);
		echo '</div>';
	
	}
	
	public function save_product_fields( $post_id ) {
		
		$_dh_disable_variation_gallery = isset( $_POST['_dh_disable_variation_gallery'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_dh_disable_variation_gallery', $_dh_disable_variation_gallery );
	
	}
	
	
	public function ajax_load_variable_gallery(){
		check_ajax_referer( 'load-variations', 'security' );
		
		// Check permissions again and make sure we have what we need
		if ( ! current_user_can( 'edit_products' ) || empty( $_POST['product_id'] )) {
			die( -1 );
		}
		
		$product_id = absint( $_POST['product_id'] );
		$per_page   = ! empty( $_POST['per_page'] ) ? absint( $_POST['per_page'] ) : 10;
		$page       = ! empty( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
		// Get variations
		$args = apply_filters( 'woocommerce_ajax_admin_get_variations_args', array(
			'post_type'      => 'product_variation',
			'post_status'    => array( 'private', 'publish' ),
			'posts_per_page' => $per_page,
			'paged'          => $page,
			'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'DESC' ),
			'post_parent'    => $product_id
		), $product_id );

		$variations = get_posts( $args );
		$html = '';
		foreach ($variations as $variation){
			$variation_id     = absint( $variation->ID );
			$dh_product_variable_gallery_ids = get_post_meta($variation_id,'_dh_variation_image_gallery',true);
			$html .= '<div id="dh-product-variable-'.$variation_id.'"><div class="dh-product-variable-gallery-wrap"></div><div class="dh-meta-gallery-wrap"><ul class="dh-meta-gallery-list">';
			$html_list = '';
			foreach (explode(',', $dh_product_variable_gallery_ids) as $dh_product_variable_gallery_id){
				if($dh_product_variable_gallery_image = wp_get_attachment_image( $dh_product_variable_gallery_id, 'thumbnail')){
					$html_list .= '<li data-id="'.absint($dh_product_variable_gallery_id).'">
						<div class="thumbnail">
							<div class="centered">
								'. wp_get_attachment_image( $dh_product_variable_gallery_id, 'thumbnail').'			
							</div>
							<a title="Delete" href="#">x</a>
						</div>						
					</li>';
				}
			}
			$html .= $html_list;
			$html .= '</ul><input type="hidden" value="'.$dh_product_variable_gallery_ids.'" class="dh_product_variable_gallery_ids" name="dh_product_variable_gallery_ids['.$variation_id.']"><input id="_dh_product_variable_gallery_upload" class="button button-primary dh-product-variable-gallery-select" type="button" value="Add Gallery Images"></div></div>';
		}
		echo $html;
		die();
		
	}
	public function admin_enqueue_scripts(){
		if(get_post_type() == 'product'){
			wp_enqueue_style('dh-woocommerce-product-variable',DHINC_ASSETS_URL.'/css/dh-woocommerce-product-variable.css',null,DHINC_VERSION);
			wp_register_script('dh-woocommerce-product-variable',DHINC_ASSETS_URL.'/js/admin-product-variable.js',array('jquery','wc-admin-product-meta-boxes'),DHINC_VERSION,true);
			wp_localize_script('dh-woocommerce-product-variable','dhWooCommerceProductVariableL10n', array(
				'upload_title'=>esc_attr__('Add Images to Gallery','forward'),
				'upload_button'=>esc_attr__('Add to Gallery','forward')
			));
			wp_enqueue_script('dh-woocommerce-product-variable');
		}
	}
	
	/**
	 * Retrieve get main image of Product
	 * 
	 * @param WC_Product $product
	 * @return Ambigous <string, false>
	 */
	public function get_product_image($product){
		$image_ids = $this->_get_variation_image_ids( $product->id );
		$images = $this->_get_variation_image_sizes( $image_ids );
		return wp_json_encode($images);
	}
	
	public function available_variation($variation_data, $product, $variation){
		$images_ids = $this->_get_variation_image_ids( $variation_data['variation_id'] );
		$images = $this->_get_variation_image_sizes( $images_ids );

		$variation_data['additional_images'] = $images;

		return $variation_data;
	}

	protected function _get_variation_image_ids($variation_id){
		$images_ids = array();
		$is_gallery = false;

		if(has_post_thumbnail($variation_id)){
			$images_ids[] = get_post_thumbnail_id($variation_id);
		} else {
			$post = get_post($variation_id);
			$post_parent_id = $post->post_parent;
			if($post_parent_id && has_post_thumbnail($post_parent_id)){
				$images_ids[] = get_post_thumbnail_id($post_parent_id);
			} else {
				$images_ids[] = 'placeholder';
			}
			$is_gallery = true;
		}
		if(get_post_type($variation_id) == 'product_variation'){
			$variation_image_gallery_ids = array_filter(explode(',', get_post_meta($variation_id, '_dh_variation_image_gallery', true)));
			$images_ids = array_merge($images_ids, $variation_image_gallery_ids);
			//$images_ids = $variation_image_gallery_ids;
		}
		if(get_post_type($variation_id) == 'product' || $is_gallery){
			$product = get_product($variation_id);
			$attachment_ids = $product->get_gallery_attachment_ids();
			if(!empty($attachment_ids)){
				$images_ids = array_merge($images_ids, $attachment_ids);
			}
		}

		return $images_ids;
	}
	

	protected function _get_variation_image_sizes($images_ids){
		$images = array();
		if(!empty($images_ids)){
			foreach($images_ids as $image_id):
			if($image_id == 'placeholder'){
				$images[] = array(
					'full' => array( wc_placeholder_img_src('dh-full') ),
					'single' => array( wc_placeholder_img_src('shop_single') ),
					'thumb' => array( wc_placeholder_img_src('shop_thumbnail') ),
					'alt' => '',
					'title' => ''
				);
			} else {
				if(!array_key_exists($image_id, $images)){
					$full_image_src=$this->__get_attachment_image_src($image_id, 'dh-full');
					if(!empty($full_image_src)){
						$attachment = $this->__get_attachment($image_id);
						$images[] = array(
							'full' => $full_image_src,
							'single' => $this->__get_attachment_image_src($image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' )),
							'thumb' => $this->__get_attachment_image_src($image_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' )),
							'alt' => $attachment['alt'],
							'title' => $attachment['title']
						);
					}
				}
			}
			endforeach;
		}
		return $images;
	}
	
	private function __get_attachment_image_src($image_id, $size='thumbnail'){
		if($image = wp_get_attachment_image_src($image_id, $size)){
			$image_src = $image[0];
			return $image_src;
		}
		return '';
	}

	private function __get_attachment( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		return array(
			'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
			'caption' => $attachment->post_excerpt,
			'description' => $attachment->post_content,
			'href' => get_permalink( $attachment->ID ),
			'src' => $attachment->guid,
			'title' => $attachment->post_title
		);
	}
	
	public function save_meta_boxes($post_id, $post){
		if(isset($_POST['dh_product_variable_gallery_ids'])) {
			foreach ($_POST['dh_product_variable_gallery_ids'] as $variable_id=>$variable_gallery_ids){
				update_post_meta($variable_id, '_dh_variation_image_gallery', $variable_gallery_ids);
			}
		}
	}
}
new DH_Woocommerce_Product_Variable();
endif;