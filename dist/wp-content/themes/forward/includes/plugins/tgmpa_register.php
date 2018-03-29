<?php
if (! function_exists ( 'theme_register_plugin' )) :
	function theme_register_plugin() {
		$plugins = array (
				array (
					'name' => 'Visual Composer',
					'slug' => 'js_composer',
					'source' => get_template_directory_uri () . '/includes/plugins/js_composer.zip',
					'required' =>true,
					'version' => '5.0.1',
					'force_activation' => false,
					'force_deactivation' => false,
					'external_url' => '' 
				),
				array (
					'name' => 'Revolution Slider',
					'slug' => 'revslider',
					'source' => get_template_directory_uri () . '/includes/plugins/revslider.zip',
					'required' =>false,
					'version' => '5.3.1.5',
					'force_activation' => false,
					'force_deactivation' => false,
					'external_url' => ''
				),
				array (
					'name' => 'Essential Grid',
					'slug' => 'essential-grid',
					'source' => get_template_directory_uri () . '/includes/plugins/essential-grid.zip',
					'required' =>true,
					'version' => '2.1.0.2',
					'force_activation' => false,
					'force_deactivation' => false,
					'external_url' => ''
				),
				array (
					'name' => 'Sidebar Generator',
					'slug' => 'smk-sidebar-generator',
					'required' => false 
				),
				array (
					'name' => 'Contact Form 7',
					'slug' => 'contact-form-7',
					'required' => false
				),
				array(
					'name' 		=> 'Woocommerce',
					'slug' 		=> 'woocommerce',
					'required' 	=> false,
					'force_activation' => false,
					'force_deactivation' => false,
				),
				array(
					'name' 		=> 'YITH WooCommerce Wishlist',
					'slug' 		=> 'yith-woocommerce-wishlist',
					'required' 	=> false,
					'force_activation' => false,
					'force_deactivation' => false,
				),
		);
		
		$config = array (
				'domain' => 'forward', // Text domain - likely want to be the same as your theme.
				'default_path' => '', // Default absolute path to pre-packaged plugins
				'menu' => 'install-required-plugins', // Menu slug
				'has_notices' => true, // Show admin notices or not
				'is_automatic' => false, // Automatically activate plugins after installation or not
				'message' => '', // Message to output right before the plugins table
				'strings' => array (
						'page_title' => __ ( 'Install Required Plugins', 'forward' ),
						'menu_title' => __ ( 'Install Plugins', 'forward' ),
						'installing' => __ ( 'Installing Plugin: %s', 'forward' ), // %1$s = plugin name
						'oops' => __ ( 'Something went wrong with the plugin API.', 'forward' ),
						'notice_can_install_required' => _n_noop ( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'forward' ), // %1$s = plugin name(s)
						'notice_can_install_recommended' => _n_noop ( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'forward' ), // %1$s = plugin name(s)
						'notice_cannot_install' => _n_noop ( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'forward' ), // %1$s = plugin name(s)
						'notice_can_activate_required' => _n_noop ( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'forward' ), // %1$s = plugin name(s)
						'notice_can_activate_recommended' => _n_noop ( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'forward' ), // %1$s = plugin name(s)
						'notice_cannot_activate' => _n_noop ( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'forward' ), // %1$s = plugin name(s)
						'notice_ask_to_update' => _n_noop ( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'forward' ), // %1$s = plugin name(s)
						'notice_cannot_update' => _n_noop ( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'forward' ), // %1$s = plugin name(s)
						'install_link' => _n_noop ( 'Begin installing plugin', 'Begin installing plugins', 'forward' ),
						'activate_link' => _n_noop ( 'Activate installed plugin', 'Activate installed plugins','forward' ),
						'return' => __ ( 'Return to Required Plugins Installer', 'forward' ),
						'plugin_activated' => __ ( 'Plugin activated successfully.', 'forward' ),
						'complete' => __ ( 'All plugins installed and activated successfully. %s', 'forward' )  // %1$s = dashboard link
								) 
		);
		
		tgmpa ( $plugins, $config );
	}
	add_action ( 'tgmpa_register', 'theme_register_plugin' );

endif;