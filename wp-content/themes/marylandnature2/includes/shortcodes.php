<?php

function nhsm_scrolling_text( $atts, $content ) {
	$words = array_map('trim', explode(',', $content));
	$retval = '';
	if(!empty($words)){
		$retval = '<ul class="nhsm_scrolling_words data-animate">';
		foreach($words as $w) $retval .= '<li class="data-animate">' . $w . '</li>';
		$retval .= '</ul>';
	}
	return $retval;

}
add_shortcode( 'scrolling_text', 'nhsm_scrolling_text' );

function nhsm_resource_search($atts, $placeholder){
	$form = sprintf('<form><input type="text" placeholder="%s" /><button type="submit"><i class="fi-play"></i></button></form>', $placeholder);
	return $form;
}
add_shortcode( 'resource-search', 'nhsm_resource_search' );

function nhsm_icon($atts){
	$a = shortcode_atts( array(
		'name' => '',
		'bg' => 'true',
		'library' => 'fi' //fa = font-awesome, fi = foundation icons
	), $atts );
	$classes = array('nhsm-icon');
	
	if($a['bg'] == 'true') $classes[] = 'circle';
	$classes[] = $a['name'];
	if($a['library'] == 'fa') $classes[] = 'fa';
	
	$icon = '<i class="'.implode($classes, ' ') . '" aria-hidden="true"></i>';
	
	return $icon;
}
add_shortcode( 'icon', 'nhsm_icon' );

function display_events_calendar($atts){
	$a = shortcode_atts( array(
		'date_start' => false,
		'date_end' => false,
		'cat_ids' => 'all',
		'topics' => 'all',
		'show_legend' => false
	), $atts );
	
	if($a['cat_ids'] !== 'all' && !empty($a['cat_ids'])){
		$cat_ids = array_map('trim', explode(',', $a['cat_ids']));
	}
	else $cat_ids = array();
	
	if($a['topics'] !== 'all' && !empty($a['topics'])){
		$topics = array_map('trim', explode(',', $a['topics']));
	}
	else $topics = array();

	wp_enqueue_script('moment');
	wp_enqueue_script('fullcalendar');
	$jsdata = array();
	$nonce = wp_create_nonce( "nhsm-fc-events" );
	$jsdata['endpoint'] = add_query_arg(array('action' => 'get_events', 'nonce' => $nonce), admin_url( 'admin-ajax.php' ));
	
	$jsdata['start'] = $a['date_start'];
	$jsdata['end'] = $a['date_end'];
	$jsdata['cat_ids'] = $cat_ids;
	$jsdata['topics'] = $topics;
	
	wp_localize_script('fullcalendar', 'fc', $jsdata);
	$cal_html = '<div id="calendar"></div>';
	return $a['show_legend'] ? '<div class="row">
		<div class="medium-10 columns">'.$cal_html.'</div>
		<div class="medium-2 columns">
			<div id="legend"><h3>Legend</h3></div>
		</div>
		</div>' : $cal_html;
}
add_shortcode( 'events_calendar', 'display_events_calendar' );

function nhsm_wa_iframe($atts){
    $a = shortcode_atts( array(
        'src' => false,
        'width' => '100%',
        'class' => ''
    ), $atts );
    $a['class'] = $a['class'] . ' wildapricotframe';
    ob_start(); ?>
    <iframe
        class="<?php echo $a['class']; ?>"
        src="<?php echo $a['src']; ?>"
        width="<?php echo $a['width']; ?>"
        height="400"
        frameborder="no"
        scrolling="yes"
        onload='tryToEnableWACookies("https://marylandnature.wildapricot.org");'></iframe>
    <?php
    $retval = ob_get_clean();
    wp_enqueue_script('wa-enable-cookies', 'https://marylandnature.wildapricot.org/Common/EnableCookies.js');
    return $retval;
}
add_shortcode('wildapricot_iframe', 'nhsm_wa_iframe');