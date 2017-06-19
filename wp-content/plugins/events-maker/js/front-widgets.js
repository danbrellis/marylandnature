( function ( $ ) {

	$( document ).ready( function () {

		$( document ).on( 'click', '.widget_events_calendar .prev-month a, .widget_events_calendar .next-month a', function ( e ) {
			
			e.preventDefault();
			
			var ajaxArgs = [],
					newMonth = $( this ).attr( 'data-rel' ),
					divCalendar = $( this ).closest( '.widget_events_calendar' ),
					tdSpinner = divCalendar.find( '.ajax-spinner' ),
					divRel = divCalendar.attr( 'data-rel' ),
					relSplit = divRel.split( '|' ),
					widgetID = relSplit[0],
					lang = relSplit[1];

			ajaxArgs = {
				action: 'get-events-widget-calendar-month',
				date: newMonth,
				widget_id: widgetID,
				nonce: emArgs.nonce
			};

			if ( lang !== '' ) {
				ajaxArgs['pll_load_front'] = 1;
				ajaxArgs['lang'] = lang;
			}

			divCalendar.find( '.ajax-spinner div' ).css( 'middle', parseInt( ( tdSpinner.height() - 16 ) / 2 ) + 'px' ).css( 'left', parseInt( ( tdSpinner.width() - 16 ) / 2 ) + 'px' ).fadeIn( 300 );

			$.ajax( {
				type: 'POST',
				url: emArgs.ajaxurl,
				data: ajaxArgs,
				dataType: 'html'
			} )
					.done( function ( data ) {
						divCalendar.fadeOut( 300, function () {
							divCalendar.replaceWith( data );
							$( '#events-calendar-' + widgetID ).fadeIn( 300 );
						} );
					} ).fail( function ( data ) {
				//
			} );

			return false;
		} );

	} );

} )( jQuery );