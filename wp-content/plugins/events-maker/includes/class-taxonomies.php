<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Events_Maker_Taxonomies Class.
 */
class Events_Maker_Taxonomies {

	public $taxonomy_field_args;

	public function __construct() {
		// actions
		add_action( 'after_setup_theme', array( $this, 'load_defaults' ) );
		add_action( 'admin_init', array( $this, 'html_description_init' ) );
		add_action( 'event-category_add_form_fields', array( $this, 'event_category_add_meta_fields' ) );
		add_action( 'event-location_add_form_fields', array( $this, 'event_location_add_meta_fields' ) );
		add_action( 'event-organizer_add_form_fields', array( $this, 'event_organizer_add_meta_fields' ) );
		add_action( 'event-category_edit_form_fields', array( $this, 'event_category_edit_meta_fields' ) );
		add_action( 'event-location_edit_form_fields', array( $this, 'event_location_edit_meta_fields' ) );
		add_action( 'event-organizer_edit_form_fields', array( $this, 'event_organizer_edit_meta_fields' ) );
		add_action( 'edited_event-category', array( $this, 'event_category_save_meta_fields' ), 10, 2 );
		add_action( 'edited_event-location', array( $this, 'event_location_save_meta_fields' ), 10, 2 );
		add_action( 'edited_event-organizer', array( $this, 'event_organizer_save_meta_fields' ), 10, 2 );
		add_action( 'create_event-category', array( $this, 'event_category_save_meta_fields' ), 10, 2 );
		add_action( 'create_event-location', array( $this, 'event_location_save_meta_fields' ), 10, 2 );
		add_action( 'create_event-organizer', array( $this, 'event_organizer_save_meta_fields' ), 10, 2 );

		// filters
		add_filter( 'manage_edit-event-category_columns', array( $this, 'event_taxonomy_columns' ) );
		add_filter( 'manage_edit-event-location_columns', array( $this, 'event_taxonomy_columns' ) );
		add_filter( 'manage_edit-event-organizer_columns', array( $this, 'event_taxonomy_columns' ) );
		add_filter( 'manage_event-category_custom_column', array( $this, 'event_taxonomy_manage_columns' ), 10, 3 );
		add_filter( 'manage_event-location_custom_column', array( $this, 'event_taxonomy_manage_columns' ), 10, 3 );
		add_filter( 'manage_event-organizer_custom_column', array( $this, 'event_taxonomy_manage_columns' ), 10, 3 );
	}

	/**
	 * Load defaults function.
	 */
	public function load_defaults() {
		$this->taxonomy_field_args = apply_filters( 'em_taxonomy_field_args', array(
			'container'				 => 'div',
			'class'					 => array( 'form-field' ),
			'description_container'	 => 'p',
			'description_class'		 => array( 'description' ),
			'label_container'		 => 'label',
			'label_class'			 => array(),
			'input_class'			 => array(),
			'required'				 => false,
			'readonly'				 => false,
			'return'				 => true,
			'context'				 => ''
			)
		);
	}

	/**
	 * Taxonomyorm field function.
	 */
	public function taxonomy_form_field( $key = '', $field = array() ) {
		if ( empty( $key ) || empty( $field ) || ! is_array( $field ) )
			return;

		// field id
		$field['id'] = isset( $field['id'] ) ? sanitize_key( $field['id'] ) : sanitize_key( $key );

		// field name
		$field['name'] = isset( $field['name'] ) ? sanitize_key( $field['name'] ) : sanitize_key( $key );

		// sanitize value
		$field['value'] = $this->sanitize_field(  ! isset( $field['value'] ) || is_null( $field['value'] ) ? $field['default'] : $field['value'], $field['type'] );

		// filter field
		$field = apply_filters( 'em_taxonomy_form_field', wp_parse_args( $field, $this->taxonomy_field_args ), $key );

		// assign classes
		$classes = array();

		// field type class
		if ( $field['type'] )
			$classes[] = 'field-' . $field['type'];

		// container classes
		if ( $field['class'] )
			$classes[] = implode( ' ', (array) $field['class'] );

		// is it required field?
		if ( $field['required'] )
			$classes[] = 'field-required';

		// is it readonly field?
		if ( $field['readonly'] )
			$classes[] = 'field-read-only';

		// field content
		switch ( $field['type'] ) {
			case 'textarea':

				$content = '<textarea name="' . $field['name'] . '" id="' . $field['id'] . '" class="' . implode( ' ', $field['input_class'] ) . '" cols="50" rows="5" />' . $field['value'] . '</textarea>';

				break;

			case 'select':

				$content = '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="' . implode( ' ', $field['input_class'] ) . '" />';
				$content .= '<option value="">' . __( 'None', 'events-maker' ) . '</value>';

				if ( isset( $field['options'] ) && ! empty( $field['options'] ) && is_array( $field['options'] ) ) {
					foreach ( $field['options'] as $value => $name ) {
						$content .= '<option value="' . esc_attr( $value ) . '" ' . selected( $value, $field['value'], false ) . '>' . esc_html( $name ) . '</option>';
					}
				}

				$content .= '</select>';

				break;

			case 'image':

				if ( ! empty( $field['value'] ) )
					$image = wp_get_attachment_image_src( $field['value'], 'thumbnail', false );
				else
					$image[0] = '';

				$content = '<input id="' . $field['id'] . '" name="' . $field['name'] . '" type="hidden" value="0" />';
				$content .= '<input id="' . $field['id'] . '-select" type="button" class="button button-secondary" value="' . __( 'Select image', 'events-maker' ) . '" />';
				$content .= '<input id="' . $field['id'] . '-remove" type="button" class="button button-secondary" value="' . __( 'Remove image', 'events-maker' ) . '" ' . $image[0] !== '' ? '' : 'disabled="disabled" />';
				$content .= '<span class="spinner"></span>';
				$content .= '<div id="' . $field['id'] . '-preview" class="image-preview">' . ($image[0] !== '' ? '<img src="' . $image[0] . '" alt="' . esc_html( get_the_title( $field['value'] ) ) . '" title="' . esc_html( get_the_title( $field['value'] ) ) . '" />' : '<img src="" alt="" style="display: none;" />') . '</div>';

				break;

			case 'google_map':

				$content = '<input id="' . $field['id'] . '-latitude" name="' . $field['name'] . '[latitude]" type="hidden" value="' . ( ! empty( $field['value']['latitude'] ) ? $field['value']['latitude'] : 0) . '" />';
				$content .= '<input id="' . $field['id'] . '-longitude" name="' . $field['name'] . '[longitude]" type="hidden" value="' . ( ! empty( $field['value']['longitude'] ) ? $field['value']['longitude'] : 0) . '" />';
				$content .= '<div id="' . $field['id'] . '" class="google-map-container"></div>';

				break;

			case 'text':
			case 'email':
			case 'url':
			case 'color_picker':
			default:

				$content = '<input id="' . $field['id'] . '" name="' . $field['name'] . '" type="text" class="' . implode( ' ', $field['input_class'] ) . '" value="' . $field['value'] . '" />';

				break;
		}

		// filter hook for field content
		$content = apply_filters( 'em_taxonomy_form_field_content', $content, $field, $key );

		// container
		$html = '<' . $field['container'] . ' class="' . implode( ' ', $classes ) . '" id="field-' . $field['id'] . '">';

		if ( $field['context'] === 'edit-term' )
			$html .= '<th scope="row" valign="top">';

		// label
		$html .= '<' . $field['label_container'] . ' for="' . $field['id'] . '" class="' . implode( ' ', $field['label_class'] ) . '">' . esc_attr( $field['label'] ) . ( ! empty( $field['required'] ) ? ' <span class="required">*</span>' : '') . '</label>';

		if ( $field['context'] === 'edit-term' )
			$html .= '</th><td>';

		// content
		$html .= $content;

		// description
		if ( $field['description'] )
			$html .= '<' . $field['description_container'] . ' class="' . implode( ' ', $field['description_class'] ) . '">' . esc_html( $field['description'] ) . '</' . $field['description_container'] . '>';

		if ( $field['context'] === 'edit-term' )
			$html .= '</td>';

		// container end
		$html .= '</' . $field['container'] . '>';

		if ( $field['return'] )
			return apply_filters( 'em_taxonomy_form_field_html', $html, $field, $key );
		else
			echo apply_filters( 'em_taxonomy_form_field_html', $html, $field, $key );
	}

	/**
	 * Sanitize field function.
	 */
	public function sanitize_field( $value = null, $type = '' ) {
		if ( is_null( $value ) )
			return null;

		switch ( $type ) {
			case 'select':
				$value = sanitize_text_field( $value );
				break;

			case 'email':
				$value = trim( $value );
				$value = is_email( $value ) ? $value : '';
				break;

			case 'url':
				$value = esc_url_raw( trim( $value ) );
				break;

			case 'image':
				$value = ! $value ? 0 : intval( $value );
				break;

			case 'color_picker':
				$value = ! $value || '#' == $value ? '' : esc_attr( $value );
				break;

			case 'google_map':
				$value = ! $value || ! is_array( $value ) ? '' : array_map( 'sanitize_text_field', $value );
				break;

			case 'text':
			default:
				$value = is_array( $value ) ? array_map( 'sanitize_text_field', $value ) : sanitize_text_field( $value );
				break;
		}

		return apply_filters( 'em_taxonomy_sanitize_field', stripslashes_deep( $value ), $type );
	}

	/**
	 * Add fields to category taxonomy.
	 */
	public function event_category_add_meta_fields() {
		foreach ( Events_Maker()->category_fields as $key => $field ) {
			echo $this->taxonomy_form_field( $key, $field );
		}
	}

	/**
	 * Add fields to location taxonomy.
	 */
	public function event_location_add_meta_fields() {
		foreach ( Events_Maker()->location_fields as $key => $field ) {
			echo $this->taxonomy_form_field( $key, $field );
		}
	}

	/**
	 * Add fields to organizer taxonomy.
	 */
	public function event_organizer_add_meta_fields() {
		foreach ( Events_Maker()->organizer_fields as $key => $field ) {
			echo $this->taxonomy_form_field( $key, $field );
		}
	}

	/**
	 * Edit fields in category taxonomy.
	 */
	public function event_category_edit_meta_fields( $term ) {
		$taxonomy_field_args = array(
			'container'	 => 'tr',
			'context'	 => 'edit-term'
		);

		// retrieve the existing value(s) for this meta field, this returns an array
		$term_meta = get_option( 'event_category_' . $term->term_taxonomy_id );

		foreach ( Events_Maker()->category_fields as $key => $field ) {
			$field['value'] = $term_meta[$key];
			echo $this->taxonomy_form_field( $key, wp_parse_args( $taxonomy_field_args, $field ) );
		}
	}

	/**
	 * Edit fields in location taxonomy.
	 */
	public function event_location_edit_meta_fields( $term ) {
		$taxonomy_field_args = array(
			'container'	 => 'tr',
			'context'	 => 'edit-term'
		);

		// retrieve the existing value(s) for this meta field, this returns an array
		$term_meta = get_option( 'event_location_' . $term->term_taxonomy_id );

		foreach ( Events_Maker()->location_fields as $key => $field ) {
			// backward compatibility
			if ( $key === 'google_map' && ! isset( $term_meta[$key] ) && isset( $term_meta['latitude'], $term_meta['longitude'] ) )
				$term_meta[$key] = array( 'latitude' => $term_meta['latitude'], 'longitude' => $term_meta['longitude'] );

			$field['value'] = $term_meta[$key];
			echo $this->taxonomy_form_field( $key, wp_parse_args( $taxonomy_field_args, $field ) );
		}
	}

	/**
	 * Edit fields in organizer taxonomy.
	 */
	public function event_organizer_edit_meta_fields( $term ) {
		$taxonomy_field_args = array(
			'container'	 => 'tr',
			'context'	 => 'edit-term'
		);

		// retrieve the existing value(s) for this meta field, this returns an array
		$term_meta = get_option( 'event_organizer_' . $term->term_taxonomy_id );

		foreach ( Events_Maker()->organizer_fields as $key => $field ) {
			$field['value'] = $term_meta[$key];
			echo $this->taxonomy_form_field( $key, wp_parse_args( $taxonomy_field_args, $field ) );
		}
	}

	/**
	 * Save fields in category taxonomy.
	 */
	public function event_category_save_meta_fields( $term_id, $tt_id ) {
		if ( ! current_user_can( 'manage_event_categories' ) )
			return;

		$term_meta = get_option( 'event_category_' . $tt_id );

		foreach ( Events_Maker()->category_fields as $key => $field ) {
			if ( isset( $_POST[$key] ) )
				$term_meta[$key] = $this->sanitize_field( $_POST[$key], $field['type'] );
		}

		if ( ! empty( $term_meta ) )
			update_option( 'event_category_' . $tt_id, $term_meta );
	}

	/**
	 * Save fields in location taxonomy.
	 */
	public function event_location_save_meta_fields( $term_id, $tt_id ) {
		if ( ! current_user_can( 'manage_event_locations' ) )
			return;

		$term_meta = get_option( 'event_location_' . $tt_id );

		foreach ( Events_Maker()->location_fields as $key => $field ) {
			if ( isset( $_POST[$key] ) )
				$term_meta[$key] = $this->sanitize_field( $_POST[$key], $field['type'] );
		}

		if ( ! empty( $term_meta ) )
			update_option( 'event_location_' . $tt_id, $term_meta );
	}

	/**
	 * Save fields in organizer taxonomy.
	 */
	public function event_organizer_save_meta_fields( $term_id, $tt_id ) {
		if ( ! current_user_can( 'manage_event_organizers' ) )
			return;

		$term_meta = get_option( 'event_organizer_' . $tt_id );

		foreach ( Events_Maker()->organizer_fields as $key => $field ) {
			if ( isset( $_POST[$key] ) )
				$term_meta[$key] = $this->sanitize_field( $_POST[$key], $field['type'] );
		}

		if ( ! empty( $term_meta ) )
			update_option( 'event_organizer_' . $tt_id, $term_meta );
	}
	
	/**
	 * Taxonomy columns.
	 */
	public function event_taxonomy_columns( $columns ) {
		global $pagenow, $taxonomy;

		if ( $pagenow !== 'edit-tags.php' )
			return $columns;

		// move posts count to default
		$temp = $columns['posts'];

		unset( $columns['posts'] );

		// generate property name, not very elegant maybe
		$property_name = str_replace( 'event-', '', $taxonomy ) . '_fields';

		foreach ( Events_Maker()->$property_name as $key => $field ) {
			if ( $field['column'] === true )
				$columns = array_merge( $columns, array( $key => esc_attr( $field['label'] ) ) );
		}

		// restore count
		$columns['posts'] = $temp;

		return $columns;
	}

	/**
	 * Taxonomy columns content.
	 */
	public function event_taxonomy_manage_columns( $output, $column_name, $term_id ) {
		global $pagenow, $taxonomy;

		if ( $pagenow !== 'edit-tags.php' )
			return $output;

		$term = get_term( $term_id, $taxonomy );

		// generate property name, not very elegant maybe
		$property_name = str_replace( 'event-', '', $taxonomy ) . '_fields';

		foreach ( Events_Maker()->$property_name as $key => $field ) {
			if ( $field['column'] === true && $key == $column_name ) {
				$callback = ! empty( $field['column_cb'] ) ? $field['column_cb'] : array( &$this, 'event_taxonomy_manage_columns_content' );
				$output .= call_user_func( $callback, $output, $column_name, $term_id );
			}
		}

		return $output;
	}

	/**
	 * Single column content for event taxonomy.
	 */
	public function event_taxonomy_manage_columns_content( $output, $column_name, $term_id ) {
		$taxonomy = ( isset( $_POST['taxonomy'] ) ) ? esc_attr( $_POST['taxonomy'] ) : esc_attr( $_GET['taxonomy'] );
		$term = get_term( $term_id, $taxonomy );

		// retrieve the existing value(s) for this term meta fields
		$term_meta = get_option( str_replace( '-', '_', $taxonomy ) . '_' . $term->term_taxonomy_id );
		
		// generate property name, not very elegant maybe
		$property_name = str_replace( 'event-', '', $taxonomy ) . '_fields';
		
		foreach ( Events_Maker()->$property_name as $key => $field ) {
			if ( $field['column'] === true && $key == $column_name ) {
				switch ( $field['type'] ) {
					case 'color_picker':
						$output = '<span class="em-' . $taxonomy . '-color"';
						$output .= ! empty( $term_meta['color'] ) ? ' style="background-color:' . $term_meta['color'] . '"' : '';
						$output .= '></span>';

						break;
					
					case 'email':
						$output = is_email( $term_meta[$column_name] ) ? '<a href="mailto:' . $term_meta[$column_name] . '">' . esc_attr( $term_meta[$column_name] ) . '</a>' : '&#8212;';
						break;

					case 'text':
					default:
						$output = ! empty( $term_meta[$column_name] ) ? esc_attr( $term_meta[$column_name] ) : '&#8212;';
						break;
				}
				
				$output = apply_filters( 'em_taxonomy_' . $field['type'] . '_column_content', $output, $column_name, $term_id );
			}
		}

		return $output;
	}
	
	/**
	 * Enable term HTML description.
	 */
	public function html_description_init() {

		$taxonomies = apply_filters( 'em_taxonomy_html_description_taxonomies', array( 'event-category', 'event-tag', 'event-location', 'event-organizer' ) );

		if ( ! empty( $taxonomies ) && is_array( $taxonomies ) ) {

			if ( current_user_can( 'unfiltered_html' ) ) {
				// remove default filters
				remove_filter( 'pre_term_description', 'wp_filter_kses' );
				remove_filter( 'term_description', 'wp_kses_data' );
				// and sanitize as post
				add_filter( 'pre_term_description', 'wp_filter_post_kses' );
				add_filter( 'term_description', 'wp_kses_post' );
				// modify column description content
				add_filter( 'get_terms', array( $this, 'html_description_column_get_terms' ), 10, 2 );
			}

			foreach ( $taxonomies as $taxonomy ) {
				add_action( $taxonomy . '_add_form_fields', array( $this, 'html_description_add_fields' ) );
				add_action( $taxonomy . '_edit_form_fields', array( $this, 'html_description_edit_fields' ), 10, 2 );
				add_action( 'admin_head-edit-tags.php', array( $this, 'html_description_editor_style' ) );
				add_action( 'admin_head-term.php', array( $this, 'html_description_editor_style' ) );
			}
		}
	}

	/**
	 * Add term HTML.
	 * 
	 * @param string $taxonomy
	 */
	public function html_description_add_fields( $taxonomy ) {

		$settings = apply_filters( 'em_taxonomy_html_editor_settings', array(
			'quicktags'		 => array(
				'buttons' => 'em,strong, link'
			),
			'textarea_name'	 => 'description',
			'quicktags'		 => true,
			'tinymce'		 => true,
			'media_buttons'	 => false,
			'editor_css'	 => '<style>#wp-html-tag-description-editor-container .wp-editor-area { height: 200px; }</style>'
		) );
		?>
		<div class="form-field term-html-description-wrap">
			<label for="tag-description"><?php echo __( 'Description' ); ?></label>
			<?php wp_editor( '', 'html-tag-description', $settings ); ?>
			<p class="description"><?php _e( 'The description is not prominent by default; however, some themes may show it.' ); ?></p>
			<script type="text/javascript">
				// remove the non-html field
				jQuery( '.term-html-description-wrap' ).detach().insertAfter( '.term-description-wrap' );
				jQuery( '.term-description-wrap' ).remove();

				jQuery( function () {
					// trigger save
					jQuery( '#addtag' ).on( 'mousedown', '#submit', function () {
					tinyMCE.triggerSave();
					} );
				} );
			</script>
		</div>
		<?php
	}

	/**
	 * Edit term HTML
	 * 
	 * @param object $term
	 * @param string $taxonomy
	 */
	public function html_description_edit_fields( $term, $taxonomy ) {

		$settings = apply_filters( 'em_taxonomy_html_editor_settings', array(
			'quicktags'		 => array( 'buttons' => 'em,strong,link' ),
			'textarea_name'	 => 'description',
			'quicktags'		 => true,
			'tinymce'		 => true,
			'media_buttons'	 => false,
			'editor_css'	 => '<style>#wp-html-description-editor-container .wp-editor-area { height: 300px; }</style>'
		) );
		?>
		<tr class="form-field term-html-description-wrap">
			<th scope="row" valign="top"><label for="description"><?php echo __( 'Description' ); ?></label></th>
			<td><?php wp_editor( html_entity_decode( stripslashes( $term->description ), ENT_COMPAT, 'UTF-8' ), 'html-tag-description', $settings ); ?>
				<span class="description"><?php _e( 'The description is not prominent by default; however, some themes may show it.' ); ?></span>
			</td>
			<script type="text/javascript">
				// remove the non-html field
				jQuery( '.term-html-description-wrap' ).detach().insertAfter( '.term-description-wrap' );
				jQuery( '.term-description-wrap' ).remove();
			</script>
		</tr>		
		<?php
	}
	
	/**
	 * Adjust admin column description.
	 * 
	 * @global string $pagenow
	 * @param array $terms
	 * @param string $taxonomy
	 * @return array
	 */
	public function html_description_column_get_terms( $terms, $taxonomy ) {
		global $pagenow;
		
		$taxonomies = apply_filters( 'em_taxonomy_html_description_taxonomies', array( 'event-category', 'event-tag', 'event-location', 'event-organizer' ) );
		
		if ( $pagenow !== 'edit-tags.php' || ! isset( $taxonomy[0] ) || ! in_array( $taxonomy[0], $taxonomies ) )
			return $terms;
		
		if ( ! empty( $terms ) ) {
			foreach ( $terms as $index => $term ) {
				if ( is_object( $term ) )
					$terms[$index]->description = apply_filters( 'em_taxonomy_html_description_column_content', wp_trim_words( wp_strip_all_tags( $term->description ), 20, null ), $term->description );
			}
		}
		return $terms;
	}
	
	/**
	 * Fix editor buttons.
	 * 
	 * @return mixed
	 */
	function html_description_editor_style() {
		echo '<style>.quicktags-toolbar input { width: auto; } #html-tag-description { border: none; } #wp-html-tag-description-wrap { width: 95%; }</style>';
	}

}

new Events_Maker_Taxonomies();