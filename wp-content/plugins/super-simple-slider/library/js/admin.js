/**
 * Plugin Template admin js.
 *
 *  @package Super Simple Slider/Library/JS
 */
(function($) {

    $( '.otb-panel-container.sortable .container' ).sortable({
    	handle: '.sort-handle',
    	stop: function( event, ui ) {
    	},
        over: function( event, ui ) {
        },
        out: function( event, ui ) {
        },
        change: function( event, ui ) {
        }
    });

    $( document ).ready( function() {
    	$('form[name="post"').on('submit', function() {
    		$('.otb-panel-container .panel.hidden').remove();
    		$('.otb-panel-container .panel .otb-form-control-checkbox').attr('disabled','disabled');
    	});
    	
    	$('input[type="checkbox"]').on('change', function(e){
            if ( $(this).prop('checked') ) {
            	$(this).next().val(1);
            } else {
            	$(this).next().val(0);
            }
    	});
    	
    	// Show / hide all dependent fields
    	$( 'input.has-dependents' ).each( function() {
    		super_simple_slider_toggle_depdents.call( $( this ) );
    	});
    	
    	$( 'input.has-dependents' ).on('change', function(e){
    		super_simple_slider_toggle_depdents.call( e.target );
    	});
    	
    	$('#super_simple_slider_slide_overlay_opacity').on( 'change', function() {
    	});
    	
		// Tabs
		$( '.otb-tabs-container .tabs li a' ).click( function(e) {
			e.preventDefault();
			
			if ( !$(this).hasClass( 'active' ) ) {
				var tabContainer = $( this ).parents( '.otb-tabs-container' );
				var tabSelector  = $( this ).data( 'tab' );
			
				tabContainer.find( '.tabs li a' ).removeClass( 'active' );
				$(this).addClass('active');
				
				tabContainer.find( '.tab-content' ).hide();
				tabContainer.find( '.tab-content.' + tabSelector ).fadeIn( 'slow' );
			}
		});

        $( '.otb-form-control-dropdown_pages_posts' ).each( function() {
        	super_simple_slider_toggle_slider_link_custom_field.call( $(this) );
        });
        $( '.otb-form-control-dropdown_pages_posts' ).on( 'change', function() {
        	super_simple_slider_toggle_slider_link_custom_field.call( $(this) );
        });

    	// Uploading files
    	var file_frame;

    	$.fn.upload_image = function( button ) {
    		var media_uploader = button.parents('.media-uploader');
    		
    		// Create the media frame.
    		file_frame = wp.media.frames.file_frame = wp.media({
    			title: $( this ).data( 'uploader_title' ),
  				button: {
  					text: $( this ).data( 'uploader_button_text' ),
  				},
  				multiple: false
    		});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				var attachment = file_frame.state().get('selection').first().toJSON();
    		  
				media_uploader.find('input[type="hidden"]').val(attachment.id);
  				media_uploader.find('img').attr('src', attachment.url);
  				media_uploader.find('img').attr('srcset', attachment.url);
  				media_uploader.addClass('has-img');
			});

    		// Finally, open the modal
    		file_frame.open();
    	};

    	// On click upload image button
    	$('.media-uploader').on( 'click', '.button.upload', function( event ) {
    		event.preventDefault();
    		$.fn.upload_image( $(this) );
    	});

    	// On click delete image button
    	$('.media-uploader').on( 'click', '.delete', function( event ) {
			event.preventDefault();
			var media_uploader = $(this).parents('.media-uploader');

    		media_uploader.removeClass( 'has-img' );
    		media_uploader.find("input[type='hidden']").val('');
    	});            
        
	    function super_simple_slider_toggle_slider_link_custom_field() {
	    	if ( $(this).val() == 'custom' ) {
	    		$(this).parents('.button-fields').find( '.link_custom_url' ).show();
	    	} else {
	    		$(this).parents('.button-fields').find( '.link_custom_url' ).hide();
	    	}
	    }
	    
		// Add a new button
		$( '.add-button' ).on( 'click', function(e) {
			e.preventDefault();
			$(this).parents( '.buttons' ).find( '.button-fields:hidden' ).first().slideDown(200, function() {
				$(this).removeClass('hidden');
			});
			
			if ( $(this).parents( '.buttons' ).find( '.button-fields:hidden' ).length == 0 ) {
				$(this).addClass( 'disabled' );
			}
		});

		// Delete a button
		$( '.delete-button' ).on( 'click', function(e) {
			e.preventDefault();

			var button_fields_container = $(this).parents( '.buttons' );
			var button_fields 			= $(this).parents( '.button-fields' );
			
			button_fields.first().slideUp(200, function() {
				button_fields.find('input[type=text], input[type=url]').val('');
				button_fields.find('select').prop('selectedIndex', 0);
				super_simple_slider_toggle_slider_link_custom_field.call( button_fields.find( '.otb-form-control-dropdown_pages_posts' ) );
			} );
			
			if ( button_fields_container.find( '.button-fields:visible' ).length > 0 ) {
				button_fields_container.find( '.add-button' ).removeClass('disabled');
			}
		});
		
		// Add a new repeatable panel
		$( '.add-repeatable-panel' ).on( 'click', function() {
			var panel = $( '.otb-panel-container .panel:last' ).clone(true);
			panel.removeClass( 'hidden' );
			panel.insertBefore( '.otb-panel-container .panel:last' );
			return false;
		});
		
		// Remove a repeatable panel
		$( '.remove-repeatable-panel .icon' ).on( 'click', function() {
			$(this).parents('.panel').remove();
			return false;
		});

		// Show / hide the dependent fields
		function super_simple_slider_toggle_depdents() {
			
			switch ( $( this ).data('fieldId') ) {
				case 'super_simple_slider_display_directional_buttons':
					if ( $( this ).prop('checked') ) {
						$( '.super_simple_slider_display_directional_button_settings' ).slideDown({
							duration: 200,
							easing: 'linear' 
						});
					} else {
						$( '.super_simple_slider_display_directional_button_settings' ).slideUp({
							duration: 200,
							easing: 'linear' 
						});
					}
					
					break;

				case 'super_simple_slider_has_min_width':
					if ( $( this ).prop('checked') ) {
						$( '.super_simple_slider_min_width_settings' ).slideDown({
							duration: 200,
							easing: 'linear' 
						});
					} else {
						$( '.super_simple_slider_min_width_settings' ).slideUp({
							duration: 200,
							easing: 'linear' 
						});
					}
	
					break;
					
				case 'super_simple_slider_slideshow':
					if ( $( this ).is( ':checked' ) ) {
					//if ( $( this ).prop('checked') ) {
						$( '.super_simple_slider_slideshow_settings' ).slideDown({
							duration: 200,
							easing: 'linear' 
						});
					} else {
						$( '.super_simple_slider_slideshow_settings' ).slideUp({
							duration: 200,
							easing: 'linear' 
						});
					}
	
					break;
			}
			
		}
		
		// Copy the slider shortcode
		$( '.copy' ).click( function(e) {
			$( this ).prev( 'input' ).select();
			document.execCommand( 'copy' );
			document.getSelection().removeAllRanges();

			$( '.text-input-with-button-container' ).addClass( 'show-message' );
			
			setTimeout(function () {
				$( '.text-input-with-button-container' ).removeClass( 'show-message' );
			}, 2000);
		});

    });

})(jQuery);
