<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1 class="single-title"><?php echo nhsm_event_scope_prefix(' '); post_type_archive_title(); ?></h1>
								<?php nhsm_em_the_event_archive_filters(); ?>
							</header>
							<?php get_template_part( 'parts/looper', 'archive-event' ); ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>