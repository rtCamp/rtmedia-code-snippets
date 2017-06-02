<?php
/**
 * Paste this function in the `function.php` file to disable creation
 * of activity while uploading media from media page.
 *
 * @param array $args Array of arguments.
 */
function rtmc_dont_create_activity_on_media_upload( $args ) {
	$referer = filter_input( INPUT_POST, '_wp_http_referer', FILTER_SANITIZE_STRING );
	$url_components = explode( '/', trim( $referer, '/' ) );
	if ( 'media' === array_slice( $url_components, 2 )[0] ) {
		die();
	}
}
add_action( 'bp_activity_before_save', 'rtmc_dont_create_activity_on_media_upload' );
