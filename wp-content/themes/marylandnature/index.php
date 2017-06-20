<?php get_header();
$page_id = get_option( 'page_for_posts' );
?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							
							<header class="article-header">

								<div class="float-right">
									<!-- Go to www.addthis.com/dashboard to customize your tools -->
									<div class="addthis_inline_share_toolbox"></div>
								</div>
								<h1 class="entry-title single-title"><?php echo apply_filters( 'the_title', get_the_title( $page_id ) ); ?></h1>
								<?php nhsm_the_banner_image($page_id); ?>

							</header> <!-- end article header -->
							<?php 
							add_filter('excerpt_more', '__return_false');
							if (have_posts()) : while (have_posts()) : the_post(); ?>

								<?php get_template_part( 'parts/loop', 'archive' ); ?>

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