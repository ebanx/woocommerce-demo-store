<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DH_Controller' ) ) :

	class DH_Controller {

		public function __construct() {
			add_action('init', array(&$this,'init'));
			// ajax search
			add_action( 'wp_ajax_dh_search_ajax', array( &$this, 'search' ) );
			add_action( 'wp_ajax_nopriv_dh_search_ajax', array( &$this, 'search' ) );
			//ajax login
			add_action( 'wp_ajax_nopriv_dh_facebook_init', array( &$this, 'facebook_init' ) );
			add_action( 'wp_ajax_nopriv_dh_login_ajax', array( &$this, 'login' ) );
			add_action( 'wp_ajax_dh_login_ajax',array( &$this, 'login_priv' ));
			//ajax register
			add_action( 'wp_ajax_nopriv_dh_register_ajax', array( &$this, 'register' ) );
			add_action( 'wp_ajax_dh_register_ajax',array( &$this, 'register_priv' ));
			//ajax lostpassword
			add_action( 'wp_ajax_dh_lostpassword_ajax', array( &$this, 'lostpassword' ) );
			add_action( 'wp_ajax_nopriv_dh_lostpassword_ajax', array( &$this, 'lostpassword' ) );
			//ajax newletter
			add_action('wp_ajax_dh_newsletter_ajax', array(&$this,'newsletter_ajax'));
			add_action('wp_ajax_nopriv_dh_newsletter_ajax', array(&$this,'newsletter_ajax'));
		}
		
		public function init(){
			if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'dh_mailchimp_subscribe'){
				$this->_mailchimp_subscribe();
			}
		}
		
		public function facebook_init(){
			@error_reporting( 0 );
			header( 'Content-type: application/json' );
			if( !isset( $_REQUEST['fb_response'] ) || !isset( $_REQUEST['fb_user'] )) {
				die(json_encode(array('error' => __('Authenication required.', 'forward'))));
			}
			$redirect = '';
			$fb_user = $_REQUEST['fb_user'];
			$fb_response = $_REQUEST['fb_response'];
			$fb_userid = $fb_user['id'];
			if(!isset($fb_user['name']))
				$fb_user['name'] = $fb_userid;
			if(!isset($fb_user['email']))
				$fb_user['email'] = $fb_userid.'@facebook.com';
				
			if( !$fb_userid ) {
				die(json_encode(array('error' => __('Please connect your facebook account.', 'forward'))));
			}
			
			global $wpdb;
			$user_ID = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_fbid' AND meta_value = '$fb_userid'" );
			
			if( !$user_ID ){
				$user_email = $fb_user['email'];
				$user_ID = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_email = '".$wpdb->escape($user_email)."'" );
				
				if( !$user_ID )
				{
					if ( !get_option( 'users_can_register' )) {
						die( json_encode( array( 'error' => __('Registration is not open at this time. Please come back later.', 'forward') )));
					}
					if (dh_get_theme_option('facebook_login',0) == 0) {
						die( json_encode( array( 'error' => __('Registration using Facebook is not currently allowed. Please use our Register page', 'forward') )));
					}
					extract( $fb_user );
					$display_name = $name;
			
					$first_name = '';
					$last_name = '';
					$name_array = explode( ' ', $name, 2 );
					$first_name = $name_array[0];
					if ( isset( $name_array[1] ) ) {
						$last_name = $name_array[1];
					}
			
					if( empty( $verified ) || !$verified ) {
						die(json_encode(array('error' => __('Your facebook account is not verified. You have to verify your account before proceed login or registering on this site.', 'forward'))));
					}
			
					$user_email = $email;
					if ( empty( $user_email )) {
						die(json_encode(array('error' => __('Please click again to login with Facebook and allow the application to use your email address', 'forward'))));
					}
			
					if( empty( $name )) {
						die(json_encode(array('error' => 'empty_name', __('We didn\'t find your name. Please complete your facebook account before proceeding.', 'forward'))));
					}
			
					$user_login = sanitize_title_with_dashes( sanitize_user( $display_name, true ));
			
					if ( username_exists( $user_login ) ) {
						$user_login = $user_login . time();
					}
			
					$user_pass = wp_generate_password( 12, false );
					$userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name', 'first_name', 'last_name' );
					$userdata = apply_filters( 'dh_fb_register_data', $userdata );
			
					$user_ID = wp_insert_user( $userdata );
					if ( is_wp_error( $user_ID )) {
						die( json_encode( array( 'error' => $user_ID->get_error_message() ) ) );
					}
			
					wp_new_user_notification( $user_ID, wp_unslash( $user_pass ) );
			
					do_action( 'fb_register_action', $user_ID );
					do_action( 'user_register', $user_ID );
			
					update_user_meta( $user_ID, '_fbid', (int) $id );
					$logintype = 'register';
					$redirect = apply_filters('dh_register_redirect', '','facebook',$user_ID );
				}
				else
				{
					$logintype = 'login';
				}
			}
			else
			{
				$logintype = 'login';
			}
			
			wp_set_auth_cookie( $user_ID, false, false );
			die( json_encode( array( 'loggedin' => true, 'type' => $logintype, 'url' => $redirect, 'siteUrl' => home_url(), 'message' => __( 'Login successful, redirecting...','forward' ) )));
				
		}
		
		public function login(){
			check_ajax_referer( 'dh-ajax-login-nonce', 'security' );
			$info = array();
			$info['user_login'] = $_POST['log'];
			$info['user_password'] = $_POST['pwd'];
			$info['remember'] = (isset( $_POST['remember'] ) && $_POST['remember'] === true) ? true : false ;
			$info = apply_filters('dh_ajax_login_info', $info);
			
			$user_signon = wp_signon( $info );
			if ( is_wp_error( $user_signon ) ){
				$error_msg = $user_signon->get_error_message();
				wp_send_json(array( 'loggedin' => false, 'message' => '<span class="error-response"><i class="fa fa-times-circle"></i> ' . $error_msg . '</span>' ));
			} else {
				$redirecturl = apply_filters( 'dh_login_redirect', '', 'modal', $user_signon );
				wp_send_json(array('loggedin'=>true, 'redirecturl' => $redirecturl, 'message'=> '<span class="success-response"><i class="fa fa-check-circle"></i> ' . __( 'Login successful, redirecting...','forward' ) . '</span>' ));
			}
			die();
		}
		public function register(){
			if( !check_ajax_referer('dh-ajax-register-nonce', 'security', false) ) {
				$result = array(
					'success' => false,
					'message' => '<span class="error-response">'.__( 'Your session is expired or you submitted an invalid form.', 'forward' ).'</span>',
				);
				wp_send_json($result);
			}
			if(get_option( 'users_can_register' )){
				$user_login = isset($_POST['user_login']) ? $_POST['user_login'] : '';
				$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
				$user_password  = isset($_POST['user_password']) ? $_POST['user_password'] : '';
				$cuser_password = isset($_POST['cuser_password']) ? $_POST['cuser_password'] : '';
				$errors = $this->_register_new_user($user_login, $user_email,$user_password,$cuser_password);
				$result = array();
				if ( is_wp_error( $errors ) ) {
					$result = array(
						'success' => false,
						'message'   => '<span class="error-response">'.$errors->get_error_message().'</span>',
					);
			
				} else {
					$result = array(
						'success'     => true,
						'message'	=> '<span class="success-response"><i class="fa fa-check-circle"></i> '.__( 'Registration complete.', 'forward' ).'</span>',
						'redirecturl'=>apply_filters('noo_register_redirect', home_url('/')),
					);
				}
			}else {
				$result = array(
					'success' => false,
					'message'   =>__( 'Not allow register in site.', 'forward' ),
				);
			}
			wp_send_json($result);
		}
		
		protected function _register_new_user($user_login, $user_email, $user_password='', $cuser_password=''){
			$errors = new WP_Error();
			$sanitized_user_login = sanitize_user( $user_login );
			$user_email = apply_filters( 'user_registration_email', $user_email );
			
			// Check the username was sanitized
			if ( $sanitized_user_login == '' ) {
				$errors->add( 'empty_username', __( 'Please enter a username.', 'forward' ) );
			} elseif ( ! validate_username( $user_login ) ) {
				$errors->add( 'invalid_username', __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', 'forward' ) );
				$sanitized_user_login = '';
			} elseif ( username_exists( $sanitized_user_login ) ) {
				$errors->add( 'username_exists', __( 'This username is already registered. Please choose another one.', 'forward' ) );
			}
			
			// Check the email address
			if ( $user_email == '' ) {
				$errors->add( 'empty_email', __( 'Please type your email address.', 'forward' ) );
			} elseif ( ! is_email( $user_email ) ) {
				$errors->add( 'invalid_email', __( 'The email address isn\'t correct.', 'forward' ) );
				$user_email = '';
			} elseif ( email_exists( $user_email ) ) {
				$errors->add( 'email_exists', __( 'This email is already registered, please choose another one.', 'forward' ) );
			}
			//Check the password
			
			if(empty($user_password)){
				$user_password = wp_generate_password( 12, false );
			}else{
				if(strlen($user_password) < 6){
					$errors->add( 'minlength_password', __( 'Password must be 6 character long.', 'forward' ) );
				}elseif (empty($cuser_password)){
					$errors->add( 'not_cpassword', __( 'Not see password confirmation field.', 'forward' ) );
				}elseif ($user_password != $cuser_password){
					$errors->add( 'unequal_password', __( 'Passwords do not match.', 'forward' ) );
				}
			}
			
			$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
			
			if ( $errors->get_error_code() )
				return $errors;
			
			$user_pass = $user_password;
			$new_user = array(
				'user_login' => $sanitized_user_login,
				'user_pass'  => $user_pass,
				'user_email' => $user_email,
			);
			$user_id = wp_insert_user( apply_filters( 'noo_create_user_data', $new_user ) );
			//$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );
			
			if ( ! $user_id ) {
				$errors->add( 'registerfail', __( 'Couldn\'t register you... please contact the site administrator', 'forward' ) );
				return $errors;
			}
			
			update_user_option( $user_id, 'default_password_nag', true, true ); // Set up the Password change nag.
			
			$user = get_userdata( $user_id );
			
			if(!empty($user_password)){
				wp_new_user_notification( $user_id, $user_pass );
			
				$data_login['user_login']             = $user->user_login;
				$data_login['user_password']          = $user_password;
				$user_login                           = wp_signon( $data_login, false );
			}
			
			
			add_filter( 'wp_mail_content_type',array(&$this,'set_html_content_type' ),100);
			
			if ( is_multisite() )
				$blogname = $GLOBALS['current_site']->site_name;
			else
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			
			$headers = array();
			$from = dh_do_not_reply_address();
			$headers[] = 'From: ' . $blogname . ' ' . $from;
			
			// user email
			$subject = sprintf(__('Welcome to [%1$s]','forward'),$blogname);
			$to = $user->email;
			
			$message = __('Hi %1$s,<br/><br/>You\'ve just successfully registered an account on %2$s.<br/>Start reading now! %3$s<br/><br/>Best regards,<br/>%4$s','forward');
			
			@wp_mail($to, $subject, sprintf($message,$user->display_name,$blogname,home_url(),$blogname),$headers);
			
			remove_filter( 'wp_mail_content_type',array(&$this,'set_html_content_type' ),100);
			
			//wp_set_auth_cookie($user_id);
			return $user_id;
		}
		
		public function set_html_content_type(){
			return 'text/html';
		}
		
		public function register_priv(){
			$link = "javascript:window.location.reload();return false;";
			wp_send_json(array('success'=>true, 'message'=> sprintf(__('You are already logged in. Please <a href="#" onclick="%s">refresh</a> page','forward'),$link)));
			die();
		}
		
		public function login_priv(){
			$link = "javascript:window.location.reload();return false;";
			wp_send_json(array('loggedin'=>true, 'message'=> sprintf(__('You are already logged in. Please <a href="#" onclick="%s">refresh</a> page','forward'),$link)));
			die();
		}
		
		public function lostpassword(){
			check_ajax_referer( 'dh-ajax-lostpassword-nonce', 'security' );
			global $wpdb, $wp_hasher;
			
			$errors = new WP_Error();
			
			if ( isset($_POST) ) {
			
				if ( empty( $_POST['user_login'] ) ) {
					$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.','forward'));
				} else if ( strpos( $_POST['user_login'], '@' ) ) {
					$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
					if ( empty( $user_data ) )
						$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.','forward'));
				} else {
					$login = trim($_POST['user_login']);
					$user_data = get_user_by('login', $login);
				}
			
				/**
				 * Fires before errors are returned from a password reset request.
				 *
				 * @since 2.1.0
				 */
				do_action( 'lostpassword_post' );
			
				if ( $errors->get_error_code() ) {
					echo '<span class="error-response">' . $errors->get_error_message() . '</span>';
					die();
				}
			
				if ( !$user_data ) {
					$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.','forward'));
					echo '<span class="error-response">' . $errors->get_error_message() . '</span>';
					die();
				}
			
				// Redefining user_login ensures we return the right case in the email.
				$user_login = $user_data->user_login;
				$user_email = $user_data->user_email;
			
				/**
				 * Fires before a new password is retrieved.
				 *
				 * @since 1.5.0
				 * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
				 *
				 * @param string $user_login The user login name.
				 */
				do_action( 'retreive_password', $user_login );
			
				/**
				 * Fires before a new password is retrieved.
				 *
				 * @since 1.5.1
				 *
				 * @param string $user_login The user login name.
				*/
				do_action( 'retrieve_password', $user_login );
			
				/**
				 * Filter whether to allow a password to be reset.
				 *
				 * @since 2.7.0
				 *
				 * @param bool true           Whether to allow the password to be reset. Default true.
				 * @param int  $user_data->ID The ID of the user attempting to reset a password.
				*/
				$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );
			
				if ( ! $allow ) {
					echo '<span class="error-response">' . __('Password reset is not allowed for this user','forward') . '</span>';
					die();
				}
				else if ( is_wp_error($allow) ) {
					echo '<span class="error-response">' . $allow->get_error_message() . '</span>';
					die();
				}
			
				if(function_exists('get_password_reset_key')){
					$key = get_password_reset_key($user_data);
					if(is_wp_error($key)){
						echo '<span class="error-response">' . $key->get_error_message() . '</span>';
						die();
					}
				}else{
					// Generate something random for a password reset key.
					$key = wp_generate_password( 20, false );
						
					/**
					 * Fires when a password reset key is generated.
					 *
					 * @since 2.5.0
					 *
					 * @param string $user_login The username for the user.
					 * @param string $key        The generated password reset key.
					*/
					do_action( 'retrieve_password_key', $user_login, $key );
						
					// Now insert the key, hashed, into the DB.
					if ( empty( $wp_hasher ) ) {
						require_once ABSPATH . WPINC . '/class-phpass.php';
						$wp_hasher = new PasswordHash( 8, true );
					}
					$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
					$key_saved = $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );
					if ( false === $key_saved ) {
						echo '<span class="error-response">' . __( 'Could not save password reset key to database.','forward') . '</span>';
						die();
					}
				}
				
				$message = __('Someone requested that the password be reset for the following account:','forward') . "\r\n\r\n";
				$message .= network_home_url( '/' ) . "\r\n\r\n";
				$message .= sprintf(__('Username: %s','forward'), $user_login) . "\r\n\r\n";
				$message .= __('If this was a mistake, just ignore this email and nothing will happen.','forward') . "\r\n\r\n";
				$message .= __('To reset your password, visit the following address:','forward') . "\r\n\r\n";
				$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
			
				if ( is_multisite() )
					$blogname = $GLOBALS['current_site']->site_name;
				else
					/*
					 * The blogname option is escaped with esc_html on the way into the database
				* in sanitize_option we want to reverse this for the plain text arena of emails.
				*/
					$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			
				$title = sprintf( __('[%s] Password Reset','forward'), $blogname );
			
				/**
				 * Filter the subject of the password reset email.
				 *
				 * @since 2.8.0
				 *
				 * @param string $title Default email title.
				*/
				$title = apply_filters( 'retrieve_password_title', $title );
				/**
				 * Filter the message body of the password reset mail.
				 *
				 * @since 2.8.0
				 *
				 * @param string $message Default mail message.
				 * @param string $key     The activation key.
				*/
				$message = apply_filters( 'retrieve_password_message', $message, $key );
			
			
				if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
					echo '<span class="error-response">' . __("Failure!", 'forward');
					echo __('The e-mail could not be sent.','forward');
					echo "</span>";
					die();
				} else {
					echo '<span class="success-response"><i class="fa fa-check-circle"></i> ' . __("Email successfully sent!", 'forward')."</span>";
					die();
				}
			}
			die();
		}
		public function newsletter_ajax(){
			$this->_mailchimp_subscribe(true);
		}
		/**
		 * Mailchimp subscribe
		 */
		protected function _mailchimp_subscribe($is_ajax = false) {
			$mailchimp_api = dh_get_theme_option( 'mailchimp_api', false );
			$success = -1;
			$message = '';
			$_POST = stripslashes_deep($_POST);
			$_REQUEST = stripslashes_deep($_REQUEST);
			$_GET = stripslashes_deep($_GET);
			
			$data = $_REQUEST;
			
			$nonce = $_REQUEST['_subscribe_nonce'];
			if(!wp_verify_nonce( $nonce, 'mailchimp_subscribe_nonce' )){
				if($is_ajax)
					wp_send_json(array( 'success' => false, 'message' => '<span class="error-response"><i class="fa fa-times-circle"></i> ' . __('Verify Nonce Failed','forward') . '</span>' ));
				else
					wp_die(__('Verify Nonce Failed','forward'));
			}
			if(!filter_var(@$data['email'], FILTER_VALIDATE_EMAIL)){
				if($is_ajax)
					wp_send_json(array( 'success' => false, 'message' => '<span class="error-response"><i class="fa fa-times-circle"></i> ' . __('Please enter a valid email address','forward') . '</span>' ));
				else
					wp_die(__('Invalid Email','forward'));
			}
			
			if ( $mailchimp_api ) {
				if ( ! class_exists( 'MCAPI' ) )
					include_once ( DHINC_DIR . '/lib/MCAPI.class.php' );
				
				$api = new MCAPI( $mailchimp_api );
				$list_id = dh_get_theme_option( 'mailchimp_list', 0 );
				$first_name = isset( $data['first_name'] ) ? $data['first_name'] : ( isset( $data['name'] ) ? $data['name'] : '' );
				$last_name = isset( $data['last_name'] ) ? $data['last_name'] : ( isset( $data['name'] ) ? $data['name'] : '' );
				$email_address = isset( $data['email'] ) ? $data['email'] : '';
				$merge_vars = array( 'FNAME' => $first_name, 'LNAME' => $last_name );
				$mailchimp_group_name = dh_get_theme_option( 'mailchimp_group_name', '' );
				$mailchimp_group = dh_get_theme_option( 'mailchimp_group', '' );
				if ( ! empty( $mailchimp_group ) && ! empty( $mailchimp_group_name ) ) {
					$merge_vars['GROUPINGS'] = array( array( 
						'name' => $mailchimp_group_name, 
						'groups' => $mailchimp_group ) );
				}
				$merge_vars = apply_filters('dh_mailchimp_groupings', $merge_vars);
				$double_optin = dh_get_theme_option( 'mailchimp_opt_in', '' ) === '1' ? true : false;
				$replace_interests = dh_get_theme_option( 'mailchimp_replace_interests', '' ) === '1' ? true : false;
				$send_welcome = dh_get_theme_option( 'mailchimp_welcome_email', '' ) === '1' ? true : false;
				
				try {
					$retval = $api->listSubscribe( 
						$list_id, 
						$email_address, 
						$merge_vars, 
						$email_type = 'html', 
						$double_optin, 
						false, 
						$replace_interests, 
						$send_welcome );
					if($retval)
						$success = 1;
					elseif (!$is_ajax && current_user_can('administrator') && !empty($api->errorMessage))
						wp_die($api->errorMessage);
				} catch ( Exception $e ) {
					if ( $e->getCode() == 214 ) {
						$success = 1;
					} else {
						$message = $e->getMessage();
					}
				}
			}
			if($is_ajax){
				if($success == 1){
					wp_send_json(array( 'success' => true, 'message' => '<span class="success-response"><i class="fa fa-check-circle"></i> ' . __('<strong>Well done!</strong> Subscribe to our Newsletter successful!','forward') . '</span>' ));
				}else{
					wp_send_json(array( 'success' => false, 'message' => '<span class="error-response"><i class="fa fa-times-circle"></i> ' . __('Can not subscribe our Newsletter','forward') . '</span>' ));
				}
			}else{
				$return = esc_url_raw(add_query_arg( 'mailchimp_subscribe',$success, wp_get_referer() ));
				wp_safe_redirect( $return.'#mailchimp-form-'.$nonce);
				die();
			}
		}

		/**
	 	* Ajax search
	 	*/
		public function search() {
			if ( empty( $_REQUEST['s'] ) ) {
				die();
			}
			$output = "";
			$args = array( 
				'post_type' => apply_filters('dh_ajax_search_form_post_type', 'product'), 
				'post_status' => 'publish', 
				'post_password' => '', 
				'suppress_filters' => false, 
				'numberposts' => 4, 
				's' => $_REQUEST['s'] );
			$args = apply_filters( 'dh_search_query_args', $args );
			$posts = get_posts( $args );
			if ( empty( $posts ) ) {
				$output .= '<div class="no-result">';
				$output .= __( 'No results matched!', 'forward' );
				$output .= '</div>';
			} else {
				$post_types = array();
				$post_types_object = array();
				foreach ( $posts as $post ) {
					$post_types[$post->post_type][] = $post;
					if ( empty( $post_types_object[$post->post_type] ) ) {
						$post_types_object[$post->post_type] = get_post_type_object( $post->post_type );
					}
				}
				$output .= '<div class="searchform-result-list">';
				foreach ( $post_types as $ptype => $post_type ) {
					if ( isset( $post_types_object[$ptype]->labels->name ) ) {
						$output .= '<h3 class="search-object"><span>' . $post_types_object[$ptype]->labels->name .
							 '</span></h3>';
					} else {
						$output .= "<hr>";
					}
					foreach ( $post_type as $post ) {
						$format = get_post_format( $post->ID );
						if ( get_the_post_thumbnail( $post->ID, 'thumbnail' ) ) {
							$image = get_the_post_thumbnail( $post->ID, 'thumbnail' );
						} else {
							if ( $format == 'video' ) {
								$image = "<i class='fa fa-file-video-o'></i>";
							} elseif ( $format == 'image' || $format == 'gallery' ) {
								$image = "<i class='fa fa-file-image-o'></i>";
							} else {
								$image = "<i class='fa fa-file-text-o'></i>";
							}
						}
						
						$excerpt = "";
						
						if ( ! empty( $post->post_content ) ) {
							$excerpt = wp_html_excerpt( strip_shortcodes( $post->post_content ), 30, "..." );
						}
						$link = apply_filters( 'dh_search_item_url', get_permalink( $post->ID ) );
						$output .= '<div class="search-entry">';
						$output .= '<div class="search-image">' . $image . '</div>';
						$output .= '<div class="search-content">';
						$output .= '<h4 class="search-title">';
						$output .= '<a href="' . $link . '">';
						$output .= get_the_title( $post->ID );
						$output .= '</a>';
						$output .= '</h4>';
						$output .= '<span class="search-excerpt">';
						$output .= $excerpt;
						$output .= '</span>';
						$output .= '</div>';
						$output .= '</div>';
					}
				}
				$output .= '</div>';
				$output .= '<div class="search-view-all"><a href="' . home_url( '?s=' . $_REQUEST['s'] ) . '&post_type='.(post_type_exists('product') ? 'product' : 'post').'">' .
					 __( 'View all results', 'forward' ) . '</a>';
			}
			$output = apply_filters('dh_ajax_search_form_result', $output);
			echo dh_print_string($output);
			die();
		}
	}
	new DH_Controller();

endif;