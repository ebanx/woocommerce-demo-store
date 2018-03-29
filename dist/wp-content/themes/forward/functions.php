<?php
class DH_Forward_Theme {
	public $themeInfo;
	public $themeName;
	public $themeAuthor;
	public $themeAuthor_URI;
	public $themeVersion;
	public function __construct(){
		$this->themeInfo            =  wp_get_theme();
		$this->themeName            = trim($this->themeInfo['Title']);
		$this->themeAuthor          = trim($this->themeInfo['Author']);
		$this->themeAuthor_URI      = trim($this->themeInfo['AuthorURI']);
		$this->themeVersion         = trim($this->themeInfo['Version']);
		$this->_define();
		$this->_includes();
		
		add_action( 'wp_head', array(&$this,'theme_slug_render_title' ));
		add_action( 'widgets_init', array(&$this,'register_sidebar' ));
		add_action( 'after_setup_theme', array(&$this,'after_setup_theme' ));
		add_action( 'wp_enqueue_scripts', array(&$this,'enqueue_theme_styles' ));
		add_action( 'wp_enqueue_scripts', array($this,'enqueue_theme_script') );
		
	}
	
	public function theme_slug_render_title(){
		if ( ! function_exists( '_wp_render_title_tag' ) ) {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
		}
	}

	public function after_setup_theme(){
		load_theme_textdomain( 'forward', get_template_directory() . '/languages' );

		add_theme_support( 'nav-menus' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_image_size('dh-thumbnail-square-small',300,300, true);
		add_image_size('dh-thumbnail-square',600, 600, true);
		add_image_size('dh-thumbnail',700,460, true);
		add_image_size('dh-masonry-thumbnail',700,0, true);
		add_theme_support( 'woocommerce' );
		add_theme_support( 'post-formats', array('image', 'video', 'gallery'));
		
		$nav_menus['top'] 		= esc_html__( 'Top Menu', 'forward' );
		$nav_menus['primary'] 	= esc_html__( 'Primary Menu', 'forward' );
		$nav_menus['mobile'] = esc_html__( 'Mobile Menu', 'forward' );
		$nav_menus['sidebar'] = esc_html__( 'Sidebar Menu', 'forward' );
		$nav_menus['footer'] = esc_html__( 'Footer Menu', 'forward' );
		register_nav_menus( $nav_menus );
	}

	protected function _define(){
		define('DH_THEME_NAME', $this->themeName);
		define('DH_THEME_AUTHOR', $this->themeAuthor);
		define('DH_THEME_AUTHOR_URI', $this->themeAuthor_URI);
		define('DH_THEME_VERSION', $this->themeVersion);
	}

	protected function _includes(){
		//do_action('dh_theme_includes');
		include_once (get_template_directory().'/includes/init.php');
		//js composer
		if(defined( 'WPB_VC_VERSION' ))
			include_once (get_template_directory().'/includes/vc/init.php');
		
		if(defined( 'WOOCOMMERCE_VERSION' )){
			//Woocommerce
			include_once (DHINC_DIR . '/woocommerce.php');
			include_once (DHINC_DIR . '/woocommerce_product_variable.php');
			
			//woocoomerce lookbook
			include_once (get_template_directory() . '/includes/lookbook/lookbook.php');
			//woocoomerce brand
			include_once (get_template_directory() . '/includes/dhwc-brand/dhwc-brand.php');
		}
		include_once ( get_template_directory(). '/includes/plugins/tgm-plugin-activation.php');
		$plugin_path = get_template_directory() . '/includes/plugins';
		if ( class_exists('TGM_Plugin_Activation')) {
			include_once ($plugin_path . '/tgmpa_register.php');
		}

	}

	public function enqueue_theme_styles(){
		$protocol = dh_get_protocol();
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$main_css_id = sanitize_file_name(basename(get_template_directory()));
		
		dh_enqueue_google_font();
		
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'forward' ) ) {
			wp_enqueue_style('dh-theme-google-font','//fonts.googleapis.com/css?family=Lato:400,300,700');
		}

		wp_enqueue_style('elegant-icon');
		wp_enqueue_style('font-awesome');
	
		wp_register_style($main_css_id,get_template_directory_uri().'/assets/css/style' . $suffix . '.css',false,DH_THEME_VERSION);
	
		if ( class_exists( 'WPCF7_ContactForm' ) ) :
			wp_deregister_style( 'contact-form-7' );
		endif;
		
		wp_enqueue_style($main_css_id);
		
		if(defined('WOOCOMMERCE_VERSION')){
			wp_enqueue_style($main_css_id.'-woocommerce',get_template_directory_uri().'/assets/css/woocommerce' . $suffix . '.css',array($main_css_id),DH_THEME_VERSION);
		}
		
		
		wp_register_style($main_css_id.'-stylesheet',get_stylesheet_uri(),false,DH_THEME_VERSION);
		do_action('dh_main_inline_style',$main_css_id);
		if($custom_css=dh_get_theme_option('custom-css')){
			wp_add_inline_style($main_css_id.'-stylesheet',dh_css_minify($custom_css));
		}
		wp_enqueue_style($main_css_id.'-stylesheet');
	}

	public function enqueue_theme_script(){
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		
		if(!defined('WOOCOMMERCE_VERSION') && dh_get_theme_option('preloader',1)) 
			wp_enqueue_script( 'cookie', get_template_directory_uri().'/assets/vendor/jquery.cookie'.$suffix.'.js', array('jquery') , '1.4.1', false );
		
		//preloader
		if(dh_get_theme_option('preloader',1)){
			wp_enqueue_style('preloader');
			wp_enqueue_script('preloader');
		}
		
		if(dh_get_theme_option('smartsidebar',0))
			wp_enqueue_script('smartsidebar');
		
		if(dh_get_post_meta('fullpage')){
			wp_enqueue_style('fullpage');
			wp_enqueue_script('fullpage');
		}
		
		wp_register_script('dh', get_template_directory_uri().'/assets/js/script'.$suffix.'.js',array('jquery','boostrap','superfish','appear','easing'),DH_THEME_VERSION,true);
		$logo_retina = '';
		$dhL10n = array(
			'ajax_url'=>admin_url( 'admin-ajax.php', 'relative' ),
			'protocol'=>dh_get_protocol(),
			'breakpoint'=>apply_filters('dh_js_breakpoint', 900),
			'nav_breakpoint'=>apply_filters('dh_nav_breakpoint', 900),
			'cookie_path'=>COOKIEPATH,
			'screen_sm'=>768,
			'screen_md'=>992,
			'screen_lg'=>1200,
			'touch_animate'=>apply_filters('dh_js_touch_animate', true),
			'logo_retina'=>$logo_retina,
			'ajax_finishedMsg'=>esc_attr__('All posts displayed','forward'),
			'ajax_msgText'=>esc_attr__('Loading the next set of posts...','forward'),
			'woocommerce'=>(defined('WOOCOMMERCE_VERSION') ? 1 : 0),
			'imageLazyLoading'=>(dh_get_theme_option('woo-lazyload',1) ? 1 : 0),
			'add_to_wishlist_text'=>esc_attr(apply_filters('dh_yith_wishlist_is_active',defined( 'YITH_WCWL' )) ? apply_filters( 'dh_yith_wcwl_button_label', get_option( 'yith_wcwl_add_to_wishlist_text' )) : ''),
			'user_logged_in'=>(is_user_logged_in() ? 1 : 0),
			'loadingmessage'=>esc_attr__('Sending info, please wait...','forward'),
		);
		wp_localize_script('dh', 'dhL10n', $dhL10n);
		wp_enqueue_script('dh');
		
		
	}


	public function register_sidebar() {
		// Default Sidebar (WP main sidebar)
		register_sidebar( 
			array(  // 1
				'name' => esc_html__( 'Main Sidebar', 'forward' ), 
				'description' => esc_html__( 'This is main sidebar', 'forward' ), 
				'id' => 'sidebar-main', 
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
				'after_widget' => '</div>', 
				'before_title' => '<h4 class="widget-title"><span>', 
				'after_title' => '</span></h4>' ) );
		// Shop Sidebar (WP shop sidebar) 
		register_sidebar( 
			array(  // 1
				'name' => esc_html__( 'Shop Sidebar', 'forward' ), 
				'description' => esc_html__( 'This sidebar use for Woocommerce page', 'forward' ), 
				'id' => 'sidebar-shop', 
				'before_widget' => '<div id="%1$s" class="widget %2$s">', 
				'after_widget' => '</div>', 
				'before_title' => '<h4 class="widget-title"><span>', 
				'after_title' => '</span></h4>' ) );
		register_sidebar(
			array(  // 1
				'name' => esc_html__( 'Shop Filter Sidebar', 'forward' ),
				'description' => esc_html__( 'This sidebar use for Woocommerce page', 'forward' ),
				'id' => 'sidebar-shop-filter',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title"><span>',
				'after_title' => '</span></h4>' ) );
		register_sidebar(
			array(  // 1
				'name' => esc_html__( 'Off-canvas Sidebar', 'forward' ),
				'description' => esc_html__( 'This sidebar use for Offcanvas Sidebar', 'forward' ),
				'id' => 'sidebar-offcanvas',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h4 class="widget-title"><span>',
				'after_title' => '</span></h4>' ) );
		for ( $i = 1; $i <= 5; $i++ ) :
			register_sidebar( 
				array( 
					'name' => esc_html__( 'Footer Sidebar #', 'forward' ) . $i, 
					'id' => 'sidebar-footer-' . $i, 
					'before_widget' => '<div id="%1$s" class="widget %2$s">', 
					'after_widget' => '</div>', 
					'before_title' => '<h3 class="widget-title"><span>', 
					'after_title' => '</span></h3>' ) );
		endfor;
	}
}
$dh_forward_theme = new DH_Forward_Theme();

if ( ! isset( $content_width ) )
	$content_width = 1200;
