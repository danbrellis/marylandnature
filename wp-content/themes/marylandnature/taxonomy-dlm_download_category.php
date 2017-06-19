<?php get_header(); ?>
	
	<div id="content">
	
		<div id="inner-content">

			<div class="hbanner">
				<div class="row">
					<header class="small-12 columns article-header">
						<h1 class="page-title stringbean text-center"><?php the_archive_title();?></h1>
						<?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
					</header>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch>
							<?php if (have_posts()){
								while (have_posts()){
									the_post();
									get_template_part( 'parts/loop', 'download-grid' );
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