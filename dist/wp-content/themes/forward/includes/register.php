<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DH_Register' ) ) :

	class DH_Register {

		public function __construct() {
			add_action( 'init', array( &$this, 'init' ) );
		}

		public function init() {
			if ( is_admin() ) {
				$this->register_vendor_assets();
			}else {
				add_action( 'template_redirect', array($this,'register_vendor_assets' ));
			}
		}
		
		public function register_vendor_assets() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			
			wp_deregister_style('dhvc-form-font-awesome');
			
			wp_register_style('font-awesome',get_template_directory_uri().'/assets/vendor/font-awesome/css/font-awesome' . $suffix . '.css', array(), '4.6.2' );
			wp_register_style('elegant-icon',get_template_directory_uri().'/assets/vendor/elegant-icon/css/elegant-icon.css');
			
			wp_register_style( 'preloader', get_template_directory_uri().'/assets/vendor/preloader/preloader.css', '1.0.0' );
			wp_register_script( 'preloader', get_template_directory_uri().'/assets/vendor/preloader/preloader'.$suffix.'.js', array('jquery') , '1.0.0', false );
			
			wp_register_script( 'countdown', get_template_directory_uri().'/assets/vendor/jquery.countdown'.$suffix.'.js', array('appear') , '2.0.4', true );
			
			wp_register_script( 'stellar', get_template_directory_uri().'/assets/vendor/jquery.stellar'.$suffix.'.js', array('appear') , '2.0.4', true );
			
			wp_register_script( 'smartsidebar', get_template_directory_uri().'/assets/vendor/smartsidebar'.$suffix.'.js', array('jquery') , '1.0.0', true );
			
			
			wp_register_style( 'chosen', get_template_directory_uri().'/assets/vendor/chosen/chosen.min.css', '1.1.0' );
			wp_register_script( 'chosen', get_template_directory_uri().'/assets/vendor/chosen/chosen.jquery' . $suffix .'.js', array( 'jquery' ), '1.0.0', true );
			
			
			wp_register_script( 'ajax-chosen', get_template_directory_uri().'/assets/vendor/chosen/ajax-chosen.jquery' . $suffix . '.js', array( 'jquery', 'chosen' ), '1.0.0', true );
			wp_register_script( 'appear', get_template_directory_uri().'/assets/vendor/jquery.appear' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );
			wp_register_script( 'typed', get_template_directory_uri().'/assets/vendor/typed' . $suffix .'.js', array( 'jquery','appear' ), '1.0.0', true );
			wp_register_script( 'easing', get_template_directory_uri().'/assets/vendor/easing' . $suffix . '.js', array( 'jquery' ), '1.3.0', true );
			wp_register_script( 'waypoints', get_template_directory_uri().'/assets/vendor/waypoints' . $suffix . '.js', array( 'jquery' ), '2.0.5', true );
			wp_register_script( 'transit', get_template_directory_uri().'/assets/vendor/jquery.transit' . $suffix . '.js', array( 'jquery' ), '0.9.12', true );
			wp_register_script( 'imagesloaded', get_template_directory_uri().'/assets/vendor/imagesloaded.pkgd' . $suffix . '.js', array( 'jquery' ), '3.1.8', true );
			
			wp_register_script( 'requestAnimationFrame', get_template_directory_uri().'/assets/vendor/requestAnimationFrame' . $suffix . '.js', null, '0.0.17', true );
			wp_register_script( 'parallax', get_template_directory_uri().'/assets/vendor/jquery.parallax' . $suffix . '.js', array( 'jquery'), '1.1.3', true );
			
			wp_register_script( 'boostrap', get_template_directory_uri().'/assets/vendor/bootstrap' . $suffix . '.js', array('jquery','imagesloaded'), '3.2.0', true );
			wp_register_script( 'superfish',get_template_directory_uri().'/assets/vendor/superfish-1.7.4.min.js',array( 'jquery' ),'1.7.4',true );
			
			wp_register_style('jquery-ui-bootstrap',get_template_directory_uri() . '/assets/vendor/jquery-ui-bootstrap/jquery-ui-1.10.0.custom.css', array(), '1.10.0' );
				
			wp_register_script( 'ace-editor', get_template_directory_uri(). '/assets/vendor/ace/ace.js', array( 'jquery' ), DHINC_VERSION, true );
			
			wp_register_style( 'datetimepicker', get_template_directory_uri() . '/assets/vendor/datetimepicker/jquery.datetimepicker.css', '2.4.0' );
			wp_register_script( 'datetimepicker', get_template_directory_uri() . '/assets/vendor/datetimepicker/jquery.datetimepicker.js', array( 'jquery' ), '2.4.0', true );
			
			
			wp_register_script( 'countTo', get_template_directory_uri().'/assets/vendor/jquery.countTo' . $suffix . '.js', array( 'jquery', 'waypoints' ), '2.0.2', true );
			wp_register_script( 'infinitescroll', get_template_directory_uri().'/assets/vendor/jquery.infinitescroll' . $suffix . '.js', array( 'jquery','imagesloaded' ), '2.0.2', true );
			
			wp_register_script( 'ProgressCircle', get_template_directory_uri().'/assets/vendor/ProgressCircle' . $suffix . '.js', array( 'jquery'), '2.0.2', true );
			
			wp_register_style( 'magnific-popup', get_template_directory_uri().'/assets/vendor/magnific-popup/magnific-popup.css' );
			wp_register_script( 'magnific-popup', get_template_directory_uri().'/assets/vendor/magnific-popup/jquery.magnific-popup' . $suffix . '.js', array( 'jquery' ), '0.9.9', true );
			
			wp_register_script( 'touchSwipe', get_template_directory_uri().'/assets/vendor/jquery.touchSwipe' . $suffix . '.js', array( 'jquery'), '1.6.6', true );
			
			wp_register_script( 'carouFredSel', get_template_directory_uri().'/assets/vendor/jquery.carouFredSel' . $suffix . '.js', array( 'jquery','touchSwipe', 'easing','imagesloaded','transit'), '6.2.1', true );
			wp_register_script( 'isotope', get_template_directory_uri().'/assets/vendor/isotope.pkgd' . $suffix . '.js', array( 'jquery', 'imagesloaded' ), '6.2.1', true );
			
			wp_register_script( 'easyzoom', get_template_directory_uri().'/assets/vendor/easyzoom/easyzoom' . $suffix . '.js', array( 'jquery'), '0.9.9', true );
			
			wp_register_script( 'fitvids', get_template_directory_uri().'/assets/vendor/jquery.fitvids' . $suffix . '.js', array( 'jquery'), '1.0.0', true );
			
			wp_register_script( 'unveil', get_template_directory_uri().'/assets/vendor/jquery.unveil' . $suffix . '.js', array( 'jquery'), '1.0.0', true );
			wp_register_script( 'dh-pie', get_template_directory_uri().'/assets/vendor/jquery.dhPie' . $suffix . '.js', array('jquery','waypoints','ProgressCircle',), '1.0.0', true );
				
			wp_register_style( 'fullpage', get_template_directory_uri() . '/assets/vendor/fullpage/jquery.fullpage.min.css', '2.7.9' );
			wp_register_script( 'slimscroll', get_template_directory_uri().'/assets/vendor/fullpage/jquery.slimscroll.min.js', array('jquery',), '1.3.2', true );
			wp_register_script( 'fullpage', get_template_directory_uri().'/assets/vendor/fullpage/jquery.fullpage.min.js', array('jquery','slimscroll',), '2.7.9', true );
		}
		
	}
	new DH_Register();


endif;