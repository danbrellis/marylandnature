<?php

function nhsm_wp_footer(){
	$min = WP_DEBUG ? '' : '.min';
	// Adding scripts file in the footer
	if(wp_script_is('events-maker-front-calendar') === true){
		wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/scripts'.$min.'.js', array( 'jquery', 'events-maker-front-calendar' ), '', true );
	}
	else wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/scripts'.$min.'.js', array( 'jquery' ), '', true );
}
add_action('wp_footer', 'nhsm_wp_footer');

function site_scripts() {
  $min = WP_DEBUG ? '' : '.min';
	//global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

	// Load What-Input files in footer
	wp_enqueue_script( 'what-input', get_template_directory_uri() . '/vendor/what-input/what-input'.$min.'.js', array(), '', true );

	// Adding Foundation scripts file in the footer
	wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/js/foundation'.$min.'.js', array( 'jquery' ), '6.2.3', true );
	
	// Adding Foundation scripts file in the footer
	//wp_enqueue_script( 'addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59381c0334485fd7', array(), '', true );

	// Register main stylesheet
	wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/css/style'.$min.'.css', array(), '', 'all' );

	// Comment reply script for threaded comments
	if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
		wp_enqueue_script( 'comment-reply' );
	}

	//Calendar Scripts (enqueued in calendar shortcode)
	//wp_register_script('moment', get_template_directory_uri() . '/assets/js/scripts/fullcalendar/lib/moment.min.js', array(), '2.17.1', true);
	//wp_register_script('fullcalendar', get_template_directory_uri() . '/assets/js/scripts/fullcalendar/fullcalendar'.$min.'.js', array('jquery', 'moment'), '3.0.0', true);
	//wp_enqueue_style('fullcalendar', get_template_directory_uri() . '/assets/js/scripts/fullcalendar/fullcalendar'.$min.'.css', array(), '3.0.0');
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);

function nhsm_category_colorpicker_enqueue( $taxonomy ) {
	$bases = array('term', 'edit-tags');
	if( null !== ( $screen = get_current_screen() ) && !in_array($screen->base, $bases) )
		return;

	// Colorpicker Scripts
	wp_enqueue_script( 'wp-color-picker' );

	// Colorpicker Styles
	wp_enqueue_style( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'nhsm_category_colorpicker_enqueue' );

function colorpicker_init_inline() {
	$bases = array('term', 'edit-tags');
	if( null !== ( $screen = get_current_screen() ) && !in_array($screen->base, $bases) )
		return;
	?>
	<script>
		
		jQuery( document ).ready( function( $ ) {
			//colorpicker for labels
			var sample = $('span.label.dynamic');
			$( '.colorpicker' ).wpColorPicker({
				change: function (event, ui) {
					var element = event.target;
					var color = ui.color.toString();
					sample.css($(element).data('style-modifier'), color);
					
				},
				clear: function (event) {
					var element = jQuery(event.target).siblings('.wp-color-picker')[0];
					var color = '';

					if (element) {
						sample.css($(element).data('style-modifier'), "");
					}
				}
			});
			
			//media uploader
			function ct_media_upload(button_class) {
				var _custom_media = true,
				_orig_send_attachment = wp.media.editor.send.attachment;
				$('body').on('click', button_class, function(e) {
					var button_id = '#'+$(this).attr('id');
					var send_attachment_bkp = wp.media.editor.send.attachment;
					var button = $(button_id);
					_custom_media = true;
					wp.media.editor.send.attachment = function(props, attachment){
						if ( _custom_media ) {
							$('#category_image_id').val(attachment.id);
							$('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
							$('#category-image-wrapper .custom_media_image').attr('src',attachment.sizes.thumbnail.url).css('display','block');
						} else {
							return _orig_send_attachment.apply( button_id, [props, attachment] );
						}
					}
					wp.media.editor.open(button);
					return false;
				});
			}
			
			ct_media_upload('.ct_tax_media_button.button'); 
		  $('body').on('click','.ct_tax_media_remove',function(){
			  $('#category_image_id').val('');
			  $('#category-image-wrapper').html('<img class="custom_media_image" src=""  style="margin:0;padding:0;max-height:100px;float:none;" />');
		  });
			
			$(document).ajaxComplete(function(event, xhr, settings) {
				var queryStringArr = settings.data.split('&');
				if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
					var xml = xhr.responseXML;
					$response = $(xml).find('term_id').text();
					if($response!=""){
						// Clear the thumb image
						$('#category-image-wrapper').html('');
					}
				}
			});
			
		} );
	</script>
	<style type="text/css">
		.label.dynamic {
			display: inline-block;
			padding: 0.33333rem 0.5rem;
			border-radius: 0;
			font-size: 0.8rem;
			line-height: 1;
			white-space: nowrap;
			cursor: default;
		}
	</style>
	<?php
}
add_action( 'admin_print_scripts', 'colorpicker_init_inline', 20 );

