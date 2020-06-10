<?php /* in the loop */ ?>
<?php add_filter('the_title', 'nhsm_add_wbr_to_title', 10, 2); ?>
<article class="collectionCard">
    <header class="collectionCard__info">
        <h1 class="collectionCard__title"><?php the_title(); ?></h1>
        <span class="collectionCard__curatedBy">Curated by <span class="collectionCard__collector"><?php echo nhsm_get_formatted_collector($post); ?></span>
    </header>
    <figure class="figure collectionCard__figure figure--captionOverlay">
        <?php the_post_thumbnail('nhsm_medium4x3', ['class' => 'collectionCard__img']); ?>
        <figcaption class="figure__caption"><?php echo nhsm_format_image_credit_line(); ?></figcaption>
    </figure>
</article>
<?php
remove_filter('the_title', 'nhsm_add_wbr_to_title');