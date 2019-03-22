<?php
global $wp_query;
$i = 0;
$template = '<div title="%2$s" class="collection"><p class="collection-info"><span class="collector">%3$s</span><span class="collection-title">%4$s</span></p><img src="%5$s" alt="%2$s" class="collection-img img-responsive" /></div>';
if(have_posts()):
	while( have_posts() ): the_post();
		$collector = get_post_meta(get_the_ID(), 'nhsm_active_curators_0_nhsm_curator', true);
		$collection = get_the_title();

		$thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'medium_large') : 'http://placehold.it/733x280';
		
		if($wp_query->post_count == 1){
			if(!has_post_thumbnail()) $thumbnail = 'http://placehold.it/733x480';
			printf($template, get_permalink(), $collector . ' ' . $collection . ' Collection', $collector, $collection, $thumbnail);
		}
		else{ //4 posts
			if($i == 0): ?><div class="row"><?php endif; ?>
			
			<div class="small-6 large-6 columns"><div class="collection_cont"><?php printf($template, get_permalink(), $collector . ' ' . $collection . ' Collection', $collector, $collection, $thumbnail); ?></div></div>
		
			<?php $i++; if($i > 1): $i = 0; ?></div><?php endif;
		}
	endwhile;
endif;

wp_reset_postdata();