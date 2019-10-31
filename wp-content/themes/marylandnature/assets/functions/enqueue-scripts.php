<?php

function nhsm_wp_footer(){
	$min = WP_DEBUG ? '' : '.min';
	// Adding scripts file in the footer
  
  //get cal pages
  $events_maker_general = get_option('events_maker_general', array());
  $local = array(
    'ajax_url' => admin_url( 'admin-ajax.php'),
    'cal_security' => wp_create_nonce( "cedar-waxwing" ),
    'img_credit_security' => wp_create_nonce( "mountain-mint" ),
    'calendar_url' => get_permalink($events_maker_general['pages']['calendar']['id']),
    'agenda_url' => get_permalink($events_maker_general['pages']['events']['id'])
  );
	if(wp_script_is('events-maker-front-calendar') === true){
    //remove plugin's version and use theme's udated version
    wp_deregister_script( 'events-maker-fullcalendar' );
    wp_register_script('events-maker-fullcalendar', get_template_directory_uri() . '/assets/js/scripts/fullcalendar/fullcalendar.js', array( 'jquery', 'events-maker-moment' ), '3.3.0');
    
		wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/js/scripts'.$min.'.js', array( 'jquery', 'events-maker-front-calendar' ), '', true );
		wp_localize_script(
			'events-maker-front-calendar',
			'nhsm_ajax',
			$local
		);
	}
	else {
    wp_enqueue_script('site-js', get_template_directory_uri() . '/assets/js/scripts' . $min . '.js', array('jquery'), '', true);
    wp_localize_script(
      'site-js',
      'nhsm_ajax',
      $local
    );
  }
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
	wp_enqueue_script( 'addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59381c0334485fd7', array(), '', true );

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

