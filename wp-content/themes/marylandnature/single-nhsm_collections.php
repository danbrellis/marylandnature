<?php get_header(); ?>

	<div id="content">
	
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/WebPage">
									<header class="article-header">
										<?php nhsm_addthis(); ?>
										<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
										<p class="collection-meta">
											<span class="collector">Collected by <strong><?php echo get_post_meta(get_the_ID(), 'nhsm_collection_owner', true); ?></strong></span>
											&nbsp;<span class="middot">&middot;</span>&nbsp;
											<span class="specimen-no">Includes <strong>230 specimens</strong></span>
											&nbsp;<span class="middot">&middot;</span>&nbsp;
											<span class="collection-date">Dated to <strong>1904</strong></span>
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