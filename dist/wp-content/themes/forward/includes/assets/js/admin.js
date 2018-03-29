;(function($) {
	$(document).ready(function(){
		
		var update_megamenu_fields = function(){			
			var menu_li_items = $( '.menu-item');
			menu_li_items.each( function( i ) 	{
				var megamenu_status = $( '.edit-menu-item-megamenu-status', this );
				if( ! $( this ).is( '.menu-item-depth-0' ) ) {
					var check_against = menu_li_items.filter( ':eq(' + (i-1) + ')' );

					if( check_against.is( '.enable-megamenu' ) ) {
						megamenu_status.attr( 'checked', 'checked' );
						$( this ).addClass( 'enable-megamenu' );
					} else {
						megamenu_status.attr( 'checked', '' );
						$( this ).removeClass( 'enable-megamenu' );
					}
				} else {
					if( megamenu_status.attr( 'checked' ) ) {
						$( this ).addClass( 'enable-megamenu' );
					}
				}
			});
		};
		
		update_megamenu_fields();
		
		//Mega menu
		$( document ).on( 'click', '.edit-menu-item-megamenu-status', function() {
			var parent_li_item = $( this ).parents( '.menu-item:eq( 0 )' );

			if( $( this ).is( ':checked' ) ) {
				parent_li_item.addClass( 'enable-megamenu' );
			} else 	{
				parent_li_item.removeClass( 'enable-megamenu' );
			}
			update_megamenu_fields();
		});
	});
})(jQuery);