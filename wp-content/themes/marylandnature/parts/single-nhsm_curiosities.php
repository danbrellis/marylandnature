<?php /* in the loop */
global $post; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page curiosity article main__content'); ?>>
  <header class="page__header article__header">
    <h1 class="page__title article__title"><?php the_title(); ?></h1>

    <?php if($post->post_parent): ?>
    <p class="event_cat_labels">
      <a href="<?php the_permalink($post->post_parent);?>" class="label label--primary"><?php echo get_the_title($post->post_parent); ?></a>
    </p>
    <?php endif; ?>

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
  <section class="page__content article__content">
    <?php the_content(); ?>
    <?php
    $children = get_children([
      'post_parent' => get_the_ID(),
      'post_type' => 'nhsm_curiosities',
      'orderby' => 'title',
      'order' => 'ASC'
    ]);
    if ( ! empty($children) ): ?>
      <ul>
        <?php foreach($children as $child): ?>
          <li><a href="<?php the_permalink($child);?>"><?php echo get_the_title($child) ?></a></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
  <footer class="page__footer article__footer">

  </footer>
</article>