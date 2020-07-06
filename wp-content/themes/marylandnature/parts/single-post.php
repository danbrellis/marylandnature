<?php /* in the loop */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page article main__content'); ?>>
    <header class="page__header article__header">
        <h1 class="page__title article__title"><?php the_title(); ?></h1>
        <p class="byline">
            <span class="author">Written by <?php the_author_posts_link(); ?></span>&nbsp;<span class="middot">&middot;</span>&nbsp;
            <time><?php echo get_the_time('F j, Y'); ?></time>
            <?php if ( comments_open() ): ?>&nbsp;<span class="middot">&middot;</span>&nbsp;
                <?php comments_popup_link( '0 Comments', '1 Comment', '% Comments', 'comments-link', ''); ?><?php endif; ?>
        </p>
        <?php nhsm_the_cat_labels(); ?>


        <?php
        if(has_post_thumbnail()): ?>
            <figure class="article__banner figure figure--captionOverlay">
                <?php the_post_thumbnail('nhsm_hbanner', ['class' => 'figure__img']); ?>
                <figcaption class="figure__caption"><?php echo nhsm_img_credit_and_caption(false, get_post_thumbnail_id()); ?></figcaption>
            </figure>
        <?php endif; ?>
        <?php the_tags('<p class="post_tags post-meta-tags flex-list__item icon-with-text"><i class="fas fa-tags icon icon--accentuate" title="Tagged with:"></i>&nbsp;', ', ', '</p>'); ?>
    </header>
    <section class="page__content article__content">
        <?php the_content(); ?>
    </section>
    <footer class="page__footer article__footer">

    </footer>
</article>