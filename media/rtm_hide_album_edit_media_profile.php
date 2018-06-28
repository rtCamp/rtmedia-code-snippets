<?php
/*
 * This snippets is allows you to hide album selection in media edit page in profile for user who have other than administrator role.
 *
 * Add this code snippet to theme's functions.php file
 *
 */
if ( ! function_exists( 'rtm_rtmedia_edit_media_album_select' ) ) {
	/**
	 * Hide album selection in media edit page in profile for user who have other than administrator role.
	 *
	 * @param bool $is_album_edit_visible Default true.
	 * @return bool
	 */
	function rtm_rtmedia_edit_media_album_select( $is_album_edit_visible ) {
		$is_album_edit_visible = true;
		$user                  = wp_get_current_user();
		$role                  = (array) $user->roles;
		if ( ! in_array( 'administrator', $role, true ) ) {
			$is_album_edit_visible = ! $is_album_edit_visible;
		}
		return $is_album_edit_visible;
	}
	add_filter( 'rtmedia_edit_media_album_select', 'rtm_rtmedia_edit_media_album_select', 999, 1 );
}
