<?php
/**
 * Add this function to theme's functions.php
 * Remove media type tabs
 */

add_filter( 'rtmedia_sub_nav_all', 'remove_media_menu', 5, 1 );
add_filter( 'rtmedia_sub_nav_albums', 'remove_media_menu', 5, 1 );
add_filter( 'rtmedia_sub_nav_photo', 'remove_media_menu', 5, 1 );
add_filter( 'rtmedia_sub_nav_video', 'remove_media_menu', 5, 1 );
add_filter( 'rtmedia_sub_nav_document', 'remove_media_menu', 5, 1 );
add_filter( 'rtmedia_sub_nav_user_likes', 'remove_media_menu', 5, 1 );

/**
 * Removes media type tab from menu.
 *
 * @param string $title text for menu.
 */
function remove_media_menu( $title ) {
	return '';
}
?>
