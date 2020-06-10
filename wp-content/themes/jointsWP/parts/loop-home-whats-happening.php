<?php $i = 0; $bullets = array();
if(have_posts()): ?>
	<div class="orbit" role="region" aria-label="What's Happening in Nature Now" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out" data-nav-buttons="false">
		<ul class="orbit-container">
			<?php while( have_posts() ): the_post(); ?>
				<li class="orbit-slide">
					<div class="row">
						<div class="medium-5 columns" style="position: relative">
							<div class="slider-img-container">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('medium', array('class' => 'img-responsive img-circle')); ?></a><br />
								<?php echo nhsm_format_image_credit_line(false, get_post_thumbnail_id()); ?>
							</div>
						</div>
						<div class="medium-6 columns slider-body">
							<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
							<p class="show-for-medium"><?php remove_filter('the_excerpt', 'wpautop'); the_excerpt(); add_filter('the_excerpt', 'wpautop'); ?></p>
						</div>
					</div>
				</li>
			<?php 
			$bullets[] = get_the_title();
			$i++; endwhile; ?>
			
		</ul>
		<nav class="orbit-bullets">
			<?php foreach($bullets as $i => $title): ?>
				<button data-slide="<?php echo $i; ?>"><span class="show-for-sr"><?php echo $title; ?></span></button>
			<?php endforeach; ?>
		</nav>
	</div>

<?php endif;

wp_reset_postdata();