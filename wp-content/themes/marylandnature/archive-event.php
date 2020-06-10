<?php get_header(); ?>
    <div class="container main-container">
        <main class="main main--twoColumns" id="main">
            <article class="main__content">
                <header class="article-header" id="page-title">
                    <h1 class="single-title"><?php echo nhsm_event_scope_prefix(' '); post_type_archive_title('', false) ? post_type_archive_title() : the_archive_title(); ?></h1>
                    <?php get_template_part('parts/snippet', 'event-archive-filters'); ?>
                </header>
                <section class="archiveList" aria-labelledby="page-title">
                    <?php if(have_posts()): while(have_posts()): the_post(); ?>
                        <?php get_template_part( 'parts/archive', 'event' ); ?>
                    <?php endwhile;
                    else: ?>
                        <div class="notice notice--alert">
                            <span class="notice__heading">No Events Listed</span>
                            <p>Apologies, but no events were found.</p>
                        </div>
                    <?php endif; ?>

                </section>
                <footer class="article-footer">
                    <nav class="prev-next"><?php posts_nav_link(); ?></nav>
                </footer>
            </article>
            <?php get_sidebar(); ?>
        </main>
    </div>
<?php get_footer(); ?>