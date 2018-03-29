<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


function dhlookbook_enqueue_scripts(){
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts','dhlookbook_enqueue_scripts');

/**
 * Description for product_cat page to aid users.
 *
 * @access public
 * @return void
 */
function  dhlookbook_product_lookbook_description() {
	echo wpautop( __( 'Product lookbooks for your store can be managed here. To change the order of lookbooks on the front-end you can drag and drop to sort them. To see more lookbooks listed click the "screen options" link at the top of the page.', 'forward' ) );
}

add_action( 'product_lookbook_pre_add_form', 'dhlookbook_product_lookbook_description' );

/**
 * Create thumbnail field
 */
function  dhlookbook_add_thumbnail(){
	global $woocommerce;
?>
	<div class="form-field">
		<label><?php _e( 'Small title', 'forward' ); ?></label>
		<input type="text" size="40" value="" id="small_title" name="small_title">
	</div>
	<div class="form-field">
		<label><?php _e( 'Thumbnail', 'forward' ); ?></label>
		<div id="product_lookbook_thumbnail" style="float:left;margin-right:10px;">
			<img src="<?php echo woocommerce_placeholder_img_src(); ?>" width="60px" height="60px" />
		</div>
		<div style="line-height:60px;">
			<input type="hidden" id="product_lookbook_thumbnail_id" name="product_lookbook_thumbnail_id" />
			<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'forward'); ?></button>
			<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'forward'); ?></button>
		</div>
		<script type="text/javascript">
	
			 // Only show the "remove image" button when needed
			 if ( ! jQuery('#product_lookbook_thumbnail_id').val() )
				 jQuery('.remove_image_button').hide();
	
			// Uploading files
			var file_frame;
	
			jQuery(document).on( 'click', '.upload_image_button', function( event ){
	
				event.preventDefault();
	
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}
	
				// Create the media frame.
				file_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php echo esc_js(__( 'Choose an image', 'forward' )); ?>',
					button: {
						text: '<?php echo esc_js(__( 'Use image', 'forward' )); ?>',
					},
					multiple: false
				});
	
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					attachment = file_frame.state().get('selection').first().toJSON();
	
					jQuery('#product_lookbook_thumbnail_id').val( attachment.id );
					jQuery('#product_lookbook_thumbnail img').attr('src', attachment.url );
					jQuery('.remove_image_button').show();
				});
	
				// Finally, open the modal.
				file_frame.open();
			});
	
			jQuery(document).on( 'click', '.remove_image_button', function( event ){
				jQuery('#product_lookbook_thumbnail img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
				jQuery('#product_lookbook_thumbnail_id').val('');
				jQuery('.remove_image_button').hide();
				return false;
			});
	
		</script>
		<div class="clear"></div>
	</div>
	<div class="form-field">
		<label><?php _e( 'Thumbnail Align', 'forward' ); ?></label>
		<select class="postform" name="lookbook_thumbnail_align">
			<option value="left"><?php esc_html_e('Left','forward')?></option>
			<option value="right"><?php esc_html_e('Right','forward')?></option>
		</select>
		<div class="clear"></div>
	</div>
<?php 
}

add_action('product_lookbook_add_form_fields','dhlookbook_add_thumbnail');

function  dhlookbook_edit_lookbook_thumbnail($term, $taxonomy ){
	global $woocommerce;
	$image 			= '';
	$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
	$lookbook_thumbnail_align = get_woocommerce_term_meta($term->term_id,'thumbnail_align',true);
	$small_title = get_woocommerce_term_meta($term->term_id,'small_title',true);
	if ($thumbnail_id) :
		$image = wp_get_attachment_url( $thumbnail_id );
	else :
		$image = woocommerce_placeholder_img_src();
	endif;
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e( 'Small title', 'forward' ); ?></label></th>
		<td><input type="text" size="40" value="<?php echo esc_attr($small_title)?>" id="small_title" name="small_title"></td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Thumbnail', 'forward'); ?></label></th>
		<td>
			<div id="product_lookbook_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo esc_url($image); ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="product_lookbook_thumbnail_id" name="product_lookbook_thumbnail_id" value="<?php echo esc_attr($thumbnail_id); ?>" />
				<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'forward'); ?></button>
				<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'forward'); ?></button>
			</div>
			<script type="text/javascript">

				jQuery(function(){

					 // Only show the "remove image" button when needed
					 if ( ! jQuery('#product_lookbook_thumbnail_id').val() )
						 jQuery('.remove_image_button').hide();

					// Uploading files
					var file_frame;

					jQuery(document).on( 'click', '.upload_image_button', function( event ){

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php echo esc_js(__( 'Choose an image', 'forward' )); ?>',
							button: {
								text: '<?php echo esc_js(__( 'Use image', 'forward' )); ?>',
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							attachment = file_frame.state().get('selection').first().toJSON();

							jQuery('#product_lookbook_thumbnail_id').val( attachment.id );
							jQuery('#product_lookbook_thumbnail img').attr('src', attachment.url );
							jQuery('.remove_image_button').show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery(document).on( 'click', '.remove_image_button', function( event ){
						jQuery('#product_lookbook_thumbnail img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
						jQuery('#product_lookbook_thumbnail_id').val('');
						jQuery('.remove_image_button').hide();
						return false;
					});
				});

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php _e('Thumbnail Align', 'forward'); ?></label></th>
		<td>
			<select class="postform" name="lookbook_thumbnail_align">
				<option value="left" <?php selected($lookbook_thumbnail_align,'left')?>><?php esc_html_e('Left','forward')?></option>
				<option value="right" <?php selected($lookbook_thumbnail_align,'right')?>><?php esc_html_e('Right','forward')?></option>
			</select>
		</td>
	</tr>
<?php 
}
add_action('product_lookbook_edit_form_fields','dhlookbook_edit_lookbook_thumbnail',10,3);

/**
 *  dhlookbook_lookbook_thumbnail_save function.
 *
 * @access public
 * @param mixed $term_id Term ID being saved
 * @param mixed $tt_id
 * @param mixed $taxonomy Taxonomy of the term being saved
 * @return void
 */
function  dhlookbook_lookbook_thumbnail_save( $term_id, $tt_id, $taxonomy ) {
	if ( isset( $_POST['product_lookbook_thumbnail_id'] ) )
		update_woocommerce_term_meta( $term_id, 'thumbnail_id', absint( $_POST['product_lookbook_thumbnail_id'] ) );
	
	if ( isset( $_POST['lookbook_thumbnail_align'] ) )
		update_woocommerce_term_meta( $term_id, 'thumbnail_align', sanitize_title( $_POST['lookbook_thumbnail_align'] ) );
	if ( isset( $_POST['small_title'] ) )
		update_woocommerce_term_meta( $term_id, 'small_title', $_POST['small_title'] );

}

add_action( 'created_term', 'dhlookbook_lookbook_thumbnail_save', 10,3 );
add_action( 'edit_term', 'dhlookbook_lookbook_thumbnail_save', 10,3 );

/**
 * Thumbnail column added to lookbook admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function  dhlookbook_product_lookbook_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumb'] = __( 'Image', 'forward' );

	unset( $columns['cb'] );

	return array_merge( $new_columns, $columns );
}

add_filter( 'manage_edit-product_lookbook_columns', 'dhlookbook_product_lookbook_columns' );

/**
 * Thumbnail column value added to lookbook admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function  dhlookbook_product_lookbook_column( $columns, $column, $id ) {
	global $woocommerce;
	if ( $column == 'thumb' ) {
		$image 			= '';
		$thumbnail_id 	= get_woocommerce_term_meta( $id, 'thumbnail_id', true );

		if ($thumbnail_id)
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		else
			$image = woocommerce_placeholder_img_src();

		$columns .= '<img src="' . $image . '" alt="Thumbnail" class="wp-post-image" height="48" width="48" />';

	}

	return $columns;
}

add_filter( 'manage_product_lookbook_custom_column', 'dhlookbook_product_lookbook_column', 10, 3 );

/**
 * sort_lookbooks function.
 */
function  dhlookbook_product_lookbook_sortable($sortable ){
	$sortable[] = 'product_lookbook';
	return $sortable;
}

add_filter( 'woocommerce_sortable_taxonomies','dhlookbook_product_lookbook_sortable');

/**
 *  dhlookbook_permalink_settings_add function
 */
function  dhlookbook_permalink_settings_add(){
	add_settings_field(
		'dhlookbook_product_lookbook_slug',      		// id
		__( 'Product lookbook base', 'forward' ), 	// setting title
		'dhlookbook_product_lookbook_slug_input',  		// display callback
		'permalink',                 				// settings page
		'optional'                  				// settings section
	);
}

add_action( 'admin_init', 'dhlookbook_permalink_settings_add' );

/**
 *  dhlookbook_permalink_settings_save function
 */
function dhlookbook_permalink_settings_save(){
	if (is_admin()){
		if (isset($_POST['dhlookbook_product_lookbook_slug'])){
			
			$dhlookbook_product_lookbook_slug = woocommerce_clean( $_POST['dhlookbook_product_lookbook_slug'] );
			
			$permalinks = get_option( 'woocommerce_permalinks' );
			if ( ! $permalinks )
				$permalinks = array();
			
			$permalinks['lookbook_base'] 	= untrailingslashit( $dhlookbook_product_lookbook_slug );
			
			update_option( 'woocommerce_permalinks', $permalinks );
		}
	}
	return;
}

add_action( 'before_woocommerce_init', 'dhlookbook_permalink_settings_save' );

/**
 *  dhlookbook_product_lookbook_slug_input function
 */
function  dhlookbook_product_lookbook_slug_input(){
	$permalinks = get_option( 'woocommerce_permalinks' );
	?>
	<input name="dhlookbook_product_lookbook_slug" type="text" class="regular-text code" value="<?php if ( isset( $permalinks['lookbook_base'] ) ) echo esc_attr( $permalinks['lookbook_base'] ); ?>" placeholder="<?php echo _x('product-lookbook', 'slug', 'forward') ?>" />
	<?php
}



