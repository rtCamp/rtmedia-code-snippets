<?php
/**
 * Add this function to theme's functions.php
 *
 * This function will show media on profile page according to particular user.
 *
 * Two actions are given:
 *  - bp_before_profile_field_content => For showing above prfile fileds.
 *  - bp_before_member_header => For showing above cover photo.
 *
 * Chose action according to your requirement and remove action which is not necessary to you.
 */
function rtmc_show_gallary() {

	// Show only on profile page.
	if ( ! function_exists( 'bp_displayed_user_id' ) && ( function_exists( 'bp_is_user' ) && ! bp_is_user() ) ) {
		return;
	}

	$user_id = bp_displayed_user_id();
	echo do_shortcode( '[rtmedia_gallery global="true" media_author="' . $user_id . '"]' );
}
add_action( 'bp_before_profile_field_content', 'rtmc_show_gallary' ); // For showing above profile fields.
add_action( 'bp_before_member_header', 'rtmc_show_gallary' ); // For showing above cover photo.
