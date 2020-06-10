<?php
// Register menus
register_nav_menus(
	array(
		'main-nav' => __( 'The Main Menu', 'jointswp' ),   // Main nav in header
		'aux-nav' => __( 'Auxiliary Menu', 'jointswp' ),   // Main nav in header
		'sidebar-nav' => __( 'Sidebar Menu', 'jointswp' ),   // Sidebar nav
		'footer-links' => __( 'Footer Links', 'jointswp' ) // Secondary nav in footer
	)
);

// The Top Menu
function joints_top_nav() {
	 wp_nav_menu(array(
        'container' => false, // Remove nav container
        'menu_class' => 'vertical medium-horizontal menu', // Adding custom nav class
        'items_wrap' => '<ul id="menu-main-nav" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s<li class="create-button menu-item" role="menuitem"><a href="'. site_url('/donate/').'">Donate</a></li></ul>',
        'theme_location' => 'main-nav', // Where it's located in the theme
        'depth' => 5, // Limit the depth of the nav
        'fallback_cb' => false, // Fallback function (see below)
        'walker' => new Topbar_Menu_Walker()
    ));
} 

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Topbar_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"menu\">\n";
    }
}

// The Top Menu
function joints_aux_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
		 		'menu_id' => 'menu-auxiliary-menu',
        'menu_class' => 'vertical medium-horizontal menu',       // Adding custom nav class
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'theme_location' => 'aux-nav'        			// Where it's located in the theme
    ));
} 

// The Sidebar Menu
function joints_sidebar_nav() {
	global $nhsm_sidebarnav;
	$nhsm_sidebarnav = new NHSM_Sidebar_Nav();
	add_filter('nav_menu_css_class', array($nhsm_sidebarnav, 'menu_css_class'), 10, 4);
	wp_nav_menu(array(
		'container' => false,                           // Remove nav container
		'menu_id' => 'menu-sidebar-menu',
		'menu_class' => 'vertical menu accordion-menu',       // Adding custom nav class
		'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true" role="navigation">%3$s</ul>',
		'theme_location' => 'sidebar-nav',        			// Where it's located in the theme
		'walker' => new Sidebar_Menu_Walker()
	));
	remove_filter('nav_menu_css_class', array($nhsm_sidebarnav, 'menu_css_class'), 10);
} 

class Sidebar_Menu_Walker extends Walker_Nav_Menu {
	function start_lvl(&$output, $depth = 0, $args = Array() ) {
		global $nhsm_sidebarnav;
		$is_active = $nhsm_sidebarnav->is_active;
		$c = $is_active ? ' is-active' : '';
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"menu vertical nested".$c."\">\n";
	}
}

class NHSM_Sidebar_Nav {
	public $queried_object;
	public $queried_ID = false;
	public $queried_posttype;
	public $queried_parent;
	public $ancestors;
	public $is_active = false;
	
	function __construct($current_page = false){
		//sets the queried object
		if(!$current_page) $post = get_queried_object();
		else $post = get_post($current_page);
		$this->queried_object = $post;
		if(is_a($post, 'WP_Post_Type')){
			$this->queried_posttype = $post->name;
		}
		elseif(is_a($post, 'WP_Post')) {
			$this->queried_ID = $post->ID;
			$this->queried_posttype = $post->post_type;
		}
		
		//set parent for ancestors
		$comparer = '';
		if(is_post_type_archive()) $comparer = $this->queried_posttype;

		$cpt = $tax = array();
		if( have_rows('parent_associations', 'option') ){
			while ( have_rows('parent_associations', 'option') ) {
				the_row();
				if(get_sub_field('archive_type') == 'post_type')
					$cpt[get_sub_field('archive_slug')] = get_sub_field('parent_object');
				elseif(get_sub_field('archive_type') == 'taxonomy'){
					$tax_term = explode(':', get_sub_field('archive_slug'));
					$tax[] = array(
						'tax' => $tax_term[0],
						'term' => isset($tax_term[1]) ? $tax_term[1]: false,
						'parent' => get_sub_field('parent_object')
					);
				}
				
				//if($this->queried_posttype == get_sub_field('post_type'))
				//	$this->queried_parent = get_sub_field('post_type_parent');
			}
		}
				

		//check if it's a single custom post
		if(is_singular(array_keys($cpt))){
			$this->queried_parent = $cpt[$this->queried_posttype];
		}
		//check if it's a single post with a specified term
		elseif(is_singular() && $foo = array_intersect(wp_get_post_terms($this->queried_ID, 'category', array('fields'=>'id=>slug') ), array_keys($tax))){
			$this->queried_parent = $tax[array_pop($foo)];
		}
		//check if it's a category archive
		else {
			
			foreach($tax as $t){
				if($t['tax'] !== 'event-category') continue;
				$term = !$t['term'] ? false : explode(',', str_replace(' ', '', $t['term']));
				if($t['tax'] == 'category') {
					if(is_category($term)) $this->queried_parent = $t['parent'];
				}
				elseif(is_tax($t['tax'], $term)) $this->queried_parent = $t['parent'];
			}
		}
		
		//if no matches to the current post type, default to the actual queried post's parent
		if(!$this->queried_parent){
			$this->queried_parent = get_post(wp_get_post_parent_id($this->queried_ID));
		}

		
		//sets the ancestors
		$this->ancestors = isset($this->queried_parent->ID) ? get_post_ancestors($this->queried_parent->ID) : array();
	}
	
	//filters the classes of the menu's <li>
	public function menu_css_class($classes, $item, $args, $depth){
		$this->is_active = false; //reset
		if(in_array('current_page_parent', $classes) || in_array('current_page_item', $classes) || in_array($item->object_id, $this->ancestors)) $this->is_active = true;
		return $classes;
	}
}

// The Off Canvas Menu
function joints_off_canvas_nav() {
	 wp_nav_menu(array(
        'container' => false,                           // Remove nav container
        'menu_class' => 'vertical menu accordion-menu',       // Adding custom nav class
     'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true" role="navigation">%3$s</ul>',
        'theme_location' => 'main-nav',        			// Where it's located in the theme
        'depth' => 5,                                   // Limit the depth of the nav
        'fallback_cb' => false,                         // Fallback function (see below)
        'walker' => new Off_Canvas_Menu_Walker()
    ));
}

class Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = Array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"vertical menu nested\">\n";
    }
}

// The Footer Menu
function joints_footer_links() {
    wp_nav_menu(array(
    	'container' => 'false',                         // Remove nav container
    	'menu' => __( 'Footer Links', 'jointswp' ),   	// Nav name
    	'menu_class' => 'menu',      					// Adding custom nav class
    	'theme_location' => 'footer-links',             // Where it's located in the theme
        'depth' => 0,                                   // Limit the depth of the nav
    	'fallback_cb' => ''  							// Fallback function
	));
} /* End Footer Menu */

// Header Fallback Menu
function joints_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => '',      						// Adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                           // Before each link
        'link_after' => ''                             // After each link
	) );
}

// Footer Fallback Menu
function joints_footer_links_fallback() {
	/* You can put a default here if you like */
}

// Add Foundation active class to menu
function required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 /*|| $item->current_item_ancestor == true*/ ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );