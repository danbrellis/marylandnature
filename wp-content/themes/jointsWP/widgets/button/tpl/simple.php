<?php

if(isset($instance['origin_style'])){
	$instance['theme'] = $instance['origin_style'];
}

echo nhsm_button($instance, $instance['text']); ?>
