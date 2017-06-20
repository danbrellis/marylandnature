<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							<header class="small-12 columns article-header">
								<div class="float-right">
									<!-- Go to www.addthis.com/dashboard to customize your tools -->
									<div class="addthis_inline_share_toolbox"></div>
								</div>
								<h1 class="entry-title single-title" itemprop="headline"><?php single_cat_title(); ?></h1>
							</header>
							<?php get_template_part( 'parts/loop', 'team' ); ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>