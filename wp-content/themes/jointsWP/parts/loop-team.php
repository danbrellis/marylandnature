<?php

global $wp_query;
$posts = $wp_query->posts;
$people = [];
foreach($posts as $post){
    $group = '';
    if(is_tax('nhsm_role')){
        if(is_tax('nhsm_role', 'board-of-directors')){
            $group = 'board-of-directors';
        }
        else{
            $group = 'team_' . $wp_query->tax_query->queried_terms['nhsm_role']['terms'][0];
        }
    }
    $rows = get_field('team_member_role', $post->ID);
    //var_dump($rows);
    if($rows) {
        foreach($rows as $row)
            if($row['group_position']['group'] === $group) {
                $post->role_position = $row['group_position']['position'];
                $post->group_order = $row['group_position']['list_order'] === "" ? 9999 : intval($row['group_position']['list_order']);
            }
    }

}

usort($wp_query->posts, function ($a, $b) {
    if($a->group_order === $b->group_order){
        return strcmp($a->post_title, $b->post_title);
    }
    return ($a->group_order < $b->group_order) ? -1 : 1;
});

if(have_posts()): ?>
    <div class="team-cards-grid">
        <?php while( have_posts() ): the_post(); ?>
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
                    <?php
                    //get appropriate role position title
                    echo '<p>' . $post->role_position . '</p>';
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif;