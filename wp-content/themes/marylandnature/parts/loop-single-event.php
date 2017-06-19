<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
	<header class="article-header">	
		<h1 class="entry-title single-title hide" itemprop="headline"><?php the_title(); ?></h1>
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
		<?php get_template_part( 'parts/content', 'byline' ); ?>
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
						
	<div class="row">
		<div class="medium-10 medium-offset-1 end columns">
			<?php comments_template(); ?>
		</div>
	</div>

</article> <!-- end article -->