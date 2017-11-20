<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
	<header class="article-header">		
		<?php nhsm_addthis(true); ?>
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		<p class="byline">
			<span class="author">Written by <?php the_author_posts_link(); ?></span>&nbsp;<span class="middot">&middot;</span>&nbsp;
			<time><?php echo get_the_time('F j, Y'); ?></time>
			<?php if ( comments_open() ): ?>&nbsp;<span class="middot">&middot;</span>&nbsp;
			<?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', ''); ?><?php endif; ?>
		</p>
    <?php nhsm_the_cat_labels(); ?>
		<?php nhsm_the_banner_image(); ?>
		<?php the_tags('<p class="post_tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</p>'); ?>

	</header> <!-- end article header -->
				
	<section class="entry-content" itemprop="articleBody">
		<?php //the_post_thumbnail('full'); ?>
		<?php the_content(); ?>
	</section> <!-- end article section -->

	<footer class="article-footer">
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jointswp' ), 'after'  => '</div>' ) ); ?>
		<p class="tags"><?php the_tags('<span class="tags-title">' . __( 'Tags:', 'jointswp' ) . '</span> ', ', ', ''); ?></p>	
	</footer> <!-- end article footer -->
					
	<?php comments_template(); ?>
</article> <!-- end article -->