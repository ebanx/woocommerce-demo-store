;( function( $, window, undefined ) {
	"use strict";
	
	$( document ).ready( function() {
		// Load Font Previews
		$( '.typolab-fonts-list .font-preview-iframe' ).each( function( i, el ) {
			var $this = $( el ),
				$iframe = $this.find( 'iframe' );
			
			$iframe.on( 'load', function() {
				var $body = $( this.contentWindow.document ),
					$previewLine = $body.find( '.single-entry' ),
					lineHeight = $previewLine.outerHeight();
				
				$this.css( {
					lineHeight: lineHeight + 'px',
					height: lineHeight
				} );
				
				$previewLine.find( 'p' ).width( $this.width() );
				
				$this.addClass( 'loaded' );
			} )
		} );
		
		// Font List Selector
		$( '.fonts-list-select' ).each( function( i, el ) {
			var $el = $( el ),
				
				$alphabet = $el.find( '.alphabet a' ),
				$search = $el.find( '.search-bar input' ),
				$fontCategory = $el.find( '.search-bar select' ),
				$fontList = $el.find( '.font-list' ),
				$fontListData = $el.find( '.font-list-data' ),
				
				$noSearchResults = $( '<div class="no-records">Nothing found!</div>' ),
			
				checked = '<span class="checked"><i class="fa fa-check"></i></span>',
				source = $el.data( 'font-source' ),
				currentLetter = $alphabet.filter( '.current' ).data( 'letter' ),
				currentFont = $el.data( 'currentFont' ),
				currentFontVariants = $el.data( 'currentFontVariants' ),
				currentFontSubsets = $el.data( 'currentFontSubsets' );
			
			// Set Current Font Letter
			var setCurrentLetter = function( letter ) {
				$alphabet.removeClass( 'current' );
				$alphabet.filter( '[data-letter="' + letter + '"]' ).addClass( 'current' );
				
				$search.val( '' );
				
				var categoryChecked = $fontCategory.length && $fontCategory.val().length ? true : false;
				
				$fonts.removeClass( 'search-match search-unmatch letter-unmatch' ).filter( '.active' ).removeClass( 'active' );

				$fonts.filter( function( k, font ) {
					var $font = $( font );
					
					if ( letter == $( font ).data( 'letter' ) ) {
						$font.addClass( 'active' );
					} else if ( categoryChecked ) {
						$font.addClass( 'letter-unmatch' );
					}
					
					return font;
				} );
				
				$fontList.scrollTop( 0 );
				currentLetter = letter;
			};
			
			// Set Available Letters
			var setAvailableLetters = function( letters ) {
				$alphabet.addClass( 'letter-unmatch' ).each( function( j, letter ) {
					if ( letters[ letter.textContent ] ) {
						$( letter ).removeClass( 'letter-unmatch' ).addClass( 'letter-match' );
					}
				} );
			}
				
			// Add font to the list
			var addFont = function( font, selected ) {
				var $font = $( '<a href="#"></a>' );
				
				// Google Fonts Add
				if ( 'google-fonts' == source ) {
					var family = font.family,
						letter = family.substring( 0, 1 ).toUpperCase();
					
					$font.html( checked + family ).data( {
						letter    : letter,
						category  : font.category
					} ).on( 'click', function( ev, variants, subsets ) {
						ev.preventDefault();
						$fontList.find( 'a' ).removeClass( 'current' );
						$font.addClass( 'current' );

						setGoogleFont( font, variants, subsets );
					} );
					
					if ( currentLetter == letter ) {
						$font.addClass( 'active' );
					}
					
					if ( selected ) {
						setTimeout( function() {
							scrollFocus = false;
							$font.trigger( 'click', [ currentFontVariants, currentFontSubsets ] );
						}, 1 );
					}
					
					$font.appendTo( $fontList );
				}
				// Font Squirrel Add
				else if ( 'font-squirrel' == source ) {
					var family = font.family_name,
						letter = family.substring( 0, 1 ).toUpperCase();
					
					$font.html( checked + family ).data( {
						letter    : letter,
						category  : font.classification
					} ).on( 'click', function( ev, variants, subsets ) {
						ev.preventDefault();
						$fontList.find( 'a' ).removeClass( 'current' );
						$font.addClass( 'current' );

						setFontSquirrel( font, variants, subsets );
					} );
					
					if ( currentLetter == letter ) {
						$font.addClass( 'active' );
					}
					
					if ( selected ) {
						setTimeout( function() {
							scrollFocus = false;
							$font.trigger( 'click', [ currentFontVariants, currentFontSubsets ] );
						}, 1 );
					}
					
					$font.appendTo( $fontList );
				}
				// Premium Fonts Add
				else if ( 'premium-fonts' == source ) {
					var family = font.family,
						letter = family.substring( 0, 1 ).toUpperCase();
					
					$font.html( checked + family ).data( {
						letter    : letter,
						category  : font.category
					} ).on( 'click', function( ev, variants, subsets ) {
						ev.preventDefault();
						$fontList.find( 'a' ).removeClass( 'current' );
						$font.addClass( 'current' );

						setPremiumFont( font, variants, subsets );
					} );
					
					if ( currentLetter == letter ) {
						$font.addClass( 'active' );
					}
					
					if ( selected ) {
						setTimeout( function() {
							scrollFocus = false;
							$font.trigger( 'click', [ currentFontVariants, currentFontSubsets ] );
						}, 1 );
					}
					
					$font.appendTo( $fontList );
				}
			};
			
			// Add Fonts List
			var fontList = JSON.parse( $fontListData.html() );
			
			$.each( fontList, function( j, font ) {
				var fontFamily = font.family ? font.family : font.family_name;
				
				addFont( font, currentFont == fontFamily );
			} );
		
			// Fonts are loaded
			$el.find( '.loading-fonts' ).remove();
			
			// Set Current Letter Event
			$alphabet.on( 'click', function( ev ) {
				ev.preventDefault();
				setCurrentLetter( $( this ).data( 'letter' ) );
			} );
			
			// No Search Results Div
			$fontList.append( $noSearchResults );
		
			// Search Functionality
			var $fonts = $fontList.find( 'a' );
			
			$search.on( 'keyup', function( ev ) {
				var search = $( this ).val(),
					results = 0;
				
				if ( search.length == 0 ) {
					$fonts.removeClass( 'search-match search-unmatch' );
					$noSearchResults.removeClass( 'active' );
					return;
				}
				
				$fonts.each( function( j, font ) {
					var $font = $( font ),
						family = $font.text();
					
					if ( 
						family.match( new RegExp( '^' + escapeRegExp( search ) + '', 'i' ) ) || 
						family.match( new RegExp( ' ' + escapeRegExp( search ) + '', 'i' ) ) ||
						family.match( new RegExp( escapeRegExp( search ) + '$', 'i' ) ) 
					) {
						$font.addClass( 'search-match' ).removeClass( 'search-unmatch' );
						results++;
					} else {
						$font.removeClass( 'search-match' ).addClass( 'search-unmatch' );
					}
				} );
				
				$noSearchResults[ results > 0 ? 'removeClass' : 'addClass' ]( 'active' );
			} ).on( 'blur', function() {
				if ( $( this ).val().length == 0 ) {
					$fonts.removeClass( 'search-match search-unmatch' );
				}
			} );
			
			$fontCategory.on( 'change', function() {
				var category = $fontCategory.val();
				
				$alphabet.removeClass( 'letter-match letter-unmatch current' );
				$fonts.removeClass( 'category-match category-unmatch letter-unmatch active' );
				
				if ( category ) {
					var availableLetters = {};
					
					$fonts.filter( function( j, font ) {
						var $font = $( font );
						
						if ( category == $font.data( 'category' ) ) {
							var letter = $font.text().substring( 0, 1 ).toUpperCase();
							
							if ( ! availableLetters[ letter ] ) {
								availableLetters[ letter ] = {
									letter : letter,
									count : 1
								};
							} else {
								availableLetters[ letter ].count++;
							}
							
							$font.addClass( 'category-match' );
						} else {
							$font.addClass( 'category-unmatch' );
						}
					} );
					
					setAvailableLetters( availableLetters );
				}
				else if ( currentLetter ) {
					setCurrentLetter( currentLetter );
				}
				
			} );
		} );
		
		// Tooltips
		$( '#typolab-wrapper .tooltip' ).each( function( i, el ) {
			$( el ).tooltipster( {
				theme : 'tooltipster-borderless'
			} );
		} );
		
		// Global Variables
		var currentSelectedFont   = '',
			scrollFocus           = true,
			adjustHeightInterval  = 0,
			
			$preview     = $( '.font-preview-container' ),
			$fontFamily  = $( '#edit-font-form input[name="font_family"]' ),
			$fontData    = $( '#edit-font-form textarea[name="font_data"]' );
		
		// Add Font Options Block
		var addFontOptionsBlock = function( id, title, content, containerClass ) {
			var $previewRow = $( '<div class="font-preview-row"></div>' ),
				$rowBg = $( '<div class="font-preview-row-bg"></div>' );
				
			$preview.append( $previewRow.clone().attr( 'id', id ).addClass( containerClass ? containerClass : '' ).append( '<span class="row-title">' + title + '</span>' ).append( content ).wrapInner( $rowBg ) );
		}
		
		// Translate Font Category Name
		var translateFontCategoryName = function( category ) {
			switch ( category ) {
				case 'display':
					return 'Display';
					break;
					
				case 'handwriting':
					return 'Handwriting';
					break;
					
				case 'monospace':
					return 'Monospace';
					break;
					
				case 'sans-serif':
					return 'Sans Serif';
					break;
					
				case 'serif':
					return 'Serif';
					break;
			}
			
			return category;
		}
		
		// Translate Font Subset Name
		var translateFontSubsetName = function( subset ) {
			switch ( subset ) {
				case 'latin':
					return 'Latin';
					break;
					
				case 'latin-ext':
					return 'Latin Extended';
					break;
					
				case 'cyrillic':
					return 'Cyrillic';
					break;
					
				case 'greek':
					return 'Greek';
					break;
					
				case 'vietnamese':
					return 'Vietnamese';
					break;
					
				case 'cyrillic-ext':
					return 'Cyrillic Extended';
					break;
					
				case 'greek-ext':
					return 'Greek Extended';
					break;
			}
			
			return subset;
		}
		
		// Google Font Handler
		var setGoogleFont = function( font, variants, subsets ) {
			if ( currentSelectedFont == font.family ) {
				return false;
			}
			
			currentSelectedFont = font.family;
			window.clearInterval( adjustHeightInterval );
			
			// Clear preview box
			$preview.html( '' );
			
			// Font Family
			addFontOptionsBlock( 'font-family-name', 'Font Family:', '<p class="font-family-name">' + font.family + '</p>' );
			
			// Preview Iframe
			var $iframe = $( '<iframe></iframe>' ),
				$iframeLoader = $( '<p class="description">Loading font preview...</p>' ),
				previewFontUrl = ajaxurl + '?action=typolab-preview-google-fonts&font-family=' + encodeURIComponent( font.family );
			
			$iframe.attr( {
				src : previewFontUrl
			} ).on( 'load', function() {
				var $body = $( this.contentWindow.document );
				
				// Preview Frame Adjust Height
				$iframeLoader.remove();
				$iframe.height( $body.height() );
				
				adjustHeightInterval = setInterval( function() {
					$iframe.height( $body.height() );
				}, 50 );
				
				if ( scrollFocus ) {
					$( 'html, body' ).animate( {
						scrollTop: $preview.offset().top - 50
					} );
				}
				
				scrollFocus = true;
				
				$iframe.after( '<p class="font-details-link"><a href="https://fonts.google.com/specimen/' + encodeURIComponent( font.family ) + '" target="_blank">Font Details</a> <span class="sep"></span> Category: ' + translateFontCategoryName( font.category ) + '</p>' );
				
				// Fill font family and data
				$fontFamily.val( font.family );
				$fontData.val( JSON.stringify( font ) );
				
				// Font Variants
				var $fontVariants = $( '<div class="checkboxes-container"></div>' ),
					defaultFontVariants = variants ? variants.split( ',' ) : [ 'regular' ];
				
				for ( var i in font.variants ) {
					var variant = font.variants[ i ],
						$variant = $( '<label></label>' ),
						$checkbox = $( '<input type="checkbox" name="font_variants[]" value="' + variant + '" ' + ( $.inArray( variant, defaultFontVariants ) != -1 ? 'checked' : '' ) + '>' );
					
					$checkbox.on( 'change', createOrUpdateFontVariantsForCSSSelectors );
					
					$variant.append( $checkbox );
					$variant.append( '<span>' + ( variant.indexOf( 'italic' ) > 0 ? variant.replace( 'italic', ', italic' ) : variant ) + '</span>' ).appendTo( $fontVariants );
				}
				
				addFontOptionsBlock( 'font-preview-variants', 'Font Variants', $fontVariants, 'half' );
				// End of: Font Variants
				
				
				// Font Subsets
				var $fontSubsets = $( '<div class="checkboxes-container"></div>' ),
					defaultFontSubsets = subsets ? subsets.split( ',' ) : [ 'latin' ];
				
				for ( var i in font.subsets ) {
					var subset = font.subsets[ i ],
						$subset = $( '<label></label>' );
						
					$subset.append( '<input type="checkbox" name="font_subsets[]" value="' + subset + '" ' + ( $.inArray( subset, defaultFontSubsets ) != -1 ? 'checked' : '' ) + '>' );
					$subset.append( '<span>' + translateFontSubsetName( subset ) + '</span>' ).appendTo( $fontSubsets );
				}
				
				addFontOptionsBlock( 'font-preview-subsets', 'Font Subsets', $fontSubsets, 'half' );
				// End of: Font Subsets
				
				// Make Font Subsets and Variants Same Height
				var fontVariantsSubsetsHeight = Math.max( $fontVariants.outerHeight(), $fontSubsets.outerHeight() );
				
				$fontVariants.add( $fontSubsets ).css( {
					minHeight: fontVariantsSubsetsHeight
				} );
				
				// Font Preview Height
				$( '.fonts-list-select .font-list' ).css( {
					maxHeight: Math.max( $( '.font-preview-container' ).outerHeight() - 95, 450 )
				} );
				
				// Register Font Variants for CSS Selectors
				createOrUpdateFontVariantsForCSSSelectors();
			} );
			
			addFontOptionsBlock( 'font-preview-iframe', 'Live Preview', [ $iframeLoader, $iframe ] );
			
			return true;
		}
		
		// Font Squirrel Handler
		var setFontSquirrel = function( font, variants, subsets ) {
			var fontSquirrelData = JSON.parse( $( '.font-squirrel-data' ).html() ),
				fontIsDownloaded = fontSquirrelData.downloadedFonts[ font.family_urlname ];
			
			if ( currentSelectedFont == font.family_name ) {
				return false;
			}
			
			currentSelectedFont = font.family_name;
			window.clearInterval( adjustHeightInterval );
			
			// Clear preview box
			$preview.html( '' );
			
			// Set Font Family Name
			addFontOptionsBlock( 'font-family-name', 'Font Family:', '<p class="font-family-name">' + font.family_name + '</p>' );
			
			// Fill font family and data
			$fontFamily.val( font.family_name );
			
			// Get Font Info
			$.getJSON( 'http://www.fontsquirrel.com/api/familyinfo/' + font.family_urlname, function( fontVariants ) {
				// Font Variants Checboxes
				var $fontVariants = $( '<div class="checkboxes-container"></div>' ),
					selectedVariants = variants ? variants.split( ',' ) : [],
					defaultFontVariants = [ 'Regular' ];
				
				$.each( fontVariants, function( i, fontVariant ) {
					var variant = fontVariant.style_name,
						$checkbox = $( '<input type="checkbox" name="font_variants[]" value="' + fontVariant.fontface_name + '" ' + ( $.inArray( fontVariant.fontface_name, selectedVariants ) != -1 ? 'checked' : '' ) + '>' ),
						$variant = $( '<label></label>' );
					
					if ( ! selectedVariants.length && $.inArray( fontVariant.style_name, defaultFontVariants ) != -1 ) {
						$checkbox.prop( 'checked', true );
					}
					
					$checkbox.on( 'change', createOrUpdateFontVariantsForCSSSelectors );
					
					$variant.append( $checkbox );
					$variant.append( '<span title="' + fontVariant.fontface_name + '">' + fontVariant.style_name + '</span>' ).appendTo( $fontVariants );
				} );
				
				// Fill font family and data
				$fontData.val( JSON.stringify( fontVariants ) );
				
				// Font is downloaded, use it
				if ( fontIsDownloaded ) {
					// Preview Iframe
					var $iframe = $( '<iframe></iframe>' ),
						$iframeLoader = $( '<p class="description">Loading font preview...</p>' ),
						previewFontUrl = ajaxurl + '?action=typolab-preview-font-squirrel&font-family=' + encodeURIComponent( font.family_urlname );

					$iframe.attr( {
						src : previewFontUrl
					} ).on( 'load', function() {
						var $body = $( this.contentWindow.document );
						
						// Preview Frame Adjust Height
						$iframeLoader.remove();
						$iframe.height( $body.height() );
						
						adjustHeightInterval = setInterval( function() {
							$iframe.height( $body.height() );
						}, 100 );
						
						if ( scrollFocus ) {
							$( 'html, body' ).animate( {
								scrollTop: $preview.offset().top - 50
							} );
						}
						
						scrollFocus = true;
						
						var $reDownloadFont = $( '<a href="#" class="font-redownload" title="Re-download font"><i class="fa fa-refresh"></i></a>' );
						
						$iframe.after( '<p class="font-details-link"><a href="https://www.fontsquirrel.com/fonts/' + encodeURIComponent( font.family_urlname ) + '" target="_blank">Font Details</a> <span class="sep"></span> Category: ' + font.classification + '</p>' );
						$iframe.next().append( $reDownloadFont );
						
						$reDownloadFont.on( 'click', function( ev ) {
							ev.preventDefault();
							
							if ( $reDownloadFont.hasClass( 'is-downloaded' ) ) {
								return false;
							}
							
							if ( confirm( 'Confirm font re-download?' ) ) {
								$reDownloadFont.addClass( 'fa-spin' ).attr( 'title', 'Downloading font...' );
								
								// Re-download Font
								downloadFontPackage( 'font-squirrel', font.family_urlname, function( response ) {
									$reDownloadFont.removeClass( 'fa-spin' );
						
									// Show errors
									if ( response.errors ) {
										var errors = '';
										
										for ( var i in response.error_msg ) {
											errors += "\n" + response.error_msg[ i ];
										}
										
										alert( errors.trim() );
									}
									// Font download was successful
									else {
										$reDownloadFont.addClass( 'is-downloaded' ).html( '<i class="fa fa-check"></i>' ).attr( 'title', 'Font has been downloaded successfully!' );
									}
								} );
							}
						} );
						

						// Font Variants
						addFontOptionsBlock( 'font-preview-variants', 'Font Variants', $fontVariants );
						// End of: Font Variants
						
						// Register Font Variants for CSS Selectors
						createOrUpdateFontVariantsForCSSSelectors();
						
					} );
					
					addFontOptionsBlock( 'font-preview-iframe', 'Live Preview', [ $iframeLoader, $iframe ] );
					
					// Enable Save Changes Button
					fontEditEnableSaveChanges();
					
					return true;
				}
				
				// Font Preview
				var $fontSquirrelPreviewer = $( '<div class="external-font-previews"></div>' ),
					$fontSquirrelLoading = $( '<p class="description">Loading font preview...</p>' );
				
				addFontOptionsBlock( 'font-preview-iframe', 'Preview', [ $fontSquirrelLoading, $fontSquirrelPreviewer ] );
				
				if ( scrollFocus ) {
					$( 'html, body' ).animate( {
						scrollTop: $preview.offset().top - 50
					} );
				}
				
				scrollFocus = true;
				
				// Generate Font Previews (Online)
				var $previews = generateFontSquirrelPreviews( fontVariants );
				
				$fontSquirrelLoading.remove();
				$fontSquirrelPreviewer.append( $previews );
				
				$fontSquirrelPreviewer.after( '<p class="font-details-link"><a href="https://www.fontsquirrel.com/fonts/' + encodeURIComponent( font.family_urlname ) + '" target="_blank">Font Details</a> <span class="sep"></span> Category: ' + font.classification + '</p>' );
				
				// Font Variants
				addFontOptionsBlock( 'font-preview-variants', 'Font Variants', $fontVariants );
				// End of: Font Variants
						
				// Register Font Variants for CSS Selectors
				createOrUpdateFontVariantsForCSSSelectors();
				
				// Download Font if not downloaded
				var fontDownloader = '<p>You need to download and install this font in order to use it in this site.<br>';
				fontDownloader += 'Installation process is automatic, simply click the button below:</p>';
				
				var $download = $( '<a href="#install-font-package" class="button-primary download-font">Download &amp; Install Font</a>' );
				
				addFontOptionsBlock( 'font-squirrel-downloader', 'Install Font', [ fontDownloader, $( '<p class="hover">' ).append( $download ) ], 'font-downloader' );
				
				// Download Font From Font Squirrel
				$download.on( 'click', function( ev ) {
					ev.preventDefault();
								
					if ( $download.hasClass( 'disabled' ) ) {
						return false;
					}
					
					$download.addClass( 'disabled' ).html( 'Installing font...' );
					
					// Start font download...
					downloadFontPackage( 'font-squirrel', font.family_urlname, function( response ) {
						var $fsDownloadBlock = $( '#font-squirrel-downloader .font-preview-row-bg' );
						
						$download.removeClass( 'disabled' ).html( 'Download &amp; Install Font' );
						$fsDownloadBlock.find( '.notice-error' ).remove();
			
						// Show errors
						if ( response.errors ) {
							$fsDownloadBlock.append( '<div class="notice notice-error"></div>' );
							
							for ( var i in response.error_msg ) {
								$fsDownloadBlock.find( '.notice-error' ).append( '<p>' + response.error_msg[ i ] + '</p>' );
							}
						}
						// Font download was successful
						else {
							$fsDownloadBlock.find( 'p, .download-font' ).remove();
							$fsDownloadBlock.append( '<p class="font-installed"><i class="fa fa-check"></i> Font has been installed successfully.</p>' );
						}
					} );
				} );
				// End of: Download Font if not downloaded
				
				// Disable Save Changes Button
				fontEditDisableSaveChanges( 'Font is not installed' );
			} );
			
			return true;
		}
		
		// Premium Font Handler
		var setPremiumFont = function( font, variants, subsets ) {
			var premiumFontData = JSON.parse( $( '.premium-font-data' ).html() ),
				fontIsDownloaded = premiumFontData.downloadedFonts[ font.family_urlname ];
			
			if ( currentSelectedFont == font.family ) {
				return false;
			}
			
			// Font Variants Checboxes
			var $fontVariants = $( '<div class="checkboxes-container"></div>' ),
				selectedVariants = variants ? variants.split( ',' ) : [],
				defaultFontVariants = [ 'FunctionProBold', 'FunctionProBook', 'FunctionProDemi', 'FunctionProExtraBold', 'FunctionProLight', 'FunctionProMedium' ];
			
			$.each( font.variants, function( variant_id, variant ) {
				var $checkbox = $( '<input type="checkbox" name="font_variants[]" value="' + variant_id + '" ' + ( $.inArray( variant_id, selectedVariants ) != -1 ? 'checked' : '' ) + '>' ),
					$variant = $( '<label></label>' );
				
				if ( ! selectedVariants.length && $.inArray( variant.name, defaultFontVariants ) != -1 ) {
					$checkbox.prop( 'checked', true );
				}
				
				$checkbox.on( 'change', createOrUpdateFontVariantsForCSSSelectors );
				
				$variant.append( $checkbox );
				$variant.append( '<span title="' + variant_id + '">' + variant.name + '</span>' ).appendTo( $fontVariants );
			} );
			// End: Font Variants Checboxes
							
			// Font Subsets
			var $fontSubsets = $( '<div class="checkboxes-container"></div>' ),
				defaultFontSubsets = subsets ? subsets.split( ',' ) : [ 'macroman' ];
			
			$.each( font.subsets, function( subset_id, subset ) {
				var $subset = $( '<label></label>' );
					
				$subset.append( '<input type="checkbox" name="font_subsets[]" value="' + subset_id + '" ' + ( $.inArray( subset_id, defaultFontSubsets ) != -1 ? 'checked' : '' ) + '>' );
				$subset.append( '<span>' + subset + '</span>' ).appendTo( $fontSubsets );
			} );
			// End of: Font Subsets
			
			// Clear preview box
			$preview.html( '' );
			
			// Fill font family and data
			$fontFamily.val( font.family );
			
			// Fill font family and data
			$fontData.val( JSON.stringify( font ) );
			
			// Set Font Family Name
			addFontOptionsBlock( 'font-family-name', 'Font Family:', '<p class="font-family-name">' + font.family + '</p>' );
			
			// Font is downloaded, do not show download block
			if ( fontIsDownloaded ) {
				// Preview Iframe
				var $iframe = $( '<iframe></iframe>' ),
					$iframeLoader = $( '<p class="description">Loading font preview...</p>' ),
					previewFontUrl = ajaxurl + '?action=typolab-preview-premium-fonts&font-family=' + encodeURIComponent( font.family_urlname );
				
				$iframe.attr( {
					src : previewFontUrl
				} ).on( 'load', function() {
					var $body = $( this.contentWindow.document );
					
					// Preview Frame Adjust Height
					$iframeLoader.remove();
					$iframe.height( $body.height() );
					
					adjustHeightInterval = setInterval( function() {
						$iframe.height( $body.height() );
					}, 100 );
					
					if ( scrollFocus ) {
						$( 'html, body' ).animate( {
							scrollTop: $preview.offset().top - 50
						} );
					}
					
					scrollFocus = true;
					
					var $reDownloadFont = $( '<a href="#" class="font-redownload" title="Re-download font"><i class="fa fa-refresh"></i></a>' );
					
					$iframe.after( '<p class="font-details-link"><a href="' + font.creator + '" target="_blank">Font Details</a> <span class="sep"></span> Category: ' + font.category + ( ! fontIsDownloaded ? ( ' <span class="sep"></span> Size: ' + font.size ) : '' ) + '</p>' );
					
					// Premium Font Re-Download
					if ( premiumFontData.isActivated && premiumFontData.licenseKey ) {
						$iframe.next().append( $reDownloadFont );
						
						$reDownloadFont.on( 'click', function( ev ) {
							ev.preventDefault();
							
							if ( $reDownloadFont.hasClass( 'is-downloaded' ) ) {
								return false;
							}
							
							if ( confirm( 'Confirm font re-download?' ) ) {
								$reDownloadFont.addClass( 'fa-spin' ).attr( 'title', 'Downloading font...' );
								
								// Re-download Font
								downloadFontPackage( 'premium-fonts', font.family, function( response ) {
									$reDownloadFont.removeClass( 'fa-spin' );
						
									// Show errors
									if ( response.errors ) {
										var errors = '';
										
										for ( var i in response.error_msg ) {
											errors += "\n" + response.error_msg[ i ];
										}
										
										alert( errors.trim() );
									}
									// Font download was successful
									else {
										$reDownloadFont.addClass( 'is-downloaded' ).html( '<i class="fa fa-check"></i>' ).attr( 'title', 'Font has been downloaded successfully!' );
									}
								} );
							}
						} );
					}
					

					// Font Variants and Subsets
					addFontOptionsBlock( 'font-preview-variants', 'Font Variants', $fontVariants, 'two-thirds' );
					addFontOptionsBlock( 'font-preview-subsets', 'Font Subsets', $fontSubsets, 'one-third' );
					// End of: Font Variants and Subsets
					
					// Register Font Variants for CSS Selectors
					createOrUpdateFontVariantsForCSSSelectors();
					
				} );
				
				addFontOptionsBlock( 'font-preview-iframe', 'Live Preview', [ $iframeLoader, $iframe ] );
				
				// Enable Save Changes Button
				fontEditEnableSaveChanges();
				
				return true;
			}
			
			// Font Preview (font is not downloaded yet)
			var $premiumFontPreviewer = $( '<div class="external-font-previews"></div>' ),
				$premiumFontLoading = $( '<p class="description">Loading font preview...</p>' );
			
			addFontOptionsBlock( 'font-preview-iframe', 'Preview', [ $premiumFontLoading, $premiumFontPreviewer ]  );
			
			// Generate Font Previews
			var $previews = generatePremiumFontPreviews( font.variants );

			$premiumFontLoading.remove();
			$premiumFontPreviewer.append( $previews );

			$premiumFontPreviewer.after( '<p class="font-details-link"><a href="' + font.creator + '" target="_blank">Font Details</a> <span class="sep"></span> Category: ' + font.category + ( ! fontIsDownloaded ? ( ' <span class="sep"></span> Size: ' + font.size ) : '' ) + '</p>' );

			// Font Variants and Subsets
			addFontOptionsBlock( 'font-preview-variants', 'Font Variants', $fontVariants, 'two-thirds' );
			addFontOptionsBlock( 'font-preview-subsets', 'Font Subsets', $fontSubsets, 'one-third' );
			// End of: Font Variants and Subsets
						
			// Register Font Variants for CSS Selectors
			createOrUpdateFontVariantsForCSSSelectors();
				
			// Download Font if not downloaded
			var fontDownloader = '<p>You need to download and install this font in order to use it in this site.<br>';
			fontDownloader += 'Installation process is automatic, simply click the button below:</p>';
			
			var $download = $( '<a href="#install-font-package" class="button-primary download-font">Download &amp; Install Font</a>' ),
				$activateText = '';
			
			// Site is activated, font can be installed
			if ( premiumFontData.isActivated && premiumFontData.licenseKey ) {
				
				$download.on( 'click', function( ev ) {
					ev.preventDefault();

					if ( $download.hasClass( 'disabled' ) ) {
						return false;
					}
					
					$download.addClass( 'disabled' ).html( 'Installing font...' );

					// Start font download...
					downloadFontPackage( 'premium-fonts', font.family, function( response ) {
						var $pfDownloadBlock = $( '#premium-font-downloader .font-preview-row-bg' );
						
						$download.removeClass( 'disabled' ).html( 'Download &amp; Install Font' );
						$pfDownloadBlock.find( '.notice-error' ).remove();
			
						// Show errors
						if ( response.errors ) {
							$pfDownloadBlock.append( '<div class="notice notice-error"></div>' );
							
							for ( var i in response.error_msg ) {
								$pfDownloadBlock.find( '.notice-error' ).append( '<p>' + response.error_msg[ i ] + '</p>' );
							}
						}
						// Font download was successful
						else {
							$pfDownloadBlock.find( 'p, .download-font' ).remove();
							$pfDownloadBlock.append( '<p class="font-installed"><i class="fa fa-check"></i> Font has been installed successfully.</p>' );
						}
						
					} );
				} );
			}
			// Font cannot be installed, site is not activated 
			else {
				// Disable Download
				$download.addClass( 'disabled' ).on( 'click', function( ev ) {
					return false;
				} );
				
				$activateText = '<div class="notice notice-warning"><p>To download this font you must <a href="admin.php?page=kalium-product-registration">activate the theme</a>.</p></div>';
			}
			
			addFontOptionsBlock( 'premium-font-downloader', 'Install Font', [ fontDownloader, $( '<p class="hover">' ).append( $download ), $activateText ], 'font-downloader' );
				
			// Disable Save Changes Button
			fontEditDisableSaveChanges( 'Font is not installed' );
		}
		
		// Generate Font Squirrel Previews
		var generateFontSquirrelPreviews = function( previews ) {
			var $previews = $( '<div></div>' );
			
			$.each( previews, function( i, preview ) {
				var $preview = $( '<div class="preview-entry"></div>' );

				$preview.append( '<img src="' + preview.listing_image + '">' )
				$preview.append( '<span>' + preview.style_name + '</span>' );
				
				$previews.append( $preview );
			} );
			
			return $previews.children();
		}
		
		// Generate Premium Font Previews
		var generatePremiumFontPreviews = function( variants ) {
			var $previews = $( '<div></div>' );
			
			$.each( variants, function( variantName, variant ) {
				var $preview = $( '<div class="preview-entry"></div>' );

				if ( variant.screenshot ) {
					$preview.append( '<img src="https://api.laborator.co/assets/img/font-previews/' + variant.screenshot + '">' )
					$preview.append( '<span>' + variant.name + '</span>' );
					
					$previews.append( $preview );
				}
			} );
			
			return $previews.children();
		}
		
		// Download Font Package Adapter
		var downloadFontPackage = function( provider_id, font_family, callback ) {
			var provider,
				$fontList = $( '.fonts-list-select .font-list' );
			
			$fontList.addClass( 'download-in-progress' );

			switch( provider_id ) {
				case 'font-squirrel':
					provider = 'typolab_font_squirrel_download';
					break;
					
				case 'premium-fonts':
					provider = 'typolab_premium_fonts_download';
					break;
			}
			
			if ( ! provider ) {
				return false;
			}
			
			$.post( ajaxurl, { action: provider, font_family: font_family }, function( response ) {
				
				$fontList.removeClass( 'download-in-progress' );
				
				// Initialize callback
				if ( typeof callback == 'function' ) {
					callback.apply( this, [ response ] );
				}
				
				// Enable Save Changes Button
				fontEditEnableSaveChanges();
				
			}, 'json' );
			
			return true;
		}
		
		// Register Font Variants for CSS Selectors
		var createOrUpdateFontVariantsForCSSSelectors = function() {
			var $variants = $( '#font-preview-variants input[type="checkbox"]:checked' ),
				$fontVariantsSelectors = $( '.font-selectors-list .font-variants select' ),
				$customFontForm = $( '.custom-font-form-layout' );
			
			// Custom Font is in use
			if ( $customFontForm.length ) {
				var fontFamilyNames = [];
					
				$customFontForm.find( '#font-family-names input[name="font_variants[]"]' ).each( function( i, el ) {
					var fontVariant = $( el ).val();
					
					// Remove font-family
					fontVariant = fontVariant.replace( /(font-family:|\'|\")/ig, '' ).trim();
					console.log( fontVariant );
					
					$.each( fontVariant.split( ';' ), function( i, variant ) {
						variant = variant.split( ',' )[0];
						
						if ( variant.trim().length ) {
							fontFamilyNames.push( $( '<input>' ).attr( {
								value : variant.split( ',' )[0]
							} ) );
						}
					} );
					
					$variants = $( fontFamilyNames );
				} );
			}
			
			$fontVariantsSelectors.each( function( i, select ) {
				var $select = $( select ),
					selected = $select.data( 'selected' ),
					hasVariants = $variants.length > 0;
					
				$select.find( 'option' ).remove();
				$select.prop( 'disabled', hasVariants == false )[ hasVariants ? 'removeClass' : 'addClass']( 'disabled' );
				
				if ( ! hasVariants ) {
					$select.append( '<option>- No font variants -</option>' );
				}
				
				$variants.each( function( j, checkbox ) {
					var $checkbox = $( checkbox ),
						val = $checkbox.val(),
						$option = $( '<option>' + val + '</option>' ).val( val );
						
					$select.append( $option );
					
					if ( val == selected ) {
						$option.prop( 'selected', true );
					}
				} );
			} );
			
			// Equal Height Font Variants and Subsets
			var $fontVariants = $( '#font-preview-variants' ),
				$fontSubsets = $( '#font-preview-subsets' );
			
			if ( $fontVariants.length && $fontSubsets.length ) {
				var $both = $fontVariants.add( $fontSubsets ).find( '.font-preview-row-bg' );
				$both.css( 'min-height', '' ).css( 'min-height', Math.max( $fontVariants.outerHeight(), $fontSubsets.outerHeight() ) );
			}
		}
		
		// Generate Preview Frame for Custom Font
		var customFontGeneratePreview = function() {
			// Font Data
			var $customFontForm = $( '.custom-font-form-layout' ),
				fontStyleFile = $customFontForm.find( '#font_url' ).val(),
				fontFamilyNames = [];
			
			$customFontForm.find( '#font-family-names input[name="font_variants[]"]' ).each( function( i, el ) {
				var fontVariant = $( el ).val().split( ';' );
				
				for ( var j in fontVariant ) {
					fontFamilyNames.push( fontVariant[ j ] );
				}
			} );
			
			if ( ! fontStyleFile || 0 == fontFamilyNames.join( '' ).trim().length || $customFontForm.data( 'last-value' ) == fontStyleFile + fontFamilyNames.join( ';' ) ) {
				return false;
			}
			
			$customFontForm.data( 'last-value', fontStyleFile + fontFamilyNames.join( ';' ) );
			
			// Clear preview box
			$preview.html( '' );
			
			// Preview Iframe
			var $iframe = $( '<iframe></iframe>' ),
				$iframeLoader = $( '<p class="description">Loading font preview...</p>' ),
				previewFontUrl = ajaxurl + '?action=typolab-preview-custom-font&font-url=' + encodeURIComponent( fontStyleFile ) + '&font-family=' + encodeURIComponent( fontFamilyNames.join( ';' ) );
			
			$iframe.attr( {
				src : previewFontUrl
			} ).on( 'load', function() {
				var $body = $( this.contentWindow.document );
				
				// Preview Frame Adjust Height
				$iframeLoader.remove();
				$iframe.height( $body.height() );
				
				adjustHeightInterval = setInterval( function() {
					$iframe.height( $body.height() );
				}, 50 );
				
				if ( scrollFocus ) {
					$( 'html, body' ).animate( {
						scrollTop: $preview.offset().top - 50
					} );
				}
				
				scrollFocus = true;
				
				// Register Font Variants for CSS Selectors
				createOrUpdateFontVariantsForCSSSelectors();
			} );
			
			addFontOptionsBlock( 'font-preview-iframe', 'Live Preview', [ $iframeLoader, $iframe ] );
			
			return true;
		}
		
		// Generate Preview Frame for TypeKit
		var typekitFontGeneratePreview = function() {
			// Font Data
			var $typekitFontForm = $( '.typekit-font-form-layout' ),
				kitId = $typekitFontForm.find( '#kit_id' ).val();
			
			// If current kit is already set, do not re-load it
			if ( ! kitId || $typekitFontForm.data( 'kit-id' ) == kitId ) {
				return false;
			}
			
			$typekitFontForm.data( 'kit-id', kitId );
				
			// Clear preview box
			$preview.html( '' );
			
			// Preview Iframe
			var $iframe = $( '<iframe></iframe>' ),
				$iframeLoader = $( '<p class="description">Loading font preview...</p>' ),
				previewFontUrl = ajaxurl + '?action=typolab-preview-typekit-font&kit-id=' + encodeURIComponent( kitId );
			
			$iframe.attr( {
				src : previewFontUrl
			} ).on( 'load', function() {
				var $body = $( this.contentWindow.document );
				
				// Preview Frame Adjust Height
				$iframeLoader.remove();
				$iframe.height( $body.height() );
				
				adjustHeightInterval = setInterval( function() {
					$iframe.height( $body.height() );
				}, 50 );
				
				if ( scrollFocus ) {
					$( 'html, body' ).animate( {
						scrollTop: $preview.offset().top - 50
					} );
				}
				
				scrollFocus = true;
				
				// Show Kit Info
				if ( this.contentWindow.kitInfo.kit != 'undefined' ) {
					var kitInfo = this.contentWindow.kitInfo.kit,
						fontFamilies = [];
					
					$.each( kitInfo.families, function( i, family ) {
						fontFamilies.push( '<a href="https://typekit.com/fonts/' + family.slug + '" title="Variations: ' + family.variations.join( ', ' ) + '" target="_blank">' + family.name + '</a>' );
					} );
					
					$iframe.after( '<p class="font-details-link">Font Families: ' + fontFamilies.join( ', ' ) + '<a href="https://typekit.com/kit_editor/kits/' + kitId + '" class="font-redownload" target="_blank" title="Kit Settings"><i class="fa fa-cog"></i></a>' + '</p>' );
				}
			} );
			
			addFontOptionsBlock( 'font-preview-iframe', 'Live Preview', [ $iframeLoader, $iframe ] );
			
			return true;
		}
		
		// Edit Font Form
		if ( $( 'form#edit-font-form' ).length == 1 ) {
			
			// Add CSS Rule and Font Options
			var $cssSelectors = $( '.font-selectors-list tbody' ),
				$noRecords = $cssSelectors.find( '.no-records' ).clone();
			
			$cssSelectors.sortable( {
				helper : function( e, ui ) {
					ui.children().each( function() {  
						$( this ).width( $( this ).width() ); 
					} );  
					return ui;  
				},
				handle : '.sort-css-rule-row',
				axis   : 'y',
			} );
					
			// Save Changes Button
			var $saveChanges = $( '#edit-font-form #save_font_changes' );
			
			$saveChanges.data( 'text', $saveChanges.val() );
			
			// Typekit Font Initialize
			var $typekitFontForm = $( '.typekit-font-form-layout' );
			
			if ( $typekitFontForm.length ) {
				
				$typekitFontForm.on( 'blur', '#kit_id', typekitFontGeneratePreview );
				
				$typekitFontForm.find( '#typekit-font-generate-preview' ).on( 'click', function( ev ) {
					ev.preventDefault();
					typekitFontGeneratePreview();
				} );
				
				scrollFocus = false;
				typekitFontGeneratePreview();
			}
			
			// Custom Font Initialize
			var $customFontForm = $( '.custom-font-form-layout' );
			
			if ( $customFontForm.length ) {
				var $fontFamilyEntries = $customFontForm.find( '.font-family-entries' ),
					$customFontFamilyInputTemplate = $( '<li><input type="text" name="font_variants[]" value="" required="required"><a href="#" class="remove"><i class="fa fa-remove"></i></a></li>' );
				
				// Add font family input
				$customFontForm.on( 'click', '#add-custom-font-input', function( ev ) {
					ev.preventDefault();
					$fontFamilyEntries.append( $customFontFamilyInputTemplate.clone() ).find( 'li:last-child input' ).focus();
				} );
				
				// Delete Custom Font Entries
				$fontFamilyEntries.on( 'click', 'a.remove', function( ev ) {
					ev.preventDefault();
					
					if ( $( this ).prev().val().length > 0 && ! confirm( 'Are you sure you want to delete this font family name?' ) ) {
						return false;
					}
					
					$( this ).parent().remove();
					
					// Register Font Variants for CSS Selectors
					createOrUpdateFontVariantsForCSSSelectors();
				} );
				
				// Generate Font Preview
				$customFontForm.on( 'blur', '#font_url, #font-family-names input[name="font_variants[]"]', customFontGeneratePreview ).find( '#custom-font-generate-preview' ).on( 'click', function( ev ) {
					ev.preventDefault();
					customFontGeneratePreview();
				} );
				
				scrollFocus = false;
				customFontGeneratePreview();
			}
			
			// Show Advanced Options
			var $toggleAdvancedOptionsLink = $( '#typolab-toggle-advanced-options' );
			
			$toggleAdvancedOptionsLink.on( 'click', function( ev ) {
				ev.preventDefault();
				$toggleAdvancedOptionsLink.toggleClass( 'shown' ).html( $toggleAdvancedOptionsLink.hasClass( 'shown' ) ? $toggleAdvancedOptionsLink.data( 'hide-options' ) : $toggleAdvancedOptionsLink.data( 'show-options' ) );
			} ).html( $toggleAdvancedOptionsLink.hasClass( 'shown' ) ? $toggleAdvancedOptionsLink.data( 'hide-options' ) : $toggleAdvancedOptionsLink.data( 'show-options' ) );
			
			// Enable Save Changes Button
			var fontEditEnableSaveChanges = function() {
				$saveChanges.removeClass( 'disabled' ).prop( 'disabled', false ).val( $saveChanges.data( 'text' ) );
			}
			
			// Disable Save Changes Button
			var fontEditDisableSaveChanges = function( text ) {
				$saveChanges.addClass( 'disabled' ).prop( 'disabled', true );
				
				if ( text ) {
					$saveChanges.val( text );
				}
			}
			
			// Generate Row ID
			var generateRowID = function( count ) {
				var $rows = $cssSelectors.find( 'tr' ),
					id = $rows.length + 1 + ( count ? count : 0 );
				
				if ( $rows.filter( '#css-selector-' + id ).length ) {
					return generateRowID( count ? count + 1 : 1 );
				}
				
				return id;
			}
			
			// Add Row to CSS Selectors List
			var addCSSSelectorRow = function( data, focusOnSelector ) {
				var $CSSSelectorRow  = $( '<tr></tr>' ),
					$drag        	 = $( '<td class="font-drag"></td>' ),
					$selector        = $( '<td class="font-selector"></td>' ),
					$variants        = $( '<td class="font-variants"></td>' ),
					$sizes           = $( '<td class="font-sizes"></td>' ),
					$action          = $( '<td class="font-selector-action"></td>' );
				
				$CSSSelectorRow.append( $drag ).append( $selector ).append( $variants ).append( $sizes ).append( $action );
				$cssSelectors.find( '.no-records' ).remove();
				
				// Group ID
				var groupID = generateRowID();
				
				$CSSSelectorRow.attr( 'id', 'css-selector-' + groupID );
				
				// CSS Rule
				var $selectorInput = $( '<input>' ).attr( {
					type        : 'text',
					required	: true,
					placeholder : 'CSS Selector Rule' + ( groupID == 1 ? ' (i.e.: body, p, .myclass)' : '' ),
					name        : "font_selectors[" + groupID + "][selector]",
					tabIndex	: groupID,
					value		: data && data.selector ? data.selector : ''
				} );
				
				$selectorInput.appendTo( $selector );
				
				// Sortable Functionality
				var $draggable = $( '<a href="#" class="sort-css-rule-row"><i class="fa fa-bars"></i></a>' );
				$draggable.appendTo( $drag );
				
				// Font Variants Select
				var $variantsSelect = $( '<select>' ).attr( {
					name : "font_selectors[" + groupID + "][variant]"
				} );
				
				if ( data && data.variant ) {
					$variantsSelect.data( 'selected', data.variant );
				}
				
				$variantsSelect.append( '<option value="" selected disabled>Loading...</option>' ).appendTo( $variants ).on( 'change', function( ev ) {
					$( this ).data( 'selected', $( this ).val() );
				} );
				
				// Font Sizes
				var $fontSizesGeneral = $( '<input>' ).attr( {
					type        : 'number',
					placeholder : 'General',
					className	: 'font-size-general',
					step		: 'any',
					name        : "font_selectors[" + groupID + "][font-sizes][general]",
					tabIndex	: groupID,
					value		: data && data.fontSizes && data.fontSizes.general ? data.fontSizes.general : ''
				} );
				
				var $fontSizesDesktop = $( '<input>' ).attr( {
					type        : 'number',
					placeholder : 'Desktop',
					className	: 'font-size-desktop',
					step		: 'any',
					name        : "font_selectors[" + groupID + "][font-sizes][desktop]",
					tabIndex	: groupID,
					value		: data && data.fontSizes && data.fontSizes.desktop ? data.fontSizes.desktop : ''
				} );
				
				var $fontSizesTablet = $( '<input>' ).attr( {
					type        : 'number',
					placeholder : 'Tablet',
					className	: 'font-size-tablet',
					step		: 'any',
					name        : "font_selectors[" + groupID + "][font-sizes][tablet]",
					tabIndex	: groupID,
					value		: data && data.fontSizes && data.fontSizes.tablet ? data.fontSizes.tablet : ''
				} );
				
				var $fontSizesMobile = $( '<input>' ).attr( {
					type        : 'number',
					placeholder : 'Mobile',
					className	: 'font-size-mobile',
					step		: 'any',
					name        : "font_selectors[" + groupID + "][font-sizes][mobile]",
					tabIndex	: groupID,
					value		: data && data.fontSizes && data.fontSizes.mobile ? data.fontSizes.mobile : ''
				} );
				
				$fontSizesGeneral.appendTo( $sizes );
				$fontSizesDesktop.appendTo( $sizes );
				$fontSizesTablet.appendTo( $sizes );
				$fontSizesMobile.appendTo( $sizes );
				
				// Font Units
				var $fontUnits = $( '<select>' ).attr( {
					name : "font_selectors[" + groupID + "][font-sizes][unit]"
				} );
				
				$fontUnits.append( '<option value="px">px</option>' );
				$fontUnits.append( '<option value="em">em</option>' );
				$fontUnits.append( '<option value="rem">rem</option>' );
				$fontUnits.append( '<option value="%">%</option>' );
				
				if ( data && data.fontSizes && data.fontSizes['unit'] ) {
					$fontUnits.find( 'option' ).each( function( j, option ) {
						if ( data.fontSizes['unit'] == $( option ).val() ) {
							$( option ).prop( 'selected', true );
						}
					} );
				}
				
				$fontUnits.appendTo( $sizes );
				
				// Delete Rule Row
				var $deleteRule = $( '<a href="#" class="remove-font-selector"><i class="fa fa-remove"></i></a>' )
				
				$deleteRule.on( 'click', function( ev ) {
					ev.preventDefault();
					
					if ( $selectorInput.val().trim().length == 0 || confirm( 'Confirm delete?' ) ) {
						$CSSSelectorRow.remove();
						
						if ( 0 == $cssSelectors.find( 'tr:not(.no-records)' ).length ) {
							$cssSelectors.append( $noRecords );
						}
					}
				} );
				
				$deleteRule.appendTo( $action );
				
				// Add Row
				$cssSelectors.append( $CSSSelectorRow );
				
				// Focus on Selector Field
				if ( focusOnSelector ) {
					$selectorInput.focus();
				}
			}
			
			// Initialize Current Selector
			var $fontSelectors = $( 'script#font-selectors' );
			
			if ( $fontSelectors.length ) {
				var fontSelectors = JSON.parse( $fontSelectors.html() );
				
				for ( var fontIndex in fontSelectors ) {
					addCSSSelectorRow( fontSelectors[ fontIndex ] );
				}
			}
			
			// Predefined CSS Selectors
			var $predefinedCSSSelectors = $( '.predefined-css-selectors' );
			
			var predefinedCloseWhenClickingOutside = function( ev ) {
				var $target = $( ev.target );
				
				if ( ! $target.closest( $predefinedCSSSelectors ).length ) {
					$predefinedCSSSelectors.removeClass( 'shown' );
				}
			}
			
			// Toggle Predefined CSS Selectors List
			$predefinedCSSSelectors.on( 'click', '.button', function( ev ) {
				ev.preventDefault();
				$predefinedCSSSelectors.toggleClass( 'shown' );
				
				if ( $predefinedCSSSelectors.hasClass( 'shown' ) ) {
					$( window ).on( 'click', predefinedCloseWhenClickingOutside );
				} else {
					$( window ).off( 'click', predefinedCloseWhenClickingOutside );
				}
			} );
			
			// Predefined CSS entry is clicked
			$predefinedCSSSelectors.on( 'click', 'ul li a', function( ev ) {
				ev.preventDefault();
				var selectors = $( this ).data( 'selectors' ),
					selectors_line = [];
				
				for ( var i in selectors ) {
					selectors_line.push( selectors[ i ] );
				}
				
				// Add CSS Selectors Row
				addCSSSelectorRow( {
					selector: selectors_line.join( ', ' )
				} );
				
				// Hide Predefined CSS Selectors Dropdown
				$predefinedCSSSelectors.removeClass( 'shown' );
				
				// Register Font Variants for CSS Selectors
				createOrUpdateFontVariantsForCSSSelectors();
			} );
			
			// Register Font Variants for CSS Selectors
			createOrUpdateFontVariantsForCSSSelectors();
			
			// Add New CSS Selector
			$( '#add-new-selector' ).on( 'click', function( ev ) {
				ev.preventDefault();
				addCSSSelectorRow( null, true );
				createOrUpdateFontVariantsForCSSSelectors();
			} );
			
			// Conditional Statements
			var $conditionalStatements = $( '.font-conditional-loading tbody' ),
				$conditionalStatementsObj = $( 'script#conditional-statements' );
				
			if ( $conditionalStatementsObj ) {
				var conditionalStatementsObj = JSON.parse( $conditionalStatementsObj.html() );
			}
			
			var addConditionalStatement = function( stmt ) {
				var $row = $( '<tr></tr>' ),
					$statement = $( '<td></td>' ).addClass( 'statement' ),
					$operator = $( '<td></td>' ).addClass( 'operator' ),
					$criteria = $( '<td></td>' ).addClass( 'criteria' ),
					$actions = $( '<td></td>' ).addClass( 'actions' );
				
				// Remove Existing "No Statements" row
				$conditionalStatements.find( '.no-statements' ).remove();
				
				// Add "OR" Label
				$conditionalStatements.append( '<tr><td colspan="4" class="or-label"><span>OR</span></td></tr>' );
				
				// Statement Select
				var $statementSelect = $( '<select></select>' ).attr( 'name', 'statements[]' ),
					statementOptions = [];
					
					// Post Type
					statementOptions.push( {
						value : 'post_type',
						text  : 'Post Type',
						group : 'General'
					} );
					
					// Page Type
					statementOptions.push( {
						value : 'page_type',
						text  : 'Page Type',
						group : 'General'
					} );
					
					// Page Templates
					statementOptions.push( {
						value : 'page_template',
						text  : 'Page Template',
						group : 'General'
					} );
					
					// Post Type Entry
					$.each( conditionalStatementsObj.data.post_types, function( key, value ) {
						statementOptions.push( {
							value : key,
							text  : value.singular,
							group : 'Post Types',
						} );
					} );
					
					// Taxonomy Entry
					$.each( conditionalStatementsObj.data.taxonomies, function( key, value ) {
						statementOptions.push( {
							value : key,
							text  : value.singular,
							group : 'Taxonomy :: ' + conditionalStatementsObj.data.post_types[ value.post_type ].name
						} );
					} );
					
					// Append Options
					var statementGroups = {};
					
					$.each( statementOptions, function( key, option ) {
						var $option = $( '<option value="' + option.value + '">' + option.text + '</option>' );
						
						if ( ! option.group ) {
							$option.appendTo( $statementSelect );
						} else {
							if ( ! statementGroups[ option.group ] ) {
								statementGroups[ option.group ] = $( '<optgroup></optgroup>' ).attr( 'label', option.group );
								statementGroups[ option.group ].appendTo( $statementSelect );
							}
							
							statementGroups[ option.group ].append( $option );
						}
						
						// Set Selected Value for Statement
						if ( stmt && stmt.statement == option.value ) {
							$option.attr( 'selected', true );
						}
					} );
				
				// Statement Data Event Handling
				$statementSelect.on( 'change', function( ev ) {
					insertAvailableConditionalStatementCriterions( $statementSelect.val(), $criteriaSelect );
				} );
				
				$statement.append( $statementSelect );
				
				// Operator Select
				var $operatorSelect = $( '<select></select>' ).attr( {
					name: 'operators[]'
				} );
				
				$operatorSelect.append( '<option value="==">is</option>' );
				$operatorSelect.append( '<option value="!=">is not</option>' );
				
				$operator.append( $operatorSelect );
				
				if ( stmt ) {
					$operatorSelect.find( 'option[value="' + stmt.operator + '"]' ).prop( 'selected', true );
				}
				
				// Criteria Select
				var $criteriaSelect = $( '<select></select>' ).attr( {
					name: 'criterions[]',
					class: 'is-loading'
				} );
				
				$criteriaSelect.append( '<option value="" class="loading-options">Loading options...</option>' );
				
				$criteria.append( $criteriaSelect );
				
				// Set Selected Value for Criteria
				$criteriaSelect.on( 'valuesSet', function( ev, dataType ) {
					if ( stmt && dataType == stmt.statement ) {
						$( this ).find( 'option' ).each( function( j, el ) {
							if ( $( el ).val() == stmt.criteria ) {
								$( el ).prop( 'selected', true );
							}
						} );
					}
				} );
				
				// Delete Rule Row
				var $deleteConditionalStatement = $( '<a href="#" class="remove-conditional-statement"><i class="fa fa-remove"></i></a>' )
				
				$deleteConditionalStatement.on( 'click', function( ev ) {
					ev.preventDefault();
					
					if ( confirm( 'Confirm delete?' ) ) {
						$row.prev().remove();
						$row.remove();
						
						if ( $conditionalStatements.find( 'tr' ).length == 0 ) {
							$conditionalStatements.append( '<tr class="no-statements"><td colspan="4">No defined conditional statements. Font will be loaded in all pages.</td></tr>' );
						}
					}
				} );
				
				$deleteConditionalStatement.appendTo( $actions );
						
				// Add Row
				$conditionalStatements.append( $row.append( $statement ).append( $operator ).append( $criteria ).append( $actions ) );
				
				$statementSelect.trigger( 'change' );
			}
			
			// Get and Insert Available Criterions Based on Statement Type
			var insertAvailableConditionalStatementCriterions = function( dataType, $input ) {
				$input.addClass( 'is-loading' ).find( 'option' ).remove();
				$input.append( '<option value="">Loading data...</option>' );
				
				// Select Predefined Post Types
				if ( 'post_type' == dataType ) {
					$input.removeClass( 'is-loading' ).find( 'option' ).remove();
					
					$.each( conditionalStatementsObj.data.post_types, function( key, value ) {
						$input.append( $( '<option value="' + key + '">' + value.singular + '</option>' ) );
					} );
					
					$input.trigger( 'valuesSet', dataType );
				}
				// Select from page types
				else if ( 'page_type' == dataType ) {
					$input.removeClass( 'is-loading' ).find( 'option' ).remove();
					
					$.each( conditionalStatementsObj.data.page_types, function( key, value ) {
						$input.append( $( '<option value="' + key + '">' + value.name + '</option>' ) );
					} );
					
					$input.trigger( 'valuesSet', dataType );
				}
				// Select from page templates
				else if ( 'page_template' == dataType ) {
					$input.removeClass( 'is-loading' ).find( 'option' ).remove();
					
					$.each( conditionalStatementsObj.data.page_template, function( key, value ) {
						$input.append( $( '<option value="' + key + '">' + value.name + '</option>' ) );
					} );
					
					$input.trigger( 'valuesSet', dataType );
				}
				// Select from Pre Defined Data Entries
				else if ( conditionalStatementsObj.data[ dataType ] ) {
					$input.removeClass( 'is-loading' ).find( 'option' ).remove();
					
					$.each( conditionalStatementsObj.data[ dataType ], function( key, option ) {
						$input.append( '<option value="' + option.value + '">' + option.text + '</option>' );
					} );
					
					if ( 0 == conditionalStatementsObj.data[ dataType ].length ) {
						$input.addClass( 'is-loading' ).append( '<option value="">:: No Entries Found ::</option>' );
					}
					
					$input.trigger( 'valuesSet', dataType );
				}
				// Select from post type entries
				else if ( conditionalStatementsObj.data.post_types[ dataType ] ) {
					if ( ! conditionalStatementsObj.data[ dataType ] ) {
						$.post( ajaxurl, { action: 'typolab_get_post_type_entries', post_type: dataType }, function( response ) {
							if ( response.success ) {
								conditionalStatementsObj.data[ dataType ] = response.entries;
								insertAvailableConditionalStatementCriterions( dataType, $input );
							}
						}, 'json' );
					} 
				}
				// Select from taxonomy entries
				else if ( conditionalStatementsObj.data.taxonomies[ dataType ] ) {
					if ( ! conditionalStatementsObj.data[ dataType ] ) {
						$.post( ajaxurl, { action: 'typolab_get_taxonomy_entries', taxonomy: dataType }, function( response ) {
							if ( response.success ) {
								conditionalStatementsObj.data[ dataType ] = response.entries;
								insertAvailableConditionalStatementCriterions( dataType, $input );
							}
						}, 'json' );
					}
				}
				
				return $input;
			}
			
			$( '#add-new-conditional-statement' ).on( 'click', function( ev ) {
				ev.preventDefault();
				addConditionalStatement();
			} );
			
			$.each( conditionalStatementsObj.statements, function( index, stmt ) {
				addConditionalStatement( stmt );
			} );
			
			// Font Status Class Toggler
			var $fontStatus = $( 'select[name="font_status"]' );
			
			if ( $fontStatus.length ) {
				var toggleFontStatusColor = function() {
					$fontStatus.closest( '.grouped-input' )[ 'published' == $fontStatus.val() ? 'addClass' : 'removeClass' ]( 'green' );
				}
				
				$fontStatus.on( 'change', toggleFontStatusColor );
				toggleFontStatusColor();
			}
		}
		
		// Font Sizes Options
		if ( $( '.font-sizes-container' ).length ) {
		
			// Show Responsive Options
			$( '.font-sizes-container .show-responsive-options' ).on( 'click', function( ev ) {
				ev.preventDefault();
				$( this ).closest( '.font-size-group' ).toggleClass( 'responsive-options-shown' );
			} );
			
			// Toggle Responsive Options for Filled fields
			$( '.font-sizes-container .font-size-group' ).each( function( i, el ) {
				var $group = $( el );
				
				if ( $group.find( 'table tbody .hidden input' ).filter( function( j, el2 ) { return $( el2 ).val().length > 0; } ).length ) {
					$group.addClass( 'responsive-options-shown' );
				}
			} );
			
			// Add New CSS Selector Alias
			$( '.add-font-selectors-table' ).on( 'click', '.add-entry', function( ev ) {
				ev.preventDefault();
				
				var $tr = $( this ).closest( 'tr' ).clone(),
					$deleteRow = $( '<a class="remove" title="Delete Selector" href="#"><i class="fa fa-remove"></i></a>' );
				
				// Create Row and Remove Existing Data
				$tr.find( 'input' ).val( '' );
				$tr.find( '.add-remove *' ).remove();
				$tr.find( '.add-remove' ).append( $deleteRow );
				
				$( this ).closest( 'tbody' ).append( $tr );
				
				// Delete Row
				$deleteRow.on( 'click', function( ev ) {
					ev.preventDefault();
					
					if ( confirm( 'Confirm delete of CSS selector' ) ) {
						$tr.remove();
					}
				} );
				
				// Focus on first input
				$tr.find( 'input:first' ).focus();
				
			} );
			
			// Add New Font Size Group
			$( '#new-font-sizes-group' ).on( 'click', function( ev ) {
				ev.preventDefault();
				$( '.add-new-font-size-group-container' ).slideToggle( 'normal', function() {
					$( this ).find( 'input, textarea' ).first().focus();
				} );
			} );
			
			// Confirm Group Deletion
			$( '.delete-custom-font-sizes-group' ).on( 'click', function( ev ) {
				
				if ( ! confirm( 'Are you sure you want to delete this font size group?' ) ) {
					ev.preventDefault();
				}
			} );
		}
		
		// Advanced Font Settings
		var $fontAdvancedSettings = $( '#typolab-advanced-settings' );
		
		if ( $fontAdvancedSettings.length ) {
			
			// Toggle Export/Import Settings
			$( '.typolab-toggle-advanced-font-settings' ).on( 'click', function( ev ) {
				ev.preventDefault();
				$fontAdvancedSettings.slideToggle( 300 );
			} );
			
			// Export Font Settings
			var $exportOptions   	= $fontAdvancedSettings.find( '.font-export-options' ),
				$exportLoading      = $fontAdvancedSettings.find( '.font-export-loading' ),
				$exportCode         = $fontAdvancedSettings.find( '.font-export-code' ),
				$exportSettingsBtn  = $fontAdvancedSettings.find( '#typolab-export-settings' );
			
			$exportSettingsBtn.on( 'click', function( ev ) {
				ev.preventDefault();
				
				var exportFontFaces    = $exportOptions.find( '#typolab_export_font_faces' ).is( ':checked' ) ? 1 : 0,
					exportFontSizes    = $exportOptions.find( '#typolab_export_font_sizes' ).is( ':checked' ) ? 1 : 0,
					exportFontSettings = $exportOptions.find( '#typolab_export_font_settings' ).is( ':checked' ) ? 1 : 0;
				
				if ( $exportOptions.hasClass( 'is-loading' ) || $exportOptions.hasClass( 'done' ) || ! ( exportFontFaces || exportFontSizes || exportFontSettings ) ) {
					return false;
				}
				
				$exportOptions.addClass( 'is-loading' ).hide();
				$exportLoading.fadeIn();
				
				$.post( ajaxurl, { action: 'typolab-export-import-manager', doExport: true, fontFaces: exportFontFaces, fontSizes: exportFontSizes, fontSettings: exportFontSettings }, function( resp ) {
					$exportOptions.removeClass( 'is-loading' );
					$exportLoading.hide();
					
					if ( resp.exported ) {
						var $export = $exportCode.find( 'textarea' );
						
						$export.val( resp.exported );
						
						$exportCode.fadeIn( 100, function() {
							$export.select();
							$exportOptions.addClass( 'done' );
							$exportSettingsBtn.addClass( 'disabled' );
						} );
					} else {
						alert( 'An error occured, export settings are not avaialble!' );
					}
				}, 'json' );
			} );
			
			// Import Font Settings
			$( '#typolab-import-button' ).on( 'click', function( ev ) {
				$( '#save_font_settings' ).click();
			} );
		}
		
		// Downloaded Fonts - Delete Font
		$( '.downloaded-fonts-list tbody .trash' ).on( 'click', function( ev ) {
			var confirmText = "Are you sure you want to delete font files?\n\nThis won't delete fonts from the list, only font files.";
			
			if ( ! confirm( confirmText ) ) {
				return false;
			}
		} );
		
		// Delete Font Confirmation
		$( '.typolab-fonts-list' ).on( 'click', '.trash', function( ev ) {
			if ( ! confirm( 'Are you sure you want to delete this font?' ) ) {
				ev.preventDefault();
				return false;
			}
		} );
		
		// Add Font from Source
		var $addFontFromSource = $( '.typolab-select-font-source' );
		
		if ( $addFontFromSource.length ) {
			var $fontSources = $addFontFromSource.find( 'tbody tr' ),
				showFontSourceDescription = function( source_id ) {
					var fontSourcesHeight = $( '.typolab-select-font-source' ).outerHeight();
					
					fontSourcesHeight -= $( '#typolab_add_font' ).outerHeight( true );
					
					$( '.font-source-description' ).removeClass( 'selected' ).filter( '.font-source-description-' + source_id ).addClass( 'selected' );
					
					// Set equals height with font sources
					$( '.typolab-selected-font-source' ).css( {
						minHeight: fontSourcesHeight
					} );
				}
			
			// Click Event
			$fontSources.on( 'click', function( ev ) {
				var $radio = $( this ).find( 'input[type="radio"]' ),
					source_id = $radio.val();
				
				$fontSources.removeClass( 'hover' );
				$radio.prop( 'checked', true );
				$( this ).addClass( 'hover' );
				
				// Set selected
				showFontSourceDescription( source_id );
			} );
			
			// Selected Font Source
			var $selected = $fontSources.find( 'input:checked' );
			
			$selected.closest( 'tr' ).addClass( 'hover' );
			showFontSourceDescription( $selected.val() );
			
		}
		
		// Escape Regular Expression String
		var escapeRegExp = function( str ) {
			return str.replace( /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&" );
		}
	} );

} )( jQuery, window );