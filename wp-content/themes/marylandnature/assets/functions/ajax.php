<?php

add_action( 'wp_ajax_get_events', 'get_events' );
add_action( 'wp_ajax_nopriv_get_events', 'get_events' );
function get_events() {
	//check_ajax_referer( 'nhsm-fc-events', 'security' );
	
	//get vars
	$start_max = isset($_REQUEST['start']) ? $_REQUEST['start'] : false;
	$end_max = isset($_REQUEST['end']) ? $_REQUEST['end'] : false;
	$cat_ids = isset($_REQUEST['cat_ids']) ? $_REQUEST['cat_ids'] : false;
	$topics = isset($_REQUEST['topics']) ? $_REQUEST['topics'] : false;
	
	$ret = array();
	$args = array(
		'post_type' => 'nhsm_event'
	);
	$e = new WP_Query( $args );

	if ( $e->have_posts() ) {
		// The 2nd Loop
		while ( $e->have_posts() ) {
			$e->the_post();
			
			$startdate = get_field('nhsm_event_start');
			$starttime = get_field('nhsm_event_start_time');
			$enddate = get_field('nhsm_event_end');
			$endtime = get_field('nhsm_event_end_time');

			$startmoment = $starttime ? $startdate . 'T' . date('H:i:s', strtotime($starttime)) : $startdate;
			$endmoment = $endtime ? $enddate . 'T' . date('H:i:s', strtotime($endtime)) : $enddate;
			
			ob_start();
			get_template_part( 'parts/event', 'tooltip' );
			$tooltip = ob_get_clean();
			
			$append_to_title = false;
			$class = 'default';
			$bg_color = false;
			$cats = get_the_terms(get_the_ID(), 'nhsm_event_category');
			if(!is_array($cats)) $cats = array();
			if(count($cats) == 1){
				$class = $cats[0]->slug . '_bgcolor';
				$label_bg_color = get_term_meta( $cats[0]->term_id, '_label_bg_color', true );
				if( ! empty( $label_bg_color ) ) $bg_color =  "#{$label_bg_color}";
			}
			elseif(count($cats > 1)){
				$cat_icons = '';
				foreach($cats as $cat){
					$bg_color = get_term_meta( $cat->term_id, '_label_bg_color', true );
					$cat_icons .= sprintf('<span style="background:#%1$s" title="%2$s"><span class="show-for-sr">%2$s</span></span>', $bg_color, $cat->name);
				}
				$append_to_title = sprintf('<span class="fc-cats">%s</span>', $cat_icons);
			}
			$cat_list = array();
			foreach($cats as $cat) $cat_list[] = $cat->slug;
			
			$ret[] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'allDay' => empty($starttime),
				'start' => $startmoment,
				'end' => $endmoment,
				//'url' => get_permalink(),
				'editable' => false,
				'description' => get_the_content(),
				'tooltip' => trim($tooltip),
				'className' => $class,
				'color' => $bg_color,
				'appendToTitle' => $append_to_title,
				'cats' => implode(',',$cat_list)
			);
		}

		// Restore original Post Data
		wp_reset_postdata();
	}
	
	wp_send_json($ret);
	
	wp_die();
}