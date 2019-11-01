<?php

add_action( 'wp_ajax_get_events', 'get_events' );
add_action( 'wp_ajax_nopriv_get_events', 'get_events' );
function get_events() {
	//check_ajax_referer( 'nhsm-fc-events', 'security' );
		
	$eventData = [];

    $args = array(
        'event_start_after'		    => '',
        'event_start_before'		=> '',
        'event_end_after'			=> '',
        'event_end_before'		    => '',
        'event_ondate'			    => '',
        'event_date_range'		    => 'between',
        'event_date_type'			=> 'all',
        'event_ticket_type'		    => 'all',
        'event_show_past_events'    => true, // show by default
        'event_show_occurrences'	=> Events_Maker()->options['general']['show_occurrences'],
        'post_type'			        => 'event',
        'author'			        => '',
        'posts_per_page'            => -1
    );

    if(isset($_REQUEST['cats']) && !empty($_REQUEST['cats'])) {
        $cats = explode('+', $_REQUEST['cats']);
        if($cats && is_array($cats) && !empty($cats)){
            $args['tax_query'][] = array(
                'taxonomy'			 => 'event-category',
                'field'				 => 'slug',
                'terms'				 => $cats,
                'include_children'	 => false
            );

        }
    }

    // calendar events query
    $args = apply_filters( 'em_get_full_calendar_events_args', $args );

	$e = new WP_Query( $args );
	if ( $e->have_posts() ) {
		// The 2nd Loop
		while ( $e->have_posts() ) {
			$e->the_post();
			$event = $e->post;

			$allday = em_is_all_day( $event->ID );

            if ( em_is_recurring( $event->ID ) && Events_Maker()->options['general']['show_occurrences'] ) {
                $start = $event->event_occurrence_start_date;
                $end = $event->event_occurrence_end_date;
            } else {
                $start = $event->_event_start_date;
                $end = $event->_event_end_date;
            }

			ob_start();
			get_template_part( 'parts/event', 'tooltip' );
			$tooltip = ob_get_clean();

			//defaults
			$append_to_title = false;
            $event_data['backgroundColor'] = '';
            $event_data['textColor'] = '';

			$eventData[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'allDay' => $allday,
                'start' => $start,
                'end' => $end,
                'tooltip' => trim($tooltip),
                'appendToTitle' => $append_to_title,
                //'url' => get_permalink(),
                'editable' => false,
                //'description' => get_the_content()
			);
		}

		// Restore original Post Data
		wp_reset_postdata();
	}
	
	wp_send_json($eventData);
	
	wp_die();
}

add_action( 'wp_ajax_get_event_cat_filters', 'get_event_cat_filters' );
add_action( 'wp_ajax_nopriv_get_event_cat_filters', 'get_event_cat_filters' );
function get_event_cat_filters(){
	check_ajax_referer( 'cedar-waxwing', 'security' );
	$terms = get_terms( array(
    'taxonomy' => 'event-category',
    'hide_empty' => true,
	) );
	ob_start();
	if($terms && !is_wp_error($terms)): ?>
        <strong>Filter: </strong>
        <ul class="event-cat-filter__list" id="event-cat-filter">
            <?php foreach($terms as $term): ?>
                <li class="event-cat-filter__item">
                    <input type="checkbox" id="cat_<?php echo $term->slug; ?>" class="" />
                    <label for="cat_<?php echo $term->slug; ?>" class="dynamic event-cat-filter__label">
                        <?php echo $term->name; ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
		<?php
		$json['error'] = false;
		$json['output'] = ob_get_clean();
	else:
		$json['error'] = true;
		$json['output'] = $terms;
	endif;
	echo wp_send_json($json);
	die();
}

add_action( 'wp_ajax_get_img_credit', 'ajax_get_img_credit' );
add_action( 'wp_ajax_nopriv_get_img_credit', 'ajax_get_img_credit' );
function ajax_get_img_credit(){
  $json = array();
  check_ajax_referer( 'mountain-mint', 'security' );
  $items = isset($_REQUEST['items']) ? json_decode(stripslashes($_REQUEST['items'])) : array();
  //echo '<pre>'; var_dump($items); echo '</pre>';
  $credits = array();
  if(is_array($items)){
    foreach($items as $item){
      $post_id = attachment_url_to_postid($item->bg);
      if($post_id){
        $credit = nhsm_img_credit_and_caption(false, $post_id);
        $credits[] = '<span class="lg_img_caption">' . $credit . '</span>';
      }
    }
  }
  //echo '<pre>'; var_dump($items); echo '</pre>';
  if(empty($credits)){
    $json['error'] = true;
    $json['output'] = 'No background images found';
  }
  else {
    $json['error'] = false;
    $json['output'] = $credits;
  }
  echo wp_send_json($json);
  die();
}