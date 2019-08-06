<?php global $post;
$date = new DateTime($post->event_occurrence_start_date);
$now = new DateTime();

if($date > $now): ?>
<aside>
	<h4 style="margin-bottom: 0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p><small>
		<?php echo nhsm_format_date_range(strtotime($post->event_occurrence_start_date), strtotime($post->event_occurrence_end_date), em_is_all_day($post->ID)); ?><br />
		<?php $locs = em_get_locations();
		$locs_formatted = array();
		if($locs && is_array($locs)){
			foreach($locs as $loc){
				if(isset($loc->location_meta['address'])){
					$address = $loc->location_meta;
					$locs_formatted[] = $address['city'] . ', ' . $address['state'];
				}
			}
		}
		echo implode('<br />', $locs_formatted); ?>
	</small></p>
</aside>
<?php endif; ?>