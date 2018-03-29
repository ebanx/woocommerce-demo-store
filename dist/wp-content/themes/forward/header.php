<?php 
	$header_style = dh_get_theme_option('header-style','classic');
	$menu_transparent = dh_get_theme_option('menu-transparent',0);
	$page_heading = 0;
	$show_heading = dh_get_theme_option('show-heading','1');
	$heading_bg = dh_get_theme_option('heading-bg',0);
	if($show_heading == '1'){
		$page_heading = dh_get_post_meta('page_heading',get_the_ID(),'default');
		if(!empty($heading_bg) && $page_heading === 'default'){
			$page_heading = 'heading';
		}
	}
	$page_heading_background_image = dh_get_post_meta('page_heading_background_image');
	$page_heading_title = dh_get_post_meta('page_heading_title');
	$page_heading_sub_title = dh_get_post_meta('page_heading_sub_title');
	$page_heading_color = dh_get_post_meta('page_heading_color');
	$page_heading_align = dh_get_post_meta('page_heading_align');
	$page_heading_button_text  = dh_get_post_meta('page_heading_button_text');
	$page_heading_button_url  = dh_get_post_meta('page_heading_button_url');
	$page_heading_breadcrumb_flag = false;
	
	if ( defined( 'WOOCOMMERCE_VERSION' ) ) {
		if(is_singular('product') && dh_get_theme_option('single-product-style','style-1') == 'style-3'){
			$page_heading = 0;
		}
		if(!empty($page_heading) && is_product_taxonomy()){
			$term_id = get_queried_object_id();
			$page_heading_background_image 	= get_woocommerce_term_meta( $term_id, 'product_cat_heading_thumbnail_id', true );
			$page_heading_title = get_woocommerce_term_meta( $term_id, 'product_cat_heading_title', true );
			$page_heading_sub_title = get_woocommerce_term_meta( $term_id, 'product_cat_heading_sub_title', true );
			$page_heading_button_text = get_woocommerce_term_meta( $term_id, 'product_cat_heading_button_text', true );
			$page_heading_button_url = get_woocommerce_term_meta( $term_id, 'product_cat_heading_button_link', true );
			if(empty($page_heading_title)){
				$page_heading_title = single_term_title('',false);
			}
			$page_heading = apply_filters('dh_product_taxonomy_menu_heading', 'heading',$term_id);'';
			$menu_transparent = apply_filters('dh_product_taxonomy_menu_transparent', false,$term_id);
		}
		
	}
	$page_heading_background_image_url = wp_get_attachment_url($page_heading_background_image);
	if (empty($page_heading_background_image_url)){
		if(!empty($heading_bg))
			$page_heading_background_image_url = $heading_bg;
		else
			$page_heading_background_image_url = get_template_directory_uri().'/assets/images/header-bg.jpg';
	}
	if(empty($page_heading_title)){
		$page_heading_title = dh_page_title(false);
	}
	if(empty($page_heading_sub_title)){
		$page_heading_breadcrumb_flag = true;
	}
	
	$page_heading_button_flag = false;
	if($page_heading_button_url && $page_heading_button_text){
		$page_heading_button_flag = true;
	}
	$logo_url = dh_get_theme_option('logo');
	$logo_fixed_url = dh_get_theme_option('logo-fixed','');
	$logo_transparent_url = dh_get_theme_option('logo-transparent','');
	$logo_mobile_url = dh_get_theme_option('logo-mobile','');
	if(empty($logo_fixed_url))
		$logo_fixed_url = $logo_url;
	if(empty($logo_mobile_url))
		$logo_mobile_url = $logo_url;
	
	if($menu_transparent && $header_style !='classic-right')
		$logo_url = $logo_transparent_url;
?>
<!doctype html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<?php if (!function_exists( 'wp_site_icon' ) && $favicon_url = dh_get_theme_option('favicon')) { ?>
<link rel="shortcut icon" href="<?php echo esc_url($favicon_url); ?>">
<meta name="msapplication-TileImage" content="<?php echo esc_attr($favicon_url); ?>">
<?php } ?>
<?php if ($apple57_url = dh_get_theme_option('apple57')) { ?>
<link rel="apple-touch-icon-precomposed" href="<?php echo esc_url($apple57_url); ?>"><?php } ?>   
<?php if ($apple72 = dh_get_theme_option('apple72')) { ?>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo esc_url($apple72); ?>"><?php } ?>   
<?php if ($apple114 = dh_get_theme_option('apple114')) { ?>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo esc_url($apple114); ?>"><?php } ?> 
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php if(defined('DHINC_ASSETS_URL')):?>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="<?php echo DHINC_ASSETS_URL ?>/vendor/html5shiv.min.js"></script>
<![endif]-->
<?php endif;?>
<?php wp_head(); ?>
<?php echo dh_get_theme_option('space-head',''); ?>
</head> 
<body <?php body_class(); ?> <?php if(dh_get_post_meta('is_one_page')) {echo ' data-spy="scroll"'; } ?>>
<?php do_action( 'dh_before_body' ); ?>
<?php if(dh_get_theme_option('preloader',1)):?>
<div id="preloader">
	<img class="preloader__logo" src="<?php echo esc_attr(dh_get_theme_option('logo'))?>" alt=""/>
	<div class="preloader__progress">
		<svg width="60px" height="60px" viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg">
			<path class="preloader__progress-circlebg" fill="none" stroke="#dddddd" stroke-width="4" stroke-linecap="round" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
			<path id='preloader__progress-circle' fill="none" stroke="#000" stroke-width="4" stroke-linecap="round" stroke-dashoffset="192.61" stroke-dasharray="192.61 192.61" d="M40,10C57.351,10,71,23.649,71,40.5S57.351,71,40.5,71 S10,57.351,10,40.5S23.649,10,40.5,10z"/>
		</svg>
	</div>
</div>
<?php endif;?>
<a class="sr-only sr-only-focusable" href="#main"><?php esc_html_e('Skip to main content','forward') ?></a>
<?php 
dh_get_template('header/offcanvas.php',array(
	'page_heading'					=> $page_heading,
	'header_style'					=>$header_style,
	'menu_transparent'				=>$menu_transparent,
	'logo_url'						=>$logo_url,
	'logo_fixed_url'				=>$logo_fixed_url,
	'logo_mobile_url'				=>$logo_mobile_url,
));
?>
<div id="wrapper" class="<?php echo dh_get_theme_option('site-layout','wide') ?>-wrap">
	<div class="wrapper-container">	
<?php if(!dh_get_post_meta('hide_header',0)):?>
		<?php 
		dh_get_template('header/'.$header_style.'.php',array(
			'page_heading'					=> $page_heading,
			'header_style'					=>$header_style,
			'menu_transparent'				=>$menu_transparent,
			'logo_url'						=>$logo_url,
			'logo_fixed_url'				=>$logo_fixed_url,
			'logo_mobile_url'				=>$logo_mobile_url,
		));
		?>
		<?php 
		$heading_menu_anchor = dh_get_post_meta('heading_menu_anchor');
		?>
		<?php if($page_heading === 'rev' && ($rev_alias = dh_get_post_meta('rev_alias'))):?>
		<div<?php echo (!empty($heading_menu_anchor) ? ' id ="'.esc_attr($heading_menu_anchor).'"': '')?> class="main-slider">
			<div class="main-slider-wrap">
				<?php echo do_shortcode('[rev_slider '.$rev_alias.']')?>
			</div>
		</div>
		<?php endif;?>
		<?php if($page_heading === 'heading' && !empty($page_heading_title)):?>
			<?php 
			wp_enqueue_script('parallax');
			wp_enqueue_script('imagesloaded');
			?>
			<div<?php echo (!empty($heading_menu_anchor) ? ' id ="'.esc_attr($heading_menu_anchor).'"': '')?> class="heading-container heading-resize<?php echo ($page_heading_button_flag ? ' heading-button':' heading-no-button');?>">
				<div class="heading-background heading-parallax" style="background-image: url('<?php echo esc_attr($page_heading_background_image_url) ?>');">			
					<div class="<?php dh_container_class() ?>">
						<div class="row">
							<div class="col-md-12">
								<div class="heading-wrap <?php echo $page_heading_color; ?> <?php echo $page_heading_align; ?>">
									<div class="page-title">
										<h1><?php echo esc_html($page_heading_title) ?></h1>
										<?php if(!empty($page_heading_sub_title)):?>
										<span class="subtitle"><?php echo esc_html($page_heading_sub_title) ?></span>
										<?php  elseif($page_heading_breadcrumb_flag):?>
										<?php if(dh_get_theme_option('breadcrumb',1)):?>
										<div class="page-breadcrumb" itemprop="breadcrumb">
											<?php dh_the_breadcrumb()?>
										</div>
										<?php endif;?>
										<?php endif;?>
											
										<?php if($page_heading_button_flag):?>
										<a class="btn btn-outline heading-button-btn" href="<?php echo esc_url_raw($page_heading_button_url)?>" title="<?php echo esc_attr($page_heading_button_text)?>"><?php echo esc_html($page_heading_button_text)?></a>
										<?php endif;?>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php elseif ($page_heading === 'default'):?>
			<div<?php echo (!empty($heading_menu_anchor) ? ' id ="'.esc_attr($heading_menu_anchor).'"': '')?> class="heading-container heading-standard-wrap">
				<div class="<?php dh_container_class() ?> heading-standard">
					<h1><?php echo esc_html($page_heading_title) ?></h1>
					<?php if(dh_get_theme_option('breadcrumb',1) ):?>
					<div class="page-breadcrumb" itemprop="breadcrumb">
						<?php dh_the_breadcrumb()?>
					</div>
					<?php endif;?>
				</div>
			</div>
		<?php endif;?>
		<?php do_action('dh_heading')?>
<?php endif;?>