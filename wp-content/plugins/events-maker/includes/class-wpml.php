<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Events_Maker_Templates Class.
 */
class Events_Maker_WPML {

	private $post_type_slugs = array();
	private $taxonomy_slugs = array();
	private $strings = array();

	public function __construct() {
		// actions
		add_action( 'init', array( $this, 'set_translated_slugs' ) );
		add_action( 'plugins_loaded', array( $this, 'register_strings' ) );
		add_action( 'wpml_translated_post_type_replace_rewrite_rules', array ($this, 'register_extra_rewrite_rules' ) , 10, 3 );

		// filters
		add_filter( 'wpml_translated_post_type_rewrite_slugs', array( $this, 'register_translated_post_type_slugs' ) );
		add_filter( 'wpml_translated_taxonomy_rewrite_slugs', array( $this, 'register_translated_taxonomy_slugs' ) );
	}
	
	/**
	 * Register strings for translation.
	 */
	public function register_strings() {
		// prepare strings
		$this->strings = array(
			'Event rewrite base'			=> Events_Maker()->options['permalinks']['event_rewrite_base'],
			'Event rewrite slug'			=> Events_Maker()->options['permalinks']['event_rewrite_slug'],
			'Event Categories rewrite slug'	=> Events_Maker()->options['permalinks']['event_categories_rewrite_slug'],
			'Event Locations rewrite slug'	=> Events_Maker()->options['permalinks']['event_locations_rewrite_slug'],
		);
		
		if ( Events_Maker()->options['general']['use_tags'] === true )
			$this->strings['Event Tags rewrite slug'] = Events_Maker()->options['permalinks']['event_tags_rewrite_slug'];
		if ( Events_Maker()->options['general']['use_organizers'] === true )
			$this->strings['Event Organizers rewrite slug'] = Events_Maker()->options['permalinks']['event_organizers_rewrite_slug'];
		
		// WPML >= 3.2
		if ( defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {
			$this->register_wpml_strings();
		// WPML and Polylang compatibility
		} elseif ( function_exists( 'icl_register_string' ) ) {
			$this->register_pll_strings();
		}
	}
	
	/**
	 * Register Polylang and WPML (< 3.2) strings if needed.
	 *
	 * @param array $strings
	 * @return void
	 */
	private function register_pll_strings() {
		if ( $this->strings ) {
			foreach ( $this->strings as $key => $string ) {
				icl_register_string( 'Events Maker', $key, $string );
			}
		}
	}
	
	/**
	 * Register WPML (>= 3.2) strings if needed.
	 * 
	 * @global objkect $wpdb
	 * @param array $strings
	 * @return void
	 */
	private function register_wpml_strings() {
		if ( $this->strings ) {
			global $wpdb;

			// get query results
			$results = $wpdb->get_col( $wpdb->prepare( "SELECT name FROM " . $wpdb->prefix . "icl_strings WHERE context = %s", 'Events Maker' ) );

			// check results
			foreach( $this->strings as $key => $string ) {
				// string does not exist?
				if ( ! in_array( $key, $results, true ) ) {
					// register string
					do_action( 'wpml_register_single_string', 'Events Maker', $key, $string );
				}
			}
		}
	}
	
	/**
	 * Register translated post type slugs.
	 */
	public function register_extra_rewrite_rules($post_type, $lang, $translated_slug) {
		global $wp_rewrite;
		
		$archive_slug = $translated_slug->has_archive === true ? $translated_slug->rewrite['slug'] : $translated_slug->has_archive;

		add_rewrite_rule( "{$archive_slug}/([0-9]{4}(?:/[0-9]{2}(?:/[0-9]{2})?)?)/?$", "index.php?post_type=$post_type" . '&event_ondate=$matches[1]', 'top' );

		if ( $translated_slug->rewrite['pages'] )
			add_rewrite_rule( "{$archive_slug}/([0-9]{4}(?:/[0-9]{2}(?:/[0-9]{2})?)?)/{$wp_rewrite->pagination_base}/([0-9]{1,})/?$", "index.php?post_type=$post_type" . '&event_ondate=$matches[1]' . '&paged=$matches[2]', 'top' );
	}

	/**
	 * Register translated post type slugs.
	 */
	public function register_translated_post_type_slugs() {
		return $this->post_type_slugs;
	}

	/**
	 * Register translated post type slugs.
	 */
	public function register_translated_taxonomy_slugs() {
		return $this->taxonomy_slugs;
	}

	/**
	 * Get post type and taxonomy slugs.
	 */
	public function set_translated_slugs() {
		$plugin = '';

		// check if WPML or Polylang is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if ( is_plugin_active( 'polylang/polylang.php' ) ) {
			$plugin = 'Polylang';
		} elseif ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && is_plugin_active( 'wpml-string-translation/plugin.php' ) ) {
			$plugin = 'WPML';
		}

		if ( empty( $plugin ) )
			return;

		$languages = array();
		$default = '';

		// Polylang
		if ( $plugin === 'Polylang' && function_exists( 'PLL' ) ) {
			// get registered languages
			$registered_languages = PLL()->model->get_languages_list();

			if ( ! empty( $registered_languages ) ) {
				foreach ( $registered_languages as $language )
					$languages[] = $language->slug;
			}

			// get default language
			$default = PLL()->options['default_lang'];
			
		// WPML
		} elseif ( $plugin === 'WPML' && class_exists( 'SitePress' ) ) {
			global $sitepress;
			
			// get registered languages
			$registered_languages = icl_get_languages();

			if ( ! empty( $registered_languages ) ) {
				foreach ( $registered_languages as $language )
					$languages[] = $language['code'];
			}

			// get default language
			$default = $sitepress->get_default_language();
			$current = $sitepress->get_current_language();
		}

		if ( ! empty( $languages ) ) {
			
			foreach ( $languages as $language ) {
				$slugs = array();

				if ( $plugin === 'Polylang' && function_exists( 'pll_translate_string' ) ) {
					foreach ( $this->strings as $key => $string ) {
						$sanitized_key = str_replace( '-', '_', sanitize_title( $key ) );
						$slugs[$sanitized_key] = pll_translate_string( untrailingslashit( esc_html( Events_Maker()->options['permalinks'][$sanitized_key] ) ), $language );
					}
				// WPML >= 3.2
				} elseif ( $plugin === 'WPML' && defined( 'ICL_SITEPRESS_VERSION' ) && version_compare( ICL_SITEPRESS_VERSION, '3.2', '>=' ) ) {
					$sitepress->switch_lang( $language, true );
					
					foreach ( $this->strings as $key => $string ) {
						$sanitized_key = str_replace( '-', '_', sanitize_title( $key ) );
						$slugs[$sanitized_key] = apply_filters( 'wpml_translate_single_string', Events_Maker()->options['permalinks'][$sanitized_key], 'Events Maker', $string, $language );
					}
				// WPML < 3.2
				} elseif ( $plugin === 'WPML' && function_exists( 'icl_t' ) ) {
					
					$sitepress->switch_lang( $language, true );
					$has_translation = null; // required by WPML icl_t() function
					
					foreach ( $this->strings as $key => $string ) {
						$sanitized_key = str_replace( '-', '_', sanitize_title( $key ) );
						$slugs[$sanitized_key] = icl_t( 'Events Maker', $key, untrailingslashit( esc_html( Events_Maker()->options['permalinks'][$sanitized_key] ) ), $has_translation, false, $language );
					}
				}

				$slugs = apply_filters( 'em_translated_taxonomy_rewrite_slugs_' . $language, $slugs );

				// set translated post type slugs
				$this->post_type_slugs['event'][$language] = array(
					'has_archive'	 => $slugs['event_rewrite_base'],
					'rewrite'		 => array(
						'slug' => $slugs['event_rewrite_base'] . '/' . $slugs['event_rewrite_slug'],
					),
				);

				// set translated taxonomy slugs
				$this->taxonomy_slugs['event-category'][$language] = $slugs['event_rewrite_base'] . '/' . $slugs['event_categories_rewrite_slug'];
				$this->taxonomy_slugs['event-location'][$language] = $slugs['event_rewrite_base'] . '/' . $slugs['event_locations_rewrite_slug'];
				if ( Events_Maker()->options['general']['use_tags'] === true )
					$this->taxonomy_slugs['event-tag'][$language] = $slugs['event_rewrite_base'] . '/' . $slugs['event_tags_rewrite_slug'];
				if ( Events_Maker()->options['general']['use_organizers'] === true )
					$this->taxonomy_slugs['event-organizer'][$language] = $slugs['event_rewrite_base'] . '/' . $slugs['event_organizers_rewrite_slug'];
			}
			// switch back to current language
			if ( $plugin === 'WPML' )
				$sitepress->switch_lang( $current, true );
		}
	}

}

new Events_Maker_WPML();