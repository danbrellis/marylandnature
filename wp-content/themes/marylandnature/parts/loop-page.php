<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
					
  <header class="article-header">
		
		<div class="float-right">
			<!-- Go to www.addthis.com/dashboard to customize your tools -->
			<div class="addthis_inline_share_toolbox"></div>
		</div>
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php nhsm_the_banner_image(); ?>

	</header> <!-- end article header -->
	
	<section class="entry-content" itemprop="articleBody">
		<?php the_content(); ?>
		<?php wp_link_pages(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer">
		
	</footer> <!-- end article footer -->
						    
</article> <!-- end article -->