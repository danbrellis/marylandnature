<?php

require_once(get_template_directory().'/includes/media.php');

require_once(get_template_directory().'/includes/menu.php');

require_once(get_template_directory().'/includes/sidebar.php');

/* Styles and Scripts */
function nhsm_enqueue_scripts(){
    $css_uri = nhsm_get_asset_directory_uri() . '/index.css';
    $css_path = nhsm_get_asset_directory() . '/index.css';
    $js_uri = nhsm_get_asset_directory_uri() . '/index.js';
    $js_path = nhsm_get_asset_directory() . '/index.js';
    wp_enqueue_style('nhsm_styles', $css_uri, [], filemtime($css_path));

    wp_enqueue_script('nhsm_index_script', $js_uri, [], filemtime($js_path));
}
add_action( 'wp_enqueue_scripts', 'nhsm_enqueue_scripts' );

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

/* Formatting */
function nhsm_add_wbr_to_title($title, $id){
    $title = str_replace( '/', '/<wbr>', $title);
    return $title;
}

/* Collections */
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

/* Events */
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