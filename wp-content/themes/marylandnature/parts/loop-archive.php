<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
					
  <header class="article-header">
		<h2 class="entry-title single-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
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
		<?php the_content(); ?>
		<div class="addthis_inline_share_toolbox float-right" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-description="<?php the_excerpt(); ?>" data-media="<?php the_post_thumbnail_url(get_the_ID(), 'nhsm_hbanner'); ?>"></div><a class="more-link button small" href="<?php the_permalink(); ?>"><span aria-label="Continue reading <?php the_title(); ?>">Read more</span></a>
		<?php wp_link_pages(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer clearfix">
		
	</footer> <!-- end article footer -->
						    
</article> <!-- end article -->