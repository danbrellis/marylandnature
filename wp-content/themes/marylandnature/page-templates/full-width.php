<?php /* Template Name: Full Width (No Sidebar) */ ?>
<?php get_header(); ?>
    <div class="container main-container">
        <main class="main" id="main">
            <section>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part( 'parts/single', 'page' ); ?>
                <?php endwhile; endif; ?>
            </section>
        </main>
    </div>
<?php get_footer(); ?>