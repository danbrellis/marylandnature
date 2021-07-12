<?php /* Template Name: No Featured Image */ ?>
<?php get_header(); ?>
<?php $no_featured_image = true; ?>
    <div class="container main-container">
        <main class="main main--twoColumns" id="main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part( 'parts/single', 'page' ); ?>
            <?php endwhile; endif; ?>
            <?php get_sidebar(); ?>
        </main>
    </div>
<?php get_footer(); ?>