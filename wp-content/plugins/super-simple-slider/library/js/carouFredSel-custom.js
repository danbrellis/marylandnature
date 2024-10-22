/**
 * 
 *
 *  @package Super Simple Slider/library/js
 */

( function( $ ) {

	SuperSimpleSlider = function( selector, options ) {
	    var settings = {};
	    var defaults = {
	    };
	    
	    settings = $.extend( defaults, options );
	    
        $( selector + ' .super-simple-slider').carouFredSel({
            responsive: true,
            circular: true,
            infinite: false,
            //width: 1200,
            height: 'variable',
            items: {
                visible: 1,
                //width: 1200,
                height: 'variable'
            },
            onCreate: function(items) {
            	super_simple_slider_init_fittext();
            	super_simple_slider_init_fitbutton();
            	super_simple_slider_scale_slider_controls();
    			
            	$(selector).css('height', 'auto');
            	$(selector).removeClass('loading');
            	
        		super_simple_slider_set_slider_controls_visibility();
        		super_simple_slider_constrain_text_overlay_opacity();
            },
            scroll: {
                fx: 'uncover-fade',
                duration: settings['speed'],
            },
            auto: false,
            pagination: selector + ' .super-simple-slider-pagination',
            prev: selector + ' .prev',
            next: selector + ' .next',
            swipe: {
            	onTouch: true
            }
        });
	}

} )( jQuery );