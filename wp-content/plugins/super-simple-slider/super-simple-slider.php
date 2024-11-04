<?php
/*
 * Plugin Name: Super Simple Slider
 * Version: 1.0.13
 * Plugin URI: https://www.outtheboxthemes.com/wordpress-plugins/super-simple-slider/
 * Description: A lightweight, easy-to-use slider plugin.
 * Author: Out the Box
 * Author URI: https://www.outtheboxthemes.com/
 * Requires at least: 4.0
 * Tested up to: 6.6
 * Requires PHP: 5.3
 *
 * Text Domain: super-simple-slider
 * Domain Path: /languages/
 *
 * @package WordPress
 * @author Out the Box
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SUPER_SIMPLE_SLIDER_DEBUG', false );
define( 'SUPER_SIMPLE_SLIDER_PLUGIN_VERSION', '1.0.13' );

// Load plugin class files.
require_once 'library/classes/class-super-simple-slider.php';
require_once 'library/classes/class-super-simple-slider-post-type.php';
require_once 'library/classes/class-super-simple-slider-widget.php';
require_once 'library/classes/class-super-simple-form-control.php';

/**
 * Returns the main instance of Super_Simple_Slider to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object Super_Simple_Slider
 */
function super_simple_slider() {
	$instance = Super_Simple_Slider::instance( __FILE__, SUPER_SIMPLE_SLIDER_PLUGIN_VERSION );
	
	return $instance;
}

super_simple_slider();

$post_type = 'super-simple-slider';
$plural    = __( 'Super Simple Sliders', 'super-simple-slider' );
$single    = __( 'Super Simple Slider', 'super-simple-slider' );

// Create the Custom Post Type and a Taxonomy for the 'super-simple-slider' Post Type
super_simple_slider()->register_post_type( $post_type, $plural, $single, '', array(
	'labels'	=> array(
		'name'               => $plural,
		'singular_name'      => $single,
		'name_admin_bar'     => $single,
		'add_new'            => _x( 'Create New Slider', $post_type, 'super-simple-slider' ),
		'add_new_item'       => __( 'Create New Slider', 'super-simple-slider' ),
		'edit_item'          => __( 'Edit Slider', 'super-simple-slider' ),
		'new_item'           => sprintf( __( 'New %s', 'super-simple-slider' ), $single ),
		'all_items' 		 => __( 'View Sliders', 'super-simple-slider' ),
		'view_item'          => __( 'View Slider', 'super-simple-slider' ),
		'search_items'       => __( 'Search Sliders', 'super-simple-slider' ),
		'not_found'          => __( 'No Sliders', 'super-simple-slider' ),
		'not_found_in_trash' => __( 'No Sliders Found In Trash', 'super-simple-slider' ),
		'parent_item_colon'  => sprintf( __( 'Parent %s' ), $single ),	
		'menu_name' => 'Super Simple Slider',
	),
	'public'    => true,
	'publicly_queryable' => true,
	'exclude_from_search' => true, // Check if this is legit
	'menu_icon' => 'dashicons-images-alt2'
) );
