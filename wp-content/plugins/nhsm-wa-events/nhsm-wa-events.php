<?php

/**
 * Plugin Name: NHSM WA Events
 * Author:      Dan Brellis
 * License:     GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Description: Connect Wild Apricot with NHSM Wordpress theme for events.
 * Version:     1.0.0
 */

namespace NHSM\Events;

use NHSM\Events\Admin;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Include the required files & dependencies
 *
 * @since 0.1.0
 */
function nhsm_wa_events_admin_init() {
    $plugin_path = plugin_dir_path( __FILE__ );
    // Classes
    require_once $plugin_path . 'includes/class-wa-api-client.php';
    require_once $plugin_path . 'admin/class-events-admin.php';
    include_once $plugin_path . 'includes/class-metaboxes.php';
    new Admin\Events_Admin();
}
add_action( 'admin_init', 'NHSM\\Events\\nhsm_wa_events_admin_init' );

/**
 * Enqueue admin scripts and styles.
 * @param string $pagenow
 */
function admin_scripts_styles( $pagenow ) {
    global $post_type;

    $plugin_url = plugins_url( '', __FILE__ );

    if ( in_array( $pagenow, array( 'post-new.php', 'post.php' ), true ) && in_array( $post_type, apply_filters( 'em_event_post_type', array( 'event' ) ) ) ) {
        wp_enqueue_style( 'nhsm-wa-events-admin', $plugin_url . '/css/admin.css' );
    }
}
add_action( 'admin_enqueue_scripts', 'NHSM\\Events\\admin_scripts_styles' );