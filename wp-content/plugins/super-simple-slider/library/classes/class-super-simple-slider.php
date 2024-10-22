<?php
/**
 * Main plugin class file.
 *
 * @package Super Simple Slider/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main plugin class.
 */
class Super_Simple_Slider {

	/**
	 * The single instance of Super_Simple_Slider.
	 *
	 * @var     object
	 * @access  private
	 * @since   1.0.0
	 */
	private static $_instance = null; //phpcs:ignore

	/**
	 * Local instance of Super_Simple_Slider_Admin_API
	 *
	 * @var Super_Simple_Slider_Admin_API|null
	 */
	public $admin = null;

	/**
	 * Settings class object
	 *
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = null;
	
	/**
	 * Super_Simple_Slider_Post_Type class object
	 *
	 * @var     object
	 * @access  public
	 * @since   10.0.0
	 */
	public $post_type = null;

	/**
	 * The version number.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_version; //phpcs:ignore

	/**
	 * The token.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $_token; //phpcs:ignore

	/**
	 * The main plugin file.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $file;

	/**
	 * The main plugin directory.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $dir;

	/**
	 * The plugin assets directory.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_dir;

	/**
	 * The plugin assets URL.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $assets_url;

	/**
	 * Suffix for JavaScripts.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $script_suffix;

	/**
	 * Constructor funtion.
	 *
	 * @param string $file File constructor.
	 * @param string $version Plugin version.
	 */
	public function __construct( $file = '', $version = SUPER_SIMPLE_SLIDER_PLUGIN_VERSION ) {
		$this->_version = $version;
		$this->_text_domain	= 'super-simple-slider';
		$this->_token   = 'super_simple_slider';

		// Load plugin environment variables.
		$this->file       = $file;
		$this->dir        = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'library';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/library/', $this->file ) ) );

		$this->themes = array (
			'namaha' => array (
				'slug' => 'namaha',
				'title' => 'Namaha',
				'thumbnail' => 'https://www.outtheboxthemes.com/wp-content/uploads/2021/04/namaha-imac.png',
				'coming_soon' => false,
				'new' => true
			),
  			'tropicana' => array (
				'slug' => 'tropicana',
				'title' => 'Tropicana',
			    'thumbnail' => 'https://www.outtheboxthemes.com/wp-content/uploads/2018/07/tropicana-imac.png',
    			'coming_soon' => false,
    			'new' => false
		  	),
  			'north-shore' => array (
				'slug' => 'north-shore',
				'title' => 'North Shore',
			    'thumbnail' => 'https://www.outtheboxthemes.com/wp-content/uploads/2018/03/north-shore-imac.png',
    			'coming_soon' => false,
    			'new' => false
		  	),
  			'citylogic' => array (
				'slug' => 'citylogic',
				'title' => 'CityLogic',
			    'thumbnail' => 'https://www.outtheboxthemes.com/wp-content/uploads/2017/08/citylogic-imac.png',
    			'coming_soon' => false,
    			'new' => false
		  	),
  			'shopstar' => array (
				'slug' => 'shopstar',
				'title' => 'Shopstar!',
			    'thumbnail' => 'https://www.outtheboxthemes.com/wp-content/uploads/2015/12/shopstar-imac.png',
    			'coming_soon' => false,
    			'new' => false
		  	),
  			'panoramic' => array (
				'slug' => 'panoramic',
				'title' => 'Panoramic',
			    'thumbnail' => 'https://www.outtheboxthemes.com/wp-content/uploads/2015/12/panoramic-imac.png',
    			'coming_soon' => false,
    			'new' => false
			)
		);
		
		// Check if there are any new themes
		foreach ($this->themes as $theme) {
			$theme = (object) $theme;
			$new = true === $theme->new;
			
			if ($new && !get_option( 'otb_new_theme_' .$theme->slug. '_viewed' ) ) {
				add_filter( 'add_menu_classes', array( $this, 'show_notification_bubble' ) );
				
				update_option( 'otb_new_theme', true );
				$this->tabs['themes']['highlighted'] = true;
			}
		}
		
		$this->script_suffix = defined( 'SUPER_SIMPLE_SLIDER_DEBUG' ) && SUPER_SIMPLE_SLIDER_DEBUG ? '' : '.min';

		register_activation_hook( $this->file, array( $this, 'install' ) );

		// Load frontend JS & CSS.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ), 10 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ), 10 );

		// Load admin JS & CSS.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), 10, 1 );

		// Handle localisation.
		$this->load_plugin_textdomain();
		add_action( 'init', array( $this, 'load_localisation' ), 0 );
		
		// Load the widget
		add_action( 'widgets_init', array( $this, 'load_custom_widgets' ) );
		
		add_action( 'admin_menu', array( $this, 'add_our_themes_menu' ) );
		
		// Add a link to the plugin listing on the Installed Plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this, 'add_link_to_plugin_listing' ) );
	}
	
	public function show_notification_bubble( $menu ) {
		foreach( $menu as $menu_key => $menu_data ) {
			if ( $menu_data[0] == 'Appearance' ) {
				$menu[$menu_key][0] .= "<span class='update-plugins count-1'><span class='plugin-count'>1</span></span>";
			}
		}
				
		return $menu;
	}
	
	/**
	 * Register post type function.
	 *
	 * @param string $post_type Post Type.
	 * @param string $plural Plural Label.
	 * @param string $single Single Label.
	 * @param string $description Description.
	 * @param array  $options Options array.
	 *
	 * @return bool|string|Super_Simple_Slider_Post_Type
	 */
	public function register_post_type( $post_type = '', $plural = '', $single = '', $description = '', $options = array() ) {

		if ( ! $post_type || ! $plural || ! $single ) {
			return false;
		}

		$post_type = new Super_Simple_Slider_Post_Type( super_simple_slider(), $post_type, $plural, $single, $description, $options );

		$this->post_type = $post_type;
		
		return $post_type;
	}

	/**
	 * Wrapper function to register a new taxonomy.
	 *
	 * @param string $taxonomy Taxonomy.
	 * @param string $plural Plural Label.
	 * @param string $single Single Label.
	 * @param array  $post_types Post types to register this taxonomy for.
	 * @param array  $taxonomy_args Taxonomy arguments.
	 *
	 * @return bool|string|Super_Simple_Slider_Taxonomy
	 */
	public function register_taxonomy( $taxonomy = '', $plural = '', $single = '', $post_types = array(), $taxonomy_args = array() ) {

		if ( ! $taxonomy || ! $plural || ! $single ) {
			return false;
		}

		$taxonomy = new Super_Simple_Slider_Taxonomy( $taxonomy, $plural, $single, $post_types, $taxonomy_args );

		return $taxonomy;
	}

	/**
	 * Load frontend CSS.
	 *
	 * @access  public
	 * @return void
	 * @since   1.0.0
	 */
	public function enqueue_frontend_styles() {
		// Font Awesome
		wp_register_style( $this->_text_domain . '-font-awesome', esc_url( $this->assets_url ) . 'fonts/sss-font-awesome/css/sss-font-awesome.css', array(), '4.7.0' );
		wp_enqueue_style( $this->_text_domain . '-font-awesome' );
		
		// The frontend stylesheet
		wp_register_style( $this->_text_domain . '-frontend', esc_url( $this->assets_url ) . 'css/frontend.css', array(), $this->_version );
		wp_enqueue_style( $this->_text_domain . '-frontend' );
	}

	/**
	 * Load frontend Javascript.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function enqueue_frontend_scripts() {
		// The slider plugin's default script file
		wp_register_script( 'carouFredSel-js', esc_url( $this->assets_url ) . 'sliders/carouFredSel/jquery.carouFredSel-6.2.1' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( 'carouFredSel-js' );

		// TouchSwipe
		wp_register_script( $this->_text_domain . '-touchswipe-js', esc_url( $this->assets_url ) . 'js/jquery.touchSwipe' . $this->script_suffix . '.js', array('jquery'), $this->_version, true );
		wp_enqueue_script( $this->_text_domain . '-touchswipe-js' );
		
		// The custom script file for the slider plugin
		wp_register_script( $this->_text_domain . '-carouFredSel-custom-js', esc_url( $this->assets_url ) . 'js/carouFredSel-custom' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( $this->_text_domain . '-carouFredSel-custom-js' );

		// FitText
		wp_register_script( $this->_text_domain . '-fittext-js', esc_url( $this->assets_url ) . 'js/jquery.fittext' . $this->script_suffix . '.js', array('jquery'), $this->_version, true );
		wp_enqueue_script( $this->_text_domain . '-fittext-js' );

		// FitButton
		wp_register_script( $this->_text_domain . '-fitbutton-js', esc_url( $this->assets_url ) . 'js/jquery.fitbutton' . $this->script_suffix . '.js', array('jquery'), $this->_version, true );
		wp_enqueue_script( $this->_text_domain . '-fitbutton-js' );
		
		// The frontend script file
		wp_register_script( $this->_text_domain . '-frontend-js', esc_url( $this->assets_url ) . 'js/frontend' . $this->script_suffix . '.js', array( 'jquery', $this->_text_domain . '-fittext-js', $this->_text_domain . '-fitbutton-js' ), $this->_version, true );
		wp_enqueue_script( $this->_text_domain . '-frontend-js' );
	}

	/**
	 * Admin enqueue style.
	 *
	 * @param string $hook Hook parameter.
	 *
	 * @return void
	 */
	public function enqueue_admin_styles( $hook = '' ) {
		global $post;
		
		if ( ( $hook != 'post-new.php' && $hook != 'post.php' && $hook != 'super-simple-slider_page_themes' ) || ( $post && $post->post_type !== 'super-simple-slider' ) ) {
			return;
	    }
		
		// Font Awesome
		wp_register_style( $this->_text_domain . '-font-awesome', esc_url( $this->assets_url ) . 'fonts/sss-font-awesome/css/sss-font-awesome.css', array(), '4.7.0' );
		wp_enqueue_style( $this->_text_domain . '-font-awesome' );

		// The admin stylesheet
		wp_register_style( $this->_text_domain . '-admin', esc_url( $this->assets_url ) . 'css/admin.css', array(), $this->_version );
		wp_enqueue_style( $this->_text_domain . '-admin' );
	}

	/**
	 * Load admin Javascript.
	 *
	 * @access  public
	 *
	 * @param string $hook Hook parameter.
	 *
	 * @return  void
	 * @since   1.0.0
	 */
	public function enqueue_admin_scripts( $hook = '' ) {
		global $post;

		if ( ( $hook != 'post-new.php' && $hook != 'post.php' ) || ( $post && $post->post_type !== 'super-simple-slider' ) ) {
			return;
	    }
		
		wp_enqueue_media();
		
		// The admin script file
		wp_register_script( $this->_text_domain . '-admin-js', esc_url( $this->assets_url ) . 'js/admin' . $this->script_suffix . '.js', array( 'jquery' ), $this->_version, true );
		wp_enqueue_script( $this->_text_domain . '-admin-js' );
	}

	/**
	 * Load plugin localisation
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function load_localisation() {
		load_plugin_textdomain( 'super-simple-slider', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	}

	/**
	 * Load plugin textdomain
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = 'super-simple-slider';

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	}

	public function load_custom_widgets() {
		register_widget( 'Super_Simple_Slider_Widget' );
	}
	
	/**
	 * Add an upgrade link to installed plugins list
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_link_to_plugin_listing( $links ) {
		$settings_link = '<a href="https://www.outtheboxthemes.com/go/plugin-super-simple-slider-upgrade/" style="color: #3db634;" target="_blank" rel="noopener noreferrer">' . __( 'Go Pro', 'super-simple-slider' ) . '</a>';
		array_push( $links, $settings_link );
		return $links;
	}
	
	/**
	 * Add plugin our themes item
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function add_our_themes_menu() {
		add_submenu_page(
			'edit.php?post_type=super-simple-slider',
			__( '<span class="premium-link" style="color: #f18500;">Our Themes</span>', 'super-simple-slider' ),
			__( '<span class="premium-link" style="color: #f18500;">Our Themes</span>', 'super-simple-slider' ),
			'manage_options',
			'themes',
			array( $this, 'create_themes_page'),
			null
		);
	}

	public function create_themes_page() {
		include( $this->assets_dir .'/template-parts/content-themes.php' );
	}
	
	public function hex_to_rgb( $hex ) {
		// Remove "#" if it was added
		$color = trim( $hex, '#' );
	
		// Return empty array if invalid value was sent
		if ( ! ( 3 === strlen( $color ) ) && ! ( 6 === strlen( $color ) ) ) {
			return array();
		}
	
		// If the color is three characters, convert it to six.
		if ( 3 === strlen( $color ) ) {
			$color = $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
		}
	
		// Get the red, green, and blue values
		$red   = hexdec( $color[0] . $color[1] );
		$green = hexdec( $color[2] . $color[3] );
		$blue  = hexdec( $color[4] . $color[5] );
	
		// Return the RGB colors as an array
		return array( 'r' => $red, 'g' => $green, 'b' => $blue );
	}
	
	/**
	 * Main Super_Simple_Slider Instance
	 *
	 * Ensures only one instance of Super_Simple_Slider is loaded or can be loaded.
	 *
	 * @param string $file File instance.
	 * @param string $version Version parameter.
	 *
	 * @return Object Super_Simple_Slider instance
	 * @see Super_Simple_Slider()
	 * @since 1.0.0
	 * @static
	 */
	public static function instance( $file = '', $version = SUPER_SIMPLE_SLIDER_PLUGIN_VERSION ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $file, $version );
		}

		return self::$_instance;
	}

	/**
	 * Function to determine whether a plugin is active.
	 *
	 * @param string $plugin_name plugin name, as the plugin-filename.php
	 * @return boolean true if the named plugin is installed and active
	 * @since 1.0.0
	 */
	public static function is_plugin_active( $plugin_name ) {

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, array_keys( get_site_option( 'active_sitewide_plugins', array() ) ) );
		}

		$plugin_filenames = array();

		foreach ( $active_plugins as $plugin ) {

			if ( false !== strpos( $plugin, '/' ) ) {

				// normal plugin name (plugin-dir/plugin-filename.php)
				list( , $filename ) = explode( '/', $plugin );

			} else {

				// no directory, just plugin file
				$filename = $plugin;
			}

			$plugin_filenames[] = $filename;
		}

		return in_array( $plugin_name, $plugin_filenames );
	}

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html( __( 'Cloning of Super_Simple_Slider is forbidden' ) ), esc_attr( $this->_version ) );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html( __( 'Unserializing instances of Super_Simple_Slider is forbidden' ) ), esc_attr( $this->_version ) );
	}

	/**
	 * Installation. Runs on activation.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function install() {
		$this->_log_version_number();
	}

	/**
	 * Log the plugin version number.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	private function _log_version_number() { //phpcs:ignore
		update_option( str_replace('-', '_', $this->_text_domain ) . '_version', $this->_version );
	}

}
