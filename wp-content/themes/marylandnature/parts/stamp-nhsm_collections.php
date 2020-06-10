<?php /* in the loop */ ?>
<?php add_filter('the_title', 'nhsm_add_wbr_to_title', 10, 2); ?>
<figure class="collectionStamp">
    <?php the_post_thumbnail('nhsm_medium4x3', ['class' => 'collectionStamp__img']); ?>
    <figcaption class="collectionStamp__caption">
        <strong class="collectionStamp__title"><?php the_title(); ?></strong>
        <span class="collectionStamp__collector"><?php echo nhsm_get_formatted_collector($post); ?></span>
    </figcaption>
</figure>
<?php
remove_filter('the_title', 'nhsm_add_wbr_to_title');