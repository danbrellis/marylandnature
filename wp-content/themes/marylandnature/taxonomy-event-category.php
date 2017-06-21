<?php get_header(); ?>
	
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
								<h1><?php echo nhsm_event_scope_prefix(' '); single_cat_title(); ?></h1>
								<?php the_archive_description('<p class="taxonomy-description">', '</p>');?>
								
								<?php
								$qo = get_queried_object();
								//var_dump($qo);
								$terms = get_terms( array(
									'taxonomy' => $qo->taxonomy,
									'hide_empty' => false,
								) );
								?>
								
								<?php $scope = isset($_GET['show']) ? sanitize_title($_GET['show']) : 'upcoming';	?>
								<form class="" method="get" action="" role="form" style="margin-top:20px; margin-bottom:10px;">
									<div class="row">
										<div class="small-1 columns">
											<label for="middle-label" class="text-right middle">Filter: </label>
										</div>
										<div class="small-5 columns end">
											<select name="show" class="form-control" onchange="this.form.submit()">
												<option value="all" <?php selected($scope, 'all'); ?>>All Events</option>
												<option value="upcoming" <?php selected($scope, 'upcoming'); ?>>Upcoming Events</option>
												<option value="past" <?php selected($scope, 'past'); ?>>Past Events</option>
											</select>
										</div>
										<?php if($terms && !empty($terms) && !is_wp_error($terms)): ?>
											<div class="medium-5 end columns">
												<select id="jum" class="form-control" onchange="javascript:location.href = this.value;">
													<?php foreach($terms as $term): ?>
													<option value="<?php echo add_query_arg('show', $scope, get_term_link($term)); ?>" <?php selected( $term->term_id, $qo->term_id ); ?>><?php echo $term->name; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
										<?php endif; ?>
									</div>
								</form>
								<?php nhsm_the_category_banner_image(); ?>

							</header> <!-- end article header -->
							<?php get_template_part( 'parts/looper', 'event-archive' ); ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>