<?php
/**
 * Add this function to theme's functions.php
 * Add custom content in progress bar
 */

// Check if function exists.
if ( ! function_exists( 'rtm_custom_progress_bar' ) ) {
	/**
	 * Add custom content in progress bar
	 */
	function rtm_custom_progress_bar() {
		?>
		<script>
		if( typeof rtMediaHook == "object" ){   // check if rtMediaHook defined or not
			rtMediaHook.register(
				'rtm_custom_progress_bar_content', // hook id here
				function ( args ) { // your function here
					var progress_status = args[0].percent;
					var file_id = args[0].id;
					jQuery( '#' + file_id ).find( '.plupload_file_progress.ui-widget-header' ).html( progress_status + '%' );
				}
			);
		}
	</script>
		<?php
	}
}
add_action( 'wp_footer', 'rtm_custom_progress_bar' );
?>
