<?php get_header(); ?>
    <div class="container main-container">
        <main class="main main--twoColumns" id="main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'parts/single', 'event' ); ?>
            <?php endwhile; endif; ?>
            <?php get_sidebar(); ?>
        </main>
    </div>
<?php get_footer(); ?>