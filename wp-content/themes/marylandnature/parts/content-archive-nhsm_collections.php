<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
					
  <header class="article-header">
		<?php nhsm_addthis(); ?>
        <h3 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h3>
		<p class="collection-meta">
			<span class="collector">Collected by <strong><?php echo nhsm_get_formatted_collector($post); ?></strong></span>
			<?php /* &nbsp;<span class="middot">&middot;</span>&nbsp;
			<span class="specimen-no">Includes <strong>230 specimens</strong></span>
			&nbsp;<span class="middot">&middot;</span>&nbsp;
			<span class="collection-date">Dated to <strong>1904</strong></span> */ ?>
		</p>
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