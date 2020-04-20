    </div><!-- //.main-container.container -->
    <?php if(class_exists('wp_debug')) wp_debug::debug_info(); ?>
    <footer class="site-footer__wrap" role="contentinfo">
        <div class="container site-footer">
            <div class="companyCard">
                <a href="<?php echo site_url(); ?>" title="Home" class="companyCard__logo"><?php echo wp_get_attachment_image( get_field('footer_logo', 'option'), 'thumbnail', "", array( "class" => "img-responsive" ) ); ?></a>
                <div class="companyCard__info">
                    <span class="companyCard__title"><?php bloginfo('name'); ?></span>
                    <div class="companyCard__address">
                        <?php echo nl2br(get_field('org_info_block', 'option')); ?>
                    </div>
                </div>
            </div>

            <div class="site-footer__socialIcons">
                <?php if( have_rows('social_icons', 'option') ): ?>
                    <ul class="flex-list site-footer__socialIconsList">
                        <?php while ( have_rows('social_icons', 'option') ) : the_row();
                            $fi = get_sub_field('social_media_icon');
                            $img_id = get_sub_field('social_website_custom_image');
                            $icon = '';
                            if($fi) $icon = '<i class="'.$fi.'"></i><span class="sr-only">Visit us on '.get_sub_field('social_website_name').'</span>';
                            elseif($img_id) {
                                $icon = wp_get_attachment_image( $img_id, false, "" );
                            }
                            else $icon = '<i class="fas fa-globe"></i>'
                            ?>
                            <li class="site-footer__socialIconsItem flex-list__item">
                                <a href="<?php the_sub_field('social_website_url'); ?>" title="<?php the_sub_field('social_website_name'); ?>" class="site-footer__socialIconsLink"><?php echo $icon; ?></a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <nav aria-label="Footer Navigation" class="site-footer__navigation">
                <?php
                add_filter('nav_menu_css_class', 'nhsm_nav_menu_css_class');
                wp_nav_menu(array(
                    'container' => 'false',                         // Remove nav container
                    'menu' => 'Footer Links',   	// Nav name
                    'menu_class' => 'menu flex-list',      					// Adding custom nav class
                    'theme_location' => 'footer-links',             // Where it's located in the theme
                    'depth' => 0,                                   // Limit the depth of the nav
                    'fallback_cb' => ''  							// Fallback function
                ));
                remove_filter('nav_menu_css_class', 'nhsm_nav_menu_css_class');
                ?>
                <?php if($login = get_field('member_login_url', 'option')): ?>
                    <a href="<?php echo $login; ?>" id="member-login">Member Login</a>
                <?php endif; ?>
            </nav>
            <p class="site-footer__siteByLine">Website designed &amp; developed by Dan Brellis for the Natural History Society of Maryland &copy; <?php echo date('Y'); ?></p>
        </div> <!-- end .site-footer.container -->
    </footer> <!-- end .site-footer__wrap -->
    <?php wp_footer(); ?>
</body>
