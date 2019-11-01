<?php
/**
 * Created by PhpStorm.
 * User: danbr
 * Date: 11/1/2019
 * Time: 1:33 PM
 */

//other post types to be added later: resources (dlm_downloads)
$post_types = [
    'event' => [
        "label" => "Events",
        "args" => [
            'event_show_occurrences' => true,
            'event_show_past_events' => false,
            'order' => 'ASC'
        ]
    ],
    'nhsm_collections' => [
        "label" => "Collections"
    ],
    'nhsm_team' => [
        "label" => "People",
        "classes" => ["team-cards-grid"]
    ]
];
?>

<ul class="tabs" data-tabs id="search-result-tabs">
    <li class="tabs-title is-active"><a href="#general" aria-selected="true">General</a></li>
    <?php foreach($post_types as $post_type => $details): ?>
        <li class="tabs-title"><a data-tabs-target="<?php echo $post_type; ?>" href="#<?php echo $post_type; ?>"><?php echo $details['label']; ?></a></li>
    <?php endforeach; ?>
</ul>

<div class="tabs-content" data-tabs-content="search-result-tabs">
    <div class="tabs-panel is-active" id="general">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php get_template_part( 'parts/loop', 'archive' ); ?>
        <?php endwhile;
            joints_page_navi();
        else : ?>
            <?php get_template_part( 'parts/content', 'missing' ); ?>
        <?php endif; ?>
    </div>
    <?php foreach($post_types as $post_type => $details): ?>
        <?php
        $classes = [];
        if (isset($details['classes'])) $classes = array_merge($details['classes'], $classes); ?>
        <div class="tabs-panel" id="<?php echo $post_type; ?>">
            <div class="<?php echo implode(' ', $classes); ?>">
                <?php
                $args = [
                    'post_type' => $post_type,
                ];
                $args['s'] = isset($_GET["s"]) ? $_GET["s"] : "";
                if(isset($tag) && $tag) $args['tag_id'] = $tag->term_id;
                if(isset($details['args'])) $args = wp_parse_args($details['args'], $args);
                $query = new WP_Query($args);
                if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                    <?php get_template_part( 'parts/loop', 'archive-' . $post_type ); ?>
                <?php endwhile;
                    joints_page_navi();
                    wp_reset_postdata();
                else : ?>
                    <?php get_template_part( 'parts/content', 'missing' ); ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
