<?php 
$i = 1;
global $wp_query;
$n = $wp_query->post_count;
if(have_posts()): ?>
    <div class="row" data-equalizer>
        <?php while( have_posts() ): the_post(); $link = false; ?>
            <div class="small-6 medium-6 large-4 columns<?php echo $i == $n ? ' end' : ''; ?>">
                <div class="card team-card" id="team-<?php the_ID(); ?>">
                    <?php if(get_the_content()): $link = true; ?><a href="<?php the_permalink(); ?>" class="incognito-links" title="View full bio"><?php endif; ?>
                        <div class="card-section team-biophotocont">
                            <?php if(has_excerpt()): ?>
                            <div class="team-excerpt">
                                <div><?php the_excerpt(); ?></div>
                            </div>
                            <?php endif; ?>
                            <img src="http://placehold.it/325x325" class="img-responsive img-circle team-headshot">

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