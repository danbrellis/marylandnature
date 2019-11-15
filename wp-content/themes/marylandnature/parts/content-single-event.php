<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
	<header class="article-header">	
		<?php nhsm_addthis(); ?>
		<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php 
		nhsm_em_the_date_reg_box();
		nhsm_the_banner_image();
		the_tags('<p class="post_tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</p>');
		nhsm_em_the_event_terms_list(); ?>
	</header> <!-- end article header -->
					
	<section class="entry-content" itemprop="articleBody">
		<?php //the_post_thumbnail('full'); ?>
		<?php the_content(); ?>
        <h2>Location</h2>
        <?php em_display_single_event_google_map(); ?>
		<?php em_display_event_gallery(); ?>
	</section> <!-- end article section -->
						
	<footer class="article-footer">
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jointswp' ), 'after'  => '</div>' ) ); ?>
	</footer> <!-- end article footer -->

	<?php comments_template(); ?>

</article> <!-- end article -->