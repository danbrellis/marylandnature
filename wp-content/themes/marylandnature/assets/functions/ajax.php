<?php

add_action( 'wp_ajax_get_events', 'get_events' );
add_action( 'wp_ajax_nopriv_get_events', 'get_events' );
function get_events() {
	//check_ajax_referer( 'nhsm-fc-events', 'security' );
	
	//get vars
	$start_max = isset($_REQUEST['start']) ? $_REQUEST['start'] : false;
	$end_max = isset($_REQUEST['end']) ? $_REQUEST['end'] : false;
	$topics = isset($_REQUEST['topics']) ? $_REQUEST['topics'] : false;
		
	$eventData = array();
	$args = array(
		'post_type' => 'event'
	);
	
	if(isset($_REQUEST['cats']) && !empty($_REQUEST['cats'])) {
		$tax_query = array();
		$cats = explode(' ', $_REQUEST['cats']);
		if($cats && is_array($cats) && !empty($cats)){
			$tax_query[0]['taxonomy'] = 'event-category';
			$tax_query[0]['field'] = 'slug';
			$tax_query[0]['terms'] = $cats;
		}
		$args['tax_query'] = $tax_query;
	}
	$e = new WP_Query( $args );
	if ( $e->have_posts() ) {
		// The 2nd Loop
		while ( $e->have_posts() ) {
			$e->the_post();
			
			$id = get_the_ID();
			
			$allday = get_post_meta($e->post->ID, '_event_all_day', true);
			$startmoment = get_post_meta($e->post->ID, '_event_start_date', true);
			$endmoment = get_post_meta($e->post->ID, '_event_end_date', true);

			ob_start();
			get_template_part( 'parts/event', 'tooltip' );
			$tooltip = ob_get_clean();
			
			//defaults
			$append_to_title = false;
			$cat_icons = '';
			$backgroundColor = '#666666';
			$textColor = '#ffffff';

			$event_categories = wp_get_post_terms( $id, 'event-category' );
			if(!empty( $event_categories ) && !is_wp_error( $event_categories )){
				if(count($event_categories) == 1){
					$backgroundColor = '#' . get_term_meta( $event_categories[0]->term_id, '_label_bg_color', true );
					$textColor = '#' . get_term_meta( $event_categories[0]->term_id, '_label_txt_color', true );
				}
				else {
					
					foreach($event_categories as $cat){
						$bg_color = get_term_meta( $cat->term_id, '_label_bg_color', true );
						$cat_icons .= sprintf('<span style="background:#%1$s" title="%2$s"><span class="show-for-sr">%2$s</span></span>', $bg_color, $cat->name);
					}
					$append_to_title = sprintf('<span class="fc-cats">%s</span>', $cat_icons);
				}
			}
			
			$eventData[] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
			  'allDay' => $allday !== 1 ? false : true,
			  'start' => $startmoment,
			  'end' => $endmoment,
			  'tooltip' => trim($tooltip),
			  'appendToTitle' => $append_to_title,
				//'url' => get_permalink(),
			  'editable' => false,
			  'description' => get_the_content(),
				'backgroundColor' => $backgroundColor,
				'textColor' => $textColor
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
    'hide_empty' => false,
	) );
	ob_start();
	if($terms && !is_wp_error($terms)): ?>
		<button class="button secondary dropdown float-right" type="button" data-toggle="event-cat-filter">Category Filtering [<span id="cal-filtered">Off</span>]</button>
		<div class="dropdown-pane bottom" id="event-cat-filter" data-dropdown data-auto-focus="true">
			<ul class="menu vertical">
					<?php foreach($terms as $term): 
						$bg_color = get_term_meta( $term->term_id, '_label_bg_color', true );
						$txt_color = get_term_meta( $term->term_id, '_label_txt_color', true ); ?>
						<li><label for="cat_<?php echo $term->slug; ?>" class="label dynamic" style="color: #<?php echo $txt_color; ?>; background-color: #<?php echo $bg_color; ?>"><?php echo $term->name; ?><input type="checkbox" id="cat_<?php echo $term->slug; ?>" class="invisible" /><i></i></label></li>
					<?php endforeach; ?>
				</ul>
		</div>
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
        $credit = nhsm_img_title_and_credit(false, $post_id, true, false);
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