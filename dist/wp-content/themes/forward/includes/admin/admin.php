<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if(!class_exists('DH_Admin')):
class DH_Admin {
	public function __construct(){
		
		include_once (DHINC_DIR . '/admin/meta-boxes.php');
		include_once (DHINC_DIR . '/admin/mega-menu.php');
		include_once (DHINC_DIR . '/admin/theme-options.php');
		// Import Demo
		include_once (DHINC_DIR . '/admin/import-demo.php');
			
		
		add_action( 'admin_init', array(&$this,'admin_init'));
		add_action('admin_enqueue_scripts',array(&$this,'enqueue_scripts'));
	}
	
	
	public function admin_init(){
		
	}
	
	public function enqueue_scripts(){
		
		wp_enqueue_style('dh-admin',DHINC_ASSETS_URL.'/css/admin.css',false,DHINC_VERSION);
		
		wp_register_script('dh-admin',DHINC_ASSETS_URL.'/js/admin.js',array('jquery'),DHINC_VERSION,true);
		$dhAdminL10n = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'theme_url'=>get_template_directory_uri(),
			'framework_assets_url'=>DHINC_ASSETS_URL,
		);
		wp_localize_script('dh-admin', 'dhAdminL10n', $dhAdminL10n);
		wp_enqueue_script('dh-admin');
	}
}
new DH_Admin();
endif;
