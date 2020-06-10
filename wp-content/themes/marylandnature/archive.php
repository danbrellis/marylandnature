<?php get_header(); ?>
    <div class="container main-container">
        <main class="main main--twoColumns" id="main">
            <article class="main__content">
                <header class="article-header" id="page-title">
                    <h1 class="single-title"><?php the_archive_title();?></h1>
                    <?php the_archive_description('<div class="taxonomy-description">', '</div>');?>
                </header>
                <section class="archiveList" aria-labelledby="page-title">
                    <?php if(have_posts()) {
                        while(have_posts()){
                            the_post();
                            get_template_part( 'parts/archive', get_post_type() );
                        }
                    }
                    else{
                        get_template_part( 'parts/content', 'missing' );
                    }
                    ?>

                </section>
                <footer class="article-footer">
                    <nav class="prev-next"><?php posts_nav_link(); ?></nav>
                </footer>
            </article>
            <?php get_sidebar(); ?>
        </main>
    </div>
<?php get_footer(); ?>