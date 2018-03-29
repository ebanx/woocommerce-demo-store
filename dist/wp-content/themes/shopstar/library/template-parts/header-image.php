<div class="header-image loading <?php echo ( get_theme_mod( 'shopstar-slider-text-shadow', customizer_library_get_default( 'shopstar-slider-text-shadow' ) ) ) ? 'text-shadow' : ''; ?>">
	<?php 
	if ( is_random_header_image() && $header_url = get_header_image() ) {
		// For a random header search for a match against all headers.
		foreach ( get_uploaded_header_images() as $header ) {
			if ( $header['url'] == $header_url ) {
				$attachment_id = $header['attachment_id'];
				break;
			}
		}

	} elseif ( $data = get_custom_header() ) {
		// For static headers
		$attachment_id = $data->attachment_id;
    } 

	$alt_text = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
	?>
	
	<img src="<?php esc_url( header_image() ); ?>" alt="<?php echo $alt_text; ?>" height="<?php echo get_custom_header()->height ?>" width="<?php echo get_custom_header()->width ?>" />
	
	<?php
	if ( get_theme_mod( 'shopstar-header-image-text', customizer_library_get_default( 'shopstar-header-image-text' ) ) != "" ) {
	?>
	<div class="overlay">
		<?php echo wp_kses_post( get_theme_mod( 'shopstar-header-image-text', customizer_library_get_default( 'shopstar-header-image-text' ) ) ); ?>
	</div>	
	<?php 
	}
	?>
	
</div>