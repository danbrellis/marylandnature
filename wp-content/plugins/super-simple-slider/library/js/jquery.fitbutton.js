/*global jQuery */
/*!
* FitButton.js 1.0
*
* Copyright 2017, Out the Box https://www.outtheboxthemes.com
* A variation on the FitText jQuery plugin by Dave Rupert http://daverupert.com
* Released under the WTFPL license
* http://sam.zoy.org/wtfpl/
*
*/

(function( $ ){

  $.fn.superSimpleSliderFitButton = function( kompressor, options ) {

    // Setup options
    var compressor = kompressor || 1,
        settings = $.extend({
          'minFontSize' : Number.NEGATIVE_INFINITY,
          'maxFontSize' : Number.POSITIVE_INFINITY,
          'minHorizontalPadding' : Number.NEGATIVE_INFINITY,
          'maxHorizontalPadding' : Number.POSITIVE_INFINITY,
          'minVerticalPadding' : Number.NEGATIVE_INFINITY,
          'maxVerticalPadding' : Number.POSITIVE_INFINITY
        }, options);

    return this.each(function(){

      // Store the object
      var $this = $(this);

      // Resizer() resizes items based on the object width divided by the compressor * 10
      var resizer = function () {
    	  $this.find('a.button, button').css('font-size', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxFontSize)), parseFloat(settings.minFontSize)));
    	  $this.find('a.button, button').css('padding-left', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxHorizontalPadding)), parseFloat(settings.minHorizontalPadding)));
    	  $this.find('a.button, button').css('padding-right', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxHorizontalPadding)), parseFloat(settings.minHorizontalPadding)));
    	  $this.find('a.button, button').css('padding-top', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxVerticalPadding)), parseFloat(settings.minVerticalPadding)));
    	  $this.find('a.button, button').css('padding-bottom', Math.max(Math.min($this.width() / (compressor*10), parseFloat(settings.maxVerticalPadding)), parseFloat(settings.minVerticalPadding)));
      };

      // Call once to set.
      resizer();

      // Call on resize. Opera debounces their resize by default.
      $(window).on('resize.fitbutton orientationchange.fitbutton', resizer);

    });

  };

})( jQuery );
