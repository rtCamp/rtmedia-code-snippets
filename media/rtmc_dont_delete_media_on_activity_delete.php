<?php
/**
 * This function allows you to delete a media activity
 * without deleting the media from the media library.
 *
 * @param number $id ID of the media.
 * @since 09/06/2017
 */
function rtmc_dont_delete_from_media( $id ) {
	if ( bp_is_activity_component() ) {
		die();
	}
}
add_action( 'rtmedia_before_delete_media', 'rtmc_dont_delete_from_media' );
