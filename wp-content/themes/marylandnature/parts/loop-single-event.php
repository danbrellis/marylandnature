<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
	<header class="article-header">	
		<?php nhsm_addthis(true); ?>
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		<div class="callout event-important-info">
			<ul class="post-meta clearfix no-bullet">
				<li class="post-meta-date"><i class="fi-clock"></i>&nbsp;<?php echo nhsm_get_date_range($post); ?></li>
				<?php if(nhsm_is_event_over()): ?>
					<li class="post-meta-notice"><i class="fi-alert"></i>&nbsp;This event has passed.</li>
				<?php else:
					$tickets_url = apply_filters( 'em_single_event_tickets_url', get_post_meta( $post->ID, '_event_tickets_url', true ) );
					if ( $tickets_url ) : ?>
					<li class="post-meta-action"><i class="fi-checkbox"></i>&nbsp;<a href="<?php echo esc_url($tickets_url); ?>" title="Visit event registration url" target="_blank">Register Now!</a></li>
					<?php endif;
				endif; ?>
				
			</ul>
		</div>
		<?php nhsm_the_banner_image(); ?>
		<?php the_tags('<p class="post_tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</p>');
		$cats = get_the_terms(get_the_ID(), 'event-category');
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

		if(!empty($cat_list)): ?>
			<p class="event_cat_labels"><?php echo implode(' ', $cat_list); ?></p>
		<?php endif; ?>
	</header> <!-- end article header -->
					
	<section class="entry-content" itemprop="articleBody">
		<?php em_display_single_event_google_map(); ?>
		<?php //the_post_thumbnail('full'); ?>
		<?php the_content(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer">
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jointswp' ), 'after'  => '</div>' ) ); ?>
		<p class="tags"><?php the_tags('<span class="tags-title">' . __( 'Tags:', 'jointswp' ) . '</span> ', ', ', ''); ?></p>	
	</footer> <!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->