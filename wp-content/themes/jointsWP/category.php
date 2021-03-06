<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1 class="entry-title single-title"><?php echo single_cat_title();?></h1>
								<?php the_archive_description('<p class="taxonomy-description">', '</p>');?>
								<?php nhsm_the_category_banner_image(); ?>

							</header> <!-- end article header -->
							<?php 
							add_filter('excerpt_more', '__return_false');
							if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php get_template_part( 'parts/content', 'archive' ); ?>

							<?php endwhile; else : ?>

								<?php get_template_part( 'parts/content', 'missing' ); ?>

							<?php endif;
							remove_filter('excerpt_more', '__return_false');?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>