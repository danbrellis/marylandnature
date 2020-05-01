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
        'show_in_rest'      => true
	) );

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

function nhsm_role_category_add_form_fields($taxonomy) { ?>
    <div class="form-field">
        <label for="term-unique-url">
        <input name="_has_unique_urls" type="checkbox" value="1" id="term-unique_url" checked /> Posts have unique URLs
        </label>
        <p>If checked, when posts are listed in templates they will link to unique pages.</p>
    </div>
    <?php
}
add_action( 'nhsm_role_add_form_fields', 'nhsm_role_category_add_form_fields' );

function nhsm_role_category_edit_category( $term ) {
    $checked = get_term_meta( $term->term_id, '_has_unique_urls', true ); ?>

    <tr class="form-field term-colorpicker-wrap">
        <th scope="row"><label for="term-unique-url">Posts have unique URLs</label></th>
        <td>
            <input name="_has_unique_urls" type="checkbox" value="1" id="term-unique_url" <?php checked($checked); ?> />
            <p class="description">If checked, when posts are listed in templates they will link to unique pages.</p>
        </td>
    </tr>
    <?php
}
add_action( 'nhsm_role_edit_form_fields', 'nhsm_role_category_edit_category' );

function nhsm_save_termmeta( $term_id ) {
	if( isset( $_POST['_has_unique_urls'] ) && '' !== $_POST['_has_unique_urls'] ){
		$checked = $_POST['_has_unique_urls'];
		update_term_meta ( $term_id, '_has_unique_urls', true );
	} else {
		update_term_meta ( $term_id, '_has_unique_urls', '' );
	}
}
add_action( 'created_nhsm_role', 'nhsm_save_termmeta' );
add_action( 'edited_nhsm_role',  'nhsm_save_termmeta' );