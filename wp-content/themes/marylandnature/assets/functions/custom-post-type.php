<?php
/* joints Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

*/

// adding the function to the Wordpress init
add_action( 'init', 'nhsm_post_types');
// let's create the function for the custom type
function nhsm_post_types() { 
	
	/** Collections **/
	register_post_type( 'nhsm_collections', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('Collections', 'nhsm'), /* This is the Title of the Group */
				'singular_name' => __('Collection', 'nhsm'), /* This is the individual type */
				'all_items' => __('All Collections', 'nhsm'), /* the all items menu item */
				'add_new' => __('Add New', 'nhsm'), /* The add new menu item */
				'add_new_item' => __('Add New Collection', 'nhsm'), /* Add New Display Title */
				'edit' => __( 'Edit', 'nhsm' ), /* Edit Dialog */
				'edit_item' => __('Edit Collection', 'nhsm'), /* Edit Display Title */
				'new_item' => __('New Collection', 'nhsm'), /* New Display Title */
				'view_item' => __('View Collection', 'nhsm'), /* View Display Title */
				'search_items' => __('Search Collections', 'nhsm'), /* Search Custom Type Title */ 
				'not_found' =>  __('Nothing found in the Database.', 'nhsm'), /* This displays if there are no entries yet */ 
				'not_found_in_trash' => __('Nothing found in Trash', 'nhsm'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			//'description' => __( 'This is the example custom post type', 'nhsm' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-list-view', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'collection', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'collections', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
	 	) /* end of options */
	); /* end of register post type */
	register_taxonomy_for_object_type('post_tag', 'nhsm_collections');
	
	register_post_type( 'nhsm_team', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('People', 'nhsm'), /* This is the Title of the Group */
				'singular_name' => __('People', 'nhsm'), /* This is the individual type */
				'all_items' => __('All People', 'nhsm'), /* the all items menu item */
				'add_new' => __('Add New', 'nhsm'), /* The add new menu item */
				'add_new_item' => __('Add New Person', 'nhsm'), /* Add New Display Title */
				'edit' => __( 'Edit', 'nhsm' ), /* Edit Dialog */
				'edit_item' => __('Edit Person', 'nhsm'), /* Edit Display Title */
				'new_item' => __('New Person', 'nhsm'), /* New Display Title */
				'view_item' => __('View Person', 'nhsm'), /* View Display Title */
				'search_items' => __('Search People', 'nhsm'), /* Search Custom Type Title */ 
				'not_found' =>  __('Nothing found in the Database.', 'nhsm'), /* This displays if there are no entries yet */ 
				'not_found_in_trash' => __('Nothing found in Trash', 'nhsm'), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			//'description' => __( 'This is the example custom post type', 'nhsm' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 9, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-groups', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
			'rewrite'	=> array( 'slug' => 'team', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'team', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes')
	 	) /* end of options */
	); /* end of register post type */
	
	register_taxonomy_for_object_type('post_tag', 'nhsm_team');
	
	register_taxonomy( 'nhsm_role', array( 'nhsm_team' ), array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'              => 'Roles',
			'singular_name'     => 'Role',
			'search_items'      => 'Search Roles',
			'all_items'         => 'All Roles',
			'parent_item'       => 'Parent Role',
			'parent_item_colon' => 'Parent Role:',
			'edit_item'         => 'Edit Role',
			'update_item'       => 'Update Role',
			'add_new_item'      => 'Add New Role',
			'new_item_name'     => 'New Role Name',
			'menu_name'         => 'Roles',
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'role' ),
	) );
	
	/*register_post_type( 'nhsm_event',
	 	// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __('Events', 'nhsm'),
				'singular_name' => __('Event', 'nhsm'),
				'all_items' => __('All Events', 'nhsm'),
				'add_new' => __('Add New', 'nhsm'), 
				'add_new_item' => __('Add New Event', 'nhsm'), 
				'edit' => __( 'Edit', 'nhsm' ),
				'edit_item' => __('Edit Event', 'nhsm'),
				'new_item' => __('New Event', 'nhsm'),
				'view_item' => __('View Event', 'nhsm'),
				'search_items' => __('Search Events', 'nhsm'),
				'not_found' =>  __('Nothing found in the Database.', 'nhsm'),
				'not_found_in_trash' => __('Nothing found in Trash', 'nhsm'),
				'parent_item_colon' => ''
			),
			//'description' => __( 'This is the example custom post type', 'nhsm' ),
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8,
			'menu_icon' => 'dashicons-calendar-alt',
			'rewrite' => array( 'slug' => 'events/%nhsm_events_year%/%nhsm_events_month%' ),
			'has_archive' => 'events',
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes')
	 	)
	);
	
	register_taxonomy( 'nhsm_event_category', array( 'nhsm_event' ), array(
		'hierarchical'      => true,
		'labels'            => array(
			'name'              => 'Event Categories',
			'singular_name'     => 'Event Category',
			'search_items'      => 'Search Categories',
			'all_items'         => 'All Categories',
			'parent_item'       => 'Parent Role',
			'parent_item_colon' => 'Parent Role:',
			'edit_item'         => 'Edit Category',
			'update_item'       => 'Update Category',
			'add_new_item'      => 'Add New Category',
			'new_item_name'     => 'New Category Name',
			'menu_name'         => 'Event Categories',
		),
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'event-category' ),
	) );*/
	
	register_taxonomy_for_object_type('post_tag', 'event');

	
} 


/*
	looking for custom meta boxes?
	check out this fantastic tool:
	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
*/

/** 
 ** Custom Meta Data
 **/

function nhsm_event_category_add_form_fields( $taxonomy ) {
	$bg_color = "#abd037";
	$txt_color = "#ffffff";
  ?>

    <div class="form-field term-colorpicker-wrap">
			<label for="term-colorpicker">Label Color</label>
			<input name="_label_bg_color" value="<?php echo $bg_color; ?>" class="colorpicker" id="term-bg-colorpicker" data-style-modifier="background" />
			<input name="_label_txt_color" value="<?php echo $txt_color; ?>" class="colorpicker" id="term-txt-colorpicker" data-style-modifier="color" />
			<span class="label dynamic" style="color:<?php echo $txt_color; ?>; background:<?php echo $bg_color; ?>">Sample This</span>
    </div>
    
    <div class="form-field term-group">
			<label for="category_image_id">Image</label>
			<input type="hidden" id="category_image_id" name="category_image_id" class="custom_media_url" value="">
			<div id="category-image-wrapper"></div>
			<p>
				<input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="Add Image" />
				<input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="Remove Image" />
			</p>
   </div>

  <?php

}
add_action( 'event-category_add_form_fields', 'nhsm_event_category_add_form_fields' );

function nhsm_colorpicker_field_edit_category( $term ) {
	$bg_color = get_term_meta( $term->term_id, '_label_bg_color', true );
	$bg_color = ( ! empty( $bg_color ) ) ? "#{$bg_color}" : '#abd037';
	$txt_color = get_term_meta( $term->term_id, '_label_txt_color', true );
	$txt_color = ( ! empty( $txt_color ) ) ? "#{$txt_color}" : '#ffffff';?>

	<tr class="form-field term-colorpicker-wrap">
			<th scope="row"><label for="term-colorpicker">Label Color</label></th>
			<td>
				<input name="_label_bg_color" value="<?php echo $bg_color; ?>" class="colorpicker" id="term-bg-colorpicker" data-style-modifier="background" />
				<input name="_label_txt_color" value="<?php echo $txt_color; ?>" class="colorpicker" id="term-txt-colorpicker" data-style-modifier="color" />
				<span class="label dynamic" style="color:<?php echo $txt_color; ?>; background:<?php echo $bg_color; ?>"><?php echo $term->name; ?></span>
			</td>
	</tr>
	
	<tr class="form-field term-group-wrap">
		<th scope="row">
			<label for="category_image_id">Image</label>
		</th>
		<td>
			<?php $image_id = get_term_meta ( $term -> term_id, 'category_image_id', true ); ?>
			<input type="hidden" id="category_image_id" name="category_image_id" value="<?php echo $image_id; ?>">
			<div id="category-image-wrapper">
			  <?php if ( $image_id ) { ?>
				  <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
			  <?php } ?>
			</div>
			<p>
			  <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="Add Image" />
			  <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="Remove Image" />
			</p>
		</td>
	</tr>
	<?php
}
add_action( 'event-category_edit_form_fields', 'nhsm_colorpicker_field_edit_category' );

function nhsm_save_termmeta( $term_id ) {

	$color_keys = array('_label_bg_color', '_label_txt_color');
	// Save term color if possible
	foreach($color_keys as $color_key){
		if( isset( $_POST[$color_key] ) && ! empty( $_POST[$color_key] ) ) {
			update_term_meta( $term_id, $color_key, sanitize_hex_color_no_hash( $_POST[$color_key] ) );
		} else {
			delete_term_meta( $term_id, $color_key );
		}
	}
	
	if( isset( $_POST['category_image_id'] ) && '' !== $_POST['category_image_id'] ){
		$image = $_POST['category_image_id'];
		update_term_meta ( $term_id, 'category_image_id', $image );
	} else {
		update_term_meta ( $term_id, 'category_image_id', '' );
	}

}
add_action( 'created_event-category', 'nhsm_save_termmeta' );
add_action( 'edited_event-category',  'nhsm_save_termmeta' );

function add_color_label_column( $columns ){
	$columns['nhsm_label_colors'] = 'Label';
	$columns['nhsm_cat_img'] = 'Image';
	unset($columns['description']);
	return $columns;
}
add_filter('manage_edit-event-category_columns', 'add_color_label_column' );

function add_color_label_column_content( $content, $column_name, $term_id ){
	if( $column_name === 'nhsm_label_colors' ){
		$bg_color = get_term_meta( $term_id, '_label_bg_color', true );
		$bg_color = ( ! empty( $bg_color ) ) ? "#{$bg_color}" : '#abd037';
		$txt_color = get_term_meta( $term_id, '_label_txt_color', true );
		$txt_color = ( ! empty( $txt_color ) ) ? "#{$txt_color}" : '#ffffff';

		$content = '<span class="label dynamic" style="color:'.$txt_color.';background:'.$bg_color.'">Label Colors</span>';
	}
	if( $column_name === 'nhsm_cat_img' ){
		$image_id = get_term_meta ( $term_id, 'category_image_id', true );
		$content = '<a href="'. get_edit_post_link( $image_id ) .'" target="_blank" title="View Image">'.wp_get_attachment_image ( $image_id, array(75, 75) ).'</a>';
	}

	return $content;
}
add_filter('manage_event-category_custom_column', 'add_color_label_column_content', 10, 3 );


