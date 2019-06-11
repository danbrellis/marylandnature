<?php

add_action( 'after_setup_theme', 'nhsm_image_sizes' );
function nhsm_image_sizes() {
	add_image_size( 'nhsm_hbanner', 870, 378, true ); // (cropped)
	add_image_size( 'nhsm_medium4x3', 800, 600, true ); // (cropped)
    add_image_size( 'nhsm_headshot', 975, 975, true ); // (cropped)
}

//adds credit fields to media library
add_filter("attachment_fields_to_edit", "add_image_source_url", 10, 2);
function add_image_source_url($form_fields, $post) {
	$form_fields["source_credit"] = array(
		"label" => __("Image Credit"),
		"input" => "text",
		"value" => get_post_meta($post->ID, "source_credit", true)
	);
	$form_fields["source_url"] = array(
		"label" => __("Source URL"),
		"input" => "text",
		"value" => get_post_meta($post->ID, "source_url", true),
		"helps" => __("Add the URL where the original image was posted"),
	);
	return $form_fields;
}

add_filter("attachment_fields_to_save", "save_image_source_url", 10 , 2);
function save_image_source_url($post, $attachment) {
	if (isset($attachment['source_credit']))
		update_post_meta($post['ID'], 'source_credit', esc_attr($attachment['source_credit']));
	if (isset($attachment['source_url']))
		update_post_meta($post['ID'], 'source_url', esc_url($attachment['source_url']));
	
	return $post;
}

//append image credit to captions
add_filter('img_caption_shortcode', 'caption_shortcode_with_credits', 10, 3);
function caption_shortcode_with_credits($empty, $attr, $content) {
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	// Extract attachment $post->ID
	preg_match('/\d+/', $id, $att_id);
	if (is_numeric($att_id[0])) {
		$parts = parse_url($source_url);
		$caption .= ' (' . nhsm_format_image_credit_line(false, $att_id[0]) . ')';
	}

	if (1 > (int) $width || empty($caption))
		return $content;

	if ($id)
		$id = 'id="' . esc_attr($id) . '" ';

	return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (10 + (int) $width) . 'px">'
		. do_shortcode($content) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

//for displaying image credits
function nhsm_img_credit_and_caption($credit = false, $img_id = false, $link = true){
  $caption = wp_get_attachment_caption($img_id);
  $credit = nhsm_format_image_credit_line($credit, $img_id, $link);
  if($credit && $caption) return sprintf("%s. %s", $credit, $caption);
  if($credit) return $credit;
  if($caption) return $caption;
  return false;
}

function nhsm_format_image_credit_line($credit = false, $img_id = false, $link = true){
	if(!$credit) $credit = nhsm_get_image_credit($img_id, $link);
	$ret = $credit ? sprintf('Photo by %s', $credit) : false;
	
	return $ret;
}

function nhsm_image_has_credit($thumbnail_id){
	if(!$thumbnail_id) $thumbnail_id = get_post_thumbnail_id();
	$thumb_cred = get_post_meta($thumbnail_id, 'source_credit', true);
	$thumb_link = get_post_meta($thumbnail_id, 'source_url', true);
	
	return ($thumb_cred || $thumb_link);
}

function nhsm_get_image_credit($thumbnail_id = false, $link = true){
	if(!$thumbnail_id) $thumbnail_id = get_post_thumbnail_id();
	$thumb_cred = get_post_meta($thumbnail_id, 'source_credit', true);
	$thumb_link = get_post_meta($thumbnail_id, 'source_url', true);
	
	if($thumb_cred && $link && $thumb_link && $link){
		$img_cred = sprintf('<a href="%s" target="_blank">%s</a>', $thumb_link, $thumb_cred);
	}
	elseif($thumb_cred){
		$img_cred = $thumb_cred;
	}
	elseif($thumb_link){
		$parse = parse_url($thumb_link);
		$img_cred = $link ? sprintf('<a href="%s" target="_blank">%s</a>', $thumb_link, $parse['host']) : sprintf('<span title="%s">%s</span>', $thumb_link, $parse['host']);
	}
	else $img_cred = '';
	return $img_cred;
}

/* Image Gallery */
add_filter('post_gallery', 'nhsm_post_gallery', 10, 3);
function nhsm_post_gallery($output, $attr, $instance){
	global $post;
	$atts = shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post ? $post->ID : 0,
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => '',
		'link'       => '',
		'title'			 => get_the_title()
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );
	$selector = "gallery-{$instance}";

	if ( ! empty( $atts['include'] ) ) {
		$_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( ! empty( $atts['exclude'] ) ) {
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	} else {
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
	}

	if ( empty( $attachments ) || !is_array($attachments) ) {
		return '';
	}

	if ( is_feed() ) {
		return '';
	}
	
	$i = 0;
	$itemclass = 'is-active orbit-slide';
	$bullets = '';
	$bullet_template = '<button class="%1$s" data-slide="%2$d"><span class="show-for-sr">Slide %2$d</span>%3$s</button>';
	
	$output = '<div class="orbit" role="region" aria-label="'.$atts['title'].'" data-orbit>
		<ul class="orbit-container">
			<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
			<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>';
		
	foreach ( $attachments as $id => $attachment ) {
		$attr = array('class' => 'orbit-image');
		if( trim( $attachment->post_excerpt ) ) 
			$attr['aria-describedby'] = $selector.'-'.$id;
		
		/* //removed for now until we create a formated single tempalte for media
		if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
			$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		} elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
			$image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
		} else {
			$image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
		}
		*/
		$image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
		
		$cred = nhsm_format_image_credit_line(false, $id);
		$caption = $attachment->post_excerpt ? wptexturize($attachment->post_excerpt) . '<br />' . $cred : $cred;
		
		$output .= '<li class="'.$itemclass.'">'.$image_output.'<figcaption class="orbit-caption">'.$caption.'</figcaption>
    </li>';
		
		$bullets .= $i == 0 ? sprintf($bullet_template, 'is-active', $i, '<span class="show-for-sr">Current Slide</span>') : sprintf($bullet_template, '', $i, '');
		
		$itemclass = 'orbit-slide';
		$i++;
	}
	$output .= '</ul><nav class="orbit-bullets">'.$bullets.'</nav></div>';
	
	return $output;
}

/* Banner Image */
function nhsm_the_banner_image($post = 0, $atts = array()){
	echo nhsm_get_the_banner_image($post, $atts);
}
function nhsm_get_the_banner_image($post = 0, $atts = array()){
	$post = get_post( $post );
	$defaults = array(
		'class' => 'single_page_banner'
	);
	$atts = wp_parse_args( $atts, $defaults );
	if(has_post_thumbnail($post)){
		return nhsm_fuse_img_and_caption(get_the_post_thumbnail($post, 'nhsm_hbanner', $atts), nhsm_img_credit_and_caption(false, get_post_thumbnail_id($post->ID)));
	}
}

function nhsm_the_category_banner_image($cat_id = 0, $taxonomy = 'category', $atts = array()){
	echo nhsm_get_the_category_banner_image($cat_id, $taxonomy, $atts);
}

function nhsm_get_the_category_banner_image($cat_id = 0, $taxonomy = 'category', $atts = array()){
	if(!$cat_id || $cat_id == 0){
		$queried_object = get_queried_object();
		$cat_id = (isset($queried_object->term_id)) ? $queried_object->term_id : 0;
	}
	$image_id = get_term_meta ( $cat_id, 'category_image_id', true );
	$defaults = array(
		'class' => 'single_page_banner'
	);
	$atts = wp_parse_args( $atts, $defaults );
	return nhsm_fuse_img_and_caption(wp_get_attachment_image($image_id, 'nhsm_hbanner', false, $atts), nhsm_img_credit_and_caption(false, $image_id));
}

function nhsm_banner_style($post = 0, $fallback = '', array $styles = array()){
	$img = $style_attr = false;
	if(is_tax()){
		$term = get_queried_object();
		var_dump($term);
		if(is_a($term, 'WP_Term')){
			$image_id = get_term_meta( $term->term_id, 'category_image_id', true );
			
			if ( $image_id ) {
				$img = get_the_post_thumbnail_url ( $image_id, 'nhsm_hbanner' );
				var_dump($img);
			}
		}
	}
	elseif($post !== false && $post = get_post( $post ) && has_post_thumbnail($post)){
		$img = get_the_post_thumbnail_url($post, 'nhsm_hbanner');
	}
	else{
		$img_id = get_field($fallback, 'option');
		if($img_id) {
			$img = wp_get_attachment_image_src($img_id, 'nhsm_hbanner');
			if(is_array($img)) $img = $img[0];
		}
	}
	var_dump($img);
	if($img) $styles['background-image'] = 'url('.$img.')';
	
	foreach($styles as $k => $v) $style_attr = $k . ':' . $v . ';';
		
	return ' style="'.$style_attr.'"';
}

function nhsm_fuse_img_and_caption($img, $caption = false){
  if($img){
    return sprintf("<div class='img-caption-container'>%s<span>%s</span></div>", $img, $caption);
  }
  else return;
}