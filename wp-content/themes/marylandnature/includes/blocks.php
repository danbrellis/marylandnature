<?php

function nhsm_register_block() {
    // Register our block script with WordPress
    wp_register_script(
        'nhsm-blocks',
        get_stylesheet_directory_uri() . '/blocks/dist/blocks.build.js',
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'],
        filemtime(get_stylesheet_directory() . '/blocks/dist/blocks.build.js')
    );

    // Register our block's base CSS
    wp_register_style(
        'nhsm-block-styles',
        get_stylesheet_directory_uri() . '/blocks/dist/blocks.style.build.css',
        [],
        filemtime( get_stylesheet_directory() . '/blocks/dist/blocks.style.build.css' )
    );

    // Register our block's editor-specific CSS
    if( is_admin() ) :
        wp_register_style(
            'nhsm-block-editor-styles',
            get_stylesheet_directory_uri() . '/blocks/dist/blocks.editor.build.css',
            ['wp-edit-blocks'],
            filemtime( get_stylesheet_directory() . '/blocks/dist/blocks.editor.build.css' )
        );
    endif;

    // Register blocks
    register_block_type('nhsm-common/contact', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
    ]);
    register_block_type('nhsm-common/page-card', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_common_page_card_render',
    ]);
    register_block_type('nhsm-featurettes/newsletter-signup', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_featurette_newsletter_signup_render',
    ]);
    register_block_type('nhsm-featurettes/collections', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_featurette_collections_render'
    ]);
    register_block_type('nhsm-widgets/collections', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_widgets_collections_render',
        'attributes' => [
            'count' => [
                'default' => 6,
                'type' => 'string'
            ],
            'format' => [
                'default' => 'card',
                'type' => 'string'
            ],
            'order' => [
                'default' => 'title',
                'type' => 'string'
            ],
            'wrapGrid' => [
                'default' => false,
                'type' => 'boolean'
            ]
        ]
    ]);
    register_block_type('nhsm-widgets/team-list', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'render_callback' => 'nhsm_widgets_team_list_render',
        'attributes' => [
            'role' => [
                'type' => 'string'
            ]
        ]
    ]);

    //@todo remove featured image from tempaltes and create block templates for post types
    /*
    $post_type_object = get_post_type_object( 'page' );
    $post_type_object->template = array(
        array( 'core/image' ),
        array( 'core/heading' )
    );
    */
}
add_action( 'init', 'nhsm_register_block' );

/** Render Functions **/
function nhsm_common_page_card_render($attributes, $content){
    $photo_credit = nhsm_format_image_credit_line( false, $attributes['imageID'] );
    if ( $photo_credit ) {
        if ( strpos( $content, '<figcaption>' ) !== false ) {
            $content = str_replace( '<figcaption>', '<figcaption class="figure__caption">'.$photo_credit, $content );
        } else {
            $content = str_replace( '</figure>', '<figcaption class="figure__caption">'. $photo_credit .'</figcaption></figure>', $content );
        }
    }

    return $content;
}
function nhsm_featurette_newsletter_signup_render($attributes, $content){
    $photo_credit = nhsm_format_image_credit_line( false, $attributes['imageID'] );
    if ( $photo_credit ) {
        if ( strpos( $content, '<figcaption>' ) !== false ) {
            $content = str_replace( '<figcaption>', '<figcaption class="figure__caption">'.esc_html( $photo_credit ), $content );
        } else {
            $content = str_replace( '</figure>', '<figcaption class="figure__caption">'.esc_html( $photo_credit ).'</figcaption></figure>', $content );
        }
    }

    return $content;
}

function nhsm_featurette_collections_render($attributes, $content){
    $collections = nhsm_widgets_collections_render(['count' => 3, 'format' => 'stamp', 'wrapGrid' => false]);
    $content = str_replace('<div id="collections_list"></div>', $collections, $content);

    return $content;
}

function nhsm_widgets_collections_render($attributes){
    $collections_args = [
        'post_type' => 'nhsm_collections',
        'post_status' => 'publish',
        'posts_per_page' => $attributes['count'],
        'orderby' => isset($attributes['order']) ? $attributes['order'] : 'title'
    ];
    $collections = new WP_Query($collections_args);

    ob_start();

    if($attributes['wrapGrid'] === true): ?>
        <div class="autoFitGrid" style="--minWidth:280px">
    <?php endif; ?>

    <?php if($collections->have_posts()): ?>
        <?php while($collections->have_posts()): $collections->the_post(); ?>
            <?php get_template_part( 'parts/' . $attributes['format'], get_post_type() ); ?>
        <?php endwhile; wp_reset_postdata(); ?>
    <?php endif;

    if($attributes['wrapGrid'] === true): ?>
        </div>
    <?php endif;

    $content = ob_get_clean();

    return $content;
}

function nhsm_widgets_team_list_render($attributes){
    //Query people based on ta provided in block
    $team_args = [
        'post_type' => 'nhsm_team',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'nhsm_role',
                'field'    => 'slug',
                'terms'    => $attributes['role'],
            ),
        ),
    ];
    $team = new WP_Query($team_args);

    ob_start();
    ?>

    <?php if($team->have_posts()): ?>
        <?php while($team->have_posts()): $team->the_post(); ?>
            <?php get_template_part( 'parts/card', get_post_type() ); ?>
        <?php endwhile; wp_reset_postdata(); ?>
    <?php endif;

    $content = ob_get_clean();

    return '<section class="autoFitGrid" style="--minWidth: 210px">' . $content . '</section>';
}

/** Misc **/
function nhsm_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        [
            [
                'slug' => 'nhsm-featurettes',
                'title' => 'NHSM Featurettes'
            ],
        ]
    );
}
add_filter( 'block_categories', 'nhsm_block_categories', 10, 2);

function nhsm_theme_supports(){
    add_theme_support( 'editor-color-palette', [
        [
            'name' => 'grass green (primary)',
            'slug' => 'green-primary',
            'color' => '#367202',
        ],
        [
            'name' => 'lime green (secondary)',
            'slug' => 'green-secondary',
            'color' => '#abd037',
        ],
        [
            'name' => 'forest green',
            'slug' => 'green-dark',
            'color' => '#121a18',
        ],
        [
            'name' => 'white',
            'slug' => 'white',
            'color' => '#ffffff',
        ],
        [
            'name' => 'very light gray',
            'slug' => 'very-light-gray',
            'color' => '#e8e8e8',
        ],
        [
            'name' => 'light gray',
            'slug' => 'light-gray',
            'color' => '#d9d9d9',
        ],
        [
            'name' => 'dark gray (reading)',
            'slug' => 'dark-gray-reading',
            'color' => '#444',
        ],
        [
            'name' => 'black',
            'slug' => 'black',
            'color' => '#000000',
        ],

    ]);
}
add_action('after_setup_theme', 'nhsm_theme_supports');

function nhsm_image_size_names_choose($sizes) {
    $sizes['nhsm_hbanner'] = 'Heading Banner';
    $sizes['nhsm_headshot'] = 'Headshot';
    $sizes['nhsm_medium4x3'] = '4x3 Card';
    return $sizes;
}
add_filter('image_size_names_choose', 'nhsm_image_size_names_choose');
