<?php get_header(); ?>

	<div id="content">
	
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
									<header class="article-header">
										<?php nhsm_addthis(); ?>
										<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
										<p class="collection-meta">
                      <?php $active_curators = array();
                      if( have_rows('nhsm_active_curators') ):
                        // loop through the rows of data
                        while (have_rows('nhsm_active_curators')):
                          the_row();
                          $active_curators[] = get_sub_field('nhsm_curator');
                        endwhile; ?>
                        <span class="collector">Curated by <strong><?php echo implode(', ', $active_curators); ?></strong></span>
                        &nbsp;<span class="middot">&middot;</span>&nbsp;
                      <?php endif; ?>
                      
                      <?php $num_specs = get_post_meta(get_the_ID(), 'nhsm_number_of_specimens', true); if($num_specs): ?>
											<span class="specimen-no">Includes ~<strong><?php echo $num_specs; ?> specimens</strong></span>
											&nbsp;<span class="middot">&middot;</span>&nbsp;
                      <?php endif; ?>
                      
                      <?php $origin = get_post_meta(get_the_ID(), 'nhsm_collection_origin', true); if($origin): ?>
											<span class="collection-date">Dated to <strong><?php echo $origin; ?></strong></span>
                      <?php endif; ?>
										</p>
										<?php nhsm_the_banner_image(); ?>
										<?php the_tags('<p class="post_tags"><i class="fi-pricetag-multiple" title="Tagged with:"></i>&nbsp;', ', ', '</p>'); ?>
									</header> <!-- end article header -->

									<section class="entry-content" itemprop="articleBody">
										<?php the_content(); ?>
										<?php wp_link_pages(); ?>
									</section> <!-- end article section -->

									<footer class="article-footer">

									</footer> <!-- end article footer -->

									<?php comments_template(); ?>

								</article> <!-- end article -->
							<?php endwhile; endif; ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>