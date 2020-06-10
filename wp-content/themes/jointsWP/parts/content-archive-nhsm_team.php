<?php global $post; ?>
<div class="card team-card" id="team-<?php the_ID(); ?>">
    <div class="card-section team-biophotocont">
        <?php if(has_excerpt()): ?>
            <div class="team-excerpt">
                <div><?php the_excerpt(); ?></div>
            </div>
        <?php endif; ?>
        <?php if(has_post_thumbnail()): ?>
            <?php $thumbnail_id = get_post_thumbnail_id( $post->ID );
            $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            the_post_thumbnail('nhsm_headshot', ['class' => 'img-responsive img-circle team-headshot', 'alt' => $alt]); ?>
        <?php else: ?>
            <img src="http://placehold.it/975x975" class="img-responsive img-circle team-headshot">
        <?php endif; ?>
    </div>
    <div class="card-section card-divider text-center">
        <strong><?php the_title(); ?></strong>
    </div>
</div>