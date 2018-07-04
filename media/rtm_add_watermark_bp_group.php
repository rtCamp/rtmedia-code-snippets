<?php
/**
 * This snippets is allows you to add watermark on buddypress group avatar and cover-image.
 *
 * Add this code snippet to end of theme's functions.php file
 */

if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if ( is_plugin_active( 'buddypress-media/index.php' ) && is_plugin_active( 'rtmedia-photo-watermak/index.php' ) ) {
	if ( ! function_exists( 'rtm_groups_cover_image_uploaded' ) ) {

		/**
		 * Add watermark to BuddyPress group cover-image after successful completion of upload.
		 *
		 * @param Integer $item_id BuddyPress Component ID.
		 */
		function rtm_groups_cover_image_uploaded( $item_id ) {
			$abspath       = bp_attachments_get_attachment(
				'path', array(
					'object_dir' => 'groups',
					'item_id'    => $item_id,
					'type'       => 'cover-image',
					'file'       => '',
				)
			);
			$callwatermark = new RTMediaWatermarkProcessor();
			$callwatermark->add_watermark( $abspath, 'rt_media_featured_image' );
		}
		add_action( 'groups_cover_image_uploaded', 'rtm_groups_cover_image_uploaded', 999, 1 );
	}

	if ( ! function_exists( 'rtm_groups_avatar_uploaded' ) ) {

		/**
		 * Add watermark to BuddyPress group avatar after successful completion of upload.
		 *
		 * @param Integer $item_id BuddyPress Component ID.
		 */
		function rtm_groups_avatar_uploaded( $item_id ) {
			$upload_dir    = wp_upload_dir();
			$basedir       = $upload_dir['basedir'];
			$abspath       = $basedir . '/group-avatars/' . $item_id . '/';
			$callwatermark = new RTMediaWatermarkProcessor();

			if ( is_dir( $abspath ) ) {
				$dh = opendir( $abspath );
				if ( $dh ) {
					$file = readdir( $dh );
					while ( false !== $file ) {
						$file_path  = $abspath . $file;
						if ( is_file( $file_path ) ) {
							$callwatermark->add_watermark( $file_path, 'rt_media_thumbnail' );
						}
						$file = readdir( $dh );
					}
					closedir( $dh );
				}
			}
		}
		add_action( 'groups_avatar_uploaded', 'rtm_groups_avatar_uploaded', 999, 1 );
	}
}
