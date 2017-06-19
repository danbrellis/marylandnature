<?php
	
// Adding WP Functions & Theme Support
function joints_theme_support() {

	// Add WP Thumbnail Support
	add_theme_support( 'post-thumbnails' );
	
	// Default thumbnail size
	set_post_thumbnail_size(125, 125, true);

	// Add RSS Support
	add_theme_support( 'automatic-feed-links' );
	
	// Add Support for WP Controlled Title Tag
	add_theme_support( 'title-tag' );
	
	// Add HTML5 Support
	add_theme_support( 'html5', 
	         array( 
	         	'comment-list', 
	         	'comment-form', 
	         	'search-form', 
	         ) 
	);
	
	// Adding post format support
	 add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	); 
	
	// Set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
	$GLOBALS['content_width'] = apply_filters( 'joints_theme_support', 1200 );	
	
} /* end theme support */

add_action( 'after_setup_theme', 'joints_theme_support' );

function nhsm_the_cat_labels($p = 0){
	echo nhsm_get_the_cat_labels($p);
}
	function nhsm_get_the_cat_labels($p = 0){
		$post = get_post($p);
		$cats = wp_get_post_categories($post->ID, array('fields' => 'all'));
		$html = '';
		$cat_list = array();

		if($cats && is_array($cats)){
			foreach($cats as $cat){
				$link = get_category_link( $cat->term_id );
				$template = !is_wp_error( $link ) ? '<a href="'.esc_url($link).'">%s</a>' : '%s';
				$styles = array();

				$cat_list[] = sprintf($template, '<span class="label">'.$cat->name.'</span>');
			}
		}
		if(!empty($cat_list))
			$html = '<p class="event_cat_labels">'. implode(' ', $cat_list) .'</p>';

		return $html;
	}