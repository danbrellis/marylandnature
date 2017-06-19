<h4><?php the_title(); ?></h4>
<?php
$id = get_the_ID();
$locs = em_get_locations_for($id);
$wheres = array();
$cats = get_the_terms($id, 'event-category');
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
?>
<?php if(!empty($cat_list)): ?>
	<div class="event_cat_labels"><?php echo implode(' ', $cat_list); ?></div>
<?php endif; ?>
<table class="unstriped event-tooltip-data">
	<tr>
		<th>When</th>
		<td><?php echo nhsm_get_date_range($id); ?></td>
	</tr>
	<?php if($locs && is_array($locs) && !empty($locs[0])): ?>
	<tr>
		<th>Where</th>
		<?php foreach($locs as $loc) $wheres[] = sprintf('%s <a href="https://www.google.com/maps/search/'.str_replace(' ', '+', $loc->name).'/@%f,%f,15z" target="_blank">map</a>', $loc->name, $loc->location_meta['google_map']['latitude'], $loc->location_meta['google_map']['longitude']); ?>
		
		
		<td><?php echo implode($wheres); ?></td>
	</tr>
	<?php endif; ?>
	<?php echo get_the_tag_list( '<tr><th>Topics</th><td>', ', ', '</td></tr>'); ?>
</table>
<a href="<?php echo get_permalink(); ?>" class="button small" title="<?php the_title(); ?>">More details</a>