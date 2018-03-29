<?php
/**
 *	Kalium WordPress Theme
 *	
 *	Laborator.co
 *	www.laborator.co 
 */

class Kalium_Theme_License {
	
	/**
	 *	Current activated license
	 */
	private static $license;
	
	/**
	 *	Laborator API Server URL
	 */
	public static $api_server = 'https://api.laborator.co';
	
	public function __construct() {
		add_action( 'admin_menu', array( & $this, 'productRegistrationMenuItem' ) );
		
		// Initialize License
		self::initLicenseVar();
	}
	
	/**
	 *	Admin Actions for this class
	 */
	public function admin_init() {
		global $wp_version;
		
		// Do not execute on AJAX
		if ( defined( 'DOING_AJAX' ) ) {
			return false;
		}
		
		// Product activated page check referer and verify license
		if ( 'kalium-product-registration' == $this->admin_page && isset( $_GET['license_key'] ) ) {
			$license_key = kalium()->get( 'license_key' );
			$referer = parse_url( server_var( 'HTTP_REFERER' ) );
			
			// Verify License from Laborator API Server
			$this->product_activated = true;
			
			if ( kalium()->get( 'perform_verification' ) ) {
				$verify_license_response = wp_remote_post( self::$api_server . "/verify-license/{$license_key}/" );
				
				$license_data = json_decode( wp_remote_retrieve_body( $verify_license_response ) );
				
				if ( $license_data->valid ) {
					unset( $license_data->valid );
					set_theme_mod( 'license', $license_data );
					wp_redirect( remove_query_arg( 'perform_verification' ) );
					die();
				}
			}
		}
		
		// Theme Backups
		if ( 'kalium-product-registration' == $this->admin_page && isset( $_POST['theme_backups'] ) ) {
			if ( self::$license ) {
				self::$license->save_backups = $_POST['theme_backups'];
				set_theme_mod( 'license', self::$license );
				Kalium_Helpers::addAdminNotice( 'Theme backup settings have been saved!' );
			}
		}
		
		// Delete Theme Activation
		if ( 'kalium-product-registration' == $this->admin_page && isset( $_GET['action'] ) && 'delete-theme-activation' == $_GET['action'] ) {
			Kalium_Helpers::addAdminNotice( 'Theme activation has been deleted!', 'warning' );
			
			if ( isset( $_GET['_nonce'] ) && wp_verify_nonce( $_GET['_nonce'], 'delete-theme-activation' ) ) {
				remove_theme_mod( 'license' );
				wp_redirect( remove_query_arg( array( '_nonce' ) ) ); 
				die();
			}
		}
		
		// Theme Activation Instance
		add_action( 'kalium_product_registration_page', array( & $this, 'themeActivationShowInstance' ) );
		
		// Nearly expiring notification
		if ( self::nearlyExpiring() ) {
			$this->displayNearlyExpiringNotice();
		}
	}
	
	/**
	 *	Add "Product Registration" item in admin menu
	 */
	public function productRegistrationMenuItem() {
		// Product Registration
		add_submenu_page( 'laborator_options', 'Product Registration', 'Product Registration', 'edit_theme_options', 'kalium-product-registration', array( & $this, 'adminPageProductRegistration' ), '', 4 );
	}
	
	/**
	 *	Product Registration Page
	 */
	public function adminPageProductRegistration() {
		if ( isset( $this->product_activated ) && $this->product_activated ) {
			include kalium()->locateFile( 'inc/admin-tpls/page-product-activated.php' );
		} else {
			include kalium()->locateFile( 'inc/admin-tpls/page-product-registration.php' );
		}
	}
	
	/**
	 *	Product Activation JSON Instance
	 */
	public function themeActivationShowInstance() {
		?>
		<script id="laborator-form-data-json" type="text/template"><?php echo json_encode( array_map( 'utf8_encode', array(
			'action'       => 'activate-product',
			'theme_id'     => 'kalium',
			'api'          => self::$api_server,
			'version'      => kalium()->getVersion(),
			'url'          => home_url(),
			'ref_url'      => admin_url( 'admin.php?page=' . $this->admin_page ),
			'server_ip'    => $_SERVER['SERVER_ADDR']
		) ) ); ?></script>
		<?php
	}
	
	/**
	 *	Diplay Nearly Expiring Notices
	 */
	private function displayNearlyExpiringNotice() {
		$days_left            = self::nearlyExpiring( true );
		$supported_until      = self::license()->supported_until;
		$supported_until_var  = 'theme-support-expiration-' . sanitize_title( $supported_until );
		$support_package_link = 'https://themeforest.net/item/kalium-creative-theme-for-professionals/10860525?ref=Laborator';
		
		// Display expiration notice if its not dismissed
		if ( ! get_theme_mod( $supported_until_var ) ) {				
			$dismiss_notice_link = '<a href="' . add_query_arg( array( 'laborator_dismiss_expiration' => wp_create_nonce( $supported_until_var ) ) ) . '">Dismiss this notice</a>';
			
			if ( $days_left > 0 ) {
				$date = date( 'r', strtotime( $supported_until ) );
				$days = $days_left == 1 ? '1 day' : "{$days_left} days";
				
				Kalium_Helpers::addAdminNotice( sprintf( 'Your support package for this theme is about to expire (<span title="%s">%s</span> left). <a href="%s" target="_blank">Renew support</a> package with 30%% discount before it expires. %s', "Expiration: $date", $days, $support_package_link, $dismiss_notice_link ), 'warning' );
			}
			
			// Dismiss the notice
			if ( isset( $_GET['laborator_dismiss_expiration'] ) && check_admin_referer( $supported_until_var, 'laborator_dismiss_expiration' ) ) {
				set_theme_mod( $supported_until_var, true );
				wp_redirect( remove_query_arg( 'laborator_dismiss_expiration' ) );
				die();
			}
		}
	}
	
	/**
	 *	Initialize Current Activated License
	 */
	public static function initLicenseVar() {
		$license = get_theme_mod( 'license' );
		
		if ( is_object( $license ) && isset( $license->license_key ) && isset( $license->purchase_date ) && isset( $license->supported_until ) && isset( $license->save_backups ) ) {
			$supported_until_time = strtotime( $license->supported_until );
			$support_expired = $supported_until_time < time();
			
			$license->support_expired = $support_expired;
			
			self::$license = $license;
		}
		
		if ( isset( self::$license ) ) {
			return self::$license;
		}
		
		return null;
	}
	
	/**
	 *	Get current license
	 */
	public static function license() {
		return self::$license;
	}
	
	/**
	 *	Check if license is nearly expiring
	 */
	public static function nearlyExpiring( $num_days = false ) {
		$license = self::license();
		$days_before_expiring = 15;
		
		if ( $license ) {
			$supported_until_time = strtotime( $license->supported_until );
			$days_left = round( ( $supported_until_time - time() ) / ( 3600 * 24 ) );
			
			if ( $supported_until_time - time() <= $days_before_expiring * 86400 ) {
				return $num_days ? $days_left : true;
			}
			
			return false;
		}
		
		return null;
	}
	
	/**
	 *	Check validity of license
	 */
	public static function isValid() {
		$license = self::$license;
		
		if ( is_object( $license ) && isset( $license->license_key ) && isset( $license->purchase_date ) && isset( $license->supported_until ) ) {
			return true;
		}
		
		return false;
	}
}