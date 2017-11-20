<article id="post-<?php the_ID(); ?>" <?php post_class('archive'); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
					
  <header class="article-header">
		<h3 class="entry-title single-title" itemprop="headline"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		<?php //nhsm_em_the_date_reg_box(); ?>
    <?php nhsm_the_cat_labels(); ?>
		<?php nhsm_the_banner_image(); ?>
		<?php the_tags('<p class="post_tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</p>');
		nhsm_em_the_event_terms_list(); ?>

	</header> <!-- end article header -->
	
	<section class="entry-content" itemprop="articleBody">
		<?php the_content(); ?>
		<div class="addthis_inline_share_toolbox float-right" data-url="<?php the_permalink(); ?>" data-title="<?php the_title(); ?>" data-description="<?php the_excerpt(); ?>" data-media="<?php the_post_thumbnail_url(get_the_ID(), 'nhsm_hbanner'); ?>"></div><a class="more-link button small" href="<?php the_permalink(); ?>"><span aria-label="Continue reading <?php the_title(); ?>">Read more</span></a>
		<?php wp_link_pages(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer clearfix">
		
	</footer> <!-- end article footer -->
						    
</article> <!-- end article -->