<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<?php get_template_part( 'parts/loop', 'single' ); ?>

<?php endwhile; else : ?>

	<?php get_template_part( 'parts/content', 'missing' ); ?>

<?php endif; ?>