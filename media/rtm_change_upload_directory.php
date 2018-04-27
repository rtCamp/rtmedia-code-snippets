<?php
/**
 * This snippet allows you to change upload directory to /wp-content/uploads/rtMedia/users/userid/postid/filename.
 * The media must be uploaded through rtMedia uploader (calling `rtmedia_filter_upload_dir` filter).
 * This code will only work if the media is being uploaded from the post, i.e. if `get_the_ID()` returns the valid post ID, it won't work if you upload from the profile.
 *
 * All your previously uploaded media files won't be affected by this code, but new media files will be uploaded to specified directory.
 */

// Check whether function exists or not.
if ( ! function_exists( 'rtmedia_set_upload_path_to_post_id' ) ) {

	/**
	 * This filter is called when a media is being uploaded through rtMedia upload mechanism.
	 * This filter is used to change the upload directory.
	 */
	add_filter( 'rtmedia_filter_upload_dir', 'rtmedia_set_upload_path_to_post_id', 10, 1 );

	/**
	 * This function will alter the upload url, path and subdir parameters
	 *
	 * @param $param array : upload parameters, ( path, url, ... )
	 *
	 * @return array
	 */
	function rtmedia_set_upload_path_to_post_id( $param ) {

		// Return as it is if $param is not array
		if ( ! is_array( $param ) ) {
			return $param;
		}

		// Get current post ID
		$post_id = get_the_ID();

		// Change parameters only if the URL is from rtMedia and `get_the_ID()` returns valid post ID.
		if ( ! empty( $post_id ) && stripos( $param['url'], 'rtmedia' ) !== false ) {
			$param['url']    .= '/' . $post_id;
			$param['path']   .= '/' . $post_id;
			$param['subdir'] .= '/' . $post_id;
		}

		return $param;
	}
}
