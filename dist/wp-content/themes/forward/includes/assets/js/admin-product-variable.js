jQuery( function( $ ) {
	var dh_product_variable = {
		load_variable_gallery: function(){
			var wrapper = $( '#variable_product_options' ).find( '.woocommerce_variations' );
			$.ajax({
				url: woocommerce_admin_meta_boxes_variations.ajax_url,
				data: {
					action:     'dh_load_variable_gallery',
					security:   woocommerce_admin_meta_boxes_variations.load_variations_nonce,
					product_id: woocommerce_admin_meta_boxes_variations.post_id,
					page:       wrapper.attr('data-page'),
					per_page:   woocommerce_admin_meta_boxes_variations.variations_per_page
				},
				type: 'POST',
				success: function( response ) {
					response = $('<div>' + response + '</div>');
					wrapper.find('.upload_image_button').each(function(){
						var _btn = $(this);
						var _variable_post_id = _btn.attr('rel');
						if(!_btn.parent().find('.dh-meta-gallery-wrap').length){
							_btn.after(response.find('#dh-product-variable-' + _variable_post_id).html());
						}
						setTimeout(function(){
							_btn.parent().on( 'click', '.dh-product-variable-gallery-select', dh_product_variable.add_gallery );
						}, 10);
						
					});
					dh_product_variable.init_gallery();
				}
			});
		},
		init_gallery: function(){
			if($('.dh-meta-gallery-list').length){
				$('.dh-meta-gallery-list').each(function(){
					var $this = $(this),
						dh_meta_gallery_ids = $this.parent().find('.dh_product_variable_gallery_ids'),
						_ids = dh_meta_gallery_ids.val();
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
				
							dh_meta_gallery_ids.val( dh_product_variable.trim(_ids,',') );
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
						dh_meta_gallery_ids.val( dh_product_variable.trim(_ids,',') );

						return false;
					});
					
				});
			}
		},
		add_gallery: function(e){
			e.stopPropagation();
			e.preventDefault();
			
			var self = this,
				$this = $(this),
				dh_meta_gallery_list = $this.parent().find('.dh-meta-gallery-list'),
				dh_product_variable_gallery,
				dh_meta_gallery_ids = $this.parent().find('.dh_product_variable_gallery_ids'),
				_ids = dh_meta_gallery_ids.val();

			if(dh_product_variable_gallery){
				dh_product_variable_gallery.open();
				return false;
			}
			
			dh_product_variable_gallery = wp.media({
				title: dhWooCommerceProductVariableL10n.upload_title,
				button: {
					text: dhWooCommerceProductVariableL10n.upload_button,
				},
				library: { type: 'image' },
				multiple: true
			});

			dh_product_variable_gallery.on('select',function(){
				var selection = dh_product_variable_gallery.state().get('selection');
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
									<a href="#" title="Delete">x</a></li>\
								</div>\
							</li>'
						);
					}
					dh_meta_gallery_ids.val( dh_product_variable.trim(_ids,',') );
					dh_product_variable.init_gallery();
				});
			});

			dh_product_variable_gallery.open();
		},
		trim: function(str, charlist) {
			  var whitespace, l = 0,
			    i = 0;
			  str += '';

			  if (!charlist) {
			    // default list
			    whitespace =
			      ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
			  } else {
			    // preg_quote custom list
			    charlist += '';
			    whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
			  }

			  l = str.length;
			  for (i = 0; i < l; i++) {
			    if (whitespace.indexOf(str.charAt(i)) === -1) {
			      str = str.substring(i);
			      break;
			    }
			  }

			  l = str.length;
			  for (i = l - 1; i >= 0; i--) {
			    if (whitespace.indexOf(str.charAt(i)) === -1) {
			      str = str.substring(0, i + 1);
			      break;
			    }
			  }

			  return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
			}
	}
	$( '#woocommerce-product-data' ).on( 'woocommerce_variations_loaded', function(){		
		dh_product_variable.load_variable_gallery();
	});	
	$('#variable_product_options').on('woocommerce_variations_added', function(){
		dh_product_variable.load_variable_gallery();
	});	
});