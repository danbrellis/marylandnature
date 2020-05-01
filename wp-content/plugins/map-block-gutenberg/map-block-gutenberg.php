<?php
/*
Plugin Name: Maps Block for Gutenberg
Description: Simple, no-nonsense map block powered by Google Maps for Gutenberg editor.
Author: WebFactory Ltd
Version: 1.30
Author URI: https://www.webfactoryltd.com/
Text Domain: map-block-gutenberg
  
  Copyright 2018  Web factory Ltd  (email : support@webfactoryltd.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//  Exit if accessed directly.
defined('ABSPATH') || exit;

class wf_map_block {
  static $version;

  // get plugin version from header
  static function get_plugin_version() {
    $plugin_data = get_file_data(__FILE__, array('version' => 'Version'), 'plugin');
    self::$version = $plugin_data['version'];

    return $plugin_data['version'];
  } // get_plugin_version


  // hook things up
  static function init() {
    if (is_admin()) {
      if (false === self::check_gutenberg()) {
        return false;
      }

      add_filter('plugin_action_links_' . basename(dirname(__FILE__)) . '/' . basename(__FILE__),
                 array(__CLASS__, 'plugin_action_links'));
      add_filter('plugin_row_meta', array(__CLASS__, 'plugin_meta_links'), 10, 2);

      add_action('enqueue_block_editor_assets', array(__CLASS__, 'enqueue_block_editor_assets'));

      add_action('wp_ajax_gmw_map_block_save_key', array(__CLASS__, 'save_key'));
      add_action('wp_ajax_nopriv_gmw_map_block_save_key', array(__CLASS__, 'save_key'));

      add_filter('install_plugins_table_api_args_featured', array(__CLASS__, 'featured_plugins_tab'));
    }
  } // init


  static function save_key() {
    $key = substr(sanitize_html_class(@$_POST['api_key']), 0, 64);
    update_option('gmw-map-block-key', $key);
    echo $key;
    die();
  } // save_key


  // some things have to be loaded earlier
  static function plugins_loaded() {
    self::$version = self::get_plugin_version();
  } // plugins_loaded


  // add links to plugins page
  static function plugin_action_links($links) {
    $gutenberg_link = '<a href="' . admin_url('admin.php?page=gutenberg') . '" title="' . __('Create a new post using the Gutenberg editor', 'map-block-gutenberg') . '">' . __('Create with Gutenberg', 'map-block-gutenberg') . '</a>';

    array_unshift($links, $gutenberg_link);

    return $links;
  } // plugin_action_links


  // add links to plugin's description in plugins table
  static function plugin_meta_links($links, $file) {
    $support_link = '<a target="_blank" href="https://wordpress.org/support/plugin/map-block-gutenberg" title="' . __('Problems? We are here to help!', 'map-block-gutenberg') . '">' . __('Support', 'map-block-gutenberg') . '</a>';
    $review_link = '<a target="_blank" href="https://wordpress.org/support/view/plugin-reviews/map-block-gutenberg?filter=5#pages" title="' . __('If you like it, please review the plugin', 'map-block-gutenberg') . '">' . __('Review the plugin', 'map-block-gutenberg') . '</a>';

    if ($file == plugin_basename(__FILE__)) {
      $links[] = $support_link;
      $links[] = $review_link;
    }

    return $links;
  } // plugin_meta_links


  // enqueue block files
  static function enqueue_block_editor_assets() {
    
    // Enqueue the bundled block JS file
    wp_register_script(
      'wf-map-block',
      plugins_url('/assets/js/editor.blocks.js', __FILE__),
      [ 'wp-editor', 'wp-i18n', 'wp-element', 'wp-blocks', 'wp-components' ],
      self::$version
    );

    $api_key = get_option('gmw-map-block-key')? get_option('gmw-map-block-key'): 'AIzaSyAjyDspiPfzEfjRSS5fQzm-3jHFjHxeXB4';
    $wf_map_block = array(
      'api_key' => $api_key,
      '_description' => __('Simple yet powerfull map block powered by Google Maps.', 'map-block-gutenberg'),
      '_map' => __('Map', 'map-block-gutenberg'),
      '_map_lc' => __('map', 'map-block-gutenberg'),
      '_location_lc' => __('location', 'map-block-gutenberg'),
      '_address' => __('Address', 'map-block-gutenberg'),
      '_zoom' => __('Zoom', 'map-block-gutenberg'),
      '_height' => __('Height', 'map-block-gutenberg'),
      '_api_key' => __('API Key', 'map-block-gutenberg'),
      '_api_info_start' => __('Please create your own API key on the', 'map-block-gutenberg'),
      '_api_info_console' => __('Google Console', 'map-block-gutenberg'),
      '_api_info_end' => __('This is a requirement enforced by Google.', 'map-block-gutenberg')
    );
    wp_localize_script( 'wf-map-block', 'wf_map_block', $wf_map_block );

    wp_enqueue_script('wf-map-block');

    // Enqueue optional editor only styles
    wp_enqueue_style(
      'wf-map-block',
      plugins_url('/assets/css/blocks.editor.css', __FILE__),
      [ 'wp-editor' ],
      self::$version
    );  
  } // enqueue_block_editor_assets


  // check if Gutenberg is available
  static function check_gutenberg() {
    if (false === defined('GUTENBERG_VERSION') && false === version_compare(get_bloginfo('version'), '5.0', '>=')) {
        add_action('admin_notices', array(__CLASS__, 'notice_gutenberg_missing'));
        return false;
    }
  } // check_gutenberg


  // complain if Gutenberg is not available
  static function notice_gutenberg_missing() {
    echo '<div class="error"><p><b>Map Block</b> plugin requires the Gutenberg plugin to work. It is after all a block for Gutenberg ;)<br>Install the <a href="https://wordpress.org/plugins/gutenberg/" target="_blank">Gutenberg plugin</a> and this notice will go away.</p></div>';
  } // notice_gutenberg_missing

  // helper function for adding plugins to fav list
  static function featured_plugins_tab($args) {
    add_filter('plugins_api_result', array(__CLASS__, 'plugins_api_result'), 10, 3);

    return $args;
  } // featured_plugins_tab


  // add single plugin to list of favs
  static function add_plugin_favs($plugin_slug, $res) {
    if (!isset($res->plugins) || !is_array($res->plugins)) {
      return $res;
    }

    if (!empty($res->plugins) && is_array($res->plugins)) {
      foreach ($res->plugins as $plugin) {
        if (is_object($plugin) && !empty($plugin->slug) && $plugin->slug == $plugin_slug) {
          return $res;
        }
      } // foreach
    }

    $plugin_info = get_transient('wf-plugin-info-' . $plugin_slug);

    if (!$plugin_info) {
      $plugin_info = plugins_api('plugin_information', array(
        'slug'   => $plugin_slug,
        'is_ssl' => is_ssl(),
        'fields' => array(
          'banners'           => true,
          'reviews'           => true,
          'downloaded'        => true,
          'active_installs'   => true,
          'icons'             => true,
          'short_description' => true,
        )
      ));
      if (!is_wp_error($plugin_info)) {
        set_transient('wf-plugin-info-' . $plugin_slug, $plugin_info, DAY_IN_SECONDS * 7);
      }
    }

    if ($plugin_info && !is_wp_error($plugin_info)) {
      array_unshift($res->plugins, $plugin_info);
    }

    return $res;
  } // add_plugin_favs


  // add our plugins to recommended list
  static function plugins_api_result($res, $action, $args) {
    remove_filter('plugins_api_result', array(__CLASS__, 'plugins_api_result'), 10, 3);

    $res = self::add_plugin_favs('eps-301-redirects', $res);
    $res = self::add_plugin_favs('sticky-menu-or-anything-on-scroll', $res);
    $res = self::add_plugin_favs('wp-force-ssl', $res);

    return $res;
  } // plugins_api_result
} // class


// get the party started
add_action('init', array('wf_map_block', 'init'));
add_action('plugins_loaded', array('wf_map_block', 'plugins_loaded'));
