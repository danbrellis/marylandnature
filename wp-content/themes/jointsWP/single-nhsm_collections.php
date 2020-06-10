<?php get_header(); ?>

	<div id="content">
	
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                                <?php get_template_part( 'parts/content', 'single-collection' ); ?>

                            <?php endwhile; else : ?>

                                <?php get_template_part( 'parts/content', 'missing' ); ?>

                            <?php endif; ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>