<?php
$output = '';
extract(shortcode_atts(array(
	'style'			=>'below',
	'name'			=>'',
	'job'			=>'',
	'avatar'		=>'',
	'description'	=>'',
	'facebook'		=>'',
	'twitter'		=>'',
	'google'		=>'',
	'linkedin'		=>'',
	'visibility'	=>'',
	'el_class'		=>'',
), $atts));

$description = vc_value_from_safe($description);

$el_class  = !empty($el_class) ? ' '.esc_attr( $el_class ) : '';
$el_class .= dh_visibility_class($visibility);

$output .='<div class="team-member team-member-'.$style.$el_class.'">';
if(!empty($avatar)){
	$img = wpb_getImageBySize( array( 'attach_id' => $avatar, 'thumb_size' => array(600,600)));
	if ( $img == NULL ) $img['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />'; 
	
	$avatar_image = $img['thumbnail'];//wp_get_attachment_image_src($avatar,'dh-thumbnail-square');
	//$avatar_url = $avatar_image[0];
	$output .='<div class="member-avatar"'.(($style=='right') ? ' style="background-image:url('.wp_get_attachment_url($avatar).')"':'').'>';
	if($style!='right'){
		$output .=$avatar_image;
		$output .='<div class="overlay"></div>';
	}
	if($style == 'below' && (!empty($facebook) || !empty($twitter) || !empty($google) || !empty($linkedin))){
		$output .='<div class="member-meta">';
		if(!empty($facebook)){
			$output .='<span class="facebook">';
			$output .='<a href="'.esc_url($facebook).'" title="'.__('Facebook','forward').'" target="_blank"><i class="fa fa-facebook"></i></a>';
			$output .='</span>';
		}
		if(!empty($twitter)){
			$output .='<span class="twitter">';
			$output .='<a href="'.esc_url($twitter).'" title="'.__('Twitter','forward').'" target="_blank"><i class="fa fa-twitter"></i></a>';
			$output .='</span>';
		}
		if(!empty($google)){
			$output .='<span class="google">';
			$output .='<a href="'.esc_url($google).'" title="'.__('Google +','forward').'" target="_blank"><i class="fa fa-google"></i></a>';
			$output .='</span>';
		}
		if(!empty($linkedin)){
			$output .='<span class="linkedin">';
			$output .='<a href="'.esc_url($linkedin).'" title="'.__('Linked In','forward').'" target="_blank"><i class="fa fa-linkedin"></i></a>';
			$output .='</span>';
		}
		$output .='</div>';
	}
	$output .='</div>';
}
$output .='<div class="member-info">';
$output .='<div class="member-info-wrap">';
$output .='<div class="member-name">';
$output .='<h4>'.$name.'</h4>';
$output .='</div>';
if(!empty($job)){
	$output .='<div class="member-job">';
	$output .=$job;
	$output .='</div>';
}
if(!empty($description) && ($style == 'below' || $style=='right')){
	$output .='<div class="member-desc">';
	$output .=$description;
	$output .='</div>';
}
if(($style == 'overlay' ||  $style=='right') && (!empty($facebook) || !empty($twitter) || !empty($google) || !empty($linkedin))){
	$output .='<div class="member-meta">';
	if(!empty($facebook)){
		$output .='<span class="facebook">';
		$output .='<a href="'.esc_url($facebook).'" title="'.__('Facebook','forward').'" target="_blank"><i class="fa fa-facebook"></i></a>';
		$output .='</span>';
	}
	if(!empty($twitter)){
		$output .='<span class="twitter">';
		$output .='<a href="'.esc_url($twitter).'" title="'.__('Twitter','forward').'" target="_blank"><i class="fa fa-twitter"></i></a>';
		$output .='</span>';
	}
	if(!empty($google)){
		$output .='<span class="google">';
		$output .='<a href="'.esc_url($google).'" title="'.__('Google +','forward').'" target="_blank"><i class="fa fa-google"></i></a>';
		$output .='</span>';
	}
	if(!empty($linkedin)){
		$output .='<span class="linkedin">';
		$output .='<a href="'.esc_url($linkedin).'" title="'.__('Linked In','forward').'" target="_blank"><i class="fa fa-linkedin"></i></a>';
		$output .='</span>';
	}
	$output .='</div>';
}
$output .='</div>';
$output .='</div>';
if(( $style=='default' ) && (!empty($facebook) || !empty($twitter) || !empty($google) || !empty($linkedin))){
	$output .='<div class="member-meta">';
	if(!empty($facebook)){
		$output .='<span class="facebook">';
		$output .='<a href="'.esc_url($facebook).'" title="'.__('Facebook','forward').'" target="_blank"><i class="fa fa-facebook"></i></a>';
		$output .='</span>';
	}
	if(!empty($twitter)){
		$output .='<span class="twitter">';
		$output .='<a href="'.esc_url($twitter).'" title="'.__('Twitter','forward').'" target="_blank"><i class="fa fa-twitter"></i></a>';
		$output .='</span>';
	}
	if(!empty($google)){
		$output .='<span class="google">';
		$output .='<a href="'.esc_url($google).'" title="'.__('Google +','forward').'" target="_blank"><i class="fa fa-google"></i></a>';
		$output .='</span>';
	}
	if(!empty($linkedin)){
		$output .='<span class="linkedin">';
		$output .='<a href="'.esc_url($linkedin).'" title="'.__('Linked In','forward').'" target="_blank"><i class="fa fa-linkedin"></i></a>';
		$output .='</span>';
	}
	$output .='</div>';
}
$output .='</div>';
echo $output;
