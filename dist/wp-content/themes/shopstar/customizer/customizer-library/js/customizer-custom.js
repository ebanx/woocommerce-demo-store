/**
 * Shopstar Customizer Custom Functionality
 *
 */
( function( $ ) {
	
    $( window ).load( function() {
    	// Show / Hide slider options
        var sliderType = $( '#customize-control-shopstar-slider-type select' ).val();
        shopstar_toggle_slider_options( sliderType );
        
        $( '#customize-control-shopstar-slider-type select' ).on( 'change', function() {
        	sliderType = $( this ).val();
        	shopstar_toggle_slider_options( sliderType );
        } );
        
        function shopstar_toggle_slider_options( sliderType ) {
            if ( sliderType == 'shopstar-slider-default' ) {
                $( '#customize-control-shopstar-slider-categories' ).show();
                $( '#customize-control-shopstar-slider-has-min-width' ).show();
                $( '#customize-control-shopstar-slider-min-width' ).show();
                $( '#customize-control-shopstar-slider-transition-speed' ).show();
                $( '#customize-control-shopstar-slider-transition-effect' ).show();
                $( '#customize-control-shopstar-slider-autoscroll' ).show();
                $( '#customize-control-shopstar-slider-speed' ).show();
                $( '#customize-control-shopstar-slider-plugin-shortcode' ).hide();
                
            } else if ( sliderType == 'shopstar-slider-plugin' ) {
                $( '#customize-control-shopstar-slider-categories' ).hide();
                $( '#customize-control-shopstar-slider-has-min-width' ).hide();
                $( '#customize-control-shopstar-slider-min-width' ).hide();
                $( '#customize-control-shopstar-slider-transition-speed' ).hide();
                $( '#customize-control-shopstar-slider-transition-effect' ).hide();
                $( '#customize-control-shopstar-slider-autoscroll' ).hide();
                $( '#customize-control-shopstar-slider-speed' ).hide();
                $( '#customize-control-shopstar-slider-plugin-shortcode' ).show();
                
            } else {
                $( '#customize-control-shopstar-slider-categories' ).hide();
                $( '#customize-control-shopstar-slider-has-min-width' ).hide();
                $( '#customize-control-shopstar-slider-min-width' ).hide();
                $( '#customize-control-shopstar-slider-transition-speed' ).hide();
                $( '#customize-control-shopstar-slider-transition-effect' ).hide();
                $( '#customize-control-shopstar-slider-autoscroll' ).hide();
                $( '#customize-control-shopstar-slider-speed' ).hide();
                $( '#customize-control-shopstar-slider-plugin-shortcode' ).hide();
                
            }
        }
        
        // Show / Hide slider min width
        shopstar_toggle_slider_min_width();
    	
        $( '#customize-control-shopstar-slider-has-min-width input' ).on( 'change', function() {
        	shopstar_toggle_slider_min_width();
        } );
        
        function shopstar_toggle_slider_min_width() {
        	if ( $( '#customize-control-shopstar-slider-has-min-width input' ).prop('checked') && $( '#customize-control-shopstar-slider-has-min-width input' ).is(':visible') ) {
        		$( '#customize-control-shopstar-slider-min-width' ).show();
        	} else {
        		$( '#customize-control-shopstar-slider-min-width' ).hide();
        	}
        }
        
    	// Show / Hide blog options
        var blogArchiveLayout = $( '#customize-control-shopstar-blog-archive-layout select' ).val();
        shopstar_toggle_blog_options( blogArchiveLayout );
        
        $( '#customize-control-shopstar-blog-archive-layout select' ).on( 'change', function() {
        	blogArchiveLayout = $( this ).val();
        	shopstar_toggle_blog_options( blogArchiveLayout );
        } );
        
        function shopstar_toggle_blog_options( blogArchiveLayout ) {
            if ( blogArchiveLayout == 'shopstar-blog-archive-layout-full' ) {
                $( '#customize-control-shopstar-blog-excerpt-length' ).hide();
                $( '#customize-control-shopstar-blog-read-more-text' ).hide();
                
            } else if ( blogArchiveLayout == 'shopstar-blog-archive-layout-excerpt' ) {
                $( '#customize-control-shopstar-blog-excerpt-length' ).show();
                $( '#customize-control-shopstar-blog-read-more-text' ).show();
                
            }
        }        
        
    } );
    
} )( jQuery );