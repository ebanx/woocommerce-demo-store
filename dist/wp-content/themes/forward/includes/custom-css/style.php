<?php
$body_typography = dh_get_theme_option('body-typography');
if(isset($body_typography['font-family'])){
	$font_family = (1 === preg_match('~[0-9]~', $body_typography['font-family'])) ? '"'. $body_typography['font-family'] .'"' : $body_typography['font-family'];
	if(!empty($font_family)):
	?>
	body{
		font-family:<?php echo dh_print_string($font_family) ?>;
	}
	<?php
	endif;
}
?>
<?php 
$tex_color = dh_format_color(dh_get_theme_option('text-color'));
if(!empty($tex_color) && ($tex_color != '#444444')):
?>
body,
pre ,
legend,
output,
.form-control,
.dropdown-menu > li > a,
.tabs-default a,
.tabs-default.tabs-top .nav-tabs > li.active > a,
.tabs-default.tabs-left .nav-tabs > li.active > a,
.tabs-default.tabs-right .nav-tabs > li.active > a,
.tabs-default.tabs-below .nav-tabs > li.active > a,
.tabs-primary a,
.tabs-success a,
.tabs-info a,
.tabs-warning a ,
.tabs-danger a,
.navbar-search .search-form-wrap,
.paginate .paginate_links .pagination-meta,
.paginate .paginate_links .page-numbers ,
.paginate .paginate_links .pagination-meta,
.alert-default ,
.progress-bars.label-above .progress-title ,
.panel-default > .panel-heading ,
.panel-default > .panel-heading .badge ,
.dummy-column h2 ,
.pricing-table .pricing-default .pricing-header ,
.timeline.timeline-text .timeline-badge a,
.timeline.timeline-image .timeline-badge a,
.timeline.timeline-icon .timeline-badge a,
.latestnews .latestnews-title .sub-cat li a ,
.topbar-nav .top-nav .dropdown-menu a ,
.posts .posts-wrap.posts-layout-default .readmore-link a,
.entry-tags > span,
.comment-author ,
#respond .required ,
.comment-form-author input,
.comment-form-email input,
.comment-form-url input,
.comment-form-comment input,
.comment-form-author textarea,
.comment-form-email textarea,
.comment-form-url textarea,
.comment-form-comment textarea ,
<?php if(defined('WOOCOMMERCE_VERSION')):?>
	.woocommerce-account .woocommerce .button ,
	.woocommerce form .form-row select,
	.woocommerce form .form-row .input-text ,
	.woocommerce small.note ,
	.woocommerce div.product form.cart .variations td.label label ,
	.woocommerce ul.products li.product .yith-wcwl-add-to-wishlist .add_to_wishlist:before ,
	.woocommerce .cart .button:hover,
	.woocommerce .cart .button:focus ,
	.woocommerce #reviews h2 small ,
	.woocommerce #reviews h2 small a,
	.woocommerce #reviews #comments ol.commentlist li .meta ,
	.woocommerce table.cart td.actions .coupon .input-text ,
	.woocommerce.widget_product_search #s,
	.woocommerce .widget_shopping_cart .total,
	.woocommerce .widget_shopping_cart .buttons .button ,
	.woocommerce .cart-collaterals .cart_totals p small ,
	.woocommerce .cart-collaterals .cart_totals table small ,
	.woocommerce form .form-row button.button,
	.woocommerce form .form-row input.button ,
	.woocommerce form .form-row textarea ,
	.woocommerce form .form-row .chosen-container-single .chosen-single,
	.woocommerce form .form-row .chosen-container-single .chosen-drop ,
	.woocommerce .checkout .create-account small ,
	.woocommerce #payment div.payment_box,
	.woocommerce #payment div.payment_box span.help,
	.woocommerce .widget_layered_nav ul small.count,
	.woocommerce .widget_price_filter .price_slider_amount,
	.minicart .minicart-header,
	.minicart .minicart-body .cart-product .cart-product-details ,
	.minicart .minicart-body .cart-product .remove ,
	.minicart .minicart-footer .minicart-total,
	.minicart .minicart-footer .minicart-actions .button,
<?php endif;?>
.widget_tag_cloud .tagcloud a,
.widget_product_tag_cloud .tagcloud a
{
  color: <?php echo dh_print_string($tex_color)?>;
}
<?php endif;?>

<?php 
//link color
$link_color = dh_format_color(dh_get_theme_option('link-color'));
if(!empty($link_color)  && ($link_color != '#262626')):
?>
a ,
.btn-link ,
<?php if(defined('WOOCOMMERCE_VERSION')):?>
	p.demo_store ,
	.woocommerce div.product .stock ,
	.woocommerce ul.products li.product .product_title a,
	.woocommerce ul.products li.product figcaption .product_title a,
	.woocommerce ul.cart_list li a,
	.woocommerce ul.product_list_widget li a ,
	.woocommerce .cart-collaterals .cart_totals .discount td,
<?php endif;?>
.comment-pending ,
.comment-reply-link:hover
{
  color: <?php echo dh_print_string($link_color) ?>;
}
<?php endif;?>

<?php 
//link hover color
$link_hover_color = dh_format_color(dh_get_theme_option('link-hover-color'));
if(!empty($link_hover_color) && ($link_hover_color != '#bca480')):
?>
a:hover,
a:focus ,
.btn-link:hover,
.btn-link:focus ,
.topbar-icon-button > div a:hover ,
.topbar-social a:hover ,
.footer-widget .posts-thumbnail-content h4 a:hover ,
.footer-widget a:hover ,
.footer .footer-menu .footer-nav li a:hover,
.footer .footer-menu .footer-nav li a:focus ,
.footer .footer-info a:hover ,
.entry-meta a:hover ,
.readmore-link a:hover,
.post-navigation a:hover ,
.entry-tags a:hover,
.highlighted .highlighted-caption h3 a:hover ,
.comment-author a:hover,
<?php if(defined('WOOCOMMERCE_VERSION')):?>
	.woocommerce ul.products li.product .product_title a:hover,
	.woocommerce ul.products li.product figcaption .product_title a:hover ,
	.woocommerce ul.products li.product figcaption .product-category a:hover,
<?php endif;?>
.posts-thumbnail-content > span a:hover,
.posts-thumbnail-content > a:hover,
.posts-thumbnail-content > h4:hover,
.posts-thumbnail-content > h4 a:hover
{
  color: <?php echo dh_print_string($link_hover_color)?>;
}
.portfolio .portfolio-filter .filter-action > ul li a.selected
{
  color: <?php echo dh_print_string($link_hover_color)?>;
  border-bottom-color: <?php echo dh_print_string($link_hover_color)?>;
}
.portfolio .portfolio-filter .filter-action.filter-action-center > ul li a.selected{
  background: <?php echo dh_print_string($link_hover_color)?>;
}
.widget_tag_cloud .tagcloud a:hover,
.widget_product_tag_cloud .tagcloud a:hover,
.footer .footer-info .footer-social a:hover {
  color: <?php echo dh_print_string($link_hover_color)?>;
  border-color: <?php echo dh_print_string($link_hover_color)?>;
}
<?php endif;?>
<?php 
#headings color
$headings_color = dh_format_color(dh_get_theme_option('headings-color'));
if(!empty($headings_color) && ($headings_color != '#000000') ):
?>
h1,
h2,
h3,
h4,
h5,
h6,
.h1,
.h2,
.h3,
.h4,
.h5,
.h6,
.popover-title ,
.posts .posts-wrap.posts-layout-default .readmore-link a ,
.posts .posts-wrap.posts-layout-timeline .timeline-date .timeline-date-title ,
.date-badge .date ,
.post-navigation .prev-post > span,
.post-navigation .next-post > span ,
#wp-calendar > thead th ,
.posts-thumbnail-content > a,
.posts-thumbnail-content > h4 ,
.posts-thumbnail-content > h4 a ,
.woocommerce div.product span.price,
.woocommerce div.product p.price
{
  color: <?php echo dh_print_string($headings_color) ?>;
}
<?php endif;?>
<?php
if(!empty($body_typography['font-size'])){
	$font_size = $body_typography['font-size'];
	?>
	body{
		font-size:<?php echo dh_print_string($font_size)?>;
	}
	<?php
}
if(!empty($body_typography['font-style'])){
	$font_style = $body_typography['font-style'];
	if(strpos($font_style,'italic') === false){
		?>
		body{
			font-weight:<?php echo dh_print_string($font_style); ?>;
		}
		<?php
	}elseif (strpos($font_style,'0italic') == true){
		$font_weight = explode("i",$font_style);
		?>
		body{
			font-weight:<?php echo @$font_weight[0] ?>;
			font-style: italic;
		}
		<?php
	}elseif (strpos($font_style,'italic') !== false){
		?>
		body{
			font-weight:400;
			font-style: italic;
		}
		<?php
	}
}

$navbar_typography = dh_get_theme_option('navbar-typography');
if(!empty($navbar_typography['font-family'])){
	$font_family = (1 === preg_match('~[0-9]~', $navbar_typography['font-family'])) ? '"'. $navbar_typography['font-family'] .'"' : $navbar_typography['font-family'];
	?>
	.primary-nav{
		font-family:<?php echo dh_print_string($font_family)?>;
	}
	@media (max-width: 991px) {
	  .primary-nav .dropdown-menu li .megamenu-title {
	  	font-family: <?php echo dh_print_string($font_family) ?>;
	  }
	}
	<?php
}
if(!empty($navbar_typography['font-size'])){
	$font_size = $navbar_typography['font-size'];
	?>
	.primary-nav{
		font-size:<?php echo dh_print_string($font_size)?>;
	}
	.primary-nav .navicon{
	   font-size:<?php echo dh_print_string($font_size)?>;
	}
	@media (max-width: 991px) {
	  .primary-nav .dropdown-menu li .megamenu-title {
	  	font-size:<?php echo dh_print_string($font_size)?>;
	  }
	}
	<?php
}
if(!empty($navbar_typography['font-style'])){
	$font_style = $navbar_typography['font-style'];
	if(strpos($font_style,'italic') === false){
		?>
		.primary-nav{
			font-weight:<?php echo dh_print_string($font_style)?>;
		}
		@media (max-width: 991px) {
		  .primary-nav .dropdown-menu li .megamenu-title {
		  	font-weight:<?php echo dh_print_string($font_style)?>;
		  }
		}
		<?php 
	}elseif (strpos($font_style,'0italic') == true){
		$font_weight = explode("i",$font_style);
		?>
		.primary-nav{
			font-weight:<?php echo @$font_weight[0]?>;
			font-style:italic;
		}
		@media (max-width: 991px) {
		  .primary-nav .dropdown-menu li .megamenu-title {
		  	font-weight:<?php echo @$font_weight[0]?>;
			font-style:italic;
		  }
		}
		<?php
	}elseif (strpos($font_style,'italic') !== false){
		?>
		.primary-nav{
			font-weight:400;
			font-style:italic;
		}
		@media (max-width: 991px) {
		  .primary-nav .dropdown-menu li .megamenu-title {
		  	font-weight:400;
			font-style:italic;
		  }
		}
		<?php
	}
}
	
$headings_typography = array('h1-typography','h2-typography','h3-typography','h4-typography','h5-typography','h6-typography');
foreach ($headings_typography as $font){
	$typography = dh_get_theme_option($font);
	$h = str_replace("-typography","",$font);
	if(!empty($typography['font-family'])){
		$font_family = (1 === preg_match('~[0-9]~', $typography['font-family'])) ? '"'. $typography['font-family'] .'"' : $typography['font-family'];
		?>
		<?php echo dh_print_string($h)?>,
		.<?php echo dh_print_string($h)?>{
			font-family: <?php echo dh_print_string($font_family)?>
		}
		<?php
	}
	if(!empty($typography['font-size'])){
		$font_size = $typography['font-size'];
		?>
		<?php echo dh_print_string($h)?>,
		.<?php echo dh_print_string($h)?>{
			font-size: <?php echo dh_print_string($font_size)?>
		}
		<?php
	}
	if(!empty($typography['font-style'])){
		$font_style = $typography['font-style'];
		if(strpos($font_style,'italic') === false){
			?>
			<?php echo dh_print_string($h)?>,
			.<?php echo dh_print_string($h)?>{
				font-weight: <?php echo dh_print_string($font_style)?>;
			}
			<?php
		}elseif (strpos($font_style,'0italic') == true){
			$font_weight = explode("i",$font_style);
			?>
			<?php echo dh_print_string($h)?>,
			.<?php echo dh_print_string($h)?>{
				font-weight: <?php echo @$font_weight[0]?>;
				font-style:italic;
			}
			<?php
			
		}elseif (strpos($font_style,'italic') !== false){
			?>
			<?php echo dh_print_string($h)?>,
			.<?php echo dh_print_string($h)?>{
				font-weight:400;
				font-style:italic;
			}
			<?php
		}
	}
}


$body_bg = dh_get_theme_option('body-bg');
$bg = array();
$bg['background-color']  = !empty($body_bg['background-color']) ? dh_format_color($body_bg['background-color']) : '';
$bg['background-repeat']  = !empty($body_bg['background-repeat']) ? $body_bg['background-repeat'] : '';
$bg['background-size']  = !empty($body_bg['background-size']) ? ' / '.$body_bg['background-size'] : '';
$bg['background-attachment'] = !empty($body_bg['background-attachment']) ? $body_bg['background-attachment']:'';
$bg['background-position'] = !empty($body_bg['background-position']) ? $body_bg['background-position']:'';
$bg['background-image'] = !empty($body_bg['background-image']) ? 'url("'.$body_bg['background-image'].'")' : '';
$boxed_body_bg = $bg['background-color'].' '.$bg['background-image'].' '.$bg['background-repeat'].' '.$bg['background-attachment'].' '.$bg['background-position'].' '.$bg['background-size'];
if(dh_get_theme_option('site-layout','wide') == 'boxed'){
?>
body{
	background:<?php echo dh_print_string($boxed_body_bg)?>
}
.boxed-wrap{
	background-color:<?php echo dh_print_string($bg['background-color'])?>
}
<?php
}

$header_custom_color = array();
$custom_colors = array();
//check custom headr color
if(dh_get_theme_option('header-color') == '1'){
	$header_custom_color = dh_get_theme_option('header-custom-color');
}
$custom_colors['topbar-bg'] = isset($header_custom_color['topbar-bg']) ? dh_format_color($header_custom_color['topbar-bg']) : '';
$custom_colors['topbar-color'] = isset($header_custom_color['topbar-font']) ? dh_format_color($header_custom_color['topbar-font']) : '';
$custom_colors['topbar-link-color'] = isset($header_custom_color['topbar-link']) ? dh_format_color($header_custom_color['topbar-link']):'';

$custom_colors['header-bg'] = isset($header_custom_color['header-bg']) ? dh_format_color($header_custom_color['header-bg']) : '';
$custom_colors['header-color'] = isset($header_custom_color['header-color']) ? dh_format_color($header_custom_color['header-color']) : '';
$custom_colors['header-hover-color'] = isset($header_custom_color['header-hover-color']) ? dh_format_color($header_custom_color['header-hover-color']):'';


$custom_colors['navbar-default-bg'] = isset($header_custom_color['navbar-bg']) ? dh_format_color($header_custom_color['navbar-bg']):'';
$custom_colors['navbar-default-link-color'] = isset($header_custom_color['navbar-font']) ? dh_format_color($header_custom_color['navbar-font']):'';
$custom_colors['navbar-default-link-hover-color'] = isset($header_custom_color['navbar-font-hover']) ? dh_format_color($header_custom_color['navbar-font-hover']):'';
$custom_colors['navbar-dropdown-default-link-color'] = isset($header_custom_color['navbar-dd-font']) ? dh_format_color($header_custom_color['navbar-dd-font']) :'';
$custom_colors['navbar-dropdown-default-link-hover-color'] = isset($header_custom_color['navbar-dd-font-hover']) ? dh_format_color($header_custom_color['navbar-dd-font-hover']) : '';
$custom_colors['navbar-dropdown-default-link-bg'] = isset($header_custom_color['navbar-dd-bg']) ? dh_format_color($header_custom_color['navbar-dd-bg']):'';
$custom_colors['navbar-dropdown-border'] = isset($header_custom_color['navbar-dd-border']) ? dh_format_color($header_custom_color['navbar-dd-border']):'';
$custom_colors['navbar-dropdown-default-link-border'] = isset($header_custom_color['navbar-dd-link-border']) ? dh_format_color($header_custom_color['navbar-dd-link-border']):'';
$custom_colors['navbar-dropdown-default-link-hover-bg'] = isset($header_custom_color['navbar-dd-hover-bg']) ? dh_format_color($header_custom_color['navbar-dd-hover-bg']):'';
$custom_colors['navbar-dropdown-mega-menu-title'] =  isset($header_custom_color['navbar-dd-mm-title']) ? dh_format_color($header_custom_color['navbar-dd-mm-title']):'';
?>
<?php if(!empty($custom_colors['topbar-bg'])):?>
.topbar{
  background: <?php echo dh_print_string($custom_colors['topbar-bg'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['topbar-color'])):?>
.topbar{
  color: <?php echo dh_print_string($custom_colors['topbar-color'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['topbar-link-color'])):?>
.topbar a,
.topbar .left-topbar > a,
.topbar-info a,
.topbar-icon-button > div a,
.topbar-social a,
.topbar-nav .top-nav > li > a,
.topbar-nav .top-nav a,
.topbar-nav .top-nav .dropdown-menu .active a
{
  color: <?php echo dh_print_string($custom_colors['topbar-link-color'])?>;
}
.topbar-nav .top-nav > li > a:before{
  border-right: 1px solid <?php echo lighten($custom_colors['topbar-link-color'],'10%')?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['header-bg'])){ ?>
	@media (min-width: 992px) {
		.navbar-default,
		.header-type-center .navbar-default{
		background:<?php echo dh_print_string($custom_colors['header-bg']);?>
	}
}
<?php }?>
<?php if(!empty($custom_colors['header-color'])){ ?>
	@media (min-width: 992px) {
		.navbar-toggle-fixed .navbar-toggle .icon-bar {
			border-color:<?php echo dh_print_string($custom_colors['header-color'])?>;
			background: <?php echo dh_print_string($custom_colors['header-color'])?>;
		}
		.navbar-header-left .social a{
			color:<?php echo dh_print_string($custom_colors['header-color'])?>;
		}
		.navbar-offcanvas svg path,.navbar-user svg path, .navbar-wishlist svg path, .navbar-search svg path, .navbar-minicart svg path {
			fill: <?php echo dh_print_string($custom_colors['header-color'])?>;
		    stroke: <?php echo dh_print_string($custom_colors['header-color'])?>;
		}
		.navsearch #top-searchform-s::-webkit-input-placeholder{
			color:<?php echo dh_print_string($custom_colors['header-color'])?>
		}
		.navsearch #top-searchform-s:-moz-placeholder{
			color:<?php echo dh_print_string($custom_colors['header-color'])?>
		}
		.navsearch #top-searchform-s::-moz-placeholder{
			color:<?php echo dh_print_string($custom_colors['header-color'])?>
		}
		.navsearch #top-searchform-s:-ms-input-placeholder{
			color:<?php echo dh_print_string($custom_colors['header-color'])?>
		}
	}
<?php }?>

<?php if(!empty($custom_colors['header-hover-color'])){ ?>
	@media (min-width: 992px) {
		.navbar-header-left .social a i:hover{
			color:<?php echo dh_print_string($custom_colors['header-hover-color'])?>
		}
		.navbar-offcanvas:hover svg path,
		.navbar-user:hover svg path,
		.navbar-wishlist:hover svg path, 
		.navbar-search:hover svg path, 
		.navbar-minicart:hover svg path {
			fill: <?php echo dh_print_string($custom_colors['header-hover-color'])?>;
			stroke: <?php echo dh_print_string($custom_colors['header-hover-color'])?>;
		}
	}
<?php }?>

<?php if(!empty($custom_colors['navbar-default-bg'])):?>
	@media (min-width: 992px) {
		.header-type-center .navbar-default .primary-navbar-collapse,
		.header-type-default .navbar-default ,
		.navbar-default {
		  background-color: <?php echo dh_print_string($custom_colors['navbar-default-bg'])?>;
	}
}
<?php endif;?>



<?php if(!empty($custom_colors['navbar-default-link-color'])):?>
	@media (min-width: 992px) {
		.navbar-header .navbar-toggle .icon-bar{
			background-color: <?php echo dh_print_string($custom_colors['navbar-default-link-color'])?>;
		}
		.navbar-header .cart-icon-mobile,
		.navbar-default .navbar-brand,
		.navbar-default .navbar-nav > li > a,
		.offcanvas-nav a,
		.offcanvas-nav .dropdown-menu a{
		  color: <?php echo dh_print_string($custom_colors['navbar-default-link-color'])?>;
		}
		.header-type-market .navbar-default .navbar-nav > li > a {
			color: <?php echo dh_print_string($custom_colors['navbar-default-link-color'])?>;
		}
	}
	@media (max-width: 991px) {
	  .navbar-default .navbar-nav .open .dropdown-menu > li > a {
	    color: <?php echo dh_print_string($custom_colors['navbar-default-link-color'])?>;
	  }
	}
	@media (max-width: 991px) {
	  .primary-nav .dropdown-menu li .megamenu-title {
	    color: <?php echo dh_print_string($custom_colors['navbar-default-link-color'])?>;
	  }
	}
<?php endif;?>


<?php if(!empty($custom_colors['navbar-default-link-hover-color'])):?>
	@media (min-width: 992px) {
		.navbar-default .navbar-nav .current-menu-ancestor > a, 
		.navbar-default .navbar-nav .current-menu-ancestor > a:hover, 
		.navbar-default .navbar-nav .current-menu-parent > a, 
		.navbar-default .navbar-nav .current-menu-parent > a:hover,
		.header-type-default .primary-nav > li > a .navicon, 
		.navbar-default .navbar-nav > .active > a, 
		.navbar-default .navbar-nav > .active > a:hover, 
		.navbar-default .navbar-nav > .active > a:hover, 
		.navbar-default .navbar-nav > .open > a, 
		.navbar-default .navbar-nav > li > a:hover,
		.offcanvas-nav a:hover,
		.offcanvas-nav .dropdown-menu a:hover{
		  color: <?php echo dh_print_string($custom_colors['navbar-default-link-hover-color'])?>;
		}
		.header-type-market .navbar-default .navbar-nav > li > a:hover{
			color: <?php echo dh_print_string($custom_colors['navbar-default-link-hover-color'])?>;
		}
	}
	@media (max-width: 991px) {
	  .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover{
	    color: <?php echo dh_print_string($custom_colors['navbar-default-link-hover-color'])?>;
	  }
	}
<?php endif;?>
<?php if(!empty($custom_colors['navbar-dropdown-border'])):?>
@media (min-width: 992px) {
	.primary-nav > li:not(.megamenu) > .dropdown-menu,
	.primary-nav > .megamenu > .dropdown-menu{
	    border-top-color:<?php echo dh_print_string($custom_colors['navbar-dropdown-border'])?> !important;
	}
}
<?php endif;?>
<?php if(!empty($custom_colors['navbar-dropdown-default-link-color'])):?>
.primary-nav .dropdown-menu a {
	color: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-color'])?>
}
<?php endif;?>

<?php if(!empty($custom_colors['navbar-dropdown-default-link-hover-color'])):?>
@media (min-width: 992px) {
  .primary-nav > .megamenu > .dropdown-menu > li .dropdown-menu a:hover{
    color: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-hover-color'])?>;
  }
}
.primary-nav .dropdown-menu a:hover,
.primary-nav .dropdown-menu .open > a,
.primary-nav .dropdown-menu .active > a,
.primary-nav .dropdown-menu .active > a:hover {
  color: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-hover-color'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['navbar-dropdown-default-link-bg'])):?>
@media (min-width: 992px) {
	.dropdown-menu {
		background: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-bg']) ?>;
	}
	.primary-nav > .megamenu > .dropdown-menu,
	.primary-nav > .megamenu > .dropdown-menu > li > a,
	.primary-nav > .megamenu > .dropdown-menu > li .dropdown-menu a {
	    background: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-bg']) ?>;
	 }
}
	.primary-nav .dropdown-menu a {
		background: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-bg'])?>;
	}
<?php endif;?>
<?php if(!empty($custom_colors['navbar-dropdown-default-link-border'])):?>
@media (min-width: 992px) {
.primary-nav .dropdown-menu li.menu-item {
  border-top: 1px solid <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-border'])?>;
}
}
<?php endif;?>

<?php if(!empty($custom_colors['navbar-dropdown-default-link-hover-bg'])):?>
	@media (min-width: 992px) {
		.header-transparent .navbar-default:not(.navbar-fixed-top) .dropdown-menu a:hover,
		.primary-nav .dropdown-menu a:hover,
		.primary-nav .dropdown-menu .open a,
		.primary-nav .dropdown-menu .open a:hover,
		.primary-nav .dropdown-menu .active a,
		.primary-nav .dropdown-menu .active a:hover{
		  background: <?php echo dh_print_string($custom_colors['navbar-dropdown-default-link-hover-bg'])?>;
		}
	}
<?php 
$navbar_dropdown_default_link_border = $custom_colors['navbar-dropdown-default-link-bg'];
?>
@media (min-width: 992px) {
  .primary-nav > .megamenu > .dropdown-menu
  {
    border-top: 1px solid <?php echo dh_print_string($navbar_dropdown_default_link_border)?>;
  }
  .primary-nav > .megamenu .megamenu-title{
  	border-bottom: 1px solid <?php echo dh_print_string($navbar_dropdown_default_link_border)?>;
  }
  
  .primary-nav > .megamenu > .dropdown-menu > li{
   	border-right: 1px solid <?php echo dh_print_string($navbar_dropdown_default_link_border)?>;
  }
}
.primary-nav .dropdown-menu li {
	border-top: 1px solid <?php echo dh_print_string($navbar_dropdown_default_link_border)?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['navbar-dropdown-mega-menu-title'])):?>
@media (min-width: 992px) {
  .primary-nav > .megamenu .megamenu-title{
  	color: <?php echo dh_print_string($custom_colors['navbar-dropdown-mega-menu-title'])?>;
  }
}	
<?php endif;?>

<?php 
//if custom sticky color
if(dh_get_theme_option('custom-sticky-color',0)){
?>
	<?php
	$navbar_fixed_bg = dh_format_color(dh_get_theme_option('sticky-menu-bg'));
	?>
	<?php if(!empty($navbar_fixed_bg)):?>
	.navbar-fixed-top .navbar-default-container {
	  background: <?php echo dh_print_string($navbar_fixed_bg)?> !important;
	}
	@media (min-width: 992px) {
	  .header-transparent .navbar-default.navbar-fixed-top .navbar-default-container{
	    background: <?php echo dh_print_string($navbar_fixed_bg)?> !important;
	  }
	}
	<?php endif;?>
	
	<?php
	$navbar_fixed_color = dh_format_color(dh_get_theme_option('sticky-menu-color'));
	?>
	<?php if(!empty($navbar_fixed_color)):?>
	.navbar-fixed-top .navbar-nav.primary-nav > li:not(.active):not(.current-menu-ancestor):not(.current-menu-parent) > a {
	  color: <?php echo dh_print_string($navbar_fixed_color)?>;
	}
	<?php endif;?>
	<?php 
	$navbar_fixed_hover_color = dh_format_color(dh_get_theme_option('sticky-menu-hover-color'));
	?>
	<?php if(!empty($navbar_fixed_hover_color)):?>
	.navbar-fixed-top .navbar-nav.primary-nav > li:not(.active):not(.current-menu-ancestor):not(.current-menu-parent) > a:hover,
	.navbar-fixed-top .navbar-nav.primary-nav > li.open:not(.active):not(.current-menu-ancestor):not(.current-menu-parent) > a,
	.navbar-fixed-top .navbar-nav.primary-nav > .open > a:hover, 
	.navbar-fixed-top .navbar-nav.primary-nav > .open > a, 
	.navbar-fixed-top .navbar-nav.primary-nav > .active > a, 
	.navbar-fixed-top .navbar-nav.primary-nav > .active > a:hover, 
	.navbar-fixed-top .navbar-nav.primary-nav > .current-menu-ancestor > a,
	.navbar-fixed-top .navbar-nav.primary-nav > .current-menu-ancestor > a:hover,
	.navbar-fixed-top .navbar-nav.primary-nav > .current-menu-parent > a,
	.navbar-fixed-top .navbar-nav.primary-nav > .current-menu-parent > a:hover,
	.navbar-fixed-top .navbar-nav.primary-nav > li > a:hover{
		color:<?php echo dh_print_string($navbar_fixed_hover_color)?>;
	}
	.navbar-fixed-top .navbar-nav.primary-nav > .open > a > .underline:before, 
	.navbar-fixed-top .navbar-nav.primary-nav > li > a > .underline:before, 
	.navbar-fixed-top .navbar-nav.primary-nav > .open > a > .underline:after, 
	.navbar-fixed-top .navbar-nav.primary-nav > li > a > .underline:after{
	  background-color:<?php echo dh_print_string($navbar_fixed_hover_color)?>;
	}
	<?php endif;?>
<?php 
}
?>

<?php 
//heading-bg
$heading_bg = dh_get_theme_option('heading-bg',0);
if(!empty($heading_bg)):
?>
.heading-background,
.heading-container{
	background-image:url(<?php echo dh_print_string($heading_bg)?>);
}
<?php endif;?>

<?php
$footer_custom_color = array();
$custom_colors = array();
if(dh_get_theme_option('footer-color',0)){
	$footer_custom_color = dh_get_theme_option('footer-custom-color');
}
$custom_colors['footer-widget-bg'] = isset($footer_custom_color['footer-widget-bg']) ? dh_format_color($footer_custom_color['footer-widget-bg']) : '';
$custom_colors['footer-widget-color'] = isset($footer_custom_color['footer-widget-color']) ? dh_format_color($footer_custom_color['footer-widget-color']) : '';
$custom_colors['footer-widget-link'] = isset($footer_custom_color['footer-widget-link']) ? dh_format_color($footer_custom_color['footer-widget-link']) :'';
$custom_colors['footer-widget-link-hover'] = isset($footer_custom_color['footer-widget-link-hover']) ? dh_format_color($footer_custom_color['footer-widget-link-hover']) :'';
$custom_colors['footer-bg'] = isset($footer_custom_color['footer-bg']) ? dh_format_color($footer_custom_color['footer-bg']) :'';
$custom_colors['footer-color'] = isset($footer_custom_color['footer-color']) ? dh_format_color($footer_custom_color['footer-color']) : '';
$custom_colors['footer-link-color'] = isset($footer_custom_color['footer-link']) ? dh_format_color($footer_custom_color['footer-link']) : '';
$custom_colors['footer-link-hover'] = isset($footer_custom_color['footer-link-hover']) ? dh_format_color($footer_custom_color['footer-link-hover']) : '';
?>
<?php if(!empty($custom_colors['footer-widget-bg'])):?>
.footer-widget,
.style-2 .footer-widget {
  background: <?php echo dh_print_string($custom_colors['footer-widget-bg'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['footer-widget-color'])):?>
.footer-widget,
.footer-widget .address h4,
.footer-widget .widget-title {
    color: <?php echo dh_print_string($custom_colors['footer-widget-color'])?>;
}
.footer-widget .address i {
	color: <?php echo dh_print_string($custom_colors['footer-widget-color'])?>;
	border-color: <?php echo dh_print_string($custom_colors['footer-widget-color'])?>;
}
.footer-widget .open-time li span:first-child:after {
	border-color: <?php echo dh_print_string($custom_colors['footer-widget-color'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['footer-widget-link'])):?>
.footer-widget .recent-tweets ul li a,
.footer-widget .posts-thumbnail-content h4 a,
.footer-widget a,
.footer-widget .social-widget-wrap i {
	color:<?php echo dh_print_string($custom_colors['footer-widget-link'])?>
}
<?php endif;?>

<?php if(!empty($custom_colors['footer-widget-link-hover'])):?>
.footer-widget .recent-tweets ul li a:hover,
.footer-widget .posts-thumbnail-content h4 a:hover,
.footer-widget .posts-thumbnail-content h4 a:focus,
.footer-widget a:hover,
.footer-widget a:focus{
	color:<?php echo dh_print_string($custom_colors['footer-widget-link-hover'])?>
}
.footer-widget .social-widget-wrap a:hover i,
.footer-widget .social-widget-wrap.social-widget-none a:hover i {
	color:<?php echo dh_print_string($custom_colors['footer-widget-link-hover'])?>!important;
}
<?php endif;?>

<?php if(!empty($custom_colors['footer-bg'])):?>
.style-2 .footer-info,
.footer-bottom,
.footer-info,
.footer-top {
  background-color: <?php echo dh_print_string($custom_colors['footer-bg'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['footer-color'])):?>
.footer-info,
.footer-social a
{
  color: <?php echo dh_print_string($custom_colors['footer-color'])?>;
}
.footer-social a {
	border-color: <?php echo dh_print_string($custom_colors['footer-color'])?>;
}
<?php endif;?>

<?php if(!empty($custom_colors['footer-link-color'])):?>
.footer .footer-info a,
.footer-info a{
	color:<?php echo dh_print_string($custom_colors['footer-link-color'])?> !important;
}
<?php endif;?>
<?php if(!empty($custom_colors['footer-link-hover'])):?>
.footer-social a:hover i,
.footer .footer-info a:hover,
.footer .footer-info a:focus{
	color:<?php echo dh_print_string($custom_colors['footer-link-hover'])?> !important;
}
.footer-social a:hover{
	border-color:<?php echo dh_print_string($custom_colors['footer-link-hover'])?> !important;
}
<?php endif;?>

<?php 
$woo_gap = absint(dh_get_theme_option('woo-gap','15'));
if(!empty($woo_gap) && $woo_gap != 15){
?>
.woocommerce ul.products:not(.masonry-products) li.product{
	padding-left:<?php echo  $woo_gap?>px;
	padding-right:<?php echo  $woo_gap?>px;
}
.woocommerce ul.products:not(.masonry-products){
	margin-left: -<?php echo  $woo_gap?>px;
    margin-right: -<?php echo  $woo_gap?>px;
}
<?php
}
?>
<?php $newsletter_bg = dh_get_theme_option('newsletter_bg',0);
if(!empty($newsletter_bg)):?>
@media (min-width: 768px) {
  .newsletter-modal .modal-content {
    background: #ffffff url("<?php echo esc_attr($newsletter_bg)?>") no-repeat scroll left center;
  }
}
<?php endif;?>
