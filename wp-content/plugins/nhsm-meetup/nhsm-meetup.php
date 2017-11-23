<?php

//use https://github.com/user3581488/Meetup once we're on live site
/*
 * Plugin Name: NHSM Meetup
 * Version: 1.0
 * Description: Uses the Meetup API to pull and create events on Meetup via the Wordpress Admin UI
 * Author: Dan Brellis
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: nhsm-meetup
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Dan Brellis
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'includes/class-nhsm-meetup.php' );
require_once( 'includes/class-nhsm-meetup-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-nhsm-meetup-admin-api.php' );
//require_once( 'includes/lib/class-nhsm-meetup-post-type.php' );
//require_once( 'includes/lib/class-nhsm-meetup-taxonomy.php' );

/**
 * Returns the main instance of NHSM_Meetup to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return object NHSM_Meetup
 */
function NHSM_Meetup () {
	$instance = NHSM_Meetup::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = NHSM_Meetup_Settings::instance( $instance );
	}

	return $instance;
}

NHSM_Meetup();