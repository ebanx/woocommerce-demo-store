<?php 
$brand_primary = dh_format_color(dh_get_theme_option('brand-primary','#9fce4e'));
$brand_primary = apply_filters('dh_brand_primary', $brand_primary);
if($brand_primary == '#9fce4e' || trim($brand_primary) == ''){
  return '';
}
$darken_8_brand_primary = darken(dh_format_color($brand_primary),'8%');
$fade_70_brand_primary = fade(dh_format_color($brand_primary),'70%');
?>
a:hover,
a:focus {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.fade-loading i {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.loadmore-action .loadmore-loading span {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.loadmore-action .btn-loadmore:hover,
.loadmore-action .btn-loadmore:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.text-primary {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.bg-primary {
  background-color: <?php echo dh_print_string($brand_primary) ?>;
}
.btn-default:hover,
.btn-default:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.btn-primary {
  background-color: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.btn-outline:hover,
.btn-outline:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.btn-primary-outline {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.btn-primary-outline:hover {
  background: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover {
  background-color: <?php echo dh_print_string($brand_primary) ?>;
}
.navbar-default .navbar-nav > li > a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.navbar-default .navbar-nav .active > a,
.navbar-default .navbar-nav .open > a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.header-transparent:not(.header-navbar-fixed) .navbar-default .navbar-nav .active > a,
.header-transparent:not(.header-navbar-fixed) .navbar-default .navbar-nav .open > a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.navbar-default .navbar-nav > .current-menu-ancestor > a,
.navbar-default .navbar-nav > .current-menu-parent > a,
.navbar-default .navbar-nav > .current-menu-ancestor > a:hover,
.navbar-default .navbar-nav > .current-menu-parent > a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.header-container .minicart .minicart-footer .minicart-actions .button:hover, .header-container .minicart .minicart-footer .minicart-actions .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
@media (max-width: 899px) {
  .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover {
    color: <?php echo dh_print_string($brand_primary) ?>;
  }
}
@media (min-width: 900px) {
  .primary-nav > .megamenu > .dropdown-menu > li .dropdown-menu a:hover {
    color: <?php echo dh_print_string($brand_primary) ?>;
  }
  .primary-nav .dropdown-menu a:hover {
    color: <?php echo dh_print_string($brand_primary) ?>;
    background: transparent;
  }
}
.primary-nav .dropdown-menu .open > a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.primary-nav > li.current-menu-parent > a,
.primary-nav > li.current-menu-parent > a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.cart-icon-mobile span {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.offcanvas-nav li.active > a, 
.offcanvas-nav li.open > a, 
.offcanvas-nav a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.offcanvas-nav a:hover:before {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.offcanvas-nav .dropdown-menu a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.breadcrumb > li a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.mejs-controls .mejs-time-rail .mejs-time-current {
  background: <?php echo dh_print_string($brand_primary) ?> !important;
}
.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
  background: <?php echo dh_print_string($brand_primary) ?> !important;
}
.ajax-modal-result a,
.user-modal-result a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
a[data-toggle="popover"],
a[data-toggle="tooltip"] {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.custom.tparrows:hover {
  background: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.caroufredsel.product-slider.nav-position-center .product-slider-title ~ .caroufredsel-wrap .caroufredsel-next:hover:after,
.caroufredsel.product-slider.nav-position-center .product-slider-title ~ .caroufredsel-wrap .caroufredsel-prev:hover:after {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.caroufredsel .caroufredsel-wrap .caroufredsel-next:hover,
.caroufredsel .caroufredsel-wrap .caroufredsel-prev:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.style-1.testimonial .testimonial-author {
  color: <?php echo dh_print_string($brand_primary) ?>;
}

.navbar-header-left .social a i:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.navbar-header-right > div a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.header-type-classic .header-right > div.navbar-offcanvas a:hover,
.header-type-classic .header-right > div .minicart-link:hover,
.header-type-classic .header-right > div a.wishlist:hover,
.header-type-classic .header-right > div .navbar-search-button:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
@media (min-width: 992px) {
	.primary-nav > li:not(.megamenu) > .dropdown-menu,
	.primary-nav > .megamenu > .dropdown-menu{
	    border-top-color: <?php echo dh_print_string($brand_primary) ?>;
	}
}
.footer-featured i {
  border: 2px solid <?php echo dh_print_string($brand_primary) ?>;
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.footer-widget a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.footer-widget .social-widget-wrap a:hover i {
  color: <?php echo dh_print_string($brand_primary) ?> !important;
}
.footer-widget .social-widget-wrap.social-widget-none a:hover i {
  color: <?php echo dh_print_string($brand_primary) ?> !important;
}
.footer-social a i:hover {
  color: <?php echo dh_print_string($brand_primary) ?> !important;
}
.entry-format {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.sticky .entry-title:before {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.entry-meta a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.readmore-link a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.sticky .entry-title a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.post-navigation a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.author-info .author-social a:hover {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.share-links .share-icons a:hover,
.share-links .share-icons a:focus {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.comment-author a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.comment-reply-link:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
#wp-calendar > tbody > tr > td > a {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.recent-tweets ul li a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.widget-post-thumbnail li .posts-thumbnail-content .posts-thumbnail-meta a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}

/*Woo*/
.woocommerce span.onsale {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce-account .woocommerce .button:hover,
.woocommerce-account .woocommerce .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce .return-to-shop .button:hover,
.woocommerce .return-to-shop .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce div.product-quickview-content div.summary .share-links .share-icons a:hover,
.woocommerce div.product div.summary .share-links .share-icons a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce div.product-quickview-content form.cart .swatch-wrapper.selected,
.woocommerce div.product form.cart .swatch-wrapper.selected {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce div.product-quickview-content form.cart .variations .woocommerce-variation-select .swatch-select.selected,
.woocommerce div.product form.cart .variations .woocommerce-variation-select .swatch-select.selected {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce span.out_of_stock {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover,
.woocommerce ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce ul.products li.product figure:hover .product-wrap .product-images {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce > div .button:not(.checkout-button):hover,
.woocommerce .cart .button:hover,
.woocommerce > div .button:not(.checkout-button):focus,
.woocommerce .cart .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce .star-rating:before {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce .star-rating span {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce p.stars.has-active a, 
.woocommerce p.stars:hover a{
 color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce p.stars a.star-1:hover:after,
.woocommerce p.stars a.star-1.active:after {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce p.stars a.star-2:hover:after,
.woocommerce p.stars a.star-2.active:after {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce p.stars a.star-3:hover:after,
.woocommerce p.stars a.star-3.active:after {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce p.stars a.star-4:hover:after,
.woocommerce p.stars a.star-4.active:after {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce p.stars a.star-5:hover:after,
.woocommerce p.stars a.star-5.active:after {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce table.cart td.actions .button:hover,
.woocommerce table.cart td.actions .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce ul.cart_list li a:hover,
.woocommerce ul.product_list_widget li a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce.dhwc_widget_brands ul.product-brands li ul.children li a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}

.woocommerce .widget_shopping_cart .buttons .button:hover,
.woocommerce .widget_shopping_cart .buttons .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce .widget_shopping_cart .buttons .button.checkout {
  background-color: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce form .form-row button.button:hover,
.woocommerce form .form-row input.button:hover,
.woocommerce form .form-row button.button:focus,
.woocommerce form .form-row input.button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.minicart-icon span {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.minicart .minicart-body .cart-product .cart-product-title a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.minicart .minicart-footer .minicart-actions .button:hover,
.minicart .minicart-footer .minicart-actions .button:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.product-slider-title.color-primary .el-heading {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.product-slider-title.color-primary .el-heading:before {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.lookbooks-grid .lookbook-small-title {
  color: <?php echo dh_print_string($brand_primary) ?> !important;
}
@media (min-width: 992px) {
  .lookbooks-grid .lookbook-info-wrap-border {
    border: 1px solid <?php echo dh_print_string($brand_primary) ?>;
  }
}
.grid-style-3.grid-gutter .product-categories-grid-wrap .product-category-grid-item-wrap:hover:before,
.grid-style-4.grid-gutter .product-categories-grid-wrap .product-category-grid-item-wrap:hover:before {
  -webkit-box-shadow: inset 0 0 0 1px <?php echo dh_print_string($brand_primary) ?>;
  box-shadow: inset 0 0 0 1px <?php echo dh_print_string($brand_primary) ?>;
}
.box-ft-3 .bof-tf-sub-title {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.box-ft-5 .bof-tf-title-wrap .bof-tf-title-wrap-2 {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.box-ft-5 .bof-tf-title-wrap .bof-tf-title {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.box-ft-5 .bof-tf-title-wrap .bof-tf-title-wrap-2 > a:before,
.box-ft-5 .bof-tf-title-wrap.bg-primary {
  background: <?php echo dh_print_string($brand_primary) ?>;
}


.header-type-market .navbar-collapse {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.dh-menu .dh-menu-title h3 {
  background: <?php echo dh_print_string($darken_8_brand_primary) ?>;
}
.navbar-search .searchinput-wrap .searchinput,
.navbar-search .searchinput-wrap .search-product-category select {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.navbar-search .searchinput-wrap .searchinput:focus {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.navbar-search .searchinput-wrap .searchsubmit {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.header-type-market .navbar-default .dh-menu .navbar-nav > li > a:hover,
.header-type-market .navbar-default .dh-menu .navbar-nav > li.active > a, 
.header-type-market .navbar-default .dh-menu .navbar-nav > li.open > a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.dh-menu .primary-nav li.menu-item-has-children > .dropdown-menu {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.header-type-market.header-navbar-fixed .minicart-icon span {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce ul.products li.product.style-3 figure .product-wrap .product-images .loop-action .loop-add-to-wishlist .add_to_wishlist:hover,
.woocommerce ul.products li.product.style-3 figure .product-wrap .product-images .loop-action .loop-add-to-cart a:hover,
.woocommerce ul.products li.product.style-3 figure .product-wrap .product-images .loop-action .shop-loop-quickview a:hover {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.woocommerce ul.products li.product.style-3 figure .product-wrap .product-images .loop-action .loop-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover, .woocommerce ul.products li.product.style-3 figure .product-wrap .product-images .loop-action .loop-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.header-offcanvas.header-offcanvas-always-show .offcanvas-nav > li.active > a, .header-offcanvas.header-offcanvas-always-show .offcanvas-nav > li.open > a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.header-offcanvas.header-offcanvas-always-show .offcanvas-nav > li.active > a:before, .header-offcanvas.header-offcanvas-always-show .offcanvas-nav > li.open > a:before {
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.header-offcanvas.header-offcanvas-always-show .offcanvas-nav a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.offcanvas-nav a:hover:before {
  background: <?php echo dh_print_string($brand_primary) ?>;
}

.vc_tta-accordion.skin-dark.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-heading:hover a,
.vc_tta-accordion.vc_tta-color-grey.vc_tta-style-classic.skin-dark .vc_tta-panel.vc_active .vc_tta-panel-heading a, 
.vc_tta-accordion.vc_tta-color-grey.vc_tta-style-classic.skin-dark .vc_tta-panel.vc_active .vc_tta-panel-heading:hover a {
  color: <?php echo dh_print_string($brand_primary) ?>;
}
.vc_tta-color-grey.vc_tta-style-classic.skin-dark .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::after, 
.vc_tta-color-grey.vc_tta-style-classic.skin-dark .vc_active .vc_tta-panel-heading .vc_tta-controls-icon::before,
.vc_tta-color-grey.vc_tta-style-classic.skin-dark .vc_tta-panel-heading:hover .vc_tta-controls-icon::after, 
.vc_tta-color-grey.vc_tta-style-classic.skin-dark .vc_tta-panel-heading:hover .vc_tta-controls-icon::before {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.header-type-market .navbar-default .dh-menu .navbar-nav > li > a:hover {
  color: <?php echo dh_print_string($brand_primary) ?>;
}

.testimonial.style-4 .caroufredsel .caroufredsel-pagination a:hover, .testimonial.style-3 .caroufredsel .caroufredsel-pagination a:hover, .testimonial.style-4 .caroufredsel .caroufredsel-pagination a.selected, .testimonial.style-3 .caroufredsel .caroufredsel-pagination a.selected {
  -webkit-box-shadow: 0 0 0 1px <?php echo dh_print_string($brand_primary) ?>;
  box-shadow: 0 0 0 1px <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.btn-white-outline:hover {
  border-color: <?php echo dh_print_string($brand_primary) ?>;
  background: <?php echo dh_print_string($brand_primary) ?>;
}
.caroufredsel .caroufredsel-wrap .caroufredsel-next, .caroufredsel .caroufredsel-wrap .caroufredsel-prev {
  background-color: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}
.posts-layout-default .readmore-link a:hover, .posts-layout-zigzag .readmore-link a:hover, .posts-layout-center .readmore-link a:hover, .posts-layout-default .readmore-link a:focus, .posts-layout-zigzag .readmore-link a:focus, .posts-layout-center .readmore-link a:focus {
  background-color: <?php echo dh_print_string($brand_primary) ?>;
  border-color: <?php echo dh_print_string($brand_primary) ?>;
}