<?php
extract( shortcode_atts( array(
	'style'				=> '1',
	'content_position'  => 'default',
	'primary_background'=> '',
	'text_color'        => '',
	'bg'				=> '',
	'href'				=> '',
	'target'			=> '_self',
	'link_title'		=> 'Discover More',
	'sub_title'			=> '',
	'title'				=> '',
	'visibility'        => '',
	'el_class'          => '',
), $atts ) );
$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class($visibility);
if($style == '4'){
	$el_class .= $text_color;
}
if($style == '5'){
	$el_class .= ' box-ft-5-'.$content_position.' ';
}
$image_src = wp_get_attachment_url($bg);
$href = !empty($href) ? $href : '#';
if(empty($image_src)){
	$image_src = get_template_directory_uri().'/assets/images/noo-thumb_700x350.png';
}
ob_start();
?>
<div class="box-ft box-ft-<?php echo esc_attr($style)?> <?php echo ($style == '2') ? 'nice-border-full':''?> <?php echo esc_attr($el_class)?>">
	<?php if($style == '2'){?>
	<a href="<?php echo esc_attr($href)?>" target="<?php echo esc_attr($target)?>">
	<?php }?>
		<img src="<?php echo esc_attr($image_src)?>" alt="">
	<?php if($style == '2'){?>
	</a>
	<?php } ?>
	<?php if($style == '3'){?>
	<div class="box-ft-img-overlay" style="background-image: url(<?php echo esc_attr($image_src)?>)"></div>
	<?php }?>
	<?php if($style != '5'){?>
		<a href="<?php echo esc_attr($href)?>" target="<?php echo esc_attr($target)?>">
	<?php }?>
		<span class="bof-tf-title-wrap <?php if($style == 5 && $content_position == 'full-box' && !empty($primary_background)){echo ' bg-primary';}?>">
			<span class="bof-tf-title-wrap-2">
				<?php if($style == '2'){?>
				<span class="nice-border-top-left"></span>
				<span class="nice-border-top-right"></span>
				<span class="nice-border-bottom-left"></span>
				<span class="nice-border-bottom-right"></span>
				<?php }?>
				<?php if($style == '4' || $style=='5'){?>
					<span class="bof-tf-title"><?php echo esc_html($title)?></span>
					<?php if(!empty($sub_title)){?>
					<span class="bof-tf-sub-title"><?php echo esc_html($sub_title)?></span>
					<?php }?>
					<?php if(!empty($link_title) && $style == '5'){?>
						<a href="<?php echo esc_attr($href)?>" title="<?php echo esc_attr($link_title);?>" target="<?php echo esc_attr($target)?>"><?php echo esc_html($link_title);?></a>
					<?php }?>
				<?php }else { ?>
					<?php if(!empty($sub_title)){?>
					<span class="bof-tf-sub-title"><?php echo esc_html($sub_title)?></span>
					<?php }?>
					<span class="bof-tf-title"><?php echo esc_html($title)?></span>
				<?php } ?>
				<?php if($style == '3'){?>
				<span class="bof-tf-view-more"><?php esc_html_e('View More','forward')?></span>
				<?php }?>
			</span>
		</span>
	<?php if($style != '5'){?>
	</a>
	<?php }?>
</div>
<?php 
echo ob_get_clean();