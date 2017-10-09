<?php
/**
 * Add this class to themes functions.php
 *
 * Show media gallery above cover image.
 *
 */
class RTMC_Gallery_Shortcode {
	/**
	 * Cunstructor
	 */
	function __construct() {
		add_action( 'wp_footer', array( $this, 'rtmc_show_gallary' ) );
	}
	/**
	 * Show gallery.
	 */
	function rtmc_show_gallary() {

		// Return if BuddyPress is not activate.
		if ( ! function_exists( 'bp_displayed_user_id' ) && ( function_exists( 'bp_is_user' ) && ! bp_is_user() ) ) {
			return;
		}

		// Get current user id.
		$user_id = bp_displayed_user_id();

		echo '<div class="custom-gallery" style="display:none">';
		echo do_shortcode( '[rtmedia_gallery global="true" media_author="' . $user_id . '"]' ); // Use your shortcode.
		echo '</div>';
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function(){
				$gallery_html = jQuery( '.custom-gallery' ).html();
				jQuery( '#cover-image-container' ).before( $gallery_html );
			} );
		</script>
		<?php
	}
}
new RTMC_Gallery_Shortcode();
