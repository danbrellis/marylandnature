<?php
/*
Template Name: Full Width (No Sidebar)
*/
?>

<?php get_header(); ?>
	
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-12 columns" role="main">
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php get_template_part( 'parts/content', 'page' ); ?>
							<?php endwhile; endif; ?>	
						</main> <!-- end #main -->

					</div>
				</div>
			</div>
		  
		  
		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>