<?php
/**
 * The template for displaying all single Super Simple Sliders.
 *
 * @package Super Simple Slider
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			if ( $queried_object ) {
				echo do_shortcode('[super-simple-slider id="' .$queried_object->ID. '"]');
			}
			?>		

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
