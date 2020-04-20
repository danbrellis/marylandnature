<?php get_header(); ?>
    <main class="main main--twoColumns" id="main">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php get_template_part( 'parts/single', 'page' ); ?>
        <?php endwhile; endif; ?>
        <?php get_sidebar(); ?>
    </main>
<?php get_footer(); ?>