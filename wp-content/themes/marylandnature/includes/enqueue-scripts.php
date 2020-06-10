<?php

function nhsm_enqueue_scripts(){
    $css_uri = nhsm_get_asset_directory_uri() . '/index.css';
    $css_path = nhsm_get_asset_directory() . '/index.css';
    $js_uri = nhsm_get_asset_directory_uri() . '/index.js';
    $js_path = nhsm_get_asset_directory() . '/index.js';
    wp_enqueue_style('nhsm_styles', $css_uri, [], filemtime($css_path));
    wp_enqueue_script('nhsm_general_script', $js_uri, [], filemtime($js_path));

    //calendar script and style
    wp_register_style(
        'nhsm_calendar_css',
        nhsm_get_asset_directory_uri() . '/scripts/calendar-app.css',
        [],
        filemtime(nhsm_get_asset_directory() . '/scripts/calendar-app.css')
    );
    wp_register_script(
        'nhsm_calendar_app',
        nhsm_get_asset_directory_uri() . '/scripts/calendar-app.js',
        [],
        filemtime(nhsm_get_asset_directory() . '/scripts/calendar-app.js')
    );
}
add_action( 'wp_enqueue_scripts', 'nhsm_enqueue_scripts' );