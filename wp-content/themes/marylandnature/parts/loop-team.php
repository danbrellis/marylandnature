<?php
$i = 1;
global $wp_query;
$n = $wp_query->post_count;
if(have_posts()): ?>
    <div class="row" data-equalizer>
        <?php while( have_posts() ): the_post(); ?>
            <div class="small-6 medium-6 large-4 columns<?php echo $i == $n ? ' end' : ''; ?>">
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
                    <div class="card-section card-divider text-center" data-equalizer-watch>
                        <strong><?php the_title(); ?></strong>
                        <?php
                        //get appropriate role position title

                        $group = '';
                        if(is_tax('nhsm_role')){
                            if(is_tax('nhsm_role', 'board-of-directors')){
                                $group = 'board-of-directors';
                            }
                            elseif(is_tax('nhsm_role', 'team')){
                                $group = 'team_' . $wp_query->tax_query->queried_terms['nhsm_team_cat']['terms'][0];
                            }
                        }
                        $rows = get_field('team_member_role');
                        //var_dump($rows);
                        if($rows) {
                            foreach($rows as $row)
                                if($row['group_position']['group'] === $group) echo '<p>' . $row['group_position']['position'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php $i++; endwhile; ?>
    </div>
<?php endif;
wp_reset_postdata();