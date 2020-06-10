<?php global $post; ?>
<p class="byline">
	<?php if($post->post_type == 'post'): ?>Written by <?php the_author_posts_link(); ?>&nbsp;<span class="middot">&middot;</span>&nbsp;<?php endif; ?>
	<?php echo is_singular('event') ? false : ($post->post_type == 'event' ? nhsm_get_upcoming_event_date_range($post) : '<time>' . get_the_time('F j, Y') . '</time>'); ?><?php if ( comments_open() ): ?>&nbsp;<span class="middot">&middot;</span>&nbsp;
	<?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', ''); ?><?php endif; ?>
</p>

<?php if(!is_tax('event-category') && $post->post_type == 'event'){
	nhsm_em_the_event_terms_list($post->ID);
}
?>