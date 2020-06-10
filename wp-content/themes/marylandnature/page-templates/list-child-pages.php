<?php /* Template Name: List Child Pages */ ?>
<?php get_header(); ?>
    <div class="container main-container">
        <main class="main main--twoColumns" id="main">
            <section>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php get_template_part( 'parts/single', 'page' ); ?>
                <?php endwhile; endif; ?>
                <?php
                $children = new WP_Query([
                    'post_type' => 'any',
                    'post_parent' => get_the_ID(),
                    'post_status' => 'publish',
                    'orderby' => 'menu_order title'
                ]);
                if($children->have_posts()): ?>
                    <nav class="two-column-grid" aria-label="Subpage navigation">
                        <ul class="two-column-grid__list">
                            <?php while($children->have_posts()): $children->the_post(); ?>
                                <li class="two-column-grid__item"><?php get_template_part( 'parts/card', get_post_type() ); ?></li>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </section>
            <?php get_sidebar(); ?>
        </main>
    </div>
<?php get_footer(); ?>