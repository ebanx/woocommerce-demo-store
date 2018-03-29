<?php
/**
 *	Whats New
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
$version = kalium()->getVersion();
?>
<div class="kalium-whats-new">
	
	<?php if ( kalium()->get( 'welcome', true ) ) : $theme_name = wp_get_theme()->get( 'Name' ); ?>
	<div class="kalium-activated">
		<h3>
			Thanks for activating Kalium theme!
			<br>
			<small>Here are the first steps to setup the theme:</small>
		</h3>
		
		<ol>
			<li>Install and activate required plugins by <a href="<?php echo admin_url('themes.php?page=kalium-install-plugins'); ?>" target="_blank">clicking here</a></li>
			<li>Install demo content via <a href="<?php echo admin_url('admin.php?page=laborator-demo-content-installer'); ?>" target="_blank">One-Click Demo Content</a> installer (Optional)</li>
			<li>Configure <a href="<?php echo admin_url('admin.php?page=theme-options'); ?>" target="_blank">theme options</a> (Optional)</li>
			<li>Refer to our <a href="<?php echo admin_url('admin.php?page=laborator-docs'); ?>">theme documentation</a> and learn how to setup <?php echo $theme_name; ?> (Recommended)</li>
		</ol>
	</div>
	<?php endif; ?>
	
	<div class="kalium-version">
		<div class="kalium-version-gradient">
			<span class="numbers-<?php echo strlen( str_replace( '.', '', $version ) ); ?>"><?php echo $version; ?></span>
		</div>
		
		<div class="kalium-version-info">
			<h2>Kalium 2: What’s New!</h2>
			<p>
				Kalium Two comes with tons of new features, improvements and bug fixes.<br>
				It is faster, richer in options, plugin compatibilities and more intuitive than ever before.
			</p>
		</div>
	</div>
	
	<div class="two-col wp-clearfix">
		<div class="col">
			<a href="<?php echo admin_url( 'admin.php?page=typolab' ); ?>"><img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/typography.jpg' ); ?>"></a>
			<h3>Typography</h3>
			<p>Ultimate Font Management Library like no other theme on ThemeForest. Supports five font sources: Google, Font Squirrel, TypeKit, Custom Font and Premium Fonts. There is no font that you can't add to Kalium anymore!</p>
		</div>
		<div class="col">
			<a href="http://demo.kaliumtheme.com/fashion" target="_blank"><img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/fashion-demo.jpg' ); ?>"></a>
			<h3>Fashion Demo</h3>
			<p>New demo content site, a stylish demo store that shows the power of Kalium to create multi-concept sites. It contains various catalog and product styles and it is unique Kalium demo. 
				<br>
				<a href="http://demo.kaliumtheme.com/fashion" target="_blank">Click to preview &raquo;</a></p>
		</div>
	</div>
	
	
	<div class="whats-new-secondary three-col wp-clearfix">
		<div class="col">
			<img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/automatic-updates.jpg' ); ?>">
			<h3>Stay up to date, always</h3>
			<p>There is no need of custom plugins to update Kalium theme anymore, simply activate the theme and you'll stay up to date with very latest releases and small fixes.</p>
		</div>
		<div class="col">
			<img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/rtl-support.jpg' ); ?>">
			<h3>RTL Support</h3>
			<p>Right to left languages are now covered in Kalium Two. It will be automatically activated once you use an RTL language.</p>
		</div>
		<div class="col">
			<img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/new-translations.jpg' ); ?>">
			<h3>15 Languages Included</h3>
			<p>Expanded in language support, so Kalium now speaks your language: Czech, Danish, German, Greek, Spanish, French, Italian, Norwegian, Dutch, Polish, Portuguese, Albanian, Swedish and Turkish.</p>
		</div>
	</div>
	
	
	<div class="whats-new-secondary three-col wp-clearfix">
		<div class="col">
			<img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/function-pro-font.jpg' ); ?>">
			<h3>Premium Font Included</h3>
			<p title="Supported Language Subsets: Afrikaans, English, French, German, Latin Basic, Latin Extreme, Western Latin, Spanish, Swedish, Turkish">Function Pro font family with 21 different styles is now part of Kalium. It is a premium font and supported by 10 language subsets.</p>
		</div>
		<div class="col">
			<img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/size-guide-plugin.jpg' ); ?>">
			<h3>New Premium Plugin Included</h3>
			<p>Product Size Guide WooCommerce extension lets you create size guide popup for your shop visitors to learn more about the size guides of your products. 
				<br>
				<a href="http://demo.kaliumtheme.com/fashion/product/jeans/" target="_blank">See example &raquo;</a></p>
		</div>
		<div class="col">
			<img src="<?php echo kalium()->assetsUrl( 'images/admin/whats-new/menu-search-bar.jpg' ); ?>">
			<h3>Search Bar on Menu</h3>
			<p>Quick search for your site, you can now add search icon next to menu bar in header which will be nicely animated when user clicks it.</p>
		</div>
	</div>
	
	<a href="https://laborator.ticksy.com/article/7530?print" target="_blank" class="view-changelog">See Full Changelog &#65515;</a>
	
</div>