<?php add_filter('excerpt_more', '__return_false');
if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php get_template_part( 'parts/content', 'archive' ); ?>

<?php endwhile; else : ?>

	<?php get_template_part( 'parts/content', 'missing' ); ?>

<?php endif; remove_filter('excerpt_more', '__return_false'); ?>