<div id="sidebar1" class="sidebar main__sidebar">
    <nav class="sidebar-nav" aria-label="Sidebar Navigation">
        <?php
        wp_nav_menu([
            'container' => false,
            'container_class' => 'sidebar-nav',
            'menu_id' => 'menu-sidebar-menu',
            'menu_class' => 'sidebar-nav__list',       // Adding custom nav class
            'theme_location' => 'sidebar-nav',        			// Where it's located in the theme
            'walker' => new NHSM_Sidebar_Menu_Walker(),
        ]);
        ?>
    </nav>

    <?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

        <?php dynamic_sidebar( 'sidebar1' ); ?>

    <?php else : ?>

        <!-- This content shows up if there are no widgets defined in the backend. -->

    <?php endif; ?>
</div>