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
        <?php
        global $wp_query;
        $max_page = $wp_query->max_num_pages;
        $paged = get_query_var('paged') === 0 ? 1 : get_query_var('paged');
        if($max_page > 1) printf("<p>Showing page %d of %d</p>", $paged, $max_page); ?>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <?php get_template_part( 'parts/content', 'archive' ); ?>
        <?php endwhile;
            joints_page_navi();
        else : ?>
            <?php get_template_part( 'parts/content', 'missing' ); ?>
        <?php endif; ?>
    </div>
    <?php foreach($post_types as $post_type => $details): ?>
        <?php
        $classes = [];
        $post_type_page_arg = $post_type . 'page';
        if(isset($_GET[$post_type_page_arg]) && is_numeric($_GET[$post_type_page_arg])) $page = intval($_GET[$post_type_page_arg]);
        if (isset($details['classes'])) $classes = array_merge($details['classes'], $classes); ?>
        <div class="tabs-panel" id="<?php echo $post_type; ?>">
            <?php
            $args = [
                'post_type' => $post_type,
                'posts_per_page' => 10,
            ];
            $args['s'] = isset($_GET["s"]) ? $_GET["s"] : "";
            if($page > 1) $args['paged'] = $page;
            if(isset($tag) && $tag) $args['tag_id'] = $tag->term_id;
            if(isset($details['args'])) $args = wp_parse_args($details['args'], $args);
            $query = new WP_Query($args);

            //page nav specific to post_types
            $posts_per_page = intval($query->get('posts_per_page'));
            $paged = intval($query->get('paged'));
            $max_page = $query->max_num_pages;
            if(empty($paged) || $paged === 0) {
                $paged = 1;
            }

            if($max_page > 1) printf("<p>Showing page %d of %d</p>", $paged, $max_page);
            ?>
            <?php if ( $query->have_posts() ) : ?>
                <div class="<?php echo implode(' ', $classes); ?>">
                     <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                        <?php get_template_part( 'parts/content', 'archive-' . $post_type ); ?>
                     <?php endwhile; ?>
                </div>
                <?php
                echo '<nav class="page-navigation"><ul class="pagination">';
                    if($paged > 1) echo '<li><a href="'.add_query_arg($post_type_page_arg, $paged - 1).'">Previous</a></li>';
                    if($paged < $max_page) echo '<li><a href="'.add_query_arg($post_type_page_arg, $paged + 1).'">Next</a></li>';
                echo '</ul></nav>';

                wp_reset_postdata();
            else : ?>
                <?php get_template_part( 'parts/content', 'missing' ); ?>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>
</div>

<?php
