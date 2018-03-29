<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (! class_exists ( 'DH_Init' )) :
	class DH_Init {
	
		public $version = '1.0.0';
		
		public function __construct() {
			$this->_define_constants ();
			$this->_includes ();
			add_action('init', array(&$this,'init'));
			add_action('init', array(&$this,'thirdparty_plugins_init'),1);
		}
		
		public function init(){
			
		}
		
		public function thirdparty_plugins_init(){
			//Visual Composer
			if ( function_exists( 'vc_set_as_theme' ) ) :
			vc_set_as_theme( true );
			vc_manager()->disableUpdater();
			endif;
			
			//RevSlider
			if(function_exists('set_revslider_as_theme')){
				if(!defined('REV_SLIDER_AS_THEME'))
					define('REV_SLIDER_AS_THEME',true);
				set_revslider_as_theme();
				update_option('revslider-valid-notice', 'false');
			}
			if(class_exists('RevSliderAdmin') && method_exists('RevSliderAdmin', 'add_plugins_page_notices')){
				remove_action('admin_notices', array('RevSliderAdmin', 'add_plugins_page_notices'));
			}
			//Es Grid
			if(function_exists('set_ess_grid_as_theme')){
				if(!defined('ESS_GRID_AS_THEME'))
					define('ESS_GRID_AS_THEME', true);
				set_ess_grid_as_theme();
				update_option('tp_eg_valid-notice', 'false');
			}
		}
		
		private function _define_constants() {
			if(!defined('DH_PRODUCT_MODE')){
				define('DH_PRODUCT_MODE','testing');
			}
			if(!defined('DHINC_VERSION'))
				define( 'DHINC_VERSION', $this->version );
			if(!defined('DHINC_DIR'))
				define( 'DHINC_DIR', get_template_directory().'/includes' );
			if(!defined('DHINC_URL'))
				define( 'DHINC_URL', get_template_directory_uri().'/includes');
			if(!defined('DHINC_ASSETS_URL'))
				define( 'DHINC_ASSETS_URL', get_template_directory_uri().'/includes/assets' );
		}
		
		private function _includes() {
			// Utils
			include_once (DHINC_DIR . '/functions.php');
			
			// LESS Helper
			include_once (DHINC_DIR . '/less-helper.php');
			
			// Register
			include_once (DHINC_DIR . '/register.php');
			// Hook
			include_once (DHINC_DIR . '/hook.php');
			
			//Walker
			include_once (DHINC_DIR. '/walker.php');
			// Widget
			include_once (DHINC_DIR . '/widget.php');
			// Breadcrumb
			include_once (DHINC_DIR . '/breadcrumb.php');
			
			//Controller
			include_once (DHINC_DIR . '/controller.php');
			
			//Updater
			//include_once (DHINC_DIR . '/updaters/updater.php');
			
			// Admin
			if (is_admin ()) {
				include_once (DHINC_DIR . '/admin/functions.php');
				include_once (DHINC_DIR . '/admin/admin.php');
			}
				
		}
		
	}
	new DH_Init ();
endif;
