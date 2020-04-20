<?php

require_once(get_template_directory().'/includes/media.php');

require_once(get_template_directory().'/includes/menu.php');

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
    return get_template_directory() . $dir;
}