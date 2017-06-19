<?php 
$scope = isset($_GET['show']) ? sanitize_title($_GET['show']) : 'upcoming';	?>
<form class="form-inline float-right" method="get" action="" role="form" style="margin-top:20px; margin-bottom:10px;">
	<select name="show" class="form-control" onchange="this.form.submit()">
		<option value="all"<?php echo $scope == "all" ? 'selected="selected"' : ''; ?>>All Events</option>
		<option value="upcoming"<?php echo $scope == "upcoming" ? 'selected="selected"' : ''; ?>>Upcoming Events</option>
		<option value="past"<?php echo $scope == "past" ? 'selected="selected"' : ''; ?>>Past Events</option>
	</select>
</form>
<?php
if (have_posts()){
	$cur_date = '';
	add_filter('excerpt_more', '__return_false');
	while (have_posts()){
		the_post();
		$start = strtotime(get_post_meta(get_the_ID(), '_event_start_date', true));
		if($cur_date !== $start){
			$format = date('Y') == date('Y', $start) ? 'l, j F' : 'l, j F Y';
			echo '<span class="h1">' . date($format, $start) . '</span>';
			$cur_date = $start;
		}
		get_template_part( 'parts/loop', 'archive' );
	}
	remove_filter('excerpt_more', '__return_false');
} 
else get_template_part( 'parts/content', 'missing' );?>