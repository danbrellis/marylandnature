<?php get_header();
$page_id = get_option( 'page_for_posts' );
?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							
							<header class="article-header">

								<?php nhsm_addthis(); ?>
								<h1 class="entry-title single-title"><?php echo apply_filters( 'the_title', get_the_title( $page_id ) ); ?></h1>
								<?php nhsm_the_banner_image($page_id); ?>

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