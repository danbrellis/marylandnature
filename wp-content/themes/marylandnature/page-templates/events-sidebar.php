<?php /* Template Name: Right Events Sidebar */ ?>
<?php get_header();
$events_args = [
    'categories' => [get_post_field( 'post_name', get_post() )],
    'show_event_thumbnail' => false,
    'show_event_excerpt' => false,
    'show_featured' => false,
    'show_past_events' => false,
    'no_events_message' => 'Apologies, but no upcoming ' . get_the_title() . ' events are scheduled.'
];
$sidebar = '<h2 class="stringbean">Events</h2>' . em_display_events( $events_args ); ?>
    <div class="container main-container">
        <main class="main main--twoColumns" id="main">
            <section>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php include( locate_template( 'parts/single-page.php', false, false ) );  ?>
                <?php endwhile; endif; ?>
            </section>
            <?php get_sidebar(); ?>
        </main>
    </div>
<?php get_footer(); ?>