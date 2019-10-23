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
			
					<div class="row" data-equalizer="brellis" data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch="brellis">
						
							<header class="article-header">
								<?php nhsm_addthis(); ?>
								<h1 class="entry-title single-title">Search<?php if(get_search_query() != '') echo ' for "'.esc_attr(get_search_query()).'"'; ?></h1>
							</header>
						
							<?php if(get_search_query() != ''): ?>
								<p>Showing results for <em><?php echo esc_attr(get_search_query()); ?></em></p>
							<?php endif;
							get_search_form(); ?>


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
                                            <?php $s = isset($_GET["s"]) ? $_GET["s"] : "";
                                            $args = [
                                                's' => $s,
                                                'post_type' => $post_type,
                                            ];
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
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
