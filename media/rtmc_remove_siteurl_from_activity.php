<?php
/**
 * Add this function to theme's functions.php
 * Remove link from activity url preview content
 * Dependency on: rtMedia Activity URL Preview
 */

// Check if function doest not exists.
if ( ! function_exists( 'rtmc_remove_siteurl_from_activity' ) ) {
	/**
	 * Remove link from activity url preview content.
	 */
	function rtmc_remove_siteurl_from_activity() {
		?>
		<script type="text/javascript">
			jQuery( function($) {
				function remove_site_url() {
					jQuery( '.rtmp_link_preview_container' ).each(function(e) {
					    var previewurl = jQuery(this).children('a').attr('href');
						// Get the site url from activity.
						jQuery(this).parent('.rtmp_final_link').siblings('p').find('a').each(function(e) {
							var otherurl = jQuery(this).attr('href');
							// If site url found, then hide it.
							if ( previewurl==otherurl ){
								jQuery(this).hide();
							}
							jQuery( '.activity-inner' ).show();
						});
					});
				}
				remove_site_url();
				// Remove site url when new elements are added
				jQuery( '#activity-stream' ).bind( "DOMSubtreeModified", function() {
					remove_site_url();
				});
	        });
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'rtmc_remove_siteurl_from_activity' );
?>

// Add this style to custom css ( rtMedia->settings->Custom CSS )

#activity-stream .activity-inner {
	 display: none;
}
