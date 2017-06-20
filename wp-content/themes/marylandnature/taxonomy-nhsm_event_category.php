<?php get_header(); ?>
	
	<div id="content">
	
		<div id="inner-content">

			<div class="hbanner">
				<div class="row">
					<header class="small-12 columns article-header">
						<h1 class="page-title stringbean text-center">
							<?php echo nhsm_event_scope_prefix(' ');
							single_cat_title(); echo ' Events'; ?>
						</h1>
					</header>
				</div>
			</div>
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							<?php get_template_part( 'parts/loop', 'event-archive' ); ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>