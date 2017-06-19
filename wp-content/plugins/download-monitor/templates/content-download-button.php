<?php
/**
 * Download button
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
?>
<p><a class="aligncenter download-button" href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow">
		<?php printf( __( 'Download &ldquo;%s&rdquo;', 'download-monitor' ), $dlm_download->get_the_title() ); ?>
		<small><?php $dlm_download->the_filename(); ?> &ndash; <?php printf( _n( 'Downloaded 1 time', 'Downloaded %d times', $dlm_download->get_the_download_count(), 'download-monitor' ), $dlm_download->get_the_download_count() ) ?> &ndash; <?php $dlm_download->the_filesize(); ?></small>
	</a></p>