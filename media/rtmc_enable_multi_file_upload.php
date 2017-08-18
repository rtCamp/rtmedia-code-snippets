<?php
/**
 * Add this function to your current theme's functions.php.
 *
 * Enable multiple file upload in all device.
 *
 * @param  array $param Array of pl-uploader config.
 * @return array        Modified config.
 */
function rtmc_allow_multiple_fileupload( $param ) {
	// Enable multi-file selection.
	$param['multi_selection'] = true;
	return $param;
}
add_filter( 'rtmedia_modify_upload_params', 'rtmc_allow_multiple_fileupload' );
