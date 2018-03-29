<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

class Kalium_Version_Upgrades {
	
	/**
	 *	Recent versions of the theme
	 *	Defined only by developer
	 */
	private $version_history = array( '1.9.5.1' );
	
	public function __construct() {
	}
	
	/**
	 *	Check for version upgrades callbacks
	 */
	public function admin_init() {
		// Execute callbacks for version upgrades
		$version_upgrades = get_option( 'kalium_version_upgrades', array() );
		$current_version = kalium()->getVersion();
		$_current_version = str_replace( '.', '_', $current_version );
		
		$this->version_history[] = $current_version;
		
		foreach ( $this->version_history as $previous_version ) {
			if ( ! in_array( $previous_version, $version_upgrades ) && version_compare( $current_version, $previous_version, '>' ) ) {
				// Version upgrade function name callback
				$current_version_callback_fn = 'version_upgrade_' . $_current_version;
				
				// Native version upgrade callback
				if ( method_exists( $this, $current_version_callback_fn ) ) {
					$this->$current_version_callback_fn( $previous_version );
				}
				
				// Execute version upgrade actions
				do_action( 'kalium_version_upgrade', $current_version, $previous_version );
				do_action( 'kalium_version_upgrade_' . $_current_version, $previous_version );
				
				// Register this version upgrade
				$version_upgrades[] = $previous_version;
				update_option( 'kalium_version_upgrades', $version_upgrades );
			}
		}
	}
	
	/**
	 *	Upgrading to version 2.0
	 */
	public function version_upgrade_2_0( $previous_version ) {
		// Kalium Updated Redirection
		update_option( 'kalium_updated', true );
	}
}