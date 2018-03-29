<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version    2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs() 0905032132
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
<div class="tabbable woocommerce-tabs">
	<ul class="nav nav-tabs wc-tabs" role="tablist">
		<?php $i = 0; ?>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<li class="<?php echo esc_attr( $key ); ?>_tab <?php echo ($i==0 ? 'active':'') ?>">
				<a role="tab" href="#tab-<?php echo esc_attr($key) ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
			</li>
		<?php $i++; ?>
		<?php endforeach; ?>
	</ul>
	<div class="tab-content">
		<?php $i = 0; ?>
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div class="tab-pane wc-tab <?php echo ($i==0 ? 'active':'') ?>" id="tab-<?php echo esc_attr($key) ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>
		<?php $i++; ?>
		<?php endforeach; ?>
	</div>
</div>
<?php endif; ?>