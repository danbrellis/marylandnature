<?php
if (have_posts()){
	$cur_date = '';
	add_filter('excerpt_more', '__return_false');
	while (have_posts()){
		the_post();
		$start = strtotime(get_post_meta(get_the_ID(), '_event_start_date', true));
		if($cur_date !== $start){
			$format = date('Y') == date('Y', $start) ? 'l, j F' : 'l, j F Y';
			echo '<h2 class="u">' . date($format, $start) . '</h2>';
			$cur_date = $start;
		}
		get_template_part( 'parts/loop', 'archive-event' );
	}
	remove_filter('excerpt_more', '__return_false');
} 
else get_template_part( 'parts/content', 'missing' );?>