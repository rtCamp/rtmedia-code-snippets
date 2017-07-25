<?php
/**
 * Plugin Name: RTM_Restrict_Custom_Extension
 * Description: Restrict allowed extension. Add this file to "wp-content/mu-plugins" folder.
 * Version:1.0
 * Author: rtCamp
 * Author URI: https://rtcamp.com
 * License: GPL2
 */

class RTM_Restrict_Custom_Extension {

	function __construct() {
		add_filter( 'rtmedia_allowed_types', array( $this, 'rtmc_restrict_allowed_types' ), 999 );
	}

	/**
	 * Restrict media type for upload.
	 *
	 * @param  array $allowed_types All allowed type.
	 * @return array                Filtered allowed types.
	 */
	function rtmc_restrict_allowed_types( $allowed_types ) {
		// Get all audio extensions.
		$all_audio_types = $allowed_types['music']['extn'];
		// Remove "wma" from the array.
		// Add your extension into array which you want to restrict.
		$restricted_ext = array_diff( $all_audio_types, array( 'wma' ) );
		// Arrange index of array.
		$restricted_ext = array_filter( $restricted_ext );
		$allowed_types['music']['extn'] = $restricted_ext;
		return $allowed_types;
	}

}

new RTM_Restrict_Custom_Extension();
