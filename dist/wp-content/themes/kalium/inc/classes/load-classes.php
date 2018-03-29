<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

$current_dir = dirname( __FILE__ );

return apply_filters( 'kalium_load_classes', array(
	'Kalium_Helpers'           => $current_dir . '/core/kalium-helpers.php',
	
	'Kalium_Theme_Upgrader'    => $current_dir . '/core/kalium-theme-upgrader.php',
	'Kalium_Theme_License'     => $current_dir . '/core/kalium-theme-license.php',
	'Kalium_Version_Upgrades'  => $current_dir . '/core/kalium-version-upgrades.php',
	
	'Laborator_System_Status'  => $current_dir . '/utility/laborator-system-status.php',
) );