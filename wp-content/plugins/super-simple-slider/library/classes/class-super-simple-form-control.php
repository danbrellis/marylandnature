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
class Super_Simple_Form_Control {
	
	/**
	 * The main plugin object.
	 *
	 * @var     object
	 * @access  public
	 * @since   1.0.0
	 */
	public $parent = null;
		
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $id;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $type;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $name;

    /**
     * Control name.
     *
     * @since 3.4.0
     * @var boolean
     */
    public $hasDependents;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $placeholder;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $prefix;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $suffix;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $label;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $description;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $value;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $show_labels;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $min_labels;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $field_counter;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $template;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $fieldset;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $options;

    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $input_attrs;
    
    /**
     * Control ID.
     *
     * @since 3.4.0
     * @var string
     */
    public $class;
    
	public function __construct( $id, $parent, $repeatable, array $args, $value, $field_counter = '' ) {
		$keys = array_keys( get_object_vars( $this ) );
		
        foreach ( $keys as $key ) {
            if ( isset( $args[ $key ] ) ) {
                $this->$key = $args[ $key ];
            }
        }
        
		$this->id = $id;
		$this->parent = $parent;
		$this->repeatable = $repeatable;
		$this->value = $value;
		$this->field_counter = $field_counter;
		
		$this->render();
	}
	
    /**
     * Renders the control wrapper and calls $this->render_content() for the internals.
     *
     * @since 3.4.0
     */
    protected function render() {
        $id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
        $class = 'customize-control customize-control-' . $this->type;
 
        //printf( '<li id="%s" class="%s">', esc_attr( $id ), esc_attr( $class ) );
        $this->render_content();
        //echo '</li>';
    }
    
    protected function create_input_group( $id, $field_name, $input_type, $field_class, $placeholder, $value, $prefix, $suffix ) {
    	$html = '';
    	
		if ( $this->prefix || $this->suffix ) {
			$input_group_classes = array();
			
			$input_group_classes = explode( ',', $field_class );
			
			$input_group_classes[] = $id;
					
			if ( $this->prefix ) {
				$input_group_classes[] = 'prefix';
			}

			if ( $this->suffix ) {
				$input_group_classes[] = 'suffix';
			}
					
			$html .= '<div class="input-group ' .esc_attr( implode( ' ', $input_group_classes ) ). '">';
		}

		if ( $this->prefix ) {
			$html .= '<span class="input-group-addon prefix">' . $this->prefix . '</span>';
		}
		
		$html .= '<input type="' . esc_attr( $input_type ) . '" step="any" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_html( $this->value ) . '" />' . "\n";

		if ( !empty( $this->suffix ) ) {
			$html .= '<span class="input-group-addon suffix">' . $this->suffix . '</span>';
		}

		if ( $this->prefix || $this->suffix ) {
			$html .= '</div>';
		}
		
		return $html;
    }
    
	public function render_content() {
		$html 		= '';
		$field_name = '';
		
		$field_name  .= $this->id;
        $field_class = 'otb-form-control otb-form-control-' . $this->type . ' ' . $this->id . ' ' . $this->class;

		if ( $this->hasDependents ) {
			$field_class .= 'has-dependents'; 
        }
        
		if ( $this->field_counter ) {
			$field_name .= $this->field_counter;
		}
        
		if ( $this->repeatable ) {
			$field_name .= '[]';
		}
		
		if ( $this->label ) {
			//$html .= '<h4>' . $this->label . '</h4>';
			$html .= '<label for="' . $this->id . '">' . $this->label . '</label>';
		}
		
		switch( $this->type ) {

			case 'text':
				$html .= '<input type="text" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_html( $this->value ) . '" />' . "\n";
			break;

			case 'email':
				$html .= '<input type="email" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_html( $this->value ) . '" />' . "\n";
			break;
			
			case 'tel':
				$html .= '<input type="tel" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_html( $this->value ) . '" />' . "\n";
			break;
			
			case 'number':
			case 'float':
				$html .= $this->create_input_group( $this->id, $field_name, 'number', $field_class, $this->placeholder, $this->value, $this->prefix, $this->suffix );
			break;

			case 'url':
				$html .= $this->create_input_group( $this->id, $field_name, 'url', $field_class, $this->placeholder, $this->value, $this->prefix, $this->suffix );
			break;
			
			case 'password':
				$html .= '<input type="password" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_html( $this->value ) . '" />' . "\n";
			break;
			
			case 'html':
			case 'textarea':
				$html .= '<textarea placeholder="' . esc_attr( $this->placeholder ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" cols="55" rows="5" name="' . esc_attr( $field_name ) . '">' . esc_html( $this->value ) . '</textarea>' . "\n";
			break;
			
			case 'tinymce':
				$settings = array(
				    'teeny' => false,
				    'textarea_name' => $field_name,
				    'textarea_rows' => 5,
					'tabindex' => 1
				);
				
				$html .= wp_editor( $this->value, $this->id .'-'. uniqid(), $settings );
			break;

			case 'checkbox':
				$checked = '';
				
				if ( $this->value ) {
					$checked = 'checked="checked"';
				}

				$html .= '<input type="checkbox" name="' . esc_attr( $field_name ) . '_checkbox" data-field-id="' .$this->id. '" ' . $checked . ' class="' . esc_attr( $field_class ) . '"/>';
				$html .= '<input type="hidden" name="' . esc_attr( $field_name ) . '" value="' . esc_html( $this->value ) . '" />';
			break;
			
			case 'select':
				$html .= '<select name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '">';
				foreach ( $this->options as $k => $v ) {
					$selected = false;
					if ( $k == $this->value ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
			break;

			case 'milliseconds':
				$this->suffix = 'ms';
				
				$html .= $this->create_input_group( $this->id, $field_name, 'number', $field_class, $this->placeholder, $this->value, $this->prefix, $this->suffix );
			break;

			case 'pixels':
				$this->suffix = 'px';
				
				$html .= $this->create_input_group( $this->id, $field_name, 'number', $field_class, $this->placeholder, $this->value, $this->prefix, $this->suffix );
			break;
						
			case 'percentage':
				$this->suffix = '%';
				
				$html .= '<input type="text" name="' . esc_attr( $field_name ) . '" class="' . esc_attr( $field_class ) . '" placeholder="' . esc_attr( $this->placeholder ) . '" value="' . esc_html( $this->value ) . '" /> %' . "\n";
			break;

			case 'color':
				$html .= '<input type="text" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="colorpicker ' . esc_attr( $field_class ) . '" maxlength="7" value="' .esc_attr( $this->value ). '" />' . "\n";
			break;

			case 'range':
				$html .= '<div class="range-container">';
				$html .= '<input type="range" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" min="' . esc_attr( $this->input_attrs['min'] ) . '" max="' . esc_attr( $this->input_attrs['max'] ) . '" step="' . esc_attr( $this->input_attrs['step'] ) . '" value="' . esc_attr( $this->value ) . '" />' . "\n";
				
				if ( $this->show_labels ) {
					$html .= '<ul class="labels">';
					
					if ( !$this->min_labels ) {
						for ( $i=$this->input_attrs['min']; $i<$this->input_attrs['max']; $i+=$this->input_attrs['step']) {
							$html .= '<li>' .$i. '</li>';
						}
					} else {
						$html .= '<li>' .$this->input_attrs['min']. '</li>';
						$html .= '<li>' . ( $this->input_attrs['max'] / 2 ). '</li>';
						$html .= '<li>' .$this->input_attrs['max']. '</li>';
					}
					
					$html .= '</ul>';
				}
				
				$html .= '</div>';
			break;

			case 'media_upload':
				global $_wp_additional_image_sizes;
				//$image_id 	   = get_post_meta( $post->ID, 'header_image_id', true );
				$image_id 		   = $this->value;
				$has_image		   	  = false;
				$media_uploader_class = '';
				
				if ( $image_id && get_post( $image_id ) ) {
					$has_image = true;
					$media_uploader_class = 'has-img';
				}
				
				$html .= '<div class="media-uploader ' .$media_uploader_class. '">';
				$html .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Upload Image', 'super-simple-slider' ) . '" href="javascript:;" class="button upload" data-uploader_title="' . esc_attr__( 'Upload Image', 'super-simple-slider' ) . '" data-uploader_button_text="' . esc_attr__( 'Upload Image', 'super-simple-slider' ) . '">' . esc_html__( 'Upload Image', 'super-simple-slider' ) . '</a></p>';				
				$html .= '<input type="hidden" name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" value="' . esc_attr( $image_id ) . '" />';
				
				$html .= '<div class="preview">';
				$html .= '<div class="delete icon">';
				$html .= '<i class="sss-fa sss-fa-times"></i>';		
				$html .= '</div>';
				
				if ( $has_image ) {
					$thumbnail_html = wp_get_attachment_image( $image_id, 'full' );

					if ( !empty( $thumbnail_html ) ) {
						$html .= $thumbnail_html;
					}
				
				} else {
					$html .= '<img src="" />';
					//$html .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Upload Image', 'super-simple-slider' ) . '" href="javascript:;" id="upload_header_image_button" class="button upload" data-uploader_title="' . esc_attr__( 'Upload Image', 'super-simple-slider' ) . '" data-uploader_button_text="' . esc_attr__( 'Upload Image', 'super-simple-slider' ) . '">' . esc_html__( 'Upload Image', 'super-simple-slider' ) . '</a></p>';
					//$html .= '<input type="hidden" id="upload_header_image" name="' . esc_attr( $field_name ) . '" value="" />';
				}
				
				$html .= '</div>';
				$html .= '</div>';
				$html .= '</div>';
			break;
			
			case 'dropdown_pages_posts':
				$html = '<select name="' . esc_attr( $field_name ) . '" data-field-id="' .$this->id. '" class="' . esc_attr( $field_class ) . '" data-customize-setting-link="' .$this->id. '">';
				$html .= '<option value="">Not linked</option>';
				$html .= '<option ' . selected( $this->value, 'custom', false ) . ' value="custom">Custom URL</option>';
				$html .= '<optgroup label="Pages">';
				
				// Get all published pages
				$pages = get_pages();
				foreach ($pages as $page) {
					$html .= '<option ' . selected( $this->value, $page->ID, false ) . ' value="' .$page->ID. '">' .$page->post_title. '</option>';
				}
				
				// Prevent weirdness
				wp_reset_postdata();
				
				$html .= '</optgroup>';
				$html .= '<optgroup label="Posts">';
		
				// Get all published posts
				$posts = get_posts( array( 'posts_per_page'   => -1 ) );
				foreach ($posts as $post) {
					$html .= '<option ' . selected( $this->value, $post->ID, false ) . ' value="' .$post->ID. '">' .$post->post_title. '</option>';
				}
				
				// Prevent weirdness
				wp_reset_postdata();
				
				$html .= '</optgroup>';
				$html .= '</select>';		
			
			break;
			
			case 'repeatable_fieldset':
				ob_start();
				include ( super_simple_slider()->assets_dir .'/template-parts/'. $this->template );
				$html .= ob_get_clean();
			break;
		}
		
		if ( $this->description ) {
			$html .= '<div class="otb-form-control-description otb-form-control-description-' .$this->type. ' ' .$this->id. '-description">' . $this->description . '</div>';
		}
		
		echo $html;
	}
}
