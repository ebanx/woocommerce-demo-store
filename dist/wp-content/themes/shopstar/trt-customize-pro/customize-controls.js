( function( api ) {

	// Extends our custom "shopstar" section.
	api.sectionConstructor['shopstar'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
