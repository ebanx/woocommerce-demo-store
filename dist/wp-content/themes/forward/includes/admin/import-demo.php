<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('DH_ImportDemo')):
class DH_ImportDemo{
	public function __construct(){
		if(!function_exists('is_plugin_active'))
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // Require plugin.php to use is_plugin_active() below
		
		if(is_admin()){
			add_action('admin_menu', array(&$this,'admin_menu'));
			add_action('wp_ajax_dh_import_demo_data', array(&$this,'ajax_import_demo'));
		}
	}
	public function admin_menu(){
		$import_demo_page = add_theme_page(__('Import Demo','forward') , __('Import Demo','forward') , 'manage_options' , 'import-demo' , array(&$this,'output') );
		add_action("admin_print_styles-$import_demo_page", array(&$this,'admin_load_page'));
	}

	public function admin_load_page(){
		
	}
	public function output(){
		?>
		<div class="dh-message content" style="display:none;">
			<img src="<?php echo DHINC_ASSETS_URL.'/images/spinner.gif' ?>" alt="spinner">
			<h1 class="dh-message-title"><?php esc_html_e('Importing Demo Content...','forward')?></h1>
			<p class="dh-message-text"><?php _e('Please be patient and do not navigate away from this page while the import is in&nbsp;progress. This can take a while if your server is slow (inexpensive hosting).<br>You will be notified via this page when the import is completed.','forward')?></p>
		</div>
		<div class="dh-message error" style="display:none;">
			<h1 class="dh-message-title"><?php esc_html_e('Error has occured','forward')?></h1>
			<div class="dh-message-text"></div>
		</div>
		<div class="dh-message success" style="display:none;">
			<h1 class="dh-message-title"><?php esc_html_e('Import completed successfully!','forward')?></h1>
			<p class="dh-message-text"><?php _e('Now you can see the result at','forward')?> <a href="<?php echo site_url(); ?>" target="_blank"><?php _e('your site','forward')?></a><br><?php _e('or start customize via','forward')?> <a href="<?php echo admin_url('themes.php?page=theme-options'); ?>"><?php _e('Theme Options','forward')?></a></p>
		</div>

		<form class="dh-importer" action="?page=import-demo" method="post">
			<h1 class="dh-importer-title"><?php _e('Import Demo Data','forward')?></h1>
			
			<div class="dh-importer-options clear">
				<div class="dh-importer-option demo-data" style="display: none">
					<label class="dh-importer-option-check">
						<input id="demo_data" type="checkbox" value="1" name="demo_data" checked="checked">
						<span class="dh-importer-title"><?php _e('Import Demo Data','forward')?></span>
					</label>
				</div>
				<div class="dh-importer-note">
					<strong><?php esc_html_e('Important Notes:','forward')?></strong>
					<ol>
						<li><?php _e('We recommend to run Demo Import on a clean WordPress installation.','forward')?></li>
						<li><?php echo sprintf(__('To reset your installation we recommend %s plugin.','forward'),'<a href="http://wordpress.org/plugins/wordpress-database-reset/" target="_blank">Wordpress Database Reset</a>')?></li>
						<li><?php _e('The Demo Import will not import the images we have used in our live demo, due to copyright/license reasons.','forward')?></li>
						<li><?php _e('Do not run the Demo Import multiple times one after another, it will result in double content.','forward')?></li>
					</ol>
				</div>
				<input type="hidden" name="action" value="import-demo">
				<input class="button-primary" id="run_import_demo_data" type="submit" value="<?php echo esc_attr__('Import','forward')?>">
			</div>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				var import_running = false;
				jQuery('#run_import_demo_data').click(function() {
					if ( ! import_running) {
						import_running = true;
						jQuery("html, body").animate({
							scrollTop: 0
						}, {
							duration: 300
						});
						jQuery('.dh-importer').slideUp(null, function(){
							jQuery('.dh-message.content').slideDown();
						});
						var demo = jQuery('input[name=demo]:checked').val();
						if (demo == undefined) {
							demo = 'main';
						}
						jQuery.ajax({
							type: 'POST',
							url: '<?php echo admin_url('admin-ajax.php'); ?>',
							data: {
								security: '<?php echo wp_create_nonce( 'dh_import_demo_data' )?>',
								action: 'dh_import_demo_data',
								demo: demo
							},
							success: function(response, textStatus, XMLHttpRequest){
								jQuery('.dh-message.content').slideUp();
								if(response != 'imported'){
									jQuery('.dh-message.error .dh-message-text').html('<div>'+response+'</div>');
									jQuery('.dh-message.error').slideDown();
								}else{
									jQuery('.dh-message.success').slideDown();
								}
								import_running = false;
							},
							error: function(MLHttpRequest, textStatus, errorThrown){
								jQuery('.dh-message.error').slideDown();
							}
						});
					}
					return false;
				});
			});
		</script>
		<?php
	}
	
	protected function _get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}
	
	protected function _parse_import_data( $import_array ) {
		global $wp_registered_sidebars;
		$sidebars_data = $import_array[0];
		$widget_data = $import_array[1];
		$current_sidebars = get_option( 'sidebars_widgets' );
		$new_widgets = array( );
	
		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :
	
			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
					$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					$new_widget_name = $this->_get_new_widget_name( $title, $index );
					$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
				
					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] = $widget_data[$title][$index];
						$multiwidget = $new_widgets[$title]['_multiwidget'];
						unset( $new_widgets[$title]['_multiwidget'] );
						$new_widgets[$title]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[$new_index] = $widget_data[$title][$index];
						$current_multiwidget = isset($current_widget_data['_multiwidget']) ? $current_widget_data['_multiwidget'] : false;
						$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
						$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[$title] = $current_widget_data;
					}
			
				endif;
			endforeach;
		endforeach;
	
		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );
	
			foreach ( $new_widgets as $title => $content )
				update_option( 'widget_' . $title, $content );
	
			return true;
		}
	
		return false;
	}
	
	protected function _import_widget_data( $widget_data ) {
		$json_data = $widget_data;
		$json_data = json_decode( $json_data, true );
	
		$sidebar_data = $json_data[0];
		$widget_data = $json_data[1];
	
		foreach ( $widget_data as $widget_data_title => $widget_data_value ) {
			$widgets[ $widget_data_title ] = '';
			foreach( $widget_data_value as $widget_data_key => $widget_data_array ) {
				if( is_int( $widget_data_key ) ) {
					$widgets[$widget_data_title][$widget_data_key] = 'on';
				}
			}
		}
		unset($widgets[""]);
	
		foreach ( $sidebar_data as $title => $sidebar ) {
			$count = count( $sidebar );
			for ( $i = 0; $i < $count; $i++ ) {
				$widget = array( );
				$widget['type'] = trim( substr( $sidebar[$i], 0, strrpos( $sidebar[$i], '-' ) ) );
				$widget['type-index'] = trim( substr( $sidebar[$i], strrpos( $sidebar[$i], '-' ) + 1 ) );
				if ( !isset( $widgets[$widget['type']][$widget['type-index']] ) ) {
					unset( $sidebar_data[$title][$i] );
				}
			}
			$sidebar_data[$title] = array_values( $sidebar_data[$title] );
		}
	
		foreach ( $widgets as $widget_title => $widget_value ) {
			foreach ( $widget_value as $widget_key => $widget_value ) {
				$widgets[$widget_title][$widget_key] = $widget_data[$widget_title][$widget_key];
			}
		}
	
		$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
	
		$this->_parse_import_data( $sidebar_data );
	}
	
	protected function _import_essential_grid($file) {
		if(!class_exists('Essential_Grid_Import'))
			return;
	
		$es_data_json 	= wp_remote_get($file);
		$es_data 		= json_decode($es_data_json['body'],true);
		
		try{
			$im = new Essential_Grid_Import();
	
			$overwriteData = array(
				'global-styles-overwrite' => 'overwrite'
			);
	
			// Create Overwrite & Ids data
			$skins = @$es_data['skins'];
			$export_skins = array();
			if(!empty($skins) && is_array($skins)){
				foreach ($skins as $skin) {
					$export_skins[] = $skin['id'];
					$overwriteData['skin-overwrite-' . $skin['id']] = 'overwrite';
				}
			}
	
			$export_navigation_skins = array();
			$navigation_skins = @$es_data['navigation-skins'];
	
			foreach ((array)$navigation_skins as $nav_skin) {
				$export_navigation_skins[] = $nav_skin['id'];
				$overwriteData['nav-skin-overwrite-' . $nav_skin['id']] = 'overwrite';
			}
	
			$export_grids = array();
			$grids = @$es_data['grids'];
			if(!empty($grids) && is_array($grids)){
				foreach ($grids as $grid) {
					$export_grids[] = $grid['id'];
					$overwriteData['grid-overwrite-' . $grid['id']] = 'overwrite';
				}
			}
	
			$export_elements = array();
			$elements = @$es_data['elements'];
			if (!empty($elements) && is_array($elements))
			{foreach ($elements as $element) {
				$export_elements[] = $element['id'];
				$overwriteData['elements-overwrite-' . $element['id']] = 'overwrite';
			}}
	
			$export_custom_meta = array();
			$custom_metas = @$es_data['custom-meta'];
			if(!empty($custom_metas) && is_array($custom_metas)){
				foreach ($custom_metas as $custom_meta) {
					$export_custom_meta[] = $custom_meta['handle'];
					$overwriteData['custom-meta-overwrite-' .  $custom_meta['handle']] = 'overwrite';
				}
			}
	
			$export_punch_fonts = array();
			$custom_fonts = @$es_data['punch-fonts'];
			if(!empty($custom_fonts) && is_array($custom_fonts)){
				foreach ($custom_fonts as $custom_font) {
					$export_punch_fonts[] = $custom_font['handle'];
					$overwriteData['punch-fonts-overwrite-' . $custom_font['handle']] = 'overwrite';
				}
			}
	
			$im->set_overwrite_data($overwriteData); //set overwrite data global to class
	
			// Import data
			$skins = @$es_data['skins'];
			if(!empty($skins) && is_array($skins)){
				if(!empty($skins)){
					$skins_imported = $im->import_skins($skins, $export_skins);
				}
			}
	
			$navigation_skins = @$es_data['navigation-skins'];
			if(!empty($navigation_skins) && is_array($navigation_skins)){
				if(!empty($navigation_skins)){
					$navigation_skins_imported = $im->import_navigation_skins(@$navigation_skins, $export_navigation_skins);
				}
			}
	
			$grids = @$es_data['grids'];
			if(!empty($grids) && is_array($grids)){
				if(!empty($grids)){
					$grids_imported = $im->import_grids($grids, $export_grids);
				}
			}
	
			$elements = @$es_data['elements'];
			if(!empty($elements) && is_array($elements)){
				if(!empty($elements)){
					$elements_imported = $im->import_elements(@$elements, $export_elements);
				}
			}
	
			$custom_metas = @$es_data['custom-meta'];
			if(!empty($custom_metas) && is_array($custom_metas)){
				if(!empty($custom_metas)){
					$custom_metas_imported = $im->import_custom_meta($custom_metas, $export_custom_meta);
				}
			}
	
			$custom_fonts = @$es_data['punch-fonts'];
			if(!empty($custom_fonts) && is_array($custom_fonts)){
				if(!empty($custom_fonts)){
					$custom_fonts_imported = $im->import_punch_fonts($custom_fonts, $export_punch_fonts);
				}
			}
	
			if(true){
				$global_css = @$es_data['global-css'];
	
				$tglobal_css = stripslashes($global_css);
				if(empty($tglobal_css)) {$tglobal_css = $global_css;}
	
				$global_styles_imported = $im->import_global_styles($tglobal_css);
			}
		}catch(Exception $d){
			
		}
	}
	
	
	public function ajax_import_demo(){
		@set_time_limit(0);
		check_ajax_referer('dh_import_demo_data','security');
		$demo = isset($_POST['demo']) ? $_POST['demo'] : 'main';
		if('main'===$demo || empty($demo))
			$demo = 'main';
		
		$dummy_data_xml_file = get_template_directory().'/dummy-data//dummy-data.xml';
		$theme_options_file = get_template_directory_uri().'/dummy-data/theme_option.json';
		$widgets_json_file = get_template_directory_uri().'/dummy-data/widget_data.json';
		$es_data_json_file = get_template_directory_uri().'/dummy-data/ess_grid.json';
		
		if ( !defined('WP_LOAD_IMPORTERS') ) 
			define('WP_LOAD_IMPORTERS', true);
		
		if ( ! class_exists( 'WP_Importer' ) ) { // if main importer class doesn't exist
			include ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}
		
		if ( ! class_exists('WP_Import') ) { // if WP importer doesn't exist
			include DHINC_DIR . '/lib/wordpress-importer/wordpress-importer.php';
		}
		
		if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
			//Import Data
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			ob_start();
			$wp_import->import($dummy_data_xml_file);
			ob_end_clean();
			
			// Import Widget
			$widgets_json = wp_remote_get( $widgets_json_file );
			$widget_data = $widgets_json['body'];
			$this->_import_widget_data($widget_data);
			
			// Import Theme Options
			$theme_options_json = wp_remote_get( $theme_options_file );
			$theme_options_data = array('dh_opt_import'=>true,'import_code'=>$theme_options_json['body']);
			update_option( dh_get_theme_option_name(), $theme_options_data ); // update theme options
					
			
			// Set menu
			$locations = get_theme_mod('nav_menu_locations');
			$menus  = wp_get_nav_menus();
			
			if(!empty($menus))
			{
				foreach($menus as $menu)
				{
					if(is_object($menu))
					{
						if($menu->name == 'Primary Menu'){
							$locations['primary'] = $menu->term_id;
						}else if ($menu->name == 'Top Menu'){
							$locations['top'] = $menu->term_id;
						}
					}
				}
			}
			
			set_theme_mod('nav_menu_locations', $locations);
			
			
			
			//Set Front Page
			$front_page = get_page_by_title('Home');
				
			if(isset($front_page->ID)) {
				update_option('show_on_front', 'page');
				update_option('page_on_front',  $front_page->ID);
			}
				
			if(defined('WOOCOMMERCE_VERSION')){
				// We no longer need to install pages
				delete_option( '_wc_needs_pages' );
				delete_transient( '_wc_activation_redirect' );
					
			}
			
			//import essential grid
			$this->_import_essential_grid($es_data_json_file);
			
			//import revslider
			if ( class_exists('RevSlider')) {
				ob_start();
				
				$_FILES['import_file']['error'] = UPLOAD_ERR_OK;
				$_FILES["import_file"]["tmp_name"] = get_template_directory().'/dummy-data/home1.zip';
				$slider = new RevSlider();
				$response = $slider->importSliderFromPost();
				unset($slider);
				
				$_FILES['import_file']['error'] = UPLOAD_ERR_OK;
				$_FILES["import_file"]["tmp_name"] = get_template_directory().'/dummy-data/home2.zip';
				$slider = new RevSlider();
				$response = $slider->importSliderFromPost();
				unset($slider);
				
				$_FILES['import_file']['error'] = UPLOAD_ERR_OK;
				$_FILES["import_file"]["tmp_name"] = get_template_directory().'/dummy-data/home3.zip';
				$slider = new RevSlider();
				$response = $slider->importSliderFromPost();
				unset($slider);
				
				$_FILES['import_file']['error'] = UPLOAD_ERR_OK;
				$_FILES["import_file"]["tmp_name"] = get_template_directory().'/dummy-data/home5.zip';
				$slider = new RevSlider();
				$response = $slider->importSliderFromPost();
				unset($slider);
				
				$_FILES['import_file']['error'] = UPLOAD_ERR_OK;
				$_FILES["import_file"]["tmp_name"] = get_template_directory().'/dummy-data/home6.zip';
				$slider = new RevSlider();
				$response = $slider->importSliderFromPost();
				unset($slider);
				
				ob_end_clean();
			}
			
			// Flush rules after install
			flush_rewrite_rules();
			echo 'imported';
			die();
		}
	}
}
new DH_ImportDemo();
endif;