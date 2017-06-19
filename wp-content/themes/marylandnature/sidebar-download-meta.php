<?php
/**
 * Template file for dlm_download post_type meta information on right sidebar
 */
global $post;
$dlm_download = new DLM_Download( get_the_ID() );

//var_dump($dlm_download);
$versions = $dlm_download->get_file_versions();
$previous_versions = '';
 
?>

<div id="sidebar_download-meta" class="sidebar medium-4 columns end" role="complementary">
	<h4>Resource Details</h4>
	<hr />
	<a href="<?php $dlm_download->the_download_link(); ?>" rel="nofollow" target="_blank" class="button">Open Resource<i class="fi-page-export rightset larger"></i></a>
    
	<?php 
	// Get previous versions
	if ( sizeof( $versions ) > 1 ) {
		array_shift( $versions );

		$previous_versions = ' <a href="#" data-dropdown="previous-versions" aria-controls="previous-versions" aria-expanded="false" class="dropdown imgWrapRight" title="' . __( 'Previous versions', 'chesnet' ) . '"><span class="dashicons dashicons-backup"></span> '.__('Versions', 'chesnet') .'</a><ul id="previous-versions" data-dropdown-content class="f-dropdown" aria-hidden="true" tabindex="-1">';

		foreach ( $versions as $version ) {
			$dlm_download->set_version( $version->id );
			$version_post = get_post( $version->id );

			$previous_versions .= '<li><a href="' . $dlm_download->get_the_download_link() . '" target="_blank">' . sprintf( __( 'Version %s', 'chesnet' ), $dlm_download->get_the_version_number() ) . ' (' . date_i18n( get_option( 'date_format' ), strtotime( $version_post->post_date ) ) . ')</a></li>';
		}

		$dlm_download->set_version();

		$previous_versions .= '</ul>';
	}

	//Download Meta
	$download_meta = array(
		'filename' => array(
			'name'     => __( 'File Name', 'chesnet' ),
			'value'    => $dlm_download->get_the_filename(),
			'title'	   => $dlm_download->get_the_filename()
		),
		'version' => array(
			'name'     => __( 'Version', 'chesnet' ),
			'value'    => $dlm_download->get_the_version_number() . $previous_versions
		),
		'filetype' => array(
			'name'     => __( 'Type', 'chesnet' ),
			'value'    => '<span class="filetype">' . $dlm_download->get_the_filetype() . '</span>'
		),
		'filesize' => array(
			'name'     => __( 'Size', 'chesnet' ),
			'value'    => $dlm_download->get_the_filesize()
		),
		'date' => array(
			'name'     => __( 'Date added', 'chesnet' ),
			'value'    => date_i18n( get_option( 'date_format' ), strtotime( $dlm_download->post->post_date ) )
		),
		'downloaded' => array(
			'name'     => __( 'Downloaded', 'chesnet' ),
			'value'    => sprintf( _n( '1 time', '%d times', $dlm_download->get_the_download_count(), 'chesnet' ), $dlm_download->get_the_download_count() )
		),
		'labels' => array(
			'name'     => __( 'Categories', 'chesnet' ),
			'value'    => get_the_term_list( $dlm_download->id, 'dlm_download_category', '', ', ', '' )
		),
	);

	$download_meta = apply_filters( 'dlm_page_addon_download_meta', $download_meta );
	echo '<div class="p-flex-table meta-p-flex-table">';
	foreach ( $download_meta as $meta ) :
		if ( empty( $meta['value'] ) )
			continue;
		?>
		<div class="ft-tr">
			<div class="ft-td-a"><?php echo $meta['name']; ?></div>
			<div class="ft-td-b"<?php echo isset($meta['title']) ? ' title="'.$meta['title'].'"' : ''; ?>><?php echo $meta['value']; ?></div>
		</div>
	<?php endforeach;
	echo '</div>';
	?>

</div>
	
	