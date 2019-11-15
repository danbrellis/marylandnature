<?php
/**
 * The template for displaying event widget content
 *
 * Override this template by copying it to yourtheme/content-widget-event.php
 *
 * @author 	Digital Factory
 * @package Events Maker/Templates
 * @since 	1.2.0
 */

if ( ! defined( 'ABSPATH' ) )
	exit; // exit if accessed directly

global $post;

remove_action( 'em_before_widget_event_title', 'em_display_widget_event_date', 10 );

// if in a shortcode, extract args
if ( $args && is_array( $args ) ) :
	extract( $args );

	// get events args and post object sent via em_get_template()
	$post = apply_filters( 'em_widget_event_post', $args[0] ); // event post object
	$args = apply_filters( 'em_widget_event_args', $args[1] ); // widget or function args
endif;

// extra event classes
$classes = apply_filters( 'em_widget_event_classes', array( 'hcalendar' ) );
?>

<li id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<?php
	/**
	 * em_before_widget_event hook
	 */
	do_action( 'em_before_widget_event' );
	?>

	<?php // event thumbnail
	if ( apply_filters( 'em_show_widget_event_thumbnail', $args['show_event_thumbnail'] ) == true && has_post_thumbnail() ) :
		?>

		<?php
		$image_title	= apply_filters( 'em_widget_event_thumbnail_title', get_the_title() );
		$image_link		= apply_filters( 'em_widget_event_thumbnail_link', get_permalink() );
		$size			= apply_filters( 'em_widget_event_thumbnail_size', $args['thumbnail_size'] );
		$attr			= apply_filters( 'em_widget_event_thumbnail_attr', array( 'title' => $image_title ) );
		$image			= get_the_post_thumbnail( $post->ID, $size, $attr );

		echo apply_filters( 'em_widget_event_thumbnail_html', sprintf( '<a href="%s" class="thumbnail event-thumbnail" title="%s">%s</a>', $image_link, $image_title, $image ), $post->ID );

	endif;
	?>

	<?php
	/**
	 * em_before_widget_event_title hook
	 * 
	 * @hooked em_display_widget_event_date - 10
	 */
	do_action( 'em_before_widget_event_title' );
	?>

	<?php // event title
	if ( apply_filters( 'em_show_widget_event_title', true ) ) :
		?>

        <h3 style="margin-bottom: 0;" class="h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

	<?php endif; ?>

	<?php
	/**
	 * em_after_widget_event_title hook
	 */
	do_action( 'em_after_widget_event_title' );
	?>

    <p><small>
        <?php echo nhsm_format_date_range(strtotime($post->event_occurrence_start_date), strtotime($post->event_occurrence_end_date), em_is_all_day($post->ID)); ?><br />
        <?php
        $loc_ids = wp_get_post_terms($post->ID, 'event-location', ['fields' => 'ids']);
        $locs_formatted = [];
        foreach($loc_ids as $loc_id){
            $loc = em_get_location($loc_id);
            if(!is_wp_error($loc)){
                $location_meta = $loc->location_meta;
                if(isset($location_meta['city']) && isset($location_meta['state'])){
                    $locs_formatted[] = $location_meta['city'] . ', ' . $location_meta['state'];
                }
                else {
                    $locs_formatted[] = $loc->name;
                }
            }
        }
        echo implode('<br />', $locs_formatted); ?>
    </small></p>

	<?php // event excerpt
	if ( apply_filters( 'em_show_widget_event_excerpt', $args['show_event_excerpt'] ) == true ) :
		?>

		<div class="event-excerpt">

			<?php the_excerpt(); ?>

		</div>

	<?php endif; ?>

	<?php

	/**
	 * em_after_widget_event hook
	 */
	do_action( 'em_after_widget_event' );
	?>

</li>