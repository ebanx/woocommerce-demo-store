<?php
/**
 *	Kalium About Page Header
 *	
 *	Laborator.co
 *	www.laborator.co 
 */
?>
<h1>Welcome to Kalium</h1>

<p class="about-text">
	Kalium theme is now installed and ready to use with your WordPress site.
	<?php if ( Kalium_Theme_License::isValid() ) : ?>
		You have activated this product and you will get latest theme updates upon their availability.
	<?php else: ?>
		We kindly ask you to register your product to get support and automatic updates.
	<?php endif; ?>
</p>

<p class="wp-badge wp-kalium-badge">
	Version: <?php echo kalium()->getVersion(); ?>
</p>

<?php include 'about-tabs.php'; ?>