<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1 class="single-title"><?php the_archive_title();?></h1>
								<?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
							</header>
							<?php
							$tag = get_queried_object();
							$tabs = array(
								'events' => array(
									'label' => 'Events',
									'template' => 'parts/loop-archive-event',
									'args' => array('post_type' => 'event', 'tag_id' => $tag->term_id)
								),
								'collections' => array(
									'label' => 'Collections',
									'template' => 'parts/loop-archive-nhsm_collections',
									'args' => array('post_type' => 'nhsm_collections', 'tag_id' => $tag->term_id)
								),
								'experts' => array(
									'label' => 'Experts',
									'template' => 'parts/loop-archive',
									'args' => array(
										'post_type' => 'nhsm_team', 
										'tax_query' => array(
											'relation' => 'AND',
											array(
												'taxonomy' => 'post_tag',
												'field'    => 'term_id',
												'terms'    => $tag->term_id,
											),
											array(
												'taxonomy' => 'nhsm_role',
												'field'    => 'slug',
												'terms'    => 'experts'
											)
										)
									)
								),
								'resources' => array(
									'label' => 'Resources',
									'template' => 'parts/loop-download-grid',
									'args' => array(
										'post_type' => 'dlm_download',
										's' => $tag->name,
									)
								),
								
							); add_filter('excerpt_more', '__return_false');
							?>
              <ul class="menu tabs" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500" data-tabs id="deeplinked-tabs">
                <li class="menu-text float-left">Filter by:</li>
                
                <li class="tabs-title is-active"><a href="#general" aria-selected="true">General</a></li>
								<?php foreach($tabs as $k => $v): ?>
									<li class="tabs-title"><a href="#<?php echo $k; ?>" aria-selected="true"><?php echo $v['label']; ?></a></li>
								<?php endforeach; ?>
							</ul>

							<div class="tabs-content" data-tabs-content="deeplinked-tabs">
								<div class="tabs-panel" id="general">
									<?php if (have_posts()){
										while (have_posts()){
											the_post();
											get_template_part( 'parts/loop', 'archive' );
										}
										joints_page_navi();
									}
									else {
										get_template_part( 'parts/content', 'missing' );
									} ?>
								</div>
								<?php foreach($tabs as $k => $v): ?>
									<div class="tabs-panel" id="<?php echo $k; ?>">
										<?php //var_dump($v['args']);
										$query2 = new WP_Query( $v['args'] );
										//var_dump($query2);
										switch($k){
											case 'events':
												if ($query2->have_posts()){
													$cur_date = '';
													
													while ($query2->have_posts()){
														$query2->the_post();
														$start = strtotime(get_post_meta($query2->post->ID, '_event_start_date', true));
														if($cur_date !== $start){
															$format = date('Y') == date('Y', $start) ? 'l, j F' : 'l, j F Y';
															echo '<h2 class="u">' . date($format, $start) . '</h2>';
															$cur_date = $start;
														}
														get_template_part( $v['template'] );
													}
													
												} 
												else get_template_part( 'parts/content', 'missing' );
												break;
											default:
												if ( $query2->have_posts() ) {
													// The 2nd Loop
													while ( $query2->have_posts() ) {
														$query2->the_post();
														$wp_query->current_post = 0;
														get_template_part( $v['template'] );
													}
												}
												else {
													get_template_part( 'parts/content', 'missing' );
												}
										}
										?>
									</div><!-- //#<?php echo $k; ?> -->
								<?php 
								// Restore original Post Data
								wp_reset_postdata();
								endforeach;
								remove_filter('excerpt_more', '__return_false'); ?>

							</div>
							
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>