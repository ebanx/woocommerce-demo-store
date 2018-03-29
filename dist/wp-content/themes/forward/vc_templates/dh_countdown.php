<?php
$output = '';
extract(shortcode_atts(array(
	'style'				=>'white',
	'end'				=>'',
	'visibility'		=>'',
	'el_class'			=>'',
), $atts));

if(empty($end) || defined('SITESAO_PREVIEW')){
	$end = date('Y/m/d', time() + 7 * 24 * 60 * 60);
}
/**
 * script
 * {{
 */
wp_enqueue_script('countdown');
$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class($visibility);
$html = '
<div class="countdown-item">
	<div class="countdown-item-label">'.__('Days','forward').'</div>
	<div class="countdown-item-value">%D</div>
</div>
<div class="countdown-item">
	<div class="countdown-item-label">'.__('Hours','forward').'</div>
	<div class="countdown-item-value">%H</div>
</div>
<div class="countdown-item">
	<div class="countdown-item-label">'.__('Minutes','forward').'</div>
	<div class="countdown-item-value">%M</div>
</div>
<div class="countdown-item">
	<div class="countdown-item-label">'.__('Seconds','forward').'</div>
	<div class="countdown-item-value">%S</div>
</div>';
ob_start();
?>
<div data-toggle="countdown" data-html="<?php echo esc_attr($html)?>" data-end="<?php echo esc_attr(mysql2date('Y/m/d', $end))?>" class="countdown countdown-<?php echo esc_attr($style) ?> <?php echo esc_attr($el_class)?>" data-now="<?php echo strtotime("now") ?>">
	<div class="countdown-wrap">
		<div class="countdown-content clearfix"></div>
	</div>
</div>
<?php
echo ob_get_clean();