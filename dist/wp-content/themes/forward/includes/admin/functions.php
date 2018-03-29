<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function dh_get_mailchimplist(){
	$options = array(__('Nothing Found...','forward'));
	if($mailchimp_api = dh_get_theme_option('mailchimp_api','')){
		if(!class_exists('MCAPI'))
			include_once( DHINC_DIR . '/lib/MCAPI.class.php' );
		$api = new MCAPI($mailchimp_api);
		$lists = $api->lists();
		if ($api->errorCode){
			$options = array(__("Unable to load MailChimp lists, check your API Key.", 'forward'));
		}else{
			if ($lists['total'] == 0){
				$options = array(__("You have not created any lists at MailChimp",'forward'));
			}else{
				$options = array(__('Select a list','forward'));
				foreach ($lists['data'] as $list){
					$options[$list['id']] = $list['name'];
				}
			}
		}
	}
	return $options;
}

function dh_render_meta_boxes($post, $meta_box) {
	$args = $meta_box ['args'];
	if(!defined('DH_META_BOX_NONCE')):
		define('DH_META_BOX_NONCE', 1);
	
	wp_nonce_field ('dh_meta_box_nonce', 'dh_meta_box_nonce',false);
	endif;
		
	if (! is_array ( $args ))
		return false;
		
	echo '<div class="dh-metaboxes">';
	if (isset ( $args ['description'] ) && $args ['description'] != '') {
		echo '<p>' . $args ['description'] . '</p>';
	}
	$count = 0;
	foreach ( $args ['fields'] as $field ) {
		if(!isset($field['type']) )
			continue;
	
		$field['name']          = isset( $field['name'] ) ? $field['name'] : '';
		$field['name'] 	= strstr( $field['name'], '_dh_' ) ? sanitize_title( $field['name'] ) : '_dh_' . sanitize_title( $field['name'] );
		
		$value = get_post_meta( $post->ID,$field['name'], true );
	
		$field['value']         = isset( $field['value'] ) ? $field['value'] : '';
		if($value !== '' && $value !== null && $value !== array() && $value !== false)
			$field['value'] = $value;
	
	
		$field['id'] 			= isset( $field['id'] ) ? $field['id'] : $field['name'];
		$field['description'] 	= isset($field['description']) ? $field['description'] : '';
		$field['label'] 		= isset( $field['label'] ) ? $field['label'] : '';
		$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : $field['label'];
		$field['fname'] = $field['name'];
		$field['name'] = 'dh_meta['.$field['name'].']';
		if( isset($field['callback']) && !empty($field['callback']) ) {
			call_user_func($field['callback'], $post,$field);
		} else {
			switch ($field['type']){
				case 'heading':
					echo '<h4>'.$field['heading'].'</h4>';
					break;
				break;
				case 'hr':
					echo '<div style="margin-top:20px;margin-bottom:20px;">';
					echo '<hr>';
					echo '</div>';
					break;
				case 'text':
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label><input type="text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" style="width: 99%;" /> ';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					if(isset($field['hidden']) && $field['hidden'] == true){
						$hidden_name = 'dh_meta['.$field['fname'].'_hidden]';
						$value = get_post_meta( $post->ID,$field['fname'], true );
						$hidden_value         = isset( $field['hidden_value'] ) ? $field['hidden_value'] : '';
						if($value !== '' && $value !== null && $value !== array() && $value !== false)
							$hidden_value = $value;
						echo '<input type="hidden" name="' . esc_attr( $hidden_name ) . '" value="' . esc_attr( $hidden_value ) . '">';
					}
					echo '</div>';
					break;
				case 'color':
					wp_enqueue_style( 'wp-color-picker');
					wp_enqueue_script( 'wp-color-picker');
					
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label><input type="text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '<script type="text/javascript">
						jQuery(document).ready(function($){
						    $("#'. esc_attr( $field['id'] ).'").wpColorPicker();
						});
					 </script>
					';
					echo '</div>';
					break;
				case 'textarea':
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label><textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20" style="width: 99%;">' . esc_textarea( $field['value'] ) . '</textarea> ';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '</div>';
					break;
				case 'checkbox':
					$field['cbvalue']       = isset( $field['cbvalue'] ) ? $field['cbvalue'] : '1';
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label><input type="checkbox" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="0"  checked="checked" style="display:none" /><input class="checkbox" type="checkbox" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['cbvalue'] ) . '" ' . checked( $field['value'], $field['cbvalue'], false ) . ' /> ';
					if ( ! empty( $field['description'] ) ) echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
						
					echo '</div>';
					break;
				case 'categories':
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label>';
					wp_dropdown_categories(array(
						'name'=>esc_attr( $field['name'] ),
						'id'=>esc_attr( $field['id'] ),
						'hierarchical'=>1,
						'selected'=>$field['value']
					));
					echo '</div>';
				break;
				case 'widgetised_sidebars':
					$sidebars = $GLOBALS['wp_registered_sidebars'];
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '">';
					echo '<option value="">' . __('Select a sidebar...','forward') . '</option>';
					foreach ( $sidebars as $sidebar ) {
						$selected = '';
						if ( $sidebar["id"] == $field['value'] ) $selected = ' selected="selected"';
						$sidebar_name = $sidebar["name"];
						echo '<option value="' . $sidebar["id"] . '"' . $selected . '>' . $sidebar_name . '</option>';
					}
					echo '</select> ';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '</div>';
					break;
					break;
				case 'select':
					$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '">';
					foreach ( $field['options'] as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
					}
					echo '</select> ';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '</div>';
					break;
				case 'radio':
					$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
					echo '<fieldset '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><legend>' . esc_html( $field['label'] ) . '</legend><ul>';
					foreach ( $field['options'] as $key => $value ) {
						echo '<li><label><input
					        		name="' . esc_attr( $field['name'] ) . '"
					        		value="' . esc_attr( $key ) . '"
					        		type="radio"
									class="radio"
					        		' . checked( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '
					        		/> ' . esc_html( $value ) . '</label>
					    	</li>';
					}
					echo '</ul>';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '</fieldset>';
					break;
				case 'gallery':
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}
					
					if(!defined('_DH_META_GALLERY_JS')):
					define('_DH_META_GALLERY_JS', 1);
					?>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							$('.dh-meta-gallery-select').on('click',function(e){
								e.stopPropagation();
								e.preventDefault();
								
								var $this = $(this),
									dh_meta_gallery_list = $this.closest('.dh-meta-box-field').find('.dh-meta-gallery-list'),
									dh_meta_gallery_frame,
									dh_meta_gallery_ids = $this.closest('.dh-meta-box-field').find('#dh_meta_gallery_ids'),
									_ids = dh_meta_gallery_ids.val();
	
								if(dh_meta_gallery_frame){
									dh_meta_gallery_frame.open();
									return false;
								}
								
								dh_meta_gallery_frame = wp.media({
									title: '<?php echo esc_js(__('Add Images to Gallery','forward'))?>',
									button: {
										text: '<?php echo esc_js(__('Add to Gallery','forward'))?>',
									},
									library: { type: 'image' },
									multiple: true
								});
	
								dh_meta_gallery_frame.on('select',function(){
									var selection = dh_meta_gallery_frame.state().get('selection');
									selection.map( function( attachment ) {
										attachment = attachment.toJSON();
										if ( attachment.id ) {
											_ids = _ids ? _ids + "," + attachment.id : attachment.id;
											dh_meta_gallery_list.append('\
												<li data-id="' + attachment.id +'">\
													<div class="thumbnail">\
														<div class="centered">\
															<img src="' + attachment.url + '" />\
														</div>\
														<a href="#" title="<?php echo esc_js(__('Delete','forward'))?>">x</a></li>\
													</div>\
												</li>'
											);
										}
										dh_meta_gallery_ids.val( dh_trim(_ids,',') );
										dh_meta_gallery_fn();
									});
								});
	
								dh_meta_gallery_frame.open();
							});
							var dh_meta_gallery_fn = function(){
								if($('.dh-meta-gallery-list').length){
									$('.dh-meta-gallery-list').each(function(){
										var $this = $(this);
										$this.sortable({
											items: 'li',
											cursor: 'move',
											forcePlaceholderSize: true,
											forceHelperSize: false,
											helper: 'clone',
											opacity: 0.65,
											placeholder: 'li-placeholder',
											start:function(event,ui){
												ui.item.css('background-color','#f6f6f6');
											},
											update: function(event, ui) {
												var _ids = '';
												$this.find('li').each(function() {
													var _id = $(this).data( 'id' );
													_ids = _ids + _id + ',';
												});
									
												$this.closest('.dh-meta-box-field').find('#dh_meta_gallery_ids').val( dh_trim(_ids,',') );
											}
										});
	
										$this.find('a').on( 'click',function(e) {
											e.stopPropagation();
											e.preventDefault();
											$(this).closest('li').remove();
											var _ids = '';
											$this.find('li').each(function() {
												var _id = $(this).data( 'id' );
												_ids = _ids + _id + ',';
											});
	
											$this.closest('.dh-meta-box-field').find('#dh_meta_gallery_ids').val( dh_trim(_ids,',') );
	
											return false;
										});
										
									});
								}
							}
							dh_meta_gallery_fn();
						});
					</script>
					<?php
					endif;
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field">';
					echo '<label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label>';
					echo '<div class="dh-meta-gallery-wrap"><ul class="dh-meta-gallery-list">';
					if($field['value']){
						$value_arr = explode(',', $field['value']);
						if(!empty($value_arr) && is_array($value_arr)){
							foreach ($value_arr as $attachment_id ){
								if($attachment_id):
							?>
								<li data-id="<?php echo esc_attr( $attachment_id ) ?>">
									<div class="thumbnail">
										<div class="centered">
											<?php echo wp_get_attachment_image( $attachment_id, array(120,120) ); ?>						
										</div>
										<a title="<?php echo esc_attr__('Delete','forward') ?>" href="#">x</a>
									</div>						
								</li>
							<?php
								endif;
							}
						}
					}
					echo '</ul></div>';
					echo '<input type="hidden" name="' . $field['name'] . '" id="dh_meta_gallery_ids" value="' . $field['value'] . '" />';
					echo '<input type="button" class="button button-primary dh-meta-gallery-select" name="' . $field['id'] . '_button_upload" id="' . $field['id'] . '_upload" value="' . __('Add Gallery Images','forward') . '" /> ';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '</div>';
				break;
				case 'media':
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}
					$btn_text = !empty(  $field['value'] ) ? __( 'Change Media', 'forward' ) : __( 'Select Media', 'forward' );
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field">';
					echo '<label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label>';
					echo '<input type="text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" style="width: 99%;margin-bottom:5px" />';
					echo '<input type="button" class="button button-primary" name="' . $field['id'] . '_button_upload" id="' . $field['id'] . '_upload" value="' . $btn_text . '" /> ';
					echo '<input type="button" class="button" name="' . $field['id'] . '_button_clear" id="' . $field['id'] . '_clear" value="' . __( 'Clear', 'forward' ) . '" />';				
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					echo '</div>';
					?>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							<?php if ( empty ( $field['value'] ) ) : ?> $('#<?php echo esc_attr($field['id']); ?>_clear').css('display', 'none'); <?php endif; ?>
							$('#<?php echo esc_attr($field['id']) ?>_upload').on('click', function(event) {
								event.preventDefault();
								var $this = $(this);
		
								// if media frame exists, reopen
								if(dh_<?php echo esc_attr($field['id']); ?>_media_frame) {
									dh_<?php echo esc_attr($field['id']); ?>_media_frame.open();
					                return;
					            }
		
								// create new media frame
								// I decided to create new frame every time to control the selected images
								var dh_<?php echo esc_attr($field['id']); ?>_media_frame = wp.media.frames.wp_media_frame = wp.media({
									title: "<?php echo esc_js(__( 'Select or Upload your Media', 'forward' )); ?>",
									button: {
										text: "<?php echo esc_js(__( 'Select', 'forward' )); ?>"
									},
									library: { type: 'video,audio' },
									multiple: false
								});
		
								// when image selected, run callback
								dh_<?php echo esc_attr($field['id']); ?>_media_frame.on('select', function(){
									var attachment = dh_<?php echo esc_attr($field['id']); ?>_media_frame.state().get('selection').first().toJSON();
									$this.closest('.dh-meta-box-field').find('input#<?php echo esc_attr($field['id']); ?>').val(attachment.url);
									
									$this.attr('value', '<?php echo esc_js(__( 'Change Media', 'forward' )); ?>');
									$('#<?php echo esc_attr($field['id']); ?>_clear').css('display', 'inline-block');
								});
		
								// open media frame
								dh_<?php echo esc_attr($field['id']); ?>_media_frame.open();
							});
		
							$('#<?php echo esc_attr($field['id']) ?>_clear').on('click', function(event) {
								var $this = $(this);
								$this.hide();
								$('#<?php echo esc_attr($field['id']) ?>_upload').attr('value', '<?php echo esc_js(__( 'Select Media', 'forward' )); ?>');
								$this.closest('.dh-meta-box-field').find('#<?php echo esc_attr($field['id']); ?>').val('');
							});
						});
					</script>
					<?php
				break;
				
				case 'image':
					if(function_exists( 'wp_enqueue_media' )){
						wp_enqueue_media();
					}else{
						wp_enqueue_style('thickbox');
						wp_enqueue_script('media-upload');
						wp_enqueue_script('thickbox');
					}
					$image_id = $field['value'];
					$image = wp_get_attachment_image( $image_id,array(120,120));
					$output = !empty( $image_id ) ? $image : '';
					$btn_text = !empty( $image_id ) ? __( 'Change Image', 'forward' ) : __( 'Select Image', 'forward' );
					echo '<div  class="dh-meta-box-field ' . esc_attr( $field['id'] ) . '_field">';
					echo '<label for="' . esc_attr( $field['id'] ) . '">' . esc_html( $field['label'] ) . '</label>';
					echo '<div class="dh-meta-image-thumb">' . $output . '</div>';
					echo '<input type="hidden" name="' . $field['name'] . '" id="' . $field['id'] . '" value="' . $field['value'] . '" />';
					echo '<input type="button" class="button button-primary" name="' . $field['id'] . '_button_upload" id="' . $field['id'] . '_upload" value="' . $btn_text . '" /> ';
					echo '<input type="button" class="button" name="' . $field['id'] . '_button_clear" id="' . $field['id'] . '_clear" value="' . __( 'Clear Image', 'forward' ) . '" />';
					if ( ! empty( $field['description'] ) ) {
						echo '<span class="description">' . dh_print_string( $field['description'] ) . '</span>';
					}
					?>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							<?php if ( empty ( $field['value'] ) ) : ?> $('#<?php echo esc_attr($field['id']) ?>_clear').css('display', 'none'); <?php endif; ?>
							$('#<?php echo esc_attr($field['id']) ?>_upload').on('click', function(event) {
								event.preventDefault();
								var $this = $(this);
		
								// if media frame exists, reopen
								if(dh_<?php echo esc_attr($field['id']); ?>_image_frame) {
									dh_<?php echo esc_attr($field['id']); ?>_image_frame.open();
					                return;
					            }
		
								// create new media frame
								// I decided to create new frame every time to control the selected images
								var dh_<?php echo esc_attr($field['id']); ?>_image_frame = wp.media.frames.wp_media_frame = wp.media({
									title: "<?php echo esc_js(__( 'Select or Upload your Image', 'forward' )); ?>",
									button: {
										text: "<?php echo esc_js(__( 'Select', 'forward' )); ?>"
									},
									library: { type: 'image' },
									multiple: false
								});
		
								// when open media frame, add the selected image
								dh_<?php echo esc_attr($field['id']); ?>_image_frame.on('open',function() {
									var selected_id = $this.closest('.dh-meta-box-field').find('#<?php echo esc_attr($field['id']); ?>').val();
									if (!selected_id)
										return;
									var selection = dh_<?php echo esc_attr($field['id']); ?>_image_frame.state().get('selection');
									var attachment = wp.media.attachment(selected_id);
									attachment.fetch();
									selection.add( attachment ? [ attachment ] : [] );
								});
		
								// when image selected, run callback
								dh_<?php echo esc_attr($field['id']); ?>_image_frame.on('select', function(){
									var attachment = dh_<?php echo esc_attr($field['id']); ?>_image_frame.state().get('selection').first().toJSON();
									$this.closest('.dh-meta-box-field').find('input#<?php echo esc_attr($field['id']); ?>').val(attachment.id);
									var thumbnail = $this.closest('.dh-meta-box-field').find('.dh-meta-image-thumb');
									thumbnail.html('');
									thumbnail.append('<img src="' + attachment.url + '" alt="" />');
		
									$this.attr('value', '<?php echo esc_js(__( 'Change Image', 'forward' )); ?>');
									$('#<?php echo esc_attr($field['id']); ?>_clear').css('display', 'inline-block');
								});
		
								// open media frame
								dh_<?php echo esc_attr($field['id']); ?>_image_frame.open();
							});
		
							$('#<?php echo esc_attr($field['id']); ?>_clear').on('click', function(event) {
								var $this = $(this);
								$this.hide();
								$('#<?php echo esc_attr($field['id']); ?>_upload').attr('value', '<?php echo esc_js(__( 'Select Image', 'forward' )); ?>');
								$this.closest('.dh-meta-box-field').find('input#<?php echo esc_attr($field['id']); ?>').val('');
								$this.closest('.dh-meta-box-field').find('.dh-meta-image-thumb').html('');
							});
						});
					</script>
								
					<?php
					echo '</div>';
				break;
			}
		}
	}
	
	echo '</div>';
}