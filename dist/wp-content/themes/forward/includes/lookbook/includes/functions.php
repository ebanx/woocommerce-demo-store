<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if (!function_exists('dhwc_is_active')){
	/**
	 * Check woocommerce plugin is active
	 * 
	 * @return boolean .TRUE is active
	 */
	function dhwc_is_active(){
		$plugin = 'woocommerce/woocommerce.php';
		
		if (in_array( $plugin, (array) get_option( 'active_plugins', array() ) ))
			return true;
			
		if ( !is_multisite() )
		return false;
	
		$plugins = get_site_option( 'active_sitewide_plugins');
		if ( isset($plugins[$plugin]) )
			return true;
	
		return false;
	}
}









