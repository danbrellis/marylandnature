<?php get_header(); $classes = array('medium-12', 'columns'); ?>
			
<div id="content">

	<div id="inner-content">
		<div class="hbanner"<?php if(has_post_thumbnail()): ?> style="background-image:url(<?php the_post_thumbnail_url('full'); ?>)"<?php endif; ?>>
			<div class="row">
				<header class="small-12 columns article-header">
					<span class="h1 page-title stringbean text-center"><?php the_title(); ?></span>
				</header>
			</div>
		</div>
		<div class="row">
			<div class="<?php echo implode(' ', $classes); ?>">
				<div class="row" data-equalizer="brellis" data-equalize-on="medium">
					<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php get_template_part( 'parts/loop', 'single-event' ); ?>

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