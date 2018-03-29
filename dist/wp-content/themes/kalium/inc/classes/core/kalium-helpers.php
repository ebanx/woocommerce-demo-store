<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

class Kalium_Helpers {
	
	/**
	 *	Admin notices to show
	 */
	private static $admin_notices = array();
	
	
	public function __construct() {
		$this->admin_init_priority = 1000;
	}
	
	/**
	 *	Add admin notice
	 */
	public static function addAdminNotice( $message, $type = 'success', $dismissible = true ) {
		
		switch ( $type ) {
			case 'success':
			case 'error':
			case 'warning':
				break;
			
			default:
				$type = 'info';
		}
		
		self::$admin_notices[] = array( 
			'message'        => $message,
			'type'           => $type,
			'dismissible'    => $dismissible ? true : false
		);
	}
	
	/**
	 *	Let to Num
	 */
	public static function letToNum( $size ) {
		$l   = substr( $size, -1 );
		$ret = substr( $size, 0, -1 );
		
		switch ( strtoupper( $l ) ) {
			case 'P':
				$ret *= 1024;
			case 'T':
				$ret *= 1024;
			case 'G':
				$ret *= 1024;
			case 'M':
				$ret *= 1024;
			case 'K':
				$ret *= 1024;
		}
		return $ret;
	}
	
	/**
	 *	Execute admin actions
	 */
	public function admin_init() {
		// Show defined admin notices
		if ( count( self::$admin_notices ) ) {
			add_action( 'admin_notices', array( & $this, 'showAdminNotices' ), 1000 );
		}
	}
	
	/**
	 *	Show defined admin notices
	 */
	public function showAdminNotices() {
		foreach ( self::$admin_notices as $i => $notice ) {
			?>			
			<div class="laborator-notice notice notice-<?php echo $notice['type']; echo $notice['dismissible'] ? ' is-dismissible' : ''; ?>">
				<?php echo wpautop( $notice['message'] ); ?>
			</div>
			<?php
		}
		
	}
	
	/**
	 *	Check if file is SVG extension
	 */
	public function isSVG( $file ) {
		$file_info = pathinfo( $file );
		return 'SVG' == strtoupper( $file_info['extension'] );
	}
	
	
	/**
	 *	Active Plugins
	 */
	public function isPluginActive( $plugin ) {
		if ( is_multisite() ) {
			$plugins = apply_filters( 'active_sitewide_plugins', get_site_option( 'active_sitewide_plugins', array() ) );
		} else {
			$plugins = apply_filters( 'active_plugins', get_option( 'active_plugins', array() ) );
		}
		
		return in_array( $plugin, $plugins ) || isset( $plugins[ $plugin ] );
	}
}