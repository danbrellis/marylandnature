<?php
global $wp_query;
$i = 0;
$template = '<div title="%2$s" class="collection"><p class="collection-info"><span class="collector">%3$s</span><span class="collection-title">%4$s</span></p><img src="%5$s" alt="%2$s" class="collection-img img-responsive" /></div>';
if(have_posts()):
	while( have_posts() ): the_post();
		$collectors = [];
		$collection = get_the_title();

		if( have_rows('nhsm_active_curators') ):
			while ( have_rows('nhsm_active_curators') ) : the_row();
				$c = trim(get_sub_field('nhsm_curator'));
				if($c) $collectors[] = $c;
			endwhile;
		endif;

		switch (count($collectors)) {
			case 0:
				$collector = '';
				break;
			case 1:
				$collector = $collectors[0];
				break;
			case 2:
				$collector = $collectors[0] . " & " . $collectors[1];
				break;
			default:
				$collector = substr(implode(', ', $collectors), 0, -3);
		}

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