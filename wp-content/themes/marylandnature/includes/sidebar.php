<?php
// SIDEBARS AND WIDGETIZED AREAS
function nhsm_register_sidebars() {
    register_sidebar(array(
        'id' => 'sidebar1',
        'name' => 'Sidebar 1',
        'description' => 'The first (primary) sidebar.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

    /*
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call
    your new sidebar just use the following code:

    Just change the name to whatever your new
    sidebar's id is, for example:

    register_sidebar(array(
        'id' => 'sidebar2',
        'name' => __('Sidebar 2', 'jointswp'),
        'description' => __('The second (secondary) sidebar.', 'jointswp'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widgettitle">',
        'after_title' => '</h4>',
    ));

    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php

    */
} // don't remove this bracket!
add_action('widgets_init', 'nhsm_register_sidebars');