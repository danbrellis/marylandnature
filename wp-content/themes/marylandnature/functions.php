<?php

require_once(get_template_directory().'/includes/ajax.php');

require_once(get_template_directory().'/includes/blocks.php');

require_once(get_template_directory().'/includes/custom-post-type.php');

require_once(get_template_directory().'/includes/enqueue-scripts.php');

require_once(get_template_directory().'/includes/media.php');

require_once(get_template_directory().'/includes/menu.php');

require_once(get_template_directory().'/includes/shortcodes.php');

require_once(get_template_directory().'/includes/sidebar.php');

/*
 * Utility
 */

function nhsm_get_asset_directory_uri(){
    $env = ENV;
    $dir = $env === 'dev' ? '/build' : '/dist';
    return get_stylesheet_directory_uri() . $dir;
}
function nhsm_get_asset_directory(){
    $env = ENV;
    $dir = $env === 'dev' ? '/build' : '/dist';
    return get_stylesheet_directory() . $dir;
}

add_theme_support( 'title-tag' );


/*
 *  Queries
 */

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


/*
 * Rewrites
 */
function nhsm_rewrite_tags() {
    global $wp;
    $wp->add_query_var( 'fc_year' );
    $wp->add_query_var( 'fc_month' );

    add_rewrite_tag( '%nhsm_events_year%', '([0-9]{4})' );
    add_rewrite_tag( '%nhsm_events_month%', '([0-9]{2})' );
    add_rewrite_rule('^get-involved/calendar(/([0-9]+))?(/([0-9]+))?/?', 'index.php?page_id=190&fc_year=$matches[2]&fc_month=$matches[4]', 'top');
}
add_action( 'init', 'nhsm_rewrite_tags' );


/*
 * Formatting
 */

/**
 * @param string $title
 * @param integer $id
 * @return string
 */
function nhsm_add_wbr_to_title($title, $id){
    $title = str_replace( '/', '/<wbr>', $title);
    return $title;
}

/*
 * Posts
 */
function nhsm_get_the_cat_labels($p = 0){
    $post = get_post($p);
    $cats = wp_get_post_categories($post->ID, array('fields' => 'all'));
    $html = '';
    $cat_list = array();

    if($cats && is_array($cats)){
        foreach($cats as $cat){
            $link = get_category_link( $cat->term_id );
            $template = !is_wp_error( $link ) ? '<a href="'.esc_url($link).'" class="label label--primary">%s</a>' : '%s';
            $styles = array();

            $cat_list[] = sprintf($template, $cat->name);
        }
    }
    if(!empty($cat_list))
        $html = '<p class="event_cat_labels">'. implode(' ', $cat_list) .'</p>';

    return $html;
}
    function nhsm_the_cat_labels($p = 0){
        echo nhsm_get_the_cat_labels($p);
    }

/*
 * Collections
 */
/**
 * @param WP_Post $collection
 * @return string
 */
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

/*
 * Events
 */
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
 * Removes event ticket/cost meta box
 * @param array $metaboxes
 * @return array
 */
function nhsm_em_event_metaboxes(array $metaboxes){
    unset($metaboxes['event-cost-tickets-box']);
    return $metaboxes;
}
add_filter( 'em_event_metaboxes', 'nhsm_em_event_metaboxes', 10, 1);

/**
 * Remove event tickets column
 * @param array $columns
 * @return array
 */
function nhsm_manage_event_post_columns(array $columns){
    unset($columns['tickets']);
    return $columns;
}
add_filter('manage_event_posts_columns', 'nhsm_manage_event_post_columns', 11, 1);

/**
 * Returns an array of htmls trings for all categories for an event
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
            $template = !is_wp_error( $link ) ? '<a href="'.esc_url($link).'" class="label label--primary">%s</a>' : '%s';

            $cat_list[] = sprintf($template, $cat->name);
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

/**
 * Returns a formatted date range for the event (or closest upcoming event if a recurrence)
 *
 * @param WP_Post $event
 * @return array|bool
 */
function nhsm_get_upcoming_event_date_range($event){
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

/**
 * Prefixes a string with 'All', 'Past', or 'Upcoming' depending on the value of $_GET['show']
 *
 * @param string $after
 * @return string
 */
function nhsm_event_scope_prefix($after){
    $scope = isset($_GET['show']) ? sanitize_title($_GET['show']) : 'upcoming';
    if($scope == 'all') $h = 'All';
    elseif($scope == 'past') $h = 'Past';
    else $h = 'Upcoming';

    return $h . $after;
}

/**
 * @param string $attr
 * @return string
 */
function nhsm_previous_posts_link_attributes($attr){
    $attr .= ' class="prev-next__prevLink" rel="prev"';
    return $attr;
}
add_filter('previous_posts_link_attributes', 'nhsm_previous_posts_link_attributes');

/**
 * @param string $attr
 * @return string
 */
function nhsm_next_posts_link_attributes($attr){
    $attr .= ' class="prev-next__nextLink" rel="next"';
    return $attr;
}
add_filter('next_posts_link_attributes', 'nhsm_next_posts_link_attributes');

/**
 * Returns true if event end date has not yet passed
 *
 * @param Integer $post_id
 * @return bool
 */
function nhsm_is_event_over($post_id = 0){
    $post_id = !$post_id ? get_the_ID() : $post_id ;
    if ( !$post_id ) return false;

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
 * Adds occurrence start and end dates to a WP_Post object
 * if the post is an event and a single post is requested
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

/**
 * Returns an array of events to be feed into Full Calendar
 * @param [] $args
 * @return array
 */
function nhsm_get_events_for_calendar($args){
    $events = em_get_events( $args );
    $calendar = [];

    /**
     * @var WP_Post $event
     */
    foreach ( $events as $event ) {
        $locs = em_get_locations_for($event->ID);
        $loc = '';
        if($locs && is_array($locs) && !empty($locs[0])){
            $loc = sprintf(
                '<address>%s <a href="https://www.google.com/maps/search/'.str_replace(' ', '+', $locs[0]->name).'/@%f,%f,15z">map</a></address>',
                $locs[0]->name,
                $locs[0]->location_meta['google_map']['latitude'],
                $locs[0]->location_meta['google_map']['longitude']
            );
        }
        $tag_list = str_replace('/"', '/#events"', get_the_tag_list('',', ','', $event->ID));
        $cat_list = nhsm_em_event_terms_list($event->ID);

        if ( em_is_recurring( $event->ID ) && Events_Maker()->options['general']['show_occurrences'] ) {
            $start = $event->event_occurrence_start_date;
            $end = $event->event_occurrence_end_date;
        } else {
            $start = $event->_event_start_date;
            $end = $event->_event_end_date;
        }

        $all_day_event = em_is_all_day( $event->ID );

        $calendar[] = apply_filters( 'em_calendar_event_data',
            [
                'title'     => $event->post_title,
                'start'     => $start,
                'end'       => ($all_day_event ? date( 'Y-m-d H:i:s', strtotime( $end . '+1 day' ) ) : $end),
                'allDay'    => $all_day_event,
                'id'        => $event->ID,
                'c'         => implode(' ', $cat_list),
                'd'         => nhsm_format_date_range(strtotime($event->event_occurrence_start_date), strtotime($event->event_occurrence_end_date), em_is_all_day($event->ID)),
                'l'         => $loc,
                't'         => $tag_list,
                'u'         => get_permalink($event)
            ], $event
        );
    }

    return $calendar;
}

/*
 * People
 */
/**
 * Adds role_position and group_order properties
 * to posts array when nhsm_team is queried by role.
 *
 * @param array $posts
 * @param WP_Query $query
 * @return array
 */
function add_meta_for_people_query(array $posts, WP_Query $query){
    //Loop through results and set ACF meta values as custom $post properties

    if($query->is_post_type_archive('nhsm_team') && $query->is_tax('nhsm_role')){

        if($query->is_tax('nhsm_role', 'board-of-directors')){
            $group = 'board-of-directors';
        }
        else{
            $group = 'team_' . $query->tax_query->queried_terms['nhsm_role']['terms'][0];
        }
        foreach($posts as $post) {
            $rows = get_field('team_member_role', $post->ID);
            //var_dump($rows);
            if ($rows) {
                foreach ($rows as $row)
                    if ($row['group_position']['group'] === $group) {
                        $post->role_position = $row['group_position']['position'];
                        $post->group_order = $row['group_position']['list_order'] === "" ? 9999 : intval($row['group_position']['list_order']);
                    }
            }
        }
    }
    //Sort results based on above custom property (list_order)
    usort($posts, function ($a, $b) {
        if($a->group_order === $b->group_order){
            return strcmp($a->post_title, $b->post_title);
        }
        return ($a->group_order < $b->group_order) ? -1 : 1;
    });
    return $posts;
}
add_filter('posts_results', 'add_meta_for_people_query', 10, 2);