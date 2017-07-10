<?php
/**
 * Event gallery
 * 
 * Override this template by copying it to yourtheme/single-event/gallery.php
 *
 * @author 	Dan Brellis
 * @package MarylandNature
 * @since 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) )
	exit; // exit if accessed directly

global $post;

// display options
$display_options = get_post_meta( $post->ID, '_event_display_options', true );

// gallery enabled?
if ( ! isset( $display_options['display_gallery'] ) || ! $display_options['display_gallery'] )
	return;

$columns = apply_filters( 'em_event_gallery_columns', 4 );
$count = 0;

// event gallery
if ( ! post_password_required() && metadata_exists( 'post', $post->ID, '_event_gallery' ) ) :

	$event_gallery = get_post_meta( $post->ID, '_event_gallery', true );

	if ( ! empty( $event_gallery ) ): ?>
		<div class="orbit" role="region" aria-label="Photo gallery for <?php the_title(); ?>" data-orbit>
			<div class="orbit-wrapper">
				<div class="orbit-controls">
					<button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
					<button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
				</div>
				<ul class="orbit-container">


					<?php $images = array_filter( explode( ',', $event_gallery ) );
					$nav = '';

					foreach ( $images as $image_id ) :

						$image_title	= esc_attr( get_the_title( $image_id ) );
						$image_link		= wp_get_attachment_url( $image_id );
						$attr			= array( 'title' => $image_title, 'class' => 'orbit-image' );
						$image			= wp_get_attachment_image( $image_id, 'nhsm_medium4x3', false, $attr );

						$cred = nhsm_format_image_credit_line(false, $image_id);
						$excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $image_id));
						$caption = $excerpt ? wptexturize($excerpt) . $cred : $cred;
					
						$active = $count == 0 ? ' class="is-active"' : '';
						$current = $count == 0 ? '<span class="show-for-sr">Current Slide</span>' : '';
						$nav .= '<button'.$active.' data-slide="'.$count.'"><span class="show-for-sr">Slide details for '.$image_title.'.</span>'.$current.'</button>';
						?>
						<li class="<?php echo $count == 0 ? "is-active " : ""; ?>orbit-slide">
							<figure class="orbit-figure">
								<a href="<?php echo $image_link; ?>" target="_blank" title="<?php echo $image_title; ?>"><?php echo $image; ?></a>
								<figcaption class="orbit-caption"><?php echo $caption; ?></figcaption>
							</figure>
						</li>

					<?php $count ++; endforeach; ?>
				</ul>
			</div>
			<nav class="orbit-bullets"><?php echo $nav; ?></nav>
		</div>

	<?php endif;

endif;