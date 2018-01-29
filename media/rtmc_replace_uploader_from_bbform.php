<?php
/**
 * Add the following functions to theme's functions.php
 *
 * First add foloowing custom CSS to rtMedia->Settings->Custom CSS
 *
 * .bbp-topic-form .rtmedia-upload-not-allowed {
 *     display: none;
 * }
 *
 * Display uploader above forum form.
 */
function rtmc_set_uploader_above_forum_form() {

	if ( ! class_exists( 'RTMediaBBPressMedia' ) || ! class_exists( 'bbPress' ) ) {
		return;
	}

	// Set uploader above forum form.
	add_action( 'bbp_theme_before_topic_form', array( 'RTMediaBBPressMedia', 'add_uploader' ), 99 );

	// Remove uploader from it's original position.
	add_action( 'bbp_theme_before_topic_form_notices', 'rtmc_remove_filter', 99 );
}

add_action( 'init', 'rtmc_set_uploader_above_forum_form', 1 );

/**
 * Remove uploader from it's original place for forum form.
 */
function rtmc_remove_filter() {

	// Remove uploader.
	add_filter( 'rtmedia_allow_uploader_view', '__return_false' );
}