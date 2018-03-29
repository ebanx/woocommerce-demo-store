<?php
extract( shortcode_atts( array(
	'username'			=> '',
	'style'				=> 'slider',
	'grid_column'		=> '4',
	'images_number'		=> '12',
	'refresh_hour'		=> '5',
	'visibility'        => '',
	'el_class'             => '',
), $atts ) );
/**
 * script
 * {{
 */
wp_enqueue_script('carouFredSel');
$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class($visibility);
$username = strtolower($username);
$grid_column = absint($grid_column);
ob_start();
?>
<div class="instagram">
	<div class="instagram-wrap">
		<?php ;
		$images_data = dh_instagram($username,$images_number, $refresh_hour);

		if ( !is_wp_error($images_data) && ! empty( $images_data ) ) {
			if($style == 'grid'){
			?>
			<?php $i = 0;?>
			<?php foreach ((array)$images_data as $item):?>
				<?php if($i ++ % $grid_column == 0){?>
				<div class="row">
				<?php }?>
				<div class="<?php echo ($grid_column == '5' ? 'col-md-15':'col-md-'.absint(12/$grid_column))  ?> col-xs-6">
					<a class="instagram-item" href="<?php echo esc_attr( $item['link'])?>" title="<?php echo esc_attr($item['description'])?>" target="_blank">
						<img src="<?php echo esc_attr($item['thumbnail'])?>"  alt="<?php echo esc_attr($item['description'])?>"/>
						<span class="instagram-item-desc">
							<span class="inner">
								<strong><?php echo esc_html(date_i18n('M j',$item['time']))?> </strong> 
								<span><?php echo esc_html($item['description'])?></span>
							</span>
						</span>
					</a>
				</div>
				<?php if($i % $grid_column == 0 || $i == count($images_data) ){?>
				</div>
				<?php }?>
			<?php endforeach;?>
			<?php 
			}else{
			?>
			<div class="caroufredsel caroufredsel-item-no-padding"  data-height="variable" data-scroll-fx="scroll" data-scroll-item="1" data-visible-min="1" data-visible-max="4" data-responsive="1" data-infinite="1" data-autoplay="0" data-circular="1">
			<div class="caroufredsel-wrap">
			<ul class="caroufredsel-items row">
				<?php foreach ((array)$images_data as $item):?>
				<li class="caroufredsel-item col-sm-3 col-xs-6">
					<a class="instagram-item" href="<?php echo esc_attr( $item['link'])?>" title="<?php echo esc_attr($item['description'])?>" target="_blank">
						<img src="<?php echo esc_attr($item['thumbnail'])?>"  alt="<?php echo esc_attr($item['description'])?>"/>
						<span class="instagram-item-desc">
							<span class="inner">
								<strong><?php echo esc_html(date_i18n('M j',$item['time']))?> </strong> 
								<span><?php echo esc_html($item['description'])?></span>
							</span>
						</span>
					</a>
				</li>
				<?php endforeach;?>
			</ul>
			<a href="#" class="caroufredsel-prev"></a>
			<a href="#" class="caroufredsel-next"></a>
			</div>
			</div>
			<?php
			}
		} else {
			echo '<div class="text-center" style="margin-bottom:30px">';
			if(is_wp_error($images_data)){
				echo implode($images_data->get_error_messages());
			}else{
				echo esc_html__( 'Instagram did not return any images.', 'forward' );
			}
			echo '</div>';
		};
		?>
	</div>
</div>
<?php
echo ob_get_clean();