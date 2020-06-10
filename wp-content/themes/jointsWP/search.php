<?php get_header();
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
remove_filter('excerpt_more', 'joints_excerpt_more');?>
			
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row">
						<main id="main" class="medium-9 medium-push-3 columns" role="main">
						
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1 class="entry-title single-title">Search<?php if(get_search_query() != '') echo ' for "'.esc_attr(get_search_query()).'"'; ?></h1>
							</header>
						
							<?php if(get_search_query() != ''): ?>
								<p>Showing results for <em><?php echo esc_attr(get_search_query()); ?></em></p>
							<?php endif;
							get_search_form();
                            include( locate_template( 'parts/looper-tabs.php', false, false ) );
                            ?>
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
