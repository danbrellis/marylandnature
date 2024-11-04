<?php
/**
 * Post type declaration file.
 *
 * @package Super Simple Slider/Includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post type declaration class.
 */
class Super_Simple_Slider_Post_Type {

	/**
	 * The single instance of Super_Simple_Slider_Post_Type.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;
	
	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;
	
	/**
	 * The name for the custom post type.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $post_type;

	/**
	 * The name for the custom post type.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $field;
	
	/**
	 * The plural name for the custom post type posts.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $plural;

	/**
	 * The singular name for the custom post type posts.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $single;

	/**
	 * The description of the custom post type.
	 *
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $description;

	/**
	 * The options of the custom post type.
	 *
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $options;
	
	public $repeatable_fieldset_settings;
	
	/**
	 * Constructor
	 *
	 * @param string $post_type Post type.
	 * @param string $plural Post type plural name.
	 * @param string $single Post type singular name.
	 * @param string $description Post type description.
	 * @param array  $options Post type options.
	 */
	public function __construct( $parent, $post_type = '', $plural = '', $single = '', $description = '', $options = array() ) {
		$this->parent = $parent;
		
		if ( ! $post_type || ! $plural || ! $single ) {
			return;
		}
		
		$this->settings = array(
			'repeatable' => false,
			'fields' => array(
				'super_simple_slider_has_min_width' => array(
					'type'			=> 'checkbox',
					'default'		=> false,
					'hasDependents'	=> true,
					'class'			=> '',
					'description'	=> __( 'Slider has a minimum width', 'super-simple-slider' ),
				),
				'super_simple_slider_min_width' => array(
					'type'			=> 'pixels',
					'placeholder'	=> '',
					'suffix'		=> 'px',
					'class'			=> 'full-width',
					'default'		=> 600,
				),
				'super_simple_slider_speed' => array(
					'label'			=> __( 'Transition Speed', 'super-simple-slider' ),
					'type'			=> 'milliseconds',
					'placeholder'	=> '',
					'suffix'		=> 'ms',
					'class'			=> 'full-width',
					'default'		=> 450,
					'description' => __( 'The speed it takes to transition between slides in milliseconds. 1000 milliseconds equals 1 second.', 'super-simple-slider' )
				)
			)
		);
		
		$this->repeatable_fieldset_settings = array(
			'repeatable' => true,
			'fields' => array(
				'super_simple_slider_slide_image' => array(
					'type'			=> 'media_upload',
					'class'			=> '',
					'description'	=> '',
				),
				'super_simple_slider_slide_title' => array(
					'type'			=> 'text',
					'placeholder'	=> __( 'Heading', 'super-simple-slider' ),
					'class'			=> '',
					'description'	=> ''
				),
				'super_simple_slider_slide_text' => array(
					'type'			=> 'html',
					'placeholder'	=> __( 'Text', 'super-simple-slider' ),
					'class'			=> '',
					'description'	=> ''
				),
				'super_simple_slider_slide_button_1_text' => array(
					'type'			=> 'text',
					'placeholder'	=> __( 'Button Text', 'super-simple-slider' ),
					'class'			=> 'full-width text',
					'description'	=> ''
				),
				'super_simple_slider_slide_button_1_link_content' => array(
					'type'			=> 'dropdown_pages_posts',
					'class'			=> 'full-width link_content',
					'description' => ''
				),
				'super_simple_slider_slide_button_1_link_target' => array(
					'type'			=> 'select',
					'options'		=> array(
						'' 			  => __( 'Open the link in...', 'super-simple-slider' ),
						'same-window' => __( 'The Same Window', 'super-simple-slider' ),
						'new-window'  => __( 'A New Window', 'super-simple-slider' )
					),
					'placeholder'	=> '',
					'class'			=> 'full-width link_target',
					'default'		=> 'placeholder'
				),
				'super_simple_slider_slide_button_1_link_custom_url' => array(
					'type'			=> 'url',
					'placeholder'	=> __( 'Add a URL to link to', 'super-simple-slider' ),
					'class'			=> 'full-with link_custom_url',
					'description'	=> ''
				),
				'super_simple_slider_slide_image_title' => array(
					'type'			=> 'text',
					'placeholder'	=> __( 'Image Title Text', 'super-simple-slider' ),
					'class'			=> '',
					'description'	=> ''
				),
				'super_simple_slider_slide_image_alt' => array(
					'type'			=> 'text',
					'placeholder'	=> __( 'Image Alt Text', 'super-simple-slider' ),
					'class'			=> '',
					'description'	=> ''
				),
				'super_simple_slider_slide_overlay_opacity' => array(
					'label'			=> __( 'Overlay Opacity', 'super-simple-slider' ),
					'type'			=> 'range',
					'default'		=> 0,
					'show_labels'	=> true,
					'min_labels' 	=> true,
			    	'input_attrs' => array(
			    		'min'   => 0,
			    		'max'   => 1,
			    		'step'  => 0.1,
			    		'style' => 'color: #000000',
			    	),
					'placeholder'	=> '',
					'class'			=> '',
					'description'	=> ''
				),
				'super_simple_slider_slide_text_overlay_opacity' => array(
					'label'			=> __( 'Text Overlay Opacity', 'super-simple-slider' ),
					'type'			=> 'range',
					'default'		=> 0.3,
					'show_labels'	=> true,
					'min_labels' 	=> true,
			    	'input_attrs' => array(
			    		'min'   => 0,
			    		'max'   => 1,
			    		'step'  => 0.1,
			    		'style' => 'color: #000000',
			    	),
					'placeholder'	=> '',
					'class'			=> '',
					'description'	=> ''
				),
				'super_simple_slider_slide_text_overlay_text_shadow' => array(
					'label'			=> __( 'Text Shadow', 'super-simple-slider' ),
					'type'			=> 'checkbox',
					'default'		=> false,
					'class'			=> '',
					'description' 	=> __( 'Display a drop shadow on the text overlay text', 'super-simple-slider' ),
				)
			)
		);

		// Post type name and labels.
		$this->post_type   = $post_type;
		$this->plural      = $plural;
		$this->single      = $single;
		$this->description = $description;
		$this->options     = $options;

		// Regsiter post type.
		add_action( 'init', array( $this, 'register_post_type' ) );

		// Add custom meta boxes
		add_action( 'admin_init', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post_super-simple-slider', array( $this, 'save_slides_meta' ) );
		add_action( 'save_post_super-simple-slider', array( $this, 'save_global_settings_meta' ) );

		// Register shortcodes
		add_shortcode( 'ssslider', array( $this, 'super_simple_slider_shortcode' ) );
		add_shortcode( 'super-simple-slider', array( $this, 'super_simple_slider_shortcode' ) );

		// Display custom update messages for posts edits.
		add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );
		add_filter( 'bulk_post_updated_messages', array( $this, 'bulk_updated_messages' ), 10, 2 );
	}

	/**
	 * Register new post type
	 *
	 * @return void
	 */
	public function register_post_type() {
		//phpcs:disable
		$labels = array(
			'name'               => $this->plural,
			'singular_name'      => $this->single,
			'name_admin_bar'     => $this->single,
			'add_new'            => _x( 'Add New', $this->post_type, 'super-simple-slider' ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'super-simple-slider' ), $this->single ),
			'edit_item'          => sprintf( __( 'Edit %s', 'super-simple-slider' ), $this->single ),
			'new_item'           => sprintf( __( 'New %s', 'super-simple-slider' ), $this->single ),
			'all_items'          => sprintf( __( 'All %s', 'super-simple-slider' ), $this->plural ),
			'view_item'          => sprintf( __( 'View %s', 'super-simple-slider' ), $this->single ),
			'search_items'       => sprintf( __( 'Search %s', 'super-simple-slider' ), $this->plural ),
			'not_found'          => sprintf( __( 'No %s Found', 'super-simple-slider' ), $this->plural ),
			'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', 'super-simple-slider' ), $this->plural ),
			'parent_item_colon'  => sprintf( __( 'Parent %s' ), $this->single ),
			'menu_name'          => $this->plural,
		);
		//phpcs:enable

		$args = array(
			'labels'                => apply_filters( $this->post_type . '_labels', $labels ),
			'description'           => $this->description,
			'public'                => true,
			'publicly_queryable'    => true,
			'exclude_from_search'   => false,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => true,
			'query_var'             => true,
			'can_export'            => true,
			'rewrite'               => true,
			'capability_type'       => 'post',
			'has_archive'           => false,
			'hierarchical'          => false,
			'show_in_rest'          => true,
			'rest_base'             => $this->post_type,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'supports'              => array( 'title' ),
			'menu_position'         => 80,
			'menu_icon'             => 'dashicons-admin-post',
		);

		$args = array_merge( $args, $this->options );

		register_post_type( $this->post_type, apply_filters( $this->post_type . '_register_args', $args, $this->post_type ) );
	}

	/*
	* Setup custom meta boxes
	*/
	public function add_meta_boxes() {
		// Create the Slide Meta Boxes
		add_meta_box( 'super-simple-slider-slide-settings-group', __( 'Slides', 'super-simple-slider' ), array( $this, 'create_slide_settings_meta_box' ), 'super-simple-slider', 'normal', 'default' );
		add_filter( 'postbox_classes_super-simple-slider_super-simple-slider-slide-settings-group', array( $this, 'add_metabox_classes' ) );
		
		// Create the Shortcode Meta Box
		add_meta_box( 'super-simple-slider-shortcode-group', __( 'Shortcode', 'super-simple-slider' ), array( $this, 'create_shortcode_meta_box' ), 'super-simple-slider', 'side', 'high' );
		
		// Create the Global Settings Meta Box
		add_meta_box( 'super-simple-slider-global-settings-group', __( 'Global Settings', 'super-simple-slider' ), array( $this, 'create_global_settings_meta_box' ), 'super-simple-slider', 'side', 'default' );
	}

	/*
	* Create repeatable slide fieldset
	*/
	public function create_slide_settings_meta_box() {
		global $post;
		
		$slide_settings = get_post_meta( $post->ID, 'super-simple-slider-slide-settings-group', true );

		wp_nonce_field( 'otb_repeater_nonce', 'otb_repeater_nonce' );
		?>
		
		<div class="otb-postbox-container">

			<table class="otb-panel-container multi sortable repeatable" width="100%" cellpadding="0" cellspacing="0" border="0">
				<tbody class="container">
					<?php
					$hidden_panel = false;
					
					if ( $slide_settings ) :
						foreach ( $slide_settings as $setting ) {
							$this->field = $setting;
							include( $this->parent->assets_dir .'/template-parts/repeatable-panel-slide.php' );
						}
					else : 
						// show a blank one
						include( $this->parent->assets_dir .'/template-parts/repeatable-panel-slide.php' );
					endif;
					
					$this->field = null;
					
					// Empty hidden panel used for creating a new panel
					$hidden_panel = true;
					include( $this->parent->assets_dir .'/template-parts/repeatable-panel-slide.php' );
					?>
				</tbody>
			</table>

			<div class="footer">
				<div class="left">
					<a class="button upgrade" href="https://www.outtheboxthemes.com/go/plugin-super-simple-slider-upgrade/" target="_blank"><?php esc_html_e( 'Go Pro', 'super-simple-slider' ); ?></a> <?php esc_html_e( 'See what Super Simple Slider Premium has to offer', 'super-simple-slider' ); ?>
				</div>
				
				<div class="right">
					<a class="button add-repeatable-panel" href="#"><?php esc_html_e( 'Add Another Slide', 'super-simple-slider' ); ?></a>
				</div>
			</div>
			
		</div>
		
	<?php
	}
	
	public function add_metabox_classes( $classes ) {
		array_push( $classes, 'otb-postbox', 'seamless' );
		return $classes;
	}
	
	/*
	* Create global settings meta box
	*/
	public function create_global_settings_meta_box() {
		global $post;
		
		include( $this->parent->assets_dir .'/template-parts/global-settings.php' );
	}
	
	/*
	* Create Shortcode meta box
	*/
	public function create_shortcode_meta_box() {
		global $post;
	?>
		<div class="text-input-with-button-container copyable">
			<input name="super_simple_slider_shortcode" value="<?php esc_html_e( '[ssslider id="' . $post->ID . '"]' ); ?>" readonly />
			<div class="icon copy">
				<i class="sss-fa sss-fa-copy"></i>
			</div>
			<div class="message"><?php esc_html_e( 'Copied to clipboard', 'super-simple-slider' ); ?></div>
		</div>
	<?php
	}
	
	/*
	* Save slides meta
	*/
	public function save_slides_meta( $post_id ) {
		if ( !isset( $_POST['otb_repeater_nonce'] ) || !wp_verify_nonce( $_POST['otb_repeater_nonce'], 'otb_repeater_nonce' ) )
			return;
		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !current_user_can( 'edit_post', $post_id ) )
			return;

		$sss_old = get_post_meta( $post_id, 'super-simple-slider-slide-settings-group', true );
		$sss_new = array();
		
		$repeatable_fieldset_settings = $this->repeatable_fieldset_settings['fields'];
		//$repeatable_fieldset_settings_array = array();
		
        foreach ( $repeatable_fieldset_settings as $name => $config ) {
			$values_array = wp_unslash( $_POST[ $name ] );
			
			for ( $i=0; $i<count( $values_array ); $i++ ) {
				$sss_new[$i][ $name ] = $this->sanitize_field( $values_array[$i], $config['type'] );
			}
        }
        
		if ( !empty( $sss_new ) && $sss_new != $sss_old ) {
			update_post_meta( $post_id, 'super-simple-slider-slide-settings-group', $sss_new );
		} elseif ( empty( $sss_new ) && $sss_old ) {
			delete_post_meta( $post_id, 'super-simple-slider-slide-settings-group', $sss_old );
		}
	}
	
	/*
	* Save global settings meta
	*/
	public function save_global_settings_meta( $post_id ) {
		if ( !isset( $_POST['otb_repeater_nonce'] ) || !wp_verify_nonce( $_POST['otb_repeater_nonce'], 'otb_repeater_nonce' ) )
			return;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !current_user_can( 'edit_post', $post_id ) )
			return;
		
		$settings = $this->settings['fields'];
		$value;
		
        foreach ( $settings as $name => $config ) {
			$post = '';
			
			if ( isset( $_POST[ $name ] ) ) {
				$post = $_POST[ $name ];
			}

			$value = $this->sanitize_field( wp_unslash( $post ), $config['type'] );
			update_post_meta( $post_id, $name, $value);
        }
	}
	
	/* Utility function for creating form controls */
	public function create_super_simple_form_control( $id, $settings ) {
		global $post;
		
		$value = '';
		$formControl = null;
		
		$repeatable 	   = $this->getIfSet( $settings['repeatable'], false);
		$parent_field_type = $this->getIfSet($settings['type'], '');
		$field_counter 	   = $this->getIfSet($settings['field_counter'], '');
		$settings 		   = $settings['fields'][$id];
		$field_type 	   = $settings['type'];
		
		if ( ( $repeatable || $parent_field_type == 'repeatable_fieldset' ) && isset( $this->field[$id] ) ) {
			$value = $this->field[$id];
		} else if ( !$repeatable ) {
			$value = get_post_meta( $post->ID, $id, true );
		}

		if ( !is_numeric( $value ) && empty( $value ) && isset( $settings['default'] ) ) {		
			$value = $settings['default'];
		}
		
		$formControl = new Super_Simple_Form_Control( $id, $this, $repeatable, $settings, $value, $field_counter );
		
		return $formControl;
	}
	
	/* Utility function for sanitizing form control values */
	public function sanitize_field( $value, $type ) {
		switch( $type ) {
			case 'text':
			case 'email':
			case 'password':
				$value = sanitize_text_field( $value );
			break;

			case 'number':
				$value = intval( $value );
			break;

			case 'float':
			case 'milliseconds':
			case 'percentage':
			case 'range':
				$value = floatVal( $value );
			break;

			case 'color':
				$value = sanitize_hex_color( $value );
			break;
			
			case 'url':
				$value = esc_url( $value );
			break;
			
			case 'textarea':
				$value = sanitize_textarea_field( $value );
			break;

			case 'html':
				$value = wp_kses( $value, array(
					'a' => array(
						'href' => array(),
						'title' => array(),
						'target' => array()
					),
					'img' => array(
						'src' => array(),
						'height' => array(),
						'width' => array()
					),
					'ol' => array(),
					'ul' => array(),
					'li' => array(),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				) );
			break;
			
			case 'tinymce':
				$value = $value;
			break;

			case 'checkbox':
 				$value = intval( (bool) $value );
			break;
			
			case 'media_upload':
				$value = intval( $value );
			break;
		}
		
		return $value;
	}
	
	function getIfSet( &$var, $defaultValue ) {
		if(isset($var)) {
			return $var;
		} else {
			return $defaultValue;
		}
	}

	public function get_default_value( $id, $settings_array ) {
		return $this->$settings_array['fields'][$id]['default'];
	}
	
	/**
	 * Create Slider Shortcode
	 */
	function super_simple_slider_shortcode( $atts ) {
		// Extract attributes passed to shortcode
		extract( shortcode_atts( array(
			'id' => ''
		), $atts ) );
		
		ob_start();
		include( $this->parent->assets_dir .'/template-parts/slider.php' );
		return ob_get_clean();		
	}

	function create_slider( $id ) {
		ob_start();
		include( $this->parent->assets_dir .'/template-parts/slider.php' );
		return ob_get_clean();
	}
	
	/**
	 * Set up admin messages for post type
	 *
	 * @param  array $messages Default message.
	 * @return array           Modified messages.
	 */
	public function updated_messages( $messages = array() ) {
		global $post, $post_ID;
		//phpcs:disable
		$messages[ $this->post_type ] = array(
			0  => '',
			1  => sprintf( __( '%1$s updated. %2$sView %3$s%4$s.', 'super-simple-slider' ), $this->single, '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', $this->single, '</a>' ),
			2  => __( 'Custom field updated.', 'super-simple-slider' ),
			3  => __( 'Custom field deleted.', 'super-simple-slider' ),
			4  => sprintf( __( '%1$s updated.', 'super-simple-slider' ), $this->single ),
			5  => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %2$s.', 'super-simple-slider' ), $this->single, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => sprintf( __( '%1$s published. %2$sView %3$s%4s.', 'super-simple-slider' ), $this->single, '<a href="' . esc_url( get_permalink( $post_ID ) ) . '">', $this->single, '</a>' ),
			7  => sprintf( __( '%1$s saved.', 'super-simple-slider' ), $this->single ),
			8  => sprintf( __( '%1$s submitted. %2$sPreview post%3$s%4$s.', 'super-simple-slider' ), $this->single, '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', $this->single, '</a>' ),
			9  => sprintf( __( '%1$s scheduled for: %2$s. %3$sPreview %4$s%5$s.', 'super-simple-slider' ), $this->single, '<strong>' . date_i18n( __( 'M j, Y @ G:i', 'super-simple-slider' ), strtotime( $post->post_date ) ) . '</strong>', '<a target="_blank" href="' . esc_url( get_permalink( $post_ID ) ) . '">', $this->single, '</a>' ),
			10 => sprintf( __( '%1$s draft updated. %2$sPreview %3$s%4$s.', 'super-simple-slider' ), $this->single, '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) . '">', $this->single, '</a>' ),
		);
		//phpcs:enable

		return $messages;
	}

	/**
	 * Set up bulk admin messages for post type
	 *
	 * @param  array $bulk_messages Default bulk messages.
	 * @param  array $bulk_counts   Counts of selected posts in each status.
	 * @return array                Modified messages.
	 */
	public function bulk_updated_messages( $bulk_messages = array(), $bulk_counts = array() ) {

		//phpcs:disable
		$bulk_messages[ $this->post_type ] = array(
			'updated'   => sprintf( _n( '%1$s %2$s updated.', '%1$s %3$s updated.', $bulk_counts['updated'], 'super-simple-slider' ), $bulk_counts['updated'], $this->single, $this->plural ),
			'locked'    => sprintf( _n( '%1$s %2$s not updated, somebody is editing it.', '%1$s %3$s not updated, somebody is editing them.', $bulk_counts['locked'], 'super-simple-slider' ), $bulk_counts['locked'], $this->single, $this->plural ),
			'deleted'   => sprintf( _n( '%1$s %2$s permanently deleted.', '%1$s %3$s permanently deleted.', $bulk_counts['deleted'], 'super-simple-slider' ), $bulk_counts['deleted'], $this->single, $this->plural ),
			'trashed'   => sprintf( _n( '%1$s %2$s moved to the Trash.', '%1$s %3$s moved to the Trash.', $bulk_counts['trashed'], 'super-simple-slider' ), $bulk_counts['trashed'], $this->single, $this->plural ),
			'untrashed' => sprintf( _n( '%1$s %2$s restored from the Trash.', '%1$s %3$s restored from the Trash.', $bulk_counts['untrashed'], 'super-simple-slider' ), $bulk_counts['untrashed'], $this->single, $this->plural ),
		);
		//phpcs:enable

		return $bulk_messages;
	}
	
	/**
	 * Main Super_Simple_Slider_Post_Type Instance
	 *
	 * Ensures only one instance of Super_Simple_Slider_Post_Type is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Super_Simple_Slider()
	 * @return Main Super_Simple_Slider_Post_Type instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

}
