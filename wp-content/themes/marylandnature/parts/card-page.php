<?php /* in the loop */ ?>
<article class="pageCard">
    <header class="pageCard__header">
        <h1 class="pageCard__title"><a class="pageCard__link" href="<?php the_permalink();?>"><?php the_title(); ?></a></h1>
        <figure class="pageCard__figure figure figure--captionOverlay">
            <?php the_post_thumbnail('nhsm_medium4x3', ['class' => 'pageCard__img']); ?>
            <figcaption class="figure__caption"><?php echo nhsm_img_credit_and_caption(); ?></figcaption>
        </figure>
    </header>
    <p class="pageCard__excerpt"><?php echo get_the_excerpt(); ?></p>
</article>
