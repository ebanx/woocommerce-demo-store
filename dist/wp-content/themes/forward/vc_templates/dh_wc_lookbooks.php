<?php
extract( shortcode_atts( array(
	'ids'=>'',
	'el_class'=> '',
	'css'=>'',
), $atts ) );

$class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$css_class = "dh-lookbooks row {$css_class}";
$select_lookbooks = array_filter(explode(',', $ids));
if(empty($select_lookbooks))
	return;
$id = uniqid('dh_lookbooks_');
?>
<div class="<?php echo esc_attr($css_class). vc_shortcode_custom_css_class($css, ' '); ?>">
	<div data-ride="carousel" class="carousel slide fade" id="<?php echo esc_attr($id)?>">
		<div role="listbox" class="carousel-inner">
		<?php 
		$i=0;
		$indicators = '';
		?>
		<?php foreach ($select_lookbooks as $lb):?>
			<?php 
			$lookbook=get_term($lb,'product_lookbook');
			if(is_wp_error($lookbook) || empty($lookbook))
				continue;
			?>
			<div class="item<?php if($i==0) echo ' active';?>"> 
				<div class="lb-info col-sm-5">
					<div class="lb-info-inner">
						<h3 class="lb-title"><?php echo esc_html($lookbook->name) ?></h3>
						<div class="lb-desc">
							<?php echo esc_html($lookbook->description)?>
						</div>
						<div class="tb-button">
							<a href="<?php get_term_link($lookbook,'product_lookbook')?>"><?php esc_html_e('Shop','forward')?></a>
						</div>
					</div>
				</div>
				<div class="lb-image col-sm-7">
					<?php 
					$thumbnail_id  			= get_woocommerce_term_meta( $lookbook->term_id, 'thumbnail_id', true  );
					$image 					= wp_get_attachment_url( $thumbnail_id  );
					if(empty($image))
						$image = wc_placeholder_img_src();
					?>
					<img alt="<?php echo esc_attr($lookbook->title)?>" src="<?php echo esc_url($image)?>" data-holder-rendered="true"> 
				</div>
			</div>
			<?php $i++;?>
		<?php endforeach;?>
		</div>
        <a data-slide="prev" role="button" href="#<?php echo esc_attr($id)?>" class="left carousel-control">
        	<span aria-hidden="true" class="elegant_arrow_left"></span> 
        	<span class="sr-only">Previous</span> 
        </a>
        <a data-slide="next" role="button" href="#<?php echo esc_attr($id)?>" class="right carousel-control"> 
        	<span aria-hidden="true" class="elegant_arrow_right"></span> 
        	<span class="sr-only">Next</span>
        </a>
    </div>
</div>
<?php
