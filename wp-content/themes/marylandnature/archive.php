<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1 class="single-title"><?php the_archive_title();?></h1>
								<?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
							</header>
							<?php if (have_posts()){
								while (have_posts()){
									the_post();
									get_template_part( 'parts/loop', 'archive' );
								}
								joints_page_navi();
							}
							else {
								get_template_part( 'parts/content', 'missing' );
							} ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>