<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class DH_Updater{
	
	protected $_api_url = 'http://updates.sitesao.com/theme.php';
	
	protected static $_instance = null;
	
	protected static $_theme_info = null;
	
	protected $_update_manager = array();
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct(){
		if(!class_exists('DH_Updating_Manager'))
			include_once (DHINC_DIR . '/updaters/updating-manager.php');
		
		$this->set_update_manager(new DH_Updating_Manager($this->_api_url,$this->get_version(), $this->get_theme_slug(), $this->get_theme_name(), $this->get_screenshot()));
		
		add_filter( 'upgrader_pre_download', array( $this, 'pre_upgrader' ), 10, 4 );
		
		if(is_admin())
			include_once (DHINC_DIR . '/updaters/updater-admin.php');
	}
	
	public function pre_upgrader($reply, $package, $updater){
		//@set_time_limit(0);
		$condition1 = isset( $updater->skin->theme ) && $updater->skin->theme === $this->get_theme_slug();
		$condition2 = isset( $updater->skin->theme_info ) && $updater->skin->theme_info['Name'] === $this->get_theme_name();
		if ( ! $condition1 && ! $condition2 ) {
			return $reply;
		}

		$res = $updater->fs_connect( array( WP_CONTENT_DIR ) );
		if ( ! $res ) {
			return new WP_Error( 'no_credentials', __( "Error! Can't connect to filesystem", 'forward' ) );
		}

		$license_key = $this->get_license_key();
		$username = $this->get_username();
		$api = $this->get_api();

		if ( empty($license_key) || empty($api)  || empty($username)) {
			$url = esc_url( is_multisite() ? network_admin_url( 'themes.php?page=theme-options' ) : admin_url( 'themes.php?page=theme-options' ) );

			return new WP_Error( 'no_credentials', sprintf(__( 'To receive automatic updates license activation is required. Please visit <a href="%1$s" target="_blank">Settings</a> to activate %2$s.', 'forward'),$url,$this->get_theme_name() )  );
		}

		$updater->strings['downloading_package_url'] = __( 'Getting download link...', 'forward' );
		$updater->skin->feedback( 'downloading_package_url' );
		
		$json = wp_remote_get( $this->get_envato_download_purchase_url( $username, $api, $license_key ) );
		$result = json_decode( $json['body'], true );
		
		if ( $json['response']['code'] == 200 ) {
			if ( isset( $result['error']) ) {
				return new WP_Error( 'no_credentials', __( 'Error! Envato API error', 'forward' ) . ( isset( $result['error'] ) ? ': ' . $result['error'] : '.' ) );
			}
			if ( ! isset( $result['download-purchase']['wordpress_theme'] ) ) {
				return new WP_Error( 'no_credentials', __( 'Error! Envato API error', 'forward' ) . ( isset( $result['error'] ) ? ': ' . $result['error'] : '.' ) );
			}
			
			$updater->strings['downloading_package'] = __( 'Downloading package...', 'forward' );
			$updater->skin->feedback( 'downloading_package' );
			
			$download_file = download_url( $result['download-purchase']['wordpress_theme'],180000 );
			if ( is_wp_error( $download_file ) ) {
				return new WP_Error( 'download_failed', $upgrader->strings['download_failed']);
			}
			
			return $download_file;
		}else{
			return new WP_Error( 'no_credentials', __( 'Error! Envato API error', 'forward' ) . ( isset( $result['error'] ) ? ': ' . $result['error'] : '.' ) );
		}
		
	}
	
	public function get_envato_download_purchase_url($username,$api_key,$purchase_code){
		return 'http://marketplace.envato.com/api/edge/' . rawurlencode( $username ) . '/' . rawurlencode( $api_key ) . '/download-purchase:' . rawurlencode( $purchase_code ) . '.json';
	}
	
	public function prepare_request( $action, $args ) {
		global $wp_version;
			
		return array(
			'body' => array(
				'action' => $action,
				'request' => json_encode($args),
				'api-key' => md5(home_url('/'))
			),
			'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
		);
	}
	
	
	public function get_theme_info($get='name'){
		if(empty(self::$_theme_info)){
			$theme_info = wp_get_theme();
			if( $theme_info->parent_theme ) {
				$template_dir 	=  basename( get_template_directory() );
				$theme_info 	= wp_get_theme( $template_dir );
			}
			$version = $theme_info->get('Version');
			$name = $theme_info->get( 'Name' );
			$slug = $theme_info->get_template();
			self::$_theme_info['screenshot'] = $theme_info->get_screenshot();
			self::$_theme_info['name'] = $name;
			self::$_theme_info['slug'] = $slug;
			self::$_theme_info['version'] = $version;
		}
		self::$_theme_info = apply_filters('dh_updater_theme_info', self::$_theme_info);
		if (isset(self::$_theme_info[$get]))
			return self::$_theme_info[$get];
		return '';
	}
	
	public function get_license_key(){
		return dh_get_theme_option('tf_purchase_code','');
	}
	
	public function get_username(){
		return dh_get_theme_option('tf_username','');
	}
	
	public function get_api(){
		return dh_get_theme_option('tf_api','');
	}
	
	public function get_download_url($license_key){
		$url = rawurlencode( $_SERVER['HTTP_HOST'] );
		$key = rawurlencode( $license_key );
		
		$url = $this->_api_url . '?theme='.$this->get_theme_slug().'&url=' . $url . '&key=' . $key . '&version=' . $this->get_version();
		
		$response = wp_remote_get( $url );
		
		if ( is_wp_error( $response ) ) {
			return false;
		}
		
		return json_decode( $response['body'], true );
	}
	
	public function get_screenshot(){
		return self::$_theme_info['screenshot'];
	}
	
	public function get_version(){
		return $this->get_theme_info('version');
	}
	
	public function get_theme_slug(){
		return $this->get_theme_info('slug');
	}
	
	public function get_theme_name(){
		return $this->get_theme_info('name');
	}
	
	public function set_update_manager(DH_Updating_Manager $updater){
		$this->_update_manager = $updater;
	}
	
	public function get_update_manager(){
		return $this->_update_manager;
	}
}
new DH_Updater();