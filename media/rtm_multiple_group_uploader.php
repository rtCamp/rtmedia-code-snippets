<?php
/*
 * This snippets is allows you to upload the media in multiple groups in single page.
 *
 * Add this code snippet to theme's functions.php file
 *
 * Usage: Create page at admin site and put below shortcode in it.
 * Shortcode: [rtmedia_group_uploader]
 * That's it.
 */

 add_action( 'init', 'rtm_shortcode_init' );
 /**
  * Check if function is exists or not.
  */
 if ( !function_exists( 'rtm_shortcode_init' ) ) {
 	/**
 	 * Add shortcode onlly if user is logged in.
 	 */
 	function rtm_shortcode_init() {
 		// Condition for is user logged in or not
 		if ( is_user_logged_in() ) {
 			// To add `rtmedia_group_uploader` shortcode
 			add_shortcode( 'rtmedia_group_uploader', 'rtm_group_uploader_func' );
 		}
 	}
 }
 /**
  * Check if function is exists or not.
  */
 if ( !function_exists( 'rtm_group_uploader_func' ) ) {
 	/**
 	 * call for shortcode rtmedia_group_uploader.
 	 */
 	function rtm_group_uploader_func() {
 		// get current logged in user id.
 		$user_id = get_current_user_id();
 		// Get all logeed in user's groups.
 		$user_groups = ( groups_get_user_groups( $user_id ) );
 		$user_groups = $user_groups["groups"];
 ?>
 		<!-- Render Uploader -->
 		<h1> Upload Media To Your Groups </h1>

 		Select Your Group:
 		<select id="select-group">
 			<option value="-1">Select Group</option>
 				<?php
 					foreach( $user_groups as $group ) {
 						$groupObj = groups_get_group( array( 'group_id' => $group) );
 				?>
 			<option value="<?php echo $group; ?>"> <?php echo esc_html( $groupObj->name ); ?> </option>
 				<?php
 					}
 				?>
 		</select>

 		<div id="multiple-group-uploader">
 			<!-- Call our rtmedia_uploader shortcode with some deffault arguments -->
 			<?php echo do_shortcode( '[rtmedia_uploader context=group context_id=-1 album_id=1 privacy=0]' ); ?>
 		</div>
 	<?php
 	}
 }

 add_action( 'wp_footer', 'rtm_custom_group_uploader', 999 );
 /**
  *
  */
 if ( ! function_exists( 'rtm_custom_group_uploader' ) ) {
 	/**
 	 *
 	 */
 	function rtm_custom_group_uploader() {
 		wp_enqueue_script( 'jquery' );
 ?>
 		<script>
 			var $ = jQuery;
 			$(document).ready( function() {
 				// Media uploader is hide by default whenever you render page.
 				$( '#multiple-group-uploader' ).hide();
 				// Chnage event of Select Group combobox.
 				$('#select-group').change( function() {
 					// Get value of selected option in combbobox.
 					var id = $(this).val();
 					// Check if user select other than Select Group.
 					if ( id !== '-1' ) {
 						// Show uploader if user select other than `Select Group` option.
 						$( '#multiple-group-uploader' ).show();
 						$('#multiple-group-uploader #rtmedia-uploader-form input[name=context_id]').val( id );
 					}
 					else {
 						// Hide uploader if user select `Select Group` option.
 						$( '#multiple-group-uploader' ).hide();
 					}
 				});
 			});
 		</script>
 <?php
 	}
 }
