<?php /* in the loop */ ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page article main__content'); ?>>
    <header class="page__header article__header">
        <h1 class="page__title article__title"><?php the_title(); ?></h1>
        <?php
        if(has_post_thumbnail()): ?>
            <figure class="article__banner figure figure--captionOverlay">
                <?php the_post_thumbnail('nhsm_hbanner', ['class' => 'figure__img']); ?>
                <figcaption class="figure__caption">
                    <?php echo nhsm_img_credit_and_caption(false, get_post_thumbnail_id()); ?>
                </figcaption>
            </figure>
        <?php endif; ?>
    </header>
    <?php if(isset($sidebar) && $sidebar): ?>
        <section class="page__content layout-thin-sidebar">
            <section class="article__content">
                <?php the_content(); ?>
            </section>
            <aside class="article__sidebar layout-thin-sidebar__sidebar"><?php echo $sidebar; ?></aside>
        </section>
    <?php else: ?>
    <section class="page__content article__content">
        <?php the_content(); ?>
    </section>
    <?php endif; ?>
    <footer class="page__footer article__footer">

    </footer>
</article>