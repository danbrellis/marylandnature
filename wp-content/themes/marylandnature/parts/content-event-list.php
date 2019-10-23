<?php global $post;
$date = new DateTime($post->event_occurrence_start_date);
$now = new DateTime();

if($date > $now): ?>
<aside>
	<h4 style="margin-bottom: 0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p><small>
        <?php echo nhsm_format_date_range(strtotime($post->event_occurrence_start_date), strtotime($post->event_occurrence_end_date), em_is_all_day($post->ID)); ?><br />
        <?php
        $loc_ids = wp_get_post_terms($post->ID, 'event-location', ['fields' => 'ids']);
        $locs_formatted = [];
        foreach($loc_ids as $loc_id){
            $loc = em_get_location($loc_id);
            if(!is_wp_error($loc)){
                $location_meta = $loc->location_meta;
                if(isset($location_meta['city']) && isset($location_meta['state'])){
                    $locs_formatted[] = $location_meta['city'] . ', ' . $location_meta['state'];
                }
                else {
                    $locs_formatted[] = $loc->name;
                }
            }
        }
		echo implode('<br />', $locs_formatted); ?>
	</small></p>
</aside>
<?php endif; ?>