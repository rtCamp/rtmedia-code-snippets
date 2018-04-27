<?php
/*
 * This snippets allows you to upload the media to multiple BuddyPress groups from single page.
 *
 * Add this code snippet to your child theme's functions.php file
 *
 * Usage: Once you use mentioned code to respected file, you can create WordPress page/post from dashboard and put below shortcode in it.
 * Shortcode: [rtmedia_group_uploader]
 * That's it.
 */

 add_action( 'init', 'rtm_shortcode_init' );
 /**
  * Check if function exists.
  */
 if ( !function_exists( 'rtm_shortcode_init' ) ) {
 	/**
 	 * Add shortcode only if user is logged in.
 	 */
 	function rtm_shortcode_init() {
 		// Check if user is logged in or not
 		if ( is_user_logged_in() ) {
 			// Function call to add rtmedia_group_uploader shortcode
 			add_shortcode( 'rtmedia_group_uploader', 'rtm_group_uploader_func' );
 		}
 	}
 }
 /**
  * Check if function exists.
  */
 if ( !function_exists( 'rtm_group_uploader_func' ) ) {
 	/**
 	 * This function will be called to render output of shortcode.
 	 */
 	function rtm_group_uploader_func() {
 		// Get current logged-in user-id.
 		$user_id = get_current_user_id();

 		// Get all logged-in user's groups.
 		$user_groups = groups_get_user_groups( $user_id );
    
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
 			<option value="<?php echo esc_attr( $group ); ?>"> <?php echo esc_html( $groupObj->name ); ?> </option>
 				<?php
 					}
 				?>
 		</select>

 		<div id="multiple-group-uploader">
 			<!-- Call rtmedia_uploader shortcode with desired parameters -->
 			<?php echo do_shortcode( '[rtmedia_uploader context=group context_id=-1 album_id=1 privacy=0]' ); ?>
 		</div>
 	<?php
 	}
 }

 add_action( 'wp_footer', 'rtm_custom_group_uploader', 999 );
 /**
  * Check if function exists.
  */
 if ( ! function_exists( 'rtm_custom_group_uploader' ) ) {
 	/**
 	 * Enqueue jquery and add script to handle uploader.
 	 */
 	function rtm_custom_group_uploader() {
 		wp_enqueue_script( 'jquery' );
 ?>
 		<script>
 			var $ = jQuery;
 			$(document).ready( function() {
 				// To hide media uploader on page load.
 				$( '#multiple-group-uploader' ).hide();
 				// Change event of Select Group combo-box.
 				$( '#select-group' ).change( function() {
 					// Get value of selected option in combo-box.
 					var id = $(this).val();
 					// Check if user hasn't selected any group yet.
 					if ( id !== '-1' ) {
 						$( '#multiple-group-uploader' ).show();
 						$( '#multiple-group-uploader #rtmedia-uploader-form input[name=context_id]' ).val( id );
 					}
 					else {
 						$( '#multiple-group-uploader' ).hide();
 					}
 				});
 			});
 		</script>
 <?php
 	}
 }
