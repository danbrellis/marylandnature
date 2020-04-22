<?php /* in the loop */ ?>
<?php add_filter('the_title', 'nhsm_add_wbr_to_title', 10, 2); ?>
<article class="collection">
    <header class="collection__info">
        <h1 class="collection__title"><?php the_title(); ?></h1>
        <span class="collection__collector"><?php echo nhsm_get_formatted_collector($post); ?></span>
    </header>
    <?php the_post_thumbnail('nhsm_medium4x3', ['class' => 'collection__img']); ?>
</article>
<?php
remove_filter('the_title', 'nhsm_add_wbr_to_title');