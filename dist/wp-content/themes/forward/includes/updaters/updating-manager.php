<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



class DH_Updating_Manager{
	
	protected $_api_url = '';
	
	protected $_current_version;
	
	protected $_theme_name;
	
	protected $_theme_slug;
	
	protected $_screenshot;
	
	public function __construct($api_url,$current_version, $theme_slug, $theme_name, $screenshot){
		$this->_api_url 		= $api_url;
		$this->_current_version = $current_version;
		$this->_theme_name 		= $theme_name;
		$this->_theme_slug 		= $theme_slug;
		$this->_screenshot 		= $screenshot;
		
		add_filter( 'pre_set_site_transient_update_themes', array( &$this, 'check_update' ) );
		
		//set_site_transient('update_themes', null);
	}
	
	public function check_update($transient){
		if ( empty( $transient->checked ) ) {
			return $transient;
		}
		// Get the remote version
		$remote_version = $this->get_remote_version();
		
		// If a newer version is available, add the update
		if ( version_compare( $this->_current_version, $remote_version, '<' ) ) {
			$response = array(
				'new_version'=>$remote_version,
				'url'		 =>'',
				'package'	 =>true
			);
			$transient->response[ $this->_theme_slug ] = $response;
		}
		
		return $transient;
	}
	
	public function get_remote_version(){
		$request = wp_remote_post( $this->_api_url, array( 'body' => array( 'theme'=>$this->_theme_slug,'action' => 'version' ) ) );
		if ( ! is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) === 200 ) {
			return $request['body'];
		}
		return false;
	}
}