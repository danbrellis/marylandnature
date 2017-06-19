<?php
/**
 * @package wp_debug
 * @version 1.6
 */
/*
Plugin Name: WP Debug
Description: Provides some helpful debugging and usage info by calling wp_debug::debug_info()
Author: Dan Brellis
Version: 1.0
*/

class wp_debug {
  public static $time_start;
	public static $time_end;
	public static $template;
	
	public static function init(){
		add_action( 'template_include', array('wp_debug', 'template_include') );
		add_action( 'registered_taxonomy', array('wp_debug', 'start_time') );
	}
	
	public static function start_time(){
		wp_debug::$time_start = microtime(true);
	}
	
	//Sets a global variables for the template being used
	public static function template_include($template) {
		wp_debug::$template = $template;
		return $template;
	}
	
	public static function get_current_template() {
		if( !isset(wp_debug::$template) || empty(wp_debug::$template) )
			return __('no clue', 'chesnet');
			
		return wp_debug::$template;
	}
	
	public static function math_time(){
		return wp_debug::$time_end - wp_debug::$time_start;
	}
	
	public static function debug_info(){
		wp_debug::$time_end = microtime(true);
		if( is_super_admin() && WP_DEBUG ) : ?>
      <div class="container"><div class="row"><div class="col-md-12"><div class="panel" style="margin-top:20px">
        <h3><?php _e('DEBUG INFO', 'chesnet'); ?></h3>
        <p>
          <strong><?php _e('Screen Size:', 'chesnet'); ?></strong>&nbsp;
          <span class="show-for-small-only"><?php _e('Small', 'chesnet'); ?></span>
          <span class="show-for-medium-only"><?php _e('Medium', 'chesnet'); ?></span>
          <span class="show-for-large-only"><?php _e('Large', 'chesnet'); ?></span>
          <span class="show-for-xlarge-only"><?php _e('Extra Large', 'chesnet'); ?></span>
          <span class="show-for-xxlarge-only"><?php _e('XX Large', 'chesnet'); ?></span>
        </p>
        <?php printf( '<p><strong>%s</strong> %s</p>', __('Current template:', 'chesnet'), wp_debug::get_current_template() ); ?>
        <?php printf( '<p><strong>%s</strong> %s</p>', __('Script Execution:', 'chesnet'), wp_debug::math_time() ); ?>
      </div></div></div></div>
    <?php endif;
	}
	
}

wp_debug::init();

function wp_debug_printtofile($var, $append = false){
	$file = get_home_path() . "wp_debug.txt";

	if($append) file_put_contents($file, print_r($var, true), FILE_APPEND);
	else file_put_contents($file, print_r($var, true));
}

?>