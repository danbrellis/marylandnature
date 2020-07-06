<?php get_header();
//@todo consolidate event occurrences and split out post types
global $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$post_types = [
    'event' => [
        "label" => "Events",
        "args" => [
            'event_show_occurrences' => true
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
remove_filter('excerpt_more', 'nhsm_excerpt_more');?>

<div class="container main-container">
    <main class="main main--twoColumns" id="main">
        <section id="post-<?php the_ID(); ?>" <?php post_class('page article main__content'); ?>>
            <header class="page__header article__header">
                <h1 class="page__title article__title">Search<?php if(get_search_query() != '') echo ' for "'.esc_attr(get_search_query()).'"'; ?></h1>
            </header>

            <?php if(get_search_query() !== ''): ?>
                <p>Showing <?php echo $paged; ?> of <?php echo $wp_query->max_num_pages; ?> page results for <em><?php echo esc_attr(get_search_query()); ?></em></p>
            <?php endif;
            get_search_form();

            if ( have_posts() && get_search_query() !== '') : ?>
                <div>
                    <?php while(have_posts()): the_post(); ?>
                        <?php get_template_part( 'parts/archive', get_post_type() ); ?>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <?php get_template_part( 'parts/content', 'missing' ); ?>
            <?php endif; ?>
            <footer class="article-footer">
                <nav class="prev-next"><?php posts_nav_link(); ?></nav>
            </footer>
        </section>
        <?php get_sidebar(); ?>
    </main>
</div>
<?php get_footer(); ?>