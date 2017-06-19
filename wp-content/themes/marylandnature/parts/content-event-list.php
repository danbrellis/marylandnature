<aside>
	<h4 style="margin-bottom: 0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p><small>
		<?php echo nhsm_get_date_range(get_the_ID()); ?><br />
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