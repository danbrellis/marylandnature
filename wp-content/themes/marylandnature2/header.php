<!doctype html>

<html class="no-js"  <?php language_attributes(); ?>>

<head>
    <?php if(ENV === 'production' && $key = get_field('google_analytics_tracking_key', 'option')): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $key; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?php echo $key; ?>');
        </script>
    <?php endif; ?>
    <meta charset="utf-8">

    <!-- Force IE to use the latest rendering engine available -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Mobile Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- If Site Icon isn't set in customizer -->
    <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
        <!-- Icons & Favicons -->
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/images/apple-icon-touch.png" rel="apple-touch-icon" />
        <!--[if IE]>
				<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
			<![endif]-->
        <meta name="msapplication-TileColor" content="#f01d4f">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/images/win8-tile-icon.png">
        <meta name="theme-color" content="#121212">
    <?php } ?>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>

    <?php
    //Adds some extra meta for fb and twitter.
    $post_id = get_queried_object_id();
    $post_thumbnail_id = get_post_thumbnail_id($post_id);
    $post_thumbnail_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
    $fb_post_thumbnail = wp_get_attachment_image_src($post_thumbnail_id, 'nhsm_headshot');
    $share_excerpt = is_singular() ? get_the_excerpt() : get_the_archive_description();
    if(get_post_type() === 'event'){
        $dates = get_event_date_range($post_id);
        if($dates){
            $allday = get_post_meta($post_id, '_event_all_day', true);
            $range = nhsm_format_date_range(strtotime($dates['start']), strtotime($dates['end']), boolval($allday));
            $share_excerpt = sprintf('Join us %s. %s', $range, $share_excerpt);
        }
    }
    ?>

    <meta name="description" content="<?php echo esc_attr($share_excerpt); ?>" />

    <meta property="og:url"                content="<?php echo home_url() . $_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:type"               content="<?php echo is_front_page() ? 'website' : 'article'; ?>" />
    <meta property="og:title"              content="<?php echo wp_get_document_title(); ?>" />
    <meta property="og:description"        content="<?php echo esc_attr($share_excerpt); ?>" />
    <meta property="og:image"              content="<?php echo esc_attr($fb_post_thumbnail[0]); ?>" />
    <meta property="og:image:width"        content="<?php echo esc_attr($fb_post_thumbnail[1]); ?>" />
    <meta property="og:image:height"       content="<?php echo esc_attr($fb_post_thumbnail[2]); ?>" />
    <meta property="og:image:alt"          content="<?php echo esc_attr($post_thumbnail_alt); ?>" />
    <meta property="fb:app_id"             content="2882465385099613" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@NHSM_Naturalist">
    <meta name="twitter:title" content="<?php echo wp_get_document_title(); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($share_excerpt); ?>">
    <meta name="twitter:image" content="<?php echo esc_attr(get_the_post_thumbnail_url(null, 'nhsm_hbanner')); ?>">
</head>

<body <?php body_class(); ?>>

<header class="site-header__wrap" role="banner">
    <a class="skip-link" href="#main">Skip to content</a>
    <div class="site-header container">
        <div class="site-header__brand">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__brand">
                <img
                    src="<?php echo nhsm_get_asset_directory_uri(); ?>/images/nhsm-logo.png"
                    srcset="
                        <?php echo nhsm_get_asset_directory_uri(); ?>/images/nhsm-logo.png 259w,
                        <?php echo nhsm_get_asset_directory_uri(); ?>/images/nhsm-logo@2x.png 516w"
                    alt="<?php bloginfo('name'); ?>" />
            </a>
            <span class="site-header__tagline"><?php bloginfo('description'); ?></span>
        </div>
        <nav class="aux-nav" aria-label="Auxiliary Navigation">
            <?php
            wp_nav_menu([
                'menu' => 'aux-nav',
                'container' => false, // Remove <nav> container
                'menu_class' => 'aux-nav__list', // Adding custom  class
                'theme_location' => 'aux-nav', // Where it's located in the theme
                'fallback_cb' => false
            ]);
            ?>
        </nav>
        <nav class="main-nav" aria-label="Main Navigation">
            <?php
            wp_nav_menu([
                'container' => false, // Remove nav container
                'menu_class' => 'main-nav__list', // Adding custom nav class
                'theme_location' => 'main-nav',
                'fallback_cb' => false
            ]);
            ?>
        </nav>
        <a href="<?php echo site_url('/donate/'); ?>" class="site-header__donate button button--iconFirst button--primary"><i class="fas fa-heart"></i> Donate</a>
    </div>
</header> <!-- end .header -->

<div class="container main-container">