<?php /* in the loop */
global $post; ?>
<article class="personCard">
    <header class="personCard__info">
        <h1 class="personCard__name"><?php the_title(); ?></h1>
        <span class="personCard__title"><?php echo $post->role_position; ?></span>
    </header>
    <figure class="personCard__figure figure figure--circle">
        <?php if(has_post_thumbnail()): ?>
            <?php the_post_thumbnail('nhsm_headshot', ['class' => 'personCard__img']); ?>
        <?php else: ?>
            <img src="http://placehold.it/975x975" class="personCard__img">
        <?php endif; ?>

    </figure>
</article>