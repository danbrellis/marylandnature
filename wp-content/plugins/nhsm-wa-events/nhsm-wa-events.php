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
    new Admin\Events_Admin();
}
add_action( 'admin_init', 'NHSM\\Events\\nhsm_wa_events_admin_init' );