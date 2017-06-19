<?php
/*
Plugin Name: (DO NOT UPDATE) Events Maker
Description: Fully featured event management system including recurring events, locations management, full calendar, iCal feed/files, google maps and more.
Version: 1.6.14
Author: dFactory
Author URI: http://www.dfactory.eu/
Plugin URI: http://www.dfactory.eu/plugins/events-maker/
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: events-maker
Domain Path: /languages

Events Maker
Copyright (C) 2013-2016, Digital Factory - info@digitalfactory.pl

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/* Below edits made to plugin (will be overwritten if updated) by dbrellis
 *
 * line			page							description
 * 235-257	css/front.css			Commented out all #events-full-calendar styles
 *
 */

 // exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'Events_Maker' ) ) :

/**
 * Events Maker class.
 *
 * @class Events_Maker
 * @version	1.6.14
 */
final class Events_Maker {

	private static $_instance;
	public $action_pages = array();
	public $notices = array();
	public $options = array();
	public $recurrences = array();
	public $category_fields;
	public $location_fields;
	public $organizer_fields;
	public $defaults = array(
		'general'		 => array(
			'supports'				 => array(
				'title'			 => true,
				'editor'		 => true,
				'author'		 => true,
				'thumbnail'		 => true,
				'excerpt'		 => true,
				'custom-fields'	 => false,
				'comments'		 => true,
				'trackbacks'	 => false,
				'revisions'		 => false,
				'gallery'		 => true
			),
			'order_by'				 => 'start',
			'order'					 => 'asc',
			'expire_current'		 => false,
			'show_past_events'		 => true,
			'show_occurrences'		 => true,
			'use_organizers'		 => true,
			'use_tags'				 => true,
			'use_event_tickets'		 => true,
			'google_maps_key'		 => '',
			'default_event_options'	 => array(
				'google_map'				 => true,
				'display_gallery'			 => true,
				'display_location_details'	 => true,
				'price_tickets_info'		 => true,
				'display_organizer_details'	 => true
			),
			'pages'					 => array(
				'events'	 => array(
					'id'		 => 0,
					'position'	 => 'after'
				),
				'calendar'	 => array(
					'id'		 => 0,
					'position'	 => 'after'
				),
				/* 'past_events' => array(
				  'id' => 0,
				  'position' => 'after'
				  ), */
				'locations'	 => array(
					'id'		 => 0,
					'position'	 => 'after'
				),
				'organizers' => array(
					'id'		 => 0,
					'position'	 => 'after'
				)
			),
			'pages_notice'			 => true,
			'ical_feed'				 => true,
			'events_in_rss'			 => true,
			'deactivation_delete'	 => false,
			'datetime_format'		 => array(
				'date'	 => '',
				'time'	 => ''
			),
			'first_weekday'			 => 1,
			'rewrite_rules'			 => true,
			'currencies'			 => array(
				'code'		 => 'usd',
				'symbol'	 => '$',
				'position'	 => 'after',
				'format'	 => 1
			)
		),
		'templates'		 => array(
			'default_templates' => true
		),
		'capabilities'	 => array(
			'publish_events',
			'edit_events',
			'edit_others_events',
			'edit_published_events',
			'delete_published_events',
			'delete_events',
			'delete_others_events',
			'read_private_events',
			'manage_event_categories',
			'manage_event_tags',
			'manage_event_locations',
			'manage_event_organizers'
		),
		'permalinks'	 => array(
			'event_rewrite_base'			 => 'events',
			'event_rewrite_slug'			 => 'event',
			'event_categories_rewrite_slug'	 => 'category',
			'event_tags_rewrite_slug'		 => 'tag',
			'event_locations_rewrite_slug'	 => 'location',
			'event_organizers_rewrite_slug'	 => 'organizer'
		),
		'version'		 => '1.6.14'
	);

	/**
	 * Disable object clone.
	 */
	private function __clone() {}

	/**
	 * Disable unserializing of the class.
	 */
	private function __wakeup() {}

	/**
	 * Main Events Maker instance.
	 */
	public static function instance() {	
		if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof Events_Maker ) ) {
			self::$_instance = new Events_Maker();
			self::$_instance->define_constants();

			add_action( 'plugins_loaded', array( self::$_instance, 'load_textdomain' ) );

			self::$_instance->includes();
			self::$_instance->localisation	= new Events_Maker_Localisation();
		}
		return self::$_instance;
	}
	
	/**
	 * Setup plugin constants.
	 *
	 * @return void
	 */
	private function define_constants() {
		define( 'EVENTS_MAKER_URL', plugins_url( '', __FILE__ ) );
		define( 'EVENTS_MAKER_PATH', plugin_dir_path( __FILE__ ) );
		define( 'EVENTS_MAKER_REL_PATH', dirname( plugin_basename( __FILE__ ) ) . '/' );
		define( 'EVENTS_MAKER_UPDATE_VERSION_1', '1.0.10' );
	}

	/**
	 * Include required files
	 *
	 * @return void
	 */
	private function includes() {
		include_once( EVENTS_MAKER_PATH . 'includes/core-functions.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-localisation.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-query.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-post-types.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-shortcodes.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-taxonomies.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-templates.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-helper.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-widgets.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-ical.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/class-wpml.php' );
		include_once( EVENTS_MAKER_PATH . 'includes/libraries/translate-rewrite-slugs.php' );
		if ( is_admin() ) {
			include_once( EVENTS_MAKER_PATH . 'includes/class-admin.php' );
			include_once( EVENTS_MAKER_PATH . 'includes/class-listing.php' );
			include_once( EVENTS_MAKER_PATH . 'includes/class-metaboxes.php' );
			include_once( EVENTS_MAKER_PATH . 'includes/class-settings.php' );
			include_once( EVENTS_MAKER_PATH . 'includes/class-update.php' );
			include_once( EVENTS_MAKER_PATH . 'includes/class-welcome.php' );
		}
	}

	/**
	 * Events Maker constructor.
	 */
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'multisite_activation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'multisite_deactivation' ) );

		// settings
		$this->options = array(
			'general'	 => array_merge( $this->defaults['general'], get_option( 'events_maker_general', $this->defaults['general'] ) ),
			'permalinks' => array_merge( $this->defaults['permalinks'], get_option( 'events_maker_permalinks', $this->defaults['permalinks'] ) ),
			'templates'	 => array_merge( $this->defaults['templates'], get_option( 'events_maker_templates', $this->defaults['templates'] ) )
		);

		// actions
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts_styles' ) );
		add_action( 'after_setup_theme', array( $this, 'load_defaults' ) );
		add_action( 'wp', array( $this, 'load_pluggable_functions' ) );
		add_action( 'wp', array( $this, 'load_pluggable_hooks' ) );

		// filters
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'plugin_settings_link' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_extend_links' ), 10, 2 );

		do_action( 'em_loaded' );
	}

	/**
	 * Multisite activation.
	 */
	public function multisite_activation( $networkwide ) {
		if ( is_multisite() && $networkwide ) {
			global $wpdb;

			$activated_blogs = array();
			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT blog_id FROM ' . $wpdb->blogs, '' ) );

			foreach ( $blogs_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->activate_single();
				$activated_blogs[] = (int) $blog_id;
			}

			switch_to_blog( $current_blog_id );
			update_site_option( 'events_maker_activated_blogs', $activated_blogs, array() );
		} else
			$this->activate_single();
	}

	/**
	 * Single site activation.
	 */
	public function activate_single() {
		global $wp_roles;

		// transient for welcome screen
		set_transient( 'em_activation_redirect', 1, 3600 );

		// add caps to administrators
		foreach ( $wp_roles->roles as $role_name => $display_name ) {
			$role = $wp_roles->get_role( $role_name );

			if ( $role->has_cap( 'manage_options' ) ) {
				foreach ( $this->defaults['capabilities'] as $capability ) {
					if ( ( ! $this->defaults['general']['use_tags'] && $capability === 'manage_event_tags') || ( ! $this->defaults['general']['use_organizers'] && $capability === 'manage_event_organizers') )
						continue;

					$role->add_cap( $capability );
				}
			}
		}

		$this->defaults['general']['datetime_format'] = array(
			'date'	 => get_option( 'date_format' ),
			'time'	 => get_option( 'time_format' )
		);

		// add default options
		add_option( 'events_maker_general', $this->defaults['general'], '', 'no' );
		add_option( 'events_maker_templates', $this->defaults['templates'], '', 'no' );
		add_option( 'events_maker_capabilities', '', '', 'no' );
		add_option( 'events_maker_permalinks', $this->defaults['permalinks'], '', 'no' );
		add_option( 'events_maker_version', $this->defaults['version'], '', 'no' );

		// permalinks
		flush_rewrite_rules();
	}

	/**
	 * Multisite deactivation.
	 */
	public function multisite_deactivation( $networkwide ) {
		if ( is_multisite() && $networkwide ) {
			global $wpdb;

			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT blog_id FROM ' . $wpdb->blogs, '' ) );

			if ( ! ($activated_blogs = get_site_option( 'events_maker_activated_blogs', false, false )) )
				$activated_blogs = array();

			foreach ( $blogs_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->deactivate_single( true );

				if ( in_array( (int) $blog_id, $activated_blogs, true ) )
					unset( $activated_blogs[array_search( $blog_id, $activated_blogs )] );
			}

			switch_to_blog( $current_blog_id );
			update_site_option( 'events_maker_activated_blogs', $activated_blogs );
		} else
			$this->deactivate_single();
	}

	/**
	 * Single site deactivation.
	 */
	public function deactivate_single( $multi = false ) {
		global $wp_roles;

		// remove capabilities
		foreach ( $wp_roles->roles as $role_name => $display_name ) {
			$role = $wp_roles->get_role( $role_name );

			foreach ( $this->defaults['capabilities'] as $capability ) {
				$role->remove_cap( $capability );
			}
		}

		if ( $multi ) {
			$options = get_option( 'events_maker_general' );
			$check = $options['deactivation_delete'];
		} else {
			$check = $this->options['general']['deactivation_delete'];
		}

		// delete default options
		if ( $check ) {
			delete_option( 'events_maker_general' );
			delete_option( 'events_maker_templates' );
			delete_option( 'events_maker_capabilities' );
			delete_option( 'events_maker_permalinks' );
			delete_option( 'events_maker_version' );
		}

		// permalinks
		flush_rewrite_rules();
	}

	/**
	 * Load defaults.
	 */
	public function load_defaults() {
		$this->recurrences = apply_filters(
			'em_event_recurrences_options', array(
				'once'		 => __( 'once', 'events-maker' ),
				'daily'		 => __( 'daily', 'events-maker' ),
				'weekly'	 => __( 'weekly', 'events-maker' ),
				'monthly'	 => __( 'monthly', 'events-maker' ),
				'yearly'	 => __( 'yearly', 'events-maker' ),
				'custom'	 => __( 'custom', 'events-maker' )
			)
		);

		$this->action_pages = apply_filters( 'em_action_pages', array(
			'events'	 => __( 'Events', 'events-maker' ),
			'calendar'	 => __( 'Calendar', 'events-maker' ),
			// 'past_events' => __('Past Events', 'events-maker'),
			'locations'	 => __( 'Locations', 'events-maker' ),
			'organizers' => __( 'Organizers', 'events-maker' )
		) );
		
		$this->category_fields = apply_filters( 'em_event_category_fields', array(
			'color' => array(
				'id'			 => 'em-color',
				'type'			 => 'color_picker',
				'label'			 => __( 'Color', 'events-maker' ),
				'default'		 => '',
				'description'	 => 'The color of events filed under that category (to be used in Full Calendar display).',
				'column'		 => true
			)
		) );

		$this->location_fields = apply_filters( 'em_event_location_fields', array(
			'google_map' => array(
				'id'			 => 'em-google_map',
				'type'			 => 'google_map',
				'label'			 => __( 'Google Map', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => false
			),
			'address'	 => array(
				'id'			 => 'em-address',
				'type'			 => 'text',
				'label'			 => __( 'Address', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => true
			),
			'city'		 => array(
				'id'			 => 'em-city',
				'type'			 => 'text',
				'label'			 => __( 'City', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => true
			),
			'state'		 => array(
				'id'			 => 'em-state',
				'type'			 => 'text',
				'label'			 => __( 'State / Province', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => true
			),
			'zip'		 => array(
				'id'			 => 'em-zip',
				'type'			 => 'text',
				'label'			 => __( 'Zip Code', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => false
			),
			'country'	 => array(
				'id'			 => 'em-country',
				'type'			 => 'select',
				'label'			 => __( 'Country', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'options'		 => Events_Maker()->localisation->countries,
				'column'		 => false
			),
			'image'		 => array(
				'id'			 => 'em-image',
				'type'			 => 'image',
				'label'			 => __( 'Image', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => false
			)
		) );

		$this->organizer_fields = apply_filters( 'em_event_organizer_fields', array(
			'contact_name'	 => array(
				'id'			 => 'em-contact_name',
				'type'			 => 'text',
				'label'			 => __( 'Contact name', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => true
			),
			'phone'			 => array(
				'id'			 => 'em-phone',
				'type'			 => 'text',
				'label'			 => __( 'Phone', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => true
			),
			'email'			 => array(
				'id'			 => 'em-email',
				'type'			 => 'email',
				'label'			 => __( 'E-mail', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => true
			),
			'website'		 => array(
				'id'			 => 'em-website',
				'type'			 => 'url',
				'label'			 => __( 'Website', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => false
			),
			'image'			 => array(
				'id'			 => 'em-image',
				'type'			 => 'image',
				'label'			 => __( 'Image', 'events-maker' ),
				'default'		 => '',
				'description'	 => '',
				'column'		 => false
			)
		) );
	}

	/**
	 * Load pluggable template functions.
	 */
	public function load_pluggable_functions() {
		include_once( EVENTS_MAKER_PATH . 'includes/template-functions.php' );
	}

	/**
	 * Load pluggable template hooks.
	 */
	public function load_pluggable_hooks() {
		include_once( EVENTS_MAKER_PATH . 'includes/template-hooks.php' );
	}

	/**
	 * Generate random string.
	 */
	private function generate_hash() {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~`+=,.;:/?|';
		$max = strlen( $chars ) - 1;
		$password = '';

		for ( $i = 0; $i < 64; $i ++  ) {
			$password .= substr( $chars, mt_rand( 0, $max ), 1 );
		}

		return $password;
	}

	/**
	 * Load text domain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'events-maker', false, EVENTS_MAKER_REL_PATH . 'languages/' );
	}

	/**
	 * Enqueue frontend scripts and style.
	 */
	public function front_scripts_styles() {
		wp_register_style(
			'events-maker-front', EVENTS_MAKER_URL . '/css/front.css'
		);

		wp_enqueue_style( 'events-maker-front' );

		wp_register_script(
			'events-maker-sorting', EVENTS_MAKER_URL . '/js/front-sorting.js', array( 'jquery' )
		);

		wp_enqueue_script( 'events-maker-sorting' );
	}

	/**
	 * Add link to Settings page.
	 */
	public function plugin_settings_link( $links ) {
		if ( ! is_admin() || ! current_user_can( 'install_plugins' ) )
			return $links;

		$links[] = sprintf( '<a href="%s">%s</a>', admin_url( 'edit.php' ) . '?post_type=event&page=events-settings', __( 'Settings', 'events-maker' ) );

		return $links;
	}

	/**
	 * Add link to Support Forum.
	 */
	public function plugin_extend_links( $links, $file ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return $links;
		}

		$plugin = plugin_basename( __FILE__ );

		if ( $file == $plugin ) {
			return array_merge( $links, array( sprintf( '<a href="http://www.dfactory.eu/support/forum/events-maker/" target="_blank">%s</a>', __( 'Support', 'events-maker' ) ) ) );
		}

		return $links;
	}
	
	/**
	 * Add admin notices.
	 */
	public function add_notice( $html = '', $status = 'error', $paragraph = false, $network = true ) {
		$this->notices[] = array(
			'html'		 => $html,
			'status'	 => $status,
			'paragraph'	 => $paragraph
		);

		add_action( 'admin_notices', array( $this, 'display_notice' ) );

		if ( $network )
			add_action( 'network_admin_notices', array( $this, 'display_notice' ) );
	}

	/**
	 * Print admin notices.
	 */
	public function display_notice() {
		foreach ( Events_Maker()->notices as $notice ) {
			echo '
			<div class="events-maker ' . $notice['status'] . '">
				' . ( $notice['paragraph'] ? '<p>' : '' ) . '
				' . $notice['html'] . '
				' . ( $notice['paragraph'] ? '</p>' : '' ) . '
			</div>';
		}
	}

	/**
	 * Get plugin action page id.
	 */
	public function get_action_page_id( $action_pages = array() ) {
		$ids = array();

		if ( empty( $action_pages ) )
			$pages = Events_Maker()->options['general']['pages'];
		else
			$pages = $action_pages;

		if ( ! empty( $pages ) ) {
			if ( is_array( $pages ) ) {
				foreach ( $pages as $key => $action ) {
					$ids[$key] = (int) $action['id'];

					// wpml and polylang compatibility
					if ( function_exists( 'icl_object_id' ) )
						$ids[$key] = (int) icl_object_id( (int) $action['id'], 'page', true );
				}
			} elseif ( is_string( $pages ) ) {
				$ids = isset( Events_Maker()->options['general']['pages'][$pages]['id'] ) ? (int) Events_Maker()->options['general']['pages'][$pages]['id'] : (int) Events_Maker()->defaults['general']['pages'][$pages]['id'];

				// wpml and polylang compatibility
				if ( function_exists( 'icl_object_id' ) )
					$ids = (int) icl_object_id( $ids, 'page', true );
			}
		}
		
		return $ids;
	}

	/**
	 * Check whether all action pages are set, valid and unique.
	 */
	public function is_action_page_set( $pages = array() ) {
		// gets action pages ids
		$pages_ids = $this->get_action_page_id( $pages );

		if ( count( array_keys( $pages_ids, 0, true ) ) === 0 )
			return true;
		else
			return false;
	}

}

endif; // end if class_exists check

/**
 * Initialise Events Maker.
 */
function Events_Maker() {
	static $instance;

	// first call to instance() initializes the plugin
	if ( $instance === null || ! ( $instance instanceof Events_Maker ) ) {
		$instance = Events_Maker::instance();
	}

	return $instance;
}

Events_Maker();