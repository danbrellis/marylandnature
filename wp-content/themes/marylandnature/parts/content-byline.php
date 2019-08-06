<?php global $post; ?>
<p class="byline">
	<?php if($post->post_type == 'post'): ?>Written by <?php the_author_posts_link(); ?>&nbsp;<span class="middot">&middot;</span>&nbsp;<?php endif; ?>
	<?php echo is_singular('event') ? false : ($post->post_type == 'event' ? nhsm_get_upcoming_event_date_range($post) : '<time>' . get_the_time('F j, Y') . '</time>'); ?><?php if ( comments_open() ): ?>&nbsp;<span class="middot">&middot;</span>&nbsp;
	<?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', ''); ?><?php endif; ?>
</p>






<?php if(!is_tax('event-category') && $post->post_type == 'event'){
	$cats = get_the_terms(get_the_ID(), 'event-category');
	$cat_list = array();

	if($cats && is_array($cats)){
		foreach($cats as $cat){
			$link = get_term_link( $cat, 'event-category' );
			$template = !is_wp_error( $link ) ? '<a href="'.esc_url($link).'">%s</a>' : '%s';
			$styles = array();

			$bg_color = get_term_meta( $cat->term_id, '_label_bg_color', true );
			if(!empty( $bg_color ) ) $styles[] = "background:#{$bg_color}";

			$txt_color = get_term_meta( $cat->term_id, '_label_txt_color', true );
			if(!empty( $txt_color ) ) $styles[] = "color:#{$txt_color}";

			$cat_list[] = sprintf($template, '<span class="label dynamic" style="'.implode(';', $styles).'">'.$cat->name.'</span>');
		}
	}
}

if(!empty($cat_list)): ?>
	<p class="event_cat_labels"><?php echo implode(' ', $cat_list); ?></p>
<?php endif; ?>