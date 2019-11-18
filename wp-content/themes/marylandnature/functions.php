<?php



/* @todo
	* Format templates/pages for:
		- single event (adding meetup link, meta, and pull in resources related to that event cat)
	* Resources
	  - Add filter to cat pages (search by title, tag): http://localhost:3000/marylandnature/downloads/program-resources/
	* Search
		- Remove homepage (and others) from results (maybe use plugin below)
		- Add filtering (like tag archive) & incorporate plugin for better results
		- Add better meta in results for specific post types (collections, evfents)
	* Single Pages
		- Connecting Naturalists: http://localhost:3000/marylandnature/learn/connecting-naturalists/
*/


if (!is_admin() && !current_user_can( 'edit_others_posts' ) && $GLOBALS['pagenow'] !== 'wp-login.php' && MAINTENANCE) {
    require_once( get_template_directory() . '/maintenance.php' );
    die();
}


// Theme support options
require_once(get_template_directory().'/assets/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/assets/functions/cleanup.php');

// Register scripts and stylesheets
require_once(get_template_directory().'/assets/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/assets/functions/menu.php');

// Functions for handling and displaying media (including images)
require_once(get_template_directory().'/assets/functions/media.php');

// A place for all your shortcodes
require_once(get_template_directory().'/assets/functions/shortcodes.php'); 

// A place for AJAX-related functions
require_once(get_template_directory().'/assets/functions/ajax.php'); 

// Register sidebars/widget areass
require_once(get_template_directory().'/assets/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/assets/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/assets/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/assets/translation/translation.php'); 


// Remove 4.2 Emoji Support
// require_once(get_template_directory().'/assets/functions/disable-emoji.php'); 

// Adds site styles to the WordPress editor
require_once(get_template_directory().'/assets/functions/editor-styles.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/assets/functions/related-posts.php'); 

// Use this as a template for custom post types
require_once(get_template_directory().'/assets/functions/custom-post-type.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/assets/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/assets/functions/admin.php'); 

/*********************
 * CUSTOM FUNCTIONS
**********************/

/** Queries **/
/**
 * @param WP_Query $query
 * @return WP_Query $query
 */
function nhsm_pre_get_posts( $query ) {
	if($query->is_main_query() && !is_admin()){
		if ( is_post_type_archive('event') || is_tax('event-category') ) {
            $query->set('post_type', 'event');
            if(isset($_GET['show'])){
				$scope = sanitize_title($_GET['show']);
			}
			else $scope = 'upcoming';
			if($scope === 'past'){
				$query->set('event_show_past_events', true);
				$query->set('event_start_before', date('Y-m-d'));
				$query->set('event_date_range', 'between');
                $query->set('order', 'DESC');
			}
			elseif($scope === 'upcoming'){
                $query->set('event_show_past_events', false);
                $query->set('order', 'ASC');
			}

		}
	}

	if( $query->is_main_query() && is_search() && !is_admin()){
        //Exclude homepage from search
        $query->set('post__not_in', array(get_option('page_on_front')));

		//set search to only posts and pages (handle other post types in search template)
        $query->set('post_type', ['post', 'page']);
	}

	return $query;
}
add_action('pre_get_posts', 'nhsm_pre_get_posts', 9);

/** Rewrites **/
function nhsm_rewrite_tags() {
  global $wp;
  $wp->add_query_var( 'fc_year' );
  $wp->add_query_var( 'fc_month' );

  add_rewrite_tag( '%nhsm_events_year%', '([0-9]{4})' );
  add_rewrite_tag( '%nhsm_events_month%', '([0-9]{2})' );
  add_rewrite_rule('^get-involved/calendar(/([0-9]+))?(/([0-9]+))?/?', 'index.php?page_id=190&fc_year=$matches[2]&fc_month=$matches[4]', 'top');
}
add_action( 'init', 'nhsm_rewrite_tags' );

function nhsm_post_type_link($permalink, $post, $leavename) {
    if ( get_post_type( $post ) === "nhsm_event" ) {
        $sd = strtotime(get_field('nhsm_event_start', $post->ID));
        $year = date('Y', $sd);
        $month = date('m', $sd);

        $rewritecode = array(
            '%nhsm_events_year%',
            '%nhsm_events_month%',
            $leavename ? '' : '%postname%',
        );

        $rewritereplace = array(
            $year,
            $month,
            $post->post_name
        );

        $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
    }
    return $permalink;
}
add_filter( 'post_type_link', 'nhsm_post_type_link', 10, 4 );

/** Events **/
function nhsm_get_date_range_by_id($e){
    $event = get_post($e);
    if(!$event) return false;
    $start = strtotime(get_post_meta($event->ID, '_event_start_date', true));
    $end = strtotime(get_post_meta($event->ID, '_event_end_date', true));
    $allday = get_post_meta($event->ID, '_event_all_day', true);
    return nhsm_format_date_range($start, $end, boolval($allday));
}

/**
 * @param int $raw_start
 * @param int $raw_end
 * @param bool $allday
 * @return string
 */
function nhsm_format_date_range($raw_start, $raw_end, $allday = false){
    $retval = '';

    $start = date('Y', $raw_start) == date('Y') ? date('D, F j', $raw_start) : date('D, F j, Y', $raw_start);
    $end = date('Y', $raw_end) == date('Y') ? date('D, F j', $raw_end) : date('D, F j, Y', $raw_end);

	if(!$allday){
		$start_time = date('i', $raw_start) == '00' ? date('ga', $raw_start) : date('g:ia', $raw_start);
		$end_time = date('i', $raw_end) == '00' ? date('ga', $raw_end) : date('g:ia', $raw_end);
	}
	else $start_time = $end_time = '';
	
	if($start == $end || !$end){
		$retval = $start;
		
		if($start_time) {
			$retval .= ', ' . $start_time;
			
			if($end_time && !$start_time != $end_time){
				$retval .= ' - ' . $end_time;
			} 
		}
	}
	elseif($end) {
		$retval = $start;
		
		if($start_time) {
			$retval .= ', ' . $start_time;
		}
		
		$retval .= ' - ' . $end;
		if($end_time){
			$retval .= ' ' . $end_time;
		} 
	}
	
	return $retval;
	
}

/**
 * Returns an array with keys 'start' and 'end' for an event. If the event is a
 * recurrence, uses the closest upcoming occurrence, otherwise, uses the event's
 * date.
 * 
 * @param $e
 * @return array|bool
 */
function get_event_date_range($e){
    $event = get_post($e);
    if(!$event) return false;

    if($event->post_type !== 'event') return false;

    //set some defaults
    $start = get_post_meta($event->ID, '_event_start_date', true);
    $end = get_post_meta($event->ID, '_event_end_date', true);

    //get all recurrences, and use the most upcoming one
    $recurrences = get_post_meta($event->ID, '_event_occurrence_date');

    $now = date("U");
    $timefromnow = false;
    foreach($recurrences as $occurrence){
        $range = explode('|', $occurrence);
        $diff = strtotime($range[0]) - $now;

        //set most upcoming occurrence
        if((!$timefromnow || $diff < $timefromnow) && $diff > 0){
            $timefromnow = $diff;
            $start = $range[0];
            $end = $range[1];
        }
    }

    return ['start' => $start, 'end' => $end];
}
function nhsm_get_upcoming_event_date_range($e){
    $event = get_post($e);
    if(!$event) return false;

    if ( empty( $event->event_occurrence_start_date ) )
        return false;

    $dates = [
        'start' => $event->event_occurrence_start_date,
        'end' => $event->event_occurrence_end_date
    ];
    if(!$dates) return false;

    $allday = get_post_meta($event->ID, '_event_all_day', true);

    return nhsm_format_date_range(strtotime($dates['start']), strtotime($dates['end']), boolval($allday));
}

function nhsm_event_scope_prefix($after){
	$scope = isset($_GET['show']) ? sanitize_title($_GET['show']) : 'upcoming';
	if($scope == 'all') $h = __('All', 'conserva');
	elseif($scope == 'past') $h = __('Past', 'conserva');
	else $h = __('Upcoming', 'conserva');
	
	return $h . $after;
}

function nhsm_is_event_over($post_id = false){
	$post_id = (int) ( empty( $post_id ) ? get_the_ID() : $post_id );

	if ( empty( $post_id ) )
		return false;

	if(em_is_recurring($post_id)){
	    $dates = em_get_current_occurrence($post_id);
	    $end = strtotime($dates['end']);
    }
    else {
        $end = strtotime(em_get_the_date($post_id, ['range'=>'end','output'=>'datetime']));
    }

	if($end === false) return false;
	return $end < time();
}

/**
 * @param WP_Post $post
 * @param WP_Query $wp_query
 * @return WP_Post
 */
function nhsm_add_occurrence_data_to_post($post, $wp_query){
    if(is_single() && $post->post_type === 'event'){
        $dates = get_event_date_range($post);
        if($dates){
            $post->event_occurrence_start_date = $dates['start'];
            $post->event_occurrence_end_date = $dates['end'];
        }
    }
    return $post;
}
add_action('the_post', 'nhsm_add_occurrence_data_to_post', 10, 2);

/** Content **/
function nhsm_the_content_more_link() {
  add_filter('excerpt_more', '__return_false');
	$retval = '<div class="addthis_inline_share_toolbox float-right" data-url="' . get_permalink() . '" data-title="'.get_the_title() .'" data-description="'.get_the_excerpt().'" data-media="'.get_the_post_thumbnail_url(get_the_ID(), 'nhsm_banner').'"></div><a class="more-link button small" href="' . get_permalink() . '"><span aria-label="Continue reading '.get_the_title() .'">Read more</span></a>';
	remove_filter('excerpt_more', '__return_false');
	return $retval;

}
add_filter( 'the_content_more_link', '__return_false' );

function nhsm_addthis($args = []){
    $defaults = [
        'class' => 'float-right',
        'url' => get_permalink(),
        'title' => get_the_title(),
        'description' => get_the_excerpt(),
        'media' => get_the_post_thumbnail_url(get_the_ID(), 'nhsm_hbanner')
    ];
    $args = wp_parse_args($args, $defaults);
	?>
    <div class="<?php echo $args['class']; ?>">
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <div class="addthis_inline_share_toolbox"
             data-url="<?php echo esc_url($args['url']); ?>"
             data-title="<?php echo htmlentities($args['title'], ENT_QUOTES); ?>"
             data-description="<?php echo htmlentities($args['description'], ENT_QUOTES); ?>"
             data-media="<?php echo esc_url($args['media']); ?>"></div>
    </div>
    <?php
}

/** PLUGINS **/

/* Events Maker */
//removes event ticket/cost meta box
add_filter( 'em_event_metaboxes', 'nhsm_em_event_metaboxes', 10, 1);
function nhsm_em_event_metaboxes($metaboxes){
    unset($metaboxes['event-cost-tickets-box']);
    return $metaboxes;
}

//remove event tickets column
add_filter('manage_event_posts_columns', 'nhsm_manage_event_post_columns', 11, 1);
function nhsm_manage_event_post_columns($columns){
    unset($columns['tickets']);
    return $columns;
}

add_filter('em_calendar_event_data', 'nhsm_em_calendar_event_data', 10, 2);
function nhsm_em_calendar_event_data($event_data, $event){
	global $post;
	$post = get_post($event);
	setup_postdata( $post );
	
	$append_to_title = false;
    $event_data['backgroundColor'] = '';
    $event_data['textColor'] = '';

	ob_start();
	get_template_part( 'parts/event', 'tooltip' );
	$tooltip = ob_get_clean();
	
	$event_data['id'] = get_the_ID();
	$event_data['description'] = get_the_content();
	$event_data['tooltip'] = trim($tooltip);
	$event_data['appendToTitle'] = $append_to_title;
	unset($event_data['url']);
	
	wp_reset_postdata();
	return $event_data;
}

add_filter('em_get_full_calendar_script_args', 'nhsm_em_get_full_calendar_script_args');
function nhsm_em_get_full_calendar_script_args($args){
	if(isset($_GET['open'])) $args['defaultDate'] = sanitize_title_with_dashes($_GET['open']);
	$args['customButtons'] = array(
	  /*'calview' => array(
	    'text' => 'Calendar',
      'href' => '#foo'
    ),*/
    'agendaview' => array(
      'text' => 'List View'
    )
  );
	$args['columnFormat'] = 'dddd';
	$args['header']['right'] = '';
	$args['header']['left'] = 'agendaview';
	$args['header']['center'] = 'prev title next';
  
  $default_date = (($fc_year = get_query_var( 'fc_year' )) !== '') ? $fc_year : date('Y');
  $default_date .= (($fc_month = get_query_var( 'fc_month' )) !== '') ? '-' . $fc_month : '-' . date('m');
  $args['defaultDate'] = $default_date;
  
	return $args;	
}

add_filter('em_event_category_fields', 'nhsm_em_event_category_fields');
function nhsm_em_event_category_fields($fields){
	if(isset($fields['color'])) unset($fields['color']);
	return $fields;
}

/**
 * @param int $event_id
 * @return array
 */
function nhsm_em_event_terms_list($event_id = 0){
    $event = get_post($event_id);
    if(get_post_type($event) !== 'event') return [];
    $cats = get_the_terms($event->ID, 'event-category');
    $cat_list = [];

    if($cats && is_array($cats)){
        foreach($cats as $cat){
            $link = get_term_link( $cat, 'event-category' );
            $template = !is_wp_error( $link ) ? '<a href="'.esc_url($link).'">%s</a>' : '%s';

            $cat_list[] = sprintf($template, '<span class="label dynamic">'.$cat->name.'</span>');
        }
    }

    return $cat_list;
}

/**
 * @param int $event_id
 * @param string $tag
 */
function nhsm_em_the_event_terms_list($event_id = 0, $tag = 'p'){
	$cat_list = nhsm_em_event_terms_list($event_id);

	echo '<'.$tag.' class="event_cat_labels">'.implode(' ', $cat_list).'</'.$tag.'>';
}

function nhsm_em_the_date_reg_box($event = 0){
	$e = get_post($event);
	if(get_post_type() !== 'event') return false;
	ob_start(); ?>
	<div class="callout event-important-info">
		<ul class="post-meta clearfix no-bullet">
			<li class="post-meta-date"><i class="fi-clock"></i>&nbsp;<?php echo nhsm_get_upcoming_event_date_range($e); ?></li>
			<?php if(nhsm_is_event_over()): ?>
				<li class="post-meta-notice"><i class="fi-alert"></i>&nbsp;This event has passed.</li>
			<?php else:
				$tickets_url = get_post_meta( $e->ID, '_event_tickets_url', true );
                $reg_enabled = get_field('enable_registration', $e->ID);
				if ( $tickets_url && $reg_enabled ) : ?>
                    <li class="post-meta-action"><i class="fi-checkbox"></i>&nbsp;<a href="<?php echo esc_url($tickets_url); ?>" title="Visit event registration url" target="_blank">Register Now!</a></li>
                <?php endif;
			endif; ?>

		</ul>
	</div>
	<?php echo ob_get_clean();
}

function nhsm_em_the_event_archive_filters(){
	$qo = get_queried_object();
	$queried_term_id = is_a($qo, 'WP_Post_Type') ? false : $qo->term_id;
	$terms = get_terms( array(
		'taxonomy' => 'event-category',
		'hide_empty' => false,
	) );
	
	$scope = isset($_GET['show']) ? sanitize_title($_GET['show']) : 'upcoming';	?>
	<form class="" method="get" action="" role="form" style="margin-top:20px; margin-bottom:10px;">
		<div class="row">
			<div class="small-1 columns">
				<label for="middle-label" class="text-right middle">Filter: </label>
			</div>
			<div class="small-5 columns end">
				<select name="show" class="form-control" onchange="this.form.submit()">
					<option value="upcoming" <?php selected($scope, 'upcoming'); ?>>Upcoming Events</option>
					<option value="past" <?php selected($scope, 'past'); ?>>Past Events</option>
				</select>
			</div>
			<?php if($terms && !empty($terms) && !is_wp_error($terms)): ?>
				<div class="medium-5 end columns">
					<select class="form-control" onchange="javascript:location.href = this.value;">
						<option value="<?php echo add_query_arg('show', $scope, get_post_type_archive_link('event')); ?>">All Categories</option>
						<?php foreach($terms as $term): ?>
						<option value="<?php echo add_query_arg('show', $scope, get_term_link($term)); ?>" <?php selected( $term->term_id, $queried_term_id ); ?>><?php echo $term->name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
		</div>
	</form>
	<?php
}

/**
 * In the post meta box, show the event occurrences
 * @param string $pagenow
 */
add_action( 'admin_enqueue_scripts', 'nhsm_em_admin_styles' );
function nhsm_em_admin_styles( $pagenow ) {
    global $post, $post_type;

    if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ), true ) && in_array( $post_type, apply_filters( 'em_event_post_type', array( 'event' ) ) ) ) {
        $recurrence = get_post_meta($post->ID, '_event_recurrence', true);
        if(isset($recurrence['type']) && $recurrence['type'] !== 'once') {
            add_action('em_before_metabox_event_datetime', 'nhsm_em_before_metabox_event_datetime');
            add_action('em_after_metabox_event_datetime', 'nhsm_em_after_metabox_event_datetime');
            wp_enqueue_style( 'nhsm-events-admin', get_stylesheet_directory_uri() . '/assets/css/events-admin.css' );
        };


    }
}

function nhsm_em_before_metabox_event_datetime(){
    echo '<div class="fields">';
}

/**
 * @var WP_Post $post
 */
function nhsm_em_after_metabox_event_datetime(){
    global $post;

    //Get occurrences and sort by date
    $occurrences = get_post_meta($post->ID, '_event_occurrence_date', false);
    $os = [];
    foreach($occurrences as $occurrence){
        $dates = explode('|', $occurrence);
        $os[strtotime($dates[0])] = $occurrence;
    }
    ksort($os);
    $sessions = '<h3>Occurrences</h3>';
    $df = 'D, d M Y g:ia';
    foreach($os as $start => $o) {
        $dates = explode('|', $o);
        $end = strtotime($dates[1]);
        $sessions .= sprintf("<p><span class='start'>%s</span><span class='end'>%s</span></p>", date($df,$start), date($df,$end));
    }
    echo '</div><!-- //.fields --><div class="occurrences">'.$sessions.'</div>';
}

/* Site Origin */
add_filter('siteorigin_panels_row_style_attributes', 'nhsm_siteorigin_panels_row_style_attributes', 10, 2);
function nhsm_siteorigin_panels_row_style_attributes($style_attributes, $style_args){
	//echo '<pre>'.print_r($style_args, true) . '</pre>';
	//echo '<pre>'.print_r($style_attributes, true) . '</pre>';
	
	if(isset($style_args['class'])){
		$classes = explode(' ', $style_args['class']);
		if(in_array('nhsm-force-stretch', $classes)){
			$style_attributes['data-stretch-type'] = 'full';
			wp_enqueue_script('siteorigin-panels-front-styles');
		}
	}
	return $style_attributes;
}

add_filter('origin_widget_presets_button_simple', 'nhsm_origin_widget_presets_button_simple');
function nhsm_origin_widget_presets_button_simple($p){
	unset($p['white'], $p['charcoal'], $p['pink'], $p['orange'], $p['green'], $p['blue'], $p['purple'], $p['turquoise'], $p['slate'], $p['black']);
	
	return $p;
}

add_action('wp_loaded', 'nhsm_so_widget_controls');
function nhsm_so_widget_controls(){
	global $wp_registered_widget_controls;
	
	/* Button */
	$origin_button_addtl_options = array(
		'size' => array(
			'type' => 'select',
			'label' => 'Size',
			'options' => array(
				'default' => 'Default',
				'tiny' => 'Tiny',
				'small' => 'Small',
				'large' => 'Large'
			)
		),
		'shape' => array(
			'type' => 'select',
			'label' => 'Shape',
			'options' => array(
				'default' => 'Default',
				'round' => 'Pill',
				'radius' => 'Rounded'
			)
		),
		'expand' => array(
			'type' => 'checkbox',
			'label' => 'Expand'
		),
		'disabled' => array(
			'type' => 'checkbox',
			'label' => 'Disabled'
		)
		
	);
	
	if(isset($wp_registered_widget_controls['origin_button-1'])) $wp_registered_widget_controls['origin_button-1']['callback'][0]->form_args = array_merge($wp_registered_widget_controls['origin_button-1']['callback'][0]->form_args, $origin_button_addtl_options);
	
	/* DEBUG */
	//echo '<pre>' . print_r($wp_registered_widget_controls, 'true' . '</pre>');exit();
	
}

$nhsm_collection_not_in = array();

add_filter('the_posts', 'nhsm_homepage_collections_get_1', 10, 2);
function nhsm_homepage_collections_get_1($posts, $q){
	if(!is_admin() && isset($q->query['post_type']) && $q->query['post_type'] == 'nhsm_collections' && isset($q->query['posts_per_page']) && $q->query['posts_per_page'] == "1"){
		global $nhsm_collection_not_in;
		$nhsm_collection_not_in[] = $posts[0]->ID;
	}
	return $posts;
}

add_action('pre_get_posts', 'nhsm_homepage_collections_query');
function nhsm_homepage_collections_query($q){
	if(!is_admin() && isset($q->query['post_type']) && $q->query['post_type'] == 'nhsm_collections' && isset($q->query['posts_per_page']) && $q->query['posts_per_page'] == "4"){
		global $nhsm_collection_not_in;
		$q->set('post__not_in', $nhsm_collection_not_in);
	}
}

function nhsm_get_formatted_collector($collection){
    $collectors = [];

    if( have_rows('nhsm_active_curators', $collection->ID) ):
        while ( have_rows('nhsm_active_curators') ) : the_row();
            $c = trim(get_sub_field('nhsm_curator'));
            if($c) $collectors[] = $c;
        endwhile;
    endif;

    switch (count($collectors)) {
        case 0:
            $collector = '';
            break;
        case 1:
            $collector = $collectors[0];
            break;
        case 2:
            $collector = $collectors[0] . " & " . $collectors[1];
            break;
        default:
            $collector = substr(implode(', ', $collectors), 0, -3);
    }
    return $collector;
}

add_filter( 'siteorigin_widgets_template_file_sow-image', 'nhsm_image_template_file', 10, 3 );
function nhsm_image_template_file() {
    $filename = get_stylesheet_directory() . '/widgets/image/tpl/default.php';
    return $filename;
}

/* Download Monitor */
add_filter('dlm_download_category_args', 'nhsm_dlm_download_category_args');
function nhsm_dlm_download_category_args($args){
	$args['show_in_nav_menus'] = true;
	$args['rewrite'] = array('slug' => 'downloads');
	return $args;
}

add_filter('dlm_cpt_dlm_download_args', 'nhsm_dlm_cpt_dlm_download_args');
function nhsm_dlm_cpt_dlm_download_args($args){
	$args['public'] = $args['publicly_queryable'] = true;
	$args['exclude_from_search'] = false;
	$args['rewrite'] = array('slug' => 'download');
	return $args;
}

add_filter('dlm_cpt_dlm_download_supports', 'nhsm_dlm_cpt_dlm_download_supports');
function nhsm_dlm_cpt_dlm_download_supports($supports){
	$supports[] = 'comments';
	return $supports;
}

add_filter( 'dlm_do_not_force', '__return_true' ); //redirect to a download instead of serving it via PHP
add_action( 'admin_init', 'kill_upload_dir' );
function kill_upload_dir() {
	remove_anonymous_object_filter(
		'upload_dir',
		'DLM_Admin',
		'upload_dir'
	);
}

function nhsm_get_the_dlm_filetype($ext){
	$webext = array('net','com','org','edu','gov','mil','info','biz','html','htm','wbp','php','asp','aspx','cfm','php');
	return strtoupper($ext && !in_array($ext, $webext) ? $ext : 'web');
}
	function nhsm_the_dlm_filetype($ext){
		echo nhsm_get_the_dlm_filetype($ext);
	}

/** Helpers **/

/**
 * Remove an anonymous object filter.
 * http://wordpress.stackexchange.com/questions/57079/how-to-remove-a-filter-that-is-an-anonymous-object#57088
 *
 * @param  string $tag    Hook name.
 * @param  string $class  Class name
 * @param  string $method Method name
 * @return void
 */
function remove_anonymous_object_filter( $tag, $class, $method ){
	$filters = isset($GLOBALS['wp_filter'][ $tag ]) ? $GLOBALS['wp_filter'][ $tag ] : array();

	if ( empty ( $filters ) )
	{
		return;
	}

	foreach ( $filters as $priority => $filter )
	{
		foreach ( $filter as $identifier => $function )
		{
			if ( is_array( $function)
				and is_a( $function['function'][0], $class )
				and $method === $function['function'][1]
			)
			{
				remove_filter(
					$tag,
					array ( $function['function'][0], $method ),
					$priority
				);
			}
		}
	}
}

