<?php
/*
Template Name: What We Do
*/
?>

<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?> role="article" itemscope itemtype="http://schema.org/WebPage">

									<header class="article-header">

										<?php nhsm_addthis(); ?>
										<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
										<?php nhsm_the_banner_image(); ?>

									</header> <!-- end article header -->

									<section class="entry-content" itemprop="articleBody">
                    <?php the_content(); ?>
										<?php //list event categories
										$programs = new WP_Query( array(
											'post_parent' => get_the_ID(),
											'post_type' => 'page',
                      'order' => 'ASC',
                      'orderby' => 'menu_order date'
										) );

										if ( $programs->have_posts() ): ?>
											<div class="row small-up-1 medium-up-2" data-equalizer="terrapin">
												<?php // The 2nd Loop
												add_filter('excerpt_more', '__return_false');
												while ( $programs->have_posts() ):
													$programs->the_post(); ?>
													
													<div class="column column-block" data-equalizer-watch="terrapin">
															<?php if(has_post_thumbnail($programs->post)): ?>
                                <div class="img-caption-container">
                                  <a href="<?php echo get_page_link($programs->post->ID); ?>"><?php echo get_the_post_thumbnail($programs->post, 'nhsm_medium4x3', array('class' => 'img-responsive')); ?></a>
                                  <span class="sm_img_caption"><?php echo nhsm_img_credit_and_caption(false, get_post_thumbnail_id($programs->post->ID)); ?></span>
                                </div>
                              <?php endif; ?>
															<h3 class="widget-title stringbean" style="margin-top: 10px;"><?php echo get_the_title($programs->post->ID); ?></h3>
														</a>
														<p>
															<?php echo get_the_excerpt($programs->post->ID); ?><br /><br />
															<a class="more-link button small" href="<?php the_permalink($programs->post->ID); ?>"><span aria-label="Continue reading <?php echo get_the_title($programs->post->ID); ?>">Read more</span></a>
														</p>
													</div>
												<?php endwhile;
												remove_filter('excerpt_more', '__return_false');
												// Restore original Post Data
												wp_reset_postdata(); ?>
											</div>
										
										<?php endif; ?>
										<?php wp_link_pages(); ?>
									</section> <!-- end article section -->

									<footer class="article-footer">

									</footer> <!-- end article footer -->

								</article> <!-- end article -->
							<?php endwhile; endif; ?>	
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>