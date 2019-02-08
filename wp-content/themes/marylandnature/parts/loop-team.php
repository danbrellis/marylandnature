<?php
$i = 1;
global $wp_query;
$queried_obj = get_queried_object();
$nolinks = true;
if(get_class($queried_obj) === 'WP_Term'){
    $nolinks = !get_term_meta( $queried_obj->term_id, '_has_unique_urls', true );

}
$n = $wp_query->post_count;
if(have_posts()): ?>
    <div class="row" data-equalizer>
        <?php while( have_posts() ): the_post(); $link = false; ?>
            <div class="small-6 medium-6 large-4 columns<?php echo $i == $n ? ' end' : ''; ?>">
                <div class="card team-card" id="team-<?php the_ID(); ?>">
                    <?php if(!$nolinks && get_the_content()): $link = true; ?><a href="<?php the_permalink(); ?>" class="incognito-links" title="View full bio"><?php endif; ?>
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
                        <div class="card-section card-divider text-center" data-equalizer-watch>
                            <strong><?php the_title(); ?></strong>
                            <p><?php the_field('team_member_role'); ?></p>
                        </div>
                    <?php if($link): ?></a><?php endif; ?>
                </div>
            </div>
        <?php $i++; endwhile; ?>
    </div>
<?php endif;
wp_reset_postdata();