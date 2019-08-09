<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1><?php echo nhsm_event_scope_prefix(' '); single_cat_title(); ?></h1>
								<?php the_archive_description('<p class="taxonomy-description">', '</p>');
								nhsm_em_the_event_archive_filters();
								nhsm_the_category_banner_image(); ?>

							</header> <!-- end article header -->
							<?php get_template_part( 'parts/looper', 'archive-event' ); ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>