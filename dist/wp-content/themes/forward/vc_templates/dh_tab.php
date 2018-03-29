<?php
$output ='';
extract( shortcode_atts( array(
	'title' => '',
	'tab_id'=>''
), $atts ) );
global $tab_active;
$output .='<div class="tab-pane fade'.($tab_active == $tab_id ? ' active in':'').'" id="'.$tab_id.'">';
$output .= wpb_js_remove_wpautop($content);
$output .= '</div>';
echo $output;