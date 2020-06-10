<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							
							<article id="post-<?php the_ID(); ?>" role="article" itemscope itemtype="http://schema.org/WebPage">

								<header class="small-12 columns article-header">
									<?php nhsm_addthis(); ?>
									<h1 class="entry-title single-title" itemprop="headline"><?php single_cat_title(); ?></h1>
								</header>	
								<?php get_template_part( 'parts/loop', 'team' ); ?>

							</article> <!-- end article -->
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>