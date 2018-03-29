<?php
/**
 *	Kalium WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$nav = kalium_get_main_menu();

// Menu In Use
$menu_type	 = get_data( 'main_menu_type' );
$sticky_header = get_data( 'sticky_header' );

// Header Options
$header_vpadding_top    = get_data( 'header_vpadding_top' );
$header_vpadding_bottom = get_data( 'header_vpadding_bottom' );
$header_fullwidth       = get_data( 'header_fullwidth' );

// Header Classes
$header_classes = array( 'main-header' );
$header_classes[] = 'menu-type-' . esc_attr( $menu_type );

// Fullwidth Header
if ( $header_fullwidth ) {
	$header_classes[] = 'fullwidth-header';
}

// Header Options
$header_options = array(
	'stickyHeader' => false
);

// Current Menu Skin
switch ( $menu_type ) {
	// Fullscreen Menu
	case 'full-bg-menu':
		$current_menu_skin = get_data( 'menu_full_bg_skin' );
		break;
		
	// Standard Menu
	case 'standard-menu':
		$current_menu_skin = get_data( 'menu_standard_skin' );
		break;
	
	// Top Menu
	case 'top-menu':
		$current_menu_skin = get_data( 'menu_top_skin' );
		break;
	
	// Sidebar Menu
	case 'sidebar-menu':
		$current_menu_skin = get_data( 'menu_sidebar_skin' );
		break;
}

// Header Vertical Padding
if ( is_numeric( $header_vpadding_top ) && $header_vpadding_top > 0 ) {
	generate_custom_style( 'header.main-header', "padding-top: {$header_vpadding_top}px;" );
	
	// Responsive
	if ( $header_vpadding_top >= 40 ) {
		generate_custom_style( 'header.main-header', 'padding-top: ' . ( $header_vpadding_top / 2 ) . 'px;', 'screen and (max-width: 992px)' );
	}
	
	if ( $header_vpadding_top >= 40 ) {
		generate_custom_style( 'header.main-header', 'padding-top: ' . ( $header_vpadding_top / 3 ) . 'px;', 'screen and (max-width: 768px)' );
	}
}

if ( is_numeric( $header_vpadding_bottom ) && $header_vpadding_bottom > 0 ) {
	generate_custom_style( 'header.main-header', "padding-bottom: {$header_vpadding_bottom}px;" );
	
	// Responsive
	if ( $header_vpadding_top >= 40 ) {
		generate_custom_style( 'header.main-header', 'padding-bottom: ' . ( $header_vpadding_bottom / 2 ) . 'px;', 'screen and (max-width: 992px)' );
	}
	
	if ( $header_vpadding_top >= 40 ) {
		generate_custom_style( 'header.main-header', 'padding-bottom: ' . ( $header_vpadding_bottom / 3 ) . 'px;', 'screen and (max-width: 768px)' );
	}
}

// Sticky Header
if ( $sticky_header ) {
	$header_classes[] = 'is-sticky';
	
	/// Sticky Header Options
	$header_options['stickyHeader'] = kalium_get_sticky_header_options();
	
	// Logo Switch Sections
	$header_options['sectionLogoSwitch'] = kalium_get_logo_switch_sections();
}
?>
<header class="<?php echo implode( ' ', $header_classes ); ?>">
	<div class="container">

		<div class="logo-and-menu-container">
			
			<?php do_action( 'kalium_header_main_before_logo' ); ?>
			
			<div class="logo-column">
				<?php get_template_part( 'tpls/logo' ); ?>
			</div>
			
			<?php do_action( 'kalium_header_main_before_menu' ); ?>
				
			<div class="menu-column">
			<?php
			// Show Menu (by type)
			switch ( $menu_type ) :
			
				case 'full-bg-menu':
				
					$menu_full_bg_search_field      = get_data( 'menu_full_bg_search_field' );
					$menu_full_bg_submenu_indicator = get_data( 'menu_full_bg_submenu_indicator' );
					$menu_full_bg_alignment         = get_data( 'menu_full_bg_alignment' );
					$menu_full_bg_footer_block		= get_data( 'menu_full_bg_footer_block' );
					$menu_full_bg_skin				= get_data( 'menu_full_bg_skin' );
					$menu_full_bg_opacity			= get_data( 'menu_full_bg_opacity' );
					
					$menu_bar_skin_active = $menu_full_bg_skin;
					
					switch ( $menu_full_bg_skin ) {
						case "menu-skin-light":
							$menu_bar_skin_active = 'menu-skin-dark';
							break;
							
						default:
							$menu_bar_skin_active = 'menu-skin-light';
					}
						
					// Show Language Switcher
					kalium_header_wpml_language_switcher( $current_menu_skin );
					
					// Show Search Field
					kalium_header_search_field( $current_menu_skin );
					
					// Show Mini Cart
					kalium_wc_header_mini_cart( $current_menu_skin );
					?>
					
					<a class="menu-bar <?php echo esc_attr( $current_menu_skin ); ?>" data-menu-skin-default="<?php echo esc_attr( $current_menu_skin ); ?>" data-menu-skin-active="<?php echo esc_attr( $menu_bar_skin_active ); ?>" href="#">
						<?php kalium_menu_icon_or_label(); ?>
					</a>
					<?php
						break;
				
				case 'standard-menu':
					
					$menu_standard_menu_bar_visible    = get_data( 'menu_standard_menu_bar_visible' );
					$menu_standard_skin                = get_data( 'menu_standard_skin' );
					$menu_standard_menu_bar_effect     = get_data( 'menu_standard_menu_bar_effect' );
					$menu_standard_menu_dropdown_caret = get_data( 'menu_standard_menu_dropdown_caret' );
					
					?>
					<div class="standard-menu-container<?php 
						when_match( $menu_standard_menu_bar_visible, 'menu-bar-root-items-hidden' );
						when_match( $menu_standard_menu_dropdown_caret, 'dropdown-caret' );
						echo " {$menu_standard_skin}";
						echo " {$menu_standard_menu_bar_effect}";
					?>">
						
						<a class="menu-bar mobile-menu-bar<?php 
							echo " {$menu_standard_skin}"; 
							when_match( false == $menu_standard_menu_bar_visible, 'menu-bar-hidden-desktop', '' );
							//when_match( $menu_standard_menu_bar_visible, '', 'hidden-md hidden-lg' );
						?>" href="#">
							<?php kalium_menu_icon_or_label(); ?>
						</a>

						<?php					
						// Show Mini Cart
						kalium_wc_header_mini_cart( $current_menu_skin );
							
						// Show Search Field
						kalium_header_search_field( $current_menu_skin );
						
						// Show Language Switcher
						kalium_header_wpml_language_switcher( $current_menu_skin );
						?>
						
						<nav><?php echo $nav; // No escaping needed, this is wp_nav_menu() with echo=false ?></nav>
					</div>
					<?php
					break;
			
			case 'top-menu':
			
				$menu_top_skin = get_data( 'menu_top_skin' );
						
				// Show Language Switcher
				kalium_header_wpml_language_switcher( $current_menu_skin );
					
				// Show Search Field
				kalium_header_search_field( $current_menu_skin );
					
				// Show Mini Cart
				kalium_wc_header_mini_cart( $current_menu_skin );
				?>
				
				<a class="menu-bar <?php echo esc_attr( $current_menu_skin ); ?>" href="#">
					<?php kalium_menu_icon_or_label(); ?>
				</a>
				<?php
					break;
			
			case 'sidebar-menu':
				
				$menu_sidebar_skin = get_data( 'menu_sidebar_skin' );
						
				// Show Language Switcher
				kalium_header_wpml_language_switcher( $current_menu_skin );
					
				// Show Search Field
				kalium_header_search_field( $current_menu_skin );
					
				// Show Mini Cart
				kalium_wc_header_mini_cart( $current_menu_skin );
				?>
				<a class="menu-bar <?php echo esc_attr( $current_menu_skin ); ?>" href="#">
					<?php kalium_menu_icon_or_label(); ?>
				</a>
				<?php	
				
				endswitch;
				?>
			</div>
		</div>
		
		<?php
		// Full Screen Menu Container
		if ( $menu_type == 'full-bg-menu' ) :
		?>
		<div class="full-screen-menu menu-open-effect-fade<?php 
			echo " {$menu_full_bg_skin}";
			when_match( $menu_full_bg_submenu_indicator, 'submenu-indicator' );
			when_match( $menu_full_bg_alignment == 'centered-horizontal', 'menu-horizontally-center' );
			when_match( in_array( $menu_full_bg_alignment, array( 'centered', 'centered-horizontal' ) ), 'menu-aligned-center' );
			when_match( $menu_full_bg_footer_block, 'has-fullmenu-footer' );
			when_match( $menu_full_bg_opacity, 'translucent-background' );
		?>">
			<div class="container">
				<nav>
				<?php 
				echo $nav;
					
				if ( $menu_full_bg_search_field ) :
					
					?>
					<form class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" enctype="application/x-www-form-urlencoded">
						<input id="full-bg-search-inp" type="search" class="search-field" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
						
						<label for="full-bg-search-inp">
							<?php 
								echo __( 'Search', 'kalium' );
								echo '<span><i></i><i></i><i></i></span>'; 
							?>
							</label>
						</form>
						<?php
						
					endif; 
					?>
					</nav>
				</div>
				
				<?php 
				if ( $menu_full_bg_footer_block ) : 
				?>
				<div class="full-menu-footer">
					<div class="container">
						<div class="right-part">
							<?php echo do_shortcode( '[lab_social_networks rounded]' ); ?>
						</div>
						
						<div class="left-part">
							<?php echo do_shortcode( get_data( 'footer_text' ) ); ?>
						</div>
					</div>
				</div>
				<?php 
				endif; 
				?>
			</div>
		<?php
		endif;
		// End of: Full Screen Menu Container
		?>

	</div>
</header>

<script type="text/javascript">
	var headerOptions = headerOptions || {};
	jQuery.extend( headerOptions, <?php echo json_encode( $header_options, JSON_NUMERIC_CHECK ); ?> );
</script>
<?php
	
do_action( 'kalium_header_main_heading_title_before' );

get_template_part( "tpls/page-heading-title" );
