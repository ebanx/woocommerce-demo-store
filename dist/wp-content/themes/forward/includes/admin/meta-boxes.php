<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (! class_exists ( 'DH_Metaboxes' )) :
	class DH_Metaboxes {
		public function __construct() {
			add_action ( 'add_meta_boxes', array (&$this, 'add_meta_boxes' ), 30 );
			add_action ( 'save_post', array (&$this,'save_meta_boxes' ), 1, 2 );
			
			//add_action( 'admin_enqueue_scripts', array( &$this, 'assets' ) );
			add_action( 'admin_print_scripts-post.php', array( &$this, 'enqueue_scripts' ) );
			add_action( 'admin_print_scripts-post-new.php', array( &$this, 'enqueue_scripts' ) );
			
		}
		
		public function add_meta_boxes() {
			global $wp_version;
			// Post Gallery
			$meta_box = array (
					'id' => 'dh-metabox-post-gallery',
					'title' => __ ( 'Gallery Settings', 'forward' ),
					'description' =>'',
					'post_type' => 'post',
					'context' => 'normal',
					'priority' => 'high',
					'fields' => array (
							array (
									'label' => __ ( 'Gallery', 'forward' ),
									'name' => '_dh_gallery',
									'type' => 'gallery',
							),
					)
			);
			add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', $meta_box ['post_type'], $meta_box ['context'], $meta_box ['priority'], $meta_box );
			
			//Post Quote
			$meta_box = array(
					'id' => 'dh-metabox-post-quote',
					'title' =>  __('Quote Settings', 'forward'),
					'description' => '',
					'post_type' => 'post',
					'context' => 'normal',
					'priority' => 'high',
					'fields' => array(
							array(
									'label' =>  __('Quote Content', 'forward'),
									'description' => __('Please type the text for your quote here.', 'forward'),
									'name' => '_dh_quote',
									'type' => 'textarea',
							)
					)
			);
			add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', $meta_box ['post_type'], $meta_box ['context'], $meta_box ['priority'], $meta_box );
			
			//Post Link
			$meta_box = array(
				'id' => 'dh-metabox-post-link',
				'title' =>  __('Link Settings', 'forward'),
				'description' => '',
				'post_type' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array(
						'label' =>  __('Link URL', 'forward'),
						'description' => __('Please input the URL for your link. I.e. http://www.example.com', 'forward'),
						'name' => '_dh_link',
						'type' => 'text',
					)
				)
			);
			add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', $meta_box ['post_type'], $meta_box ['context'], $meta_box ['priority'], $meta_box );
			
			//Post  Video
			$meta_box = array(
					'id' => 'dh-metabox-post-video',
					'title' => __('Video Settings', 'forward'),
					'description' => '',
					'post_type' => 'post',
					'context' => 'normal',
					'priority' => 'high',
					'fields' => array(
							array(
								'type' => 'heading',
								'heading'=>__('Use service video','forward'),
							),
							array(
									'label' => __('Embedded Code', 'forward'),
									'description' => __('Used when you select Video format. Enter a Youtube, Vimeo, Soundcloud, etc URL. See supported services at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'forward'),
									'name' => '_dh_video_embed',
									'type' => 'text',
							),
							array(
								'type' => 'heading',
								'heading'=>__('Use hosted video','forward'),
							),
							array(
									'label' => __('MP4 File URL', 'forward'),
									'description' => __('Please enter in the URL to the .m4v video file.', 'forward'),
									'name' => '_dh_video_mp4',
									'type' => 'media',
							),
							array(
									'label' => __('OGV/OGG File URL', 'forward'),
									'description' => __('Please enter in the URL to the .ogv or .ogg video file.', 'forward'),
									'name' => '_dh_video_ogv',
									'type' => 'media',
							),
							array(
									'label' => __('WEBM File URL', 'forward'),
									'description' => __('Please enter in the URL to the .webm video file.', 'forward'),
									'name' => '_dh_video_webm',
									'type' => 'media',
							),
					)
			);
			add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', $meta_box ['post_type'], $meta_box ['context'], $meta_box ['priority'], $meta_box );
			//Product Video
			if(defined('WOOCOMMERCE_VERSION'))
				add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', 'product', $meta_box ['context'], $meta_box ['priority'], $meta_box );
			
			//Post  Audio
			$meta_box = array(
				'id' => 'dh-metabox-post-audio',
				'title' =>  __('Audio Settings', 'forward'),
				'description' => '',
				'post_type' => 'post',
				'context' => 'normal',
				'priority' => 'high',
				'fields' => array(
					array( 
							'label' => __('MP3 File URL', 'forward'),
							'description' => __('Please enter in the URL to the .mp3 file', 'forward'),
							'name' => '_dh_audio_mp3',
							'type' => 'media',
					),
					array( 
							'label' => __('OGA File URL', 'forward'),
							'description' => __('Please enter in the URL to the .ogg or .oga file', 'forward'),
							'name' => '_dh_audio_ogg',
							'type' => 'media',
						)
				)
			);
			add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', $meta_box ['post_type'], $meta_box ['context'], $meta_box ['priority'], $meta_box );
			
			//Page Settings
			$revsliders = array();
			if ( ! function_exists( 'is_plugin_active' ) ) {
				include_once ( ABSPATH . 'wp-admin/includes/plugin.php' );
			}
			if ( is_plugin_active( 'revslider/revslider.php' ) ) {
				global $wpdb;
				$rs = $wpdb->get_results(
						"
	  SELECT id, title, alias
	  FROM " . $wpdb->prefix . "revslider_sliders
	  ORDER BY id ASC LIMIT 999
	  "
				);
				if ( $rs ) {
					foreach ( $rs as $slider ) {
						$revsliders[$slider->alias] = $slider->title;
					}
				} else {
					$revsliders[0] = __( 'No sliders found', 'forward' );
				}
			}
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
			$menu_options[''] = __('Default Menu...','forward');
			foreach ( $menus as $menu ) {
				$menu_options[$menu->term_id] = $menu->name;
			}
			$meta_box = array (
					'id' => 'dh-metabox-page-settings',
					'title' => __ ( 'Page Settings', 'forward' ),
					'description' =>'',
					'post_type' => 'page',
					'context' => 'normal',
					'priority' => 'high',
					'fields' => array (
							array (
									'label' => __ ( 'Content Page no Padding', 'forward' ),
									'description' => __ ( 'If checked. content of page  with no padding top and padding bottom', 'forward' ),
									'name' => '_dh_no_padding',
									'type' => 'checkbox',
							),
							array (
								'label' => __ ( 'Full page Slider', 'forward' ),
								'description' => __ ( 'If checked. with make page with full page scroll', 'forward' ),
								'name' => 'fullpage',
								'type' => 'checkbox',
							),
							array (
								'label' => __ ( 'Hide Header', 'forward' ),
								'description' => __ ( 'Hide Headear.', 'forward' ),
								'name' => 'hide_header',
								'type' => 'select',
								'options'=>array(
									'0'=>__('No','forward'),
									'1'=>__('Yes','forward'),
								)
							),
							array (
								'label' => __ ( 'Hide Footer', 'forward' ),
								'description' => __ ( 'Hide Footer.', 'forward' ),
								'name' => 'hide_footer',
								'type' => 'select',
								'options'=>array(
									'0'=>__('No','forward'),
									'1'=>__('Yes','forward'),
								)
							),
							array (
								'label' => __ ( 'Background', 'forward' ),
								'description' => __ ( 'Page backgorund.', 'forward' ),
								'name' => 'page_background',
								'type' => 'select',
								'options'=>array(
									'0'=>__('No','forward'),
									'full'=>__('Full Background','forward'),
									'half'=>__('Half Background','forward')
								)
							),
							array (
								'label' => __ ( 'Main Navigation Menu', 'forward' ),
								'description' => __ ( 'Select which main menu displays on this page.', 'forward' ),
								'name' => 'main_menu',
								'type' => 'select',
								'value'=>'',
								'options'=>$menu_options,
							),
							array (
									'label' => __ ( 'Main Sidebar', 'forward' ),
									'description' => __ ( 'Select sidebar for page with 2 or 3 colums.', 'forward' ),
									'name' => 'main_sidebar',
									'type' => 'widgetised_sidebars',
							),
							array (
									'label' => __ ( 'Header Style', 'forward' ),
									'description' => __ ( 'Please select your header style here.', 'forward' ),
									'name' => 'header_style',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'classic'=>__('Classic','forward'),
											'classic-full'=>__('Classic Full','forward'),
											'center'=>__('Center','forward'),
											'center-logo'=>__('Center Logo','forward'),
											'sidebar'=>__('Sidebar','forward'),
									)
							),
							array (
									'label' => __ ( 'Topbar', 'forward' ),
									'description' => __ ( 'Enable or disable the top bar.', 'forward' ),
									'name' => 'show_topbar',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'1'=>__('Show','forward'),
											'0'=>__('Hide','forward')
									)
							),
							array (
									'label' => __ ( 'Transparent Main Menu', 'forward' ),
									'description' => __ ( 'Enable or disable main menu background transparency.', 'forward' ),
									'name' => 'menu_transparent',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'1'=>__('On','forward'),
											'0'=>__('Off','forward')
									)
							),
							array (
								'label' => __ ( 'Sticky Menu', 'forward' ),
								'description' => __ ( 'Enable or disable sticky.', 'forward' ),
								'name' => 'sticky-menu',
								'type' => 'select',
								'options'=>array(
									'-1'=>__('Global','forward'),
									'1'=>__('On','forward'),
									'0'=>__('Off','forward')
								)
							),
							array (
									'label' => __ ( 'Page Heading', 'forward' ),
									'description' => __ ( 'Enable/disable page heading or custom page heading', 'forward' ),
									'name' => 'page_heading',
									'type' => 'select',
									'value'=>'default',
									'options'=>array(
											'default'=>__('Default Heading','forward'),
											'heading'=>__('Custom Heading','forward'),
											'rev'=>__('Use Revolution Slider','forward'),
											'0'=>__('Hide','forward')
									)
							),
							array (
								'label' => __ ( 'Heading Menu Anchor ', 'forward' ),
								'description' => __ ( 'Add menu anchor for heading. You can use in One Page', 'forward' ),
								'name' => 'heading_menu_anchor',
								'type' => 'text',
							),
							array (
									'label' => __ ( 'Revolution Slider', 'forward' ),
									'description' => __ ( 'Select your Revolution Slider.', 'forward' ),
									'name' => 'rev_alias',
									'type' => 'select',
									'options'=>$revsliders,
							),
							array (
									'label' => __ ( 'Page Heading Background Image', 'forward' ),
									'description' => __ ( 'Custom heading background image.', 'forward' ),
									'name' => 'page_heading_background_image',
									'type' => 'image',
							),
// 							array (
// 								'label' => __ ( 'Sub Heading Title', 'forward' ),
// 								'description' => __ ( 'Sub heading title.', 'forward' ),
// 								'name' => 'default_sub_heading_title',
// 								'type' => 'text',
// 							),
							array (
									'label' => __ ( 'Page Heading Title', 'forward' ),
									'description' => __ ( 'Custom heading title.', 'forward' ),
									'name' => 'page_heading_title',
									'type' => 'text',
							),
							array (
									'label' => __ ( 'Page Heading Sub-title', 'forward' ),
									'description' => __ ( 'Custom heading sub-title.', 'forward' ),
									'name' => 'page_heading_sub_title',
									'type' => 'text',
							),
							array(
								'type' => 'select',
								'label' => __( 'Page Heading Color', 'forward' ),
								'name' => 'page_heading_color',
								'options' => array(
									'-1'=>__('Global','forward'),
									'white'=>__('White','forward'),
									'black'=>__('Black','forward')
								),
							),
							array(
								'type' => 'select',
								'label' => __( 'Page Heading Align', 'forward' ),
								'name' => 'page_heading_align',
								'options' => array(
									'center'=>__('Center','forward'),
									'left'=>__('Left','forward'),
									'right'=>__('Right','forward')
								),
							),
							array (
								'label' => __ ( 'Button text', 'forward' ),
								'description' => __ ( 'Custom heading button text.', 'forward' ),
								'name' => 'page_heading_button_text',
								'type' => 'text',
							),
							array (
								'label' => __ ( 'Button URL', 'forward' ),
								'description' => __ ( 'Custom heading button URL.', 'forward' ),
								'name' => 'page_heading_button_url',
								'type' => 'text',
							),
							array(
								'type' => 'select',
								'label' => __( 'Footer Style', 'forward' ),
								'name' => 'footer-style',
								'options' => array(
									'-1'=>__('Global','forward'),
									'style-1'=>__('Style 1','forward'),
									'style-2'=>__('Style 2','forward')
								),
							),
							array (
									'label' => __ ( 'Footer Top', 'forward' ),
									'description' => __ ( 'Do you want show/hide footer top.', 'forward' ),
									'name' => 'footer_top',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'1'=>__('Show','forward'),
											'0'=>__('Hide','forward')
									)
							),
							array (
									'label' => __ ( 'Footer Widget Area', 'forward' ),
									'description' => __ ( 'Do you want use the main footer that contains all the widgets areas.', 'forward' ),
									'name' => 'footer_area',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'1'=>__('Show','forward'),
											'0'=>__('Hide','forward')
									)
							),
							array (
									'label' => __ ( 'Footer Bottom', 'forward' ),
									'description' => __ ( 'Do you want show/hide footer bottom.', 'forward' ),
									'name' => 'footer_bottom',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'1'=>__('Show','forward'),
											'0'=>__('Hide','forward')
									)
							),
							array (
									'label' => __ ( 'Footer Info', 'forward' ),
									'description' => __ ( 'Do you want show/hide Footer Info.', 'forward' ),
									'name' => 'footer_info_switch',
									'type' => 'select',
									'options'=>array(
											'-1'=>__('Global','forward'),
											'1'=>__('Show','forward'),
											'0'=>__('Hide','forward')
									)
							),
					)
			);
			add_meta_box ( $meta_box ['id'], $meta_box ['title'], 'dh_render_meta_boxes', $meta_box ['post_type'], $meta_box ['context'], $meta_box ['priority'], $meta_box );
				
			
		}
		
		public function add_video_featured_image($att_id){
			$p = get_post($att_id);
			update_post_meta($p->post_parent,'_thumbnail_id',$att_id);
		}
		
		
		public function save_meta_boxes($post_id, $post) {
			// $post_id and $post are required
			if (empty ( $post_id ) || empty ( $post )) {
				return;
			}
			// Dont' save meta boxes for revisions or autosaves
			if (defined ( 'DOING_AUTOSAVE' ) || is_int ( wp_is_post_revision ( $post ) ) || is_int ( wp_is_post_autosave ( $post ) )) {
				return;
			}
			// Check the nonce
			if (empty ( $_POST ['dh_meta_box_nonce'] ) || ! wp_verify_nonce ( $_POST ['dh_meta_box_nonce'], 'dh_meta_box_nonce' )) {
				return;
			}
			
			// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
			if (empty ( $_POST ['post_ID'] ) || $_POST ['post_ID'] != $post_id) {
				return;
			}
			
			// Check user has permission to edit
			if (! current_user_can ( 'edit_post', $post_id )) {
				return;
			}
			if(isset( $_POST['dh_meta'] )){
				$dh_meta = $_POST['dh_meta'];
// 				if(get_post_format() == 'video' ){
// 					$_dh_video_embed = $dh_meta['_dh_video_embed'];
// 					if(dh_is_video_support($_dh_video_embed) && ($_dh_video_embed != dh_get_post_meta('video_embed_hidden'))){
// 						$videoThumbUrl = dh_get_video_thumb_url($_dh_video_embed);
// 						if (!empty($videoThumbUrl)) {
// 							 // add the function above to catch the attachments creation
// 							add_action('add_attachment',array(&$this,'add_video_featured_image'));
// 							// load the attachment from the URL
// 							media_sideload_image($videoThumbUrl, $post_id, $post_id);
// 							// we have the Image now, and the function above will have fired too setting the thumbnail ID in the process, so lets remove the hook so we don't cause any more trouble
// 							remove_action('add_attachment',array(&$this,'add_video_featured_image'));
// 						}
// 					}
// 				}
				// Process
				foreach( (array)$_POST['dh_meta'] as $key=>$val ){
					$val = wp_unslash($val);
					if(is_array($val)){
						$option_value = array_filter( array_map( 'sanitize_text_field', (array) $val ) );
						update_post_meta( $post_id, $key, $option_value );
					}else{
						update_post_meta( $post_id, $key, wp_kses_post($val) );
					}
				}
			}
			do_action('dh_metabox_save',$post_id);
		}
		
		public function enqueue_scripts(){
			wp_enqueue_style('dh-meta-box',DHINC_ASSETS_URL.'/css/meta-box.css',null,DHINC_VERSION);
			wp_enqueue_script('dh-meta-box',DHINC_ASSETS_URL.'/js/meta-box.js',array('jquery','jquery-ui-sortable'),DHINC_VERSION,true);
		}
		
	}
	new DH_Metaboxes ();

endif;