<?php

function nhsm_wp_loaded(){
    remove_shortcode('em-full-calendar');
    add_shortcode('em-full-calendar', 'nhsm_full_calendar');
}
add_action('wp_loaded', 'nhsm_wp_loaded');

function nhsm_scrolling_text( $atts, $content ) {
	$words = array_map('trim', explode(',', $content));
	$retval = '';
	if(!empty($words)){
		$retval = '<ul class="nhsm_scrolling_words data-animate">';
		foreach($words as $w) $retval .= '<li class="data-animate">' . $w . '</li>';
		$retval .= '</ul>';
	}
	return $retval;

}
add_shortcode( 'scrolling_text', 'nhsm_scrolling_text' );

function nhsm_resource_search($atts, $placeholder){
	$form = sprintf('<form><input type="text" placeholder="%s" /><button type="submit"><i class="fi-play"></i></button></form>', $placeholder);
	return $form;
}
add_shortcode( 'resource-search', 'nhsm_resource_search' );

function nhsm_icon($atts){
	$a = shortcode_atts( array(
		'name' => '',
		'bg' => 'true',
		'library' => 'fi' //fa = font-awesome, fi = foundation icons
	), $atts );
	$classes = array('nhsm-icon');
	
	if($a['bg'] == 'true') $classes[] = 'circle';
	$classes[] = $a['name'];
	if($a['library'] == 'fa') $classes[] = 'fa';
	
	$icon = '<i class="'.implode($classes, ' ') . '" aria-hidden="true"></i>';
	
	return $icon;
}
add_shortcode( 'icon', 'nhsm_icon' );

function nhsm_full_calendar( $args ) {
    $start_after = new DateTime('first day of this month');
    $start_after->modify('-1 week');
    $start_before = new DateTime('last day of this month');
    $start_before->modify('+1 week');
    $defaults = array(
        'start_after'		 => $start_after->format('Y-m-d'),
        'start_before'		 => $start_before->format('Y-m-d'),
        'end_after'			 => '',
        'end_before'		 => '',
        'ondate'			 => '',
        'date_range'		 => 'between',
        'date_type'			 => 'all',
        'ticket_type'		 => 'all',
        'show_past_events'	 => true, // show by default
        'show_occurrences'	 => Events_Maker()->options['general']['show_occurrences'],
        'categories'		 => '',
        'locations'			 => '',
        'organizers'		 => '',
        'post_type'			 => 'event',
        'author'			 => ''
    );

    // parse arguments
    $args = shortcode_atts( $defaults, $args );

    // make strings
    $args['start_after'] = (string) $args['start_after'];
    $args['start_before'] = (string) $args['start_before'];
    $args['end_after'] = (string) $args['end_after'];
    $args['end_before'] = (string) $args['end_before'];
    $args['ondate'] = (string) $args['ondate'];

    // valid date range?
    if ( ! in_array( $args['date_range'], array( 'between', 'outside' ), true ) )
        $args['date_range'] = $defaults['date_range'];

    // valid date type?
    if ( ! in_array( $args['date_type'], array( 'all', 'all_day', 'not_all_day' ), true ) )
        $args['date_type'] = $defaults['date_type'];

    // valid ticket type?
    if ( ! in_array( $args['ticket_type'], array( 'all', 'free', 'paid' ), true ) )
        $args['ticket_type'] = $defaults['ticket_type'];

    // make bitwise integers
    $args['show_past_events'] = (bool) (int) $args['show_past_events'];
    $args['show_occurrences'] = (bool) (int) $args['show_occurrences'];

    $authors = $users = array();

    if ( trim( $args['author'] ) !== '' )
        $users = explode( ',', $args['author'] );

    if ( ! empty( $users ) ) {
        foreach ( $users as $author ) {
            $authors[] = (int) $author;
        }

        // remove possible duplicates
        $args['author__in'] = array_unique( $authors );
    }

    // unset author argument
    unset( $args['author'] );

    // set new arguments
    $args['event_start_after'] = $args['start_after'];
    $args['event_start_before'] = $args['start_before'];
    $args['event_end_after'] = $args['end_after'];
    $args['event_end_before'] = $args['end_before'];
    $args['event_ondate'] = $args['ondate'];
    $args['event_date_range'] = $args['date_range'];
    $args['event_date_type'] = $args['date_type'];
    $args['event_ticket_type'] = $args['ticket_type'];
    $args['event_show_past_events'] = $args['show_past_events'];
    $args['event_show_occurrences'] = $args['show_occurrences'];

    // unset old arguments
    unset( $args['start_after'] );
    unset( $args['start_before'] );
    unset( $args['end_after'] );
    unset( $args['end_before'] );
    unset( $args['ondate'] );
    unset( $args['date_range'] );
    unset( $args['date_type'] );
    unset( $args['ticket_type'] );
    unset( $args['show_past_events'] );
    unset( $args['show_occurrences'] );

    if ( ! empty( $args['categories'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy'			 => 'event-category',
            'field'				 => 'id',
            'terms'				 => explode( ',', $args['categories'] ),
            'include_children'	 => false,
            'operator'			 => 'IN'
        );
    }

    if ( ! empty( $args['locations'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy'			 => 'event-location',
            'field'				 => 'id',
            'terms'				 => explode( ',', $args['locations'] ),
            'include_children'	 => false,
            'operator'			 => 'IN'
        );
    }

    if ( ! empty( $args['organizers'] ) ) {
        $args['tax_query'][] = array(
            'taxonomy'			 => 'event-organizer',
            'field'				 => 'id',
            'terms'				 => explode( ',', $args['organizers'] ),
            'include_children'	 => false,
            'operator'			 => 'IN'
        );
    }

    unset( $args['categories'] );
    unset( $args['locations'] );
    unset( $args['organizers'] );

    wp_enqueue_style('nhsm_calendar_css' );
    wp_enqueue_script('nhsm_calendar_app' );

    // calendar events query
    $args = apply_filters( 'em_get_full_calendar_events_args', $args );

    // script args
    $events_maker_general = get_option('events_maker_general', []);
    $default_date = (($fc_year = get_query_var( 'fc_year' )) !== '') ? $fc_year : date('Y');
    $default_date .= (($fc_month = get_query_var( 'fc_month' )) !== '') ? '-' . $fc_month : '-' . date('m');
    $script_args = apply_filters( 'em_get_full_calendar_script_args', [
        'customButtons'     => [
            'agendaview'        => ['text' => 'List View']
        ],
        'firstWeekDay'	 	=> ( Events_Maker()->options['general']['first_weekday'] === 7 ? 0 : 1 ),
        'header'			=> [
            'left'				=> 'agendaview',
            'center'			=> 'prev next title',
            'right'             => false
        ],
        'defaultDate'       => $default_date,
        'ajax_url'          => admin_url( 'admin-ajax.php'),
        'cal_security'      => wp_create_nonce( "cedar-waxwing" ),
        'calendar_url'      => get_permalink($events_maker_general['pages']['calendar']['id']),
        'agenda_url'        => get_permalink($events_maker_general['pages']['events']['id'])
    ] );

    wp_localize_script(
        'nhsm_calendar_app', 'emCalendarArgs', json_encode( $script_args )
    );

    $html = '<div id="events-full-calendar" class="nhsm-calendar"></div>';

    return apply_filters( 'em_shortcode_full_calendar', $html );
}

function nhsm_wa_iframe($atts){
    $a = shortcode_atts( array(
        'src' => false,
        'width' => '100%',
        'class' => ''
    ), $atts );
    $a['class'] = $a['class'] . ' wildapricotframe';
    ob_start(); ?>
    <iframe
        class="<?php echo $a['class']; ?>"
        src="<?php echo $a['src']; ?>"
        width="<?php echo $a['width']; ?>"
        height="400"
        frameborder="no"
        scrolling="yes"
        onload='tryToEnableWACookies("https://marylandnature.wildapricot.org");'></iframe>
    <?php
    $retval = ob_get_clean();
    wp_enqueue_script('wa-enable-cookies', 'https://marylandnature.wildapricot.org/Common/EnableCookies.js');
    return $retval;
}
add_shortcode('wildapricot_iframe', 'nhsm_wa_iframe');