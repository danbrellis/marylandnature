<?php
if (have_posts()){
	$cur_date = '';
	add_filter('excerpt_more', '__return_false');
	while (have_posts()){
		the_post();
        $start = em_get_the_date(get_the_ID(), ['range'=>'start','output'=>'date', 'format'=> 'Y-m-d']);
        $start_ts = strtotime($start);
		if($cur_date !== $start){
			$format = date('Y') === date('Y', $start_ts) ? 'l, j F' : 'l, j F Y';
			echo '<h2 class="u">' . date($format, $start_ts) . '</h2>';
			$cur_date = $start;
		}
		get_template_part( 'parts/content', 'archive-event' );
	}
	remove_filter('excerpt_more', '__return_false');
}
else {
    echo '<h3>No Events</h3>';
}
