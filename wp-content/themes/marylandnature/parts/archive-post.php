<?php global $post; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('article archiveArticle'); ?>>

    <header class="article__header">
        <h1 class="article__title archiveArticle__title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
        <p class="byline">
            <span class="author">Written by <?php the_author_posts_link(); ?></span>&nbsp;<span class="middot">&middot;</span>&nbsp;
            <time><?php echo get_the_time('F j, Y'); ?></time>
            <?php if ( comments_open() ): ?>&nbsp;<span class="middot">&middot;</span>&nbsp;
                <?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', ''); ?>
            <?php endif; ?>
        </p>
        <?php nhsm_the_cat_labels(); ?>
        <div class="article__banner"><?php nhsm_the_banner_image(); ?></div>
        <?php the_tags('<p class="post_tags post-meta-tags flex-list__item icon-with-text"><i class="fas fa-tags icon icon--accentuate" title="Tagged with:"></i>&nbsp;', ', ', '</p>'); ?>

    </header><!-- end article header -->

    <section class="entry-content" itemprop="articleBody">
        <?php the_excerpt(); ?>
    </section> <!-- end article section -->

    <footer class="article-footer">
        <a class="more-link button button--primary button--small" href="<?php the_permalink(); ?>" title="Continue reading <?php the_title(); ?>">Read more</a>
    </footer> <!-- end article footer -->

</article> <!-- end article -->