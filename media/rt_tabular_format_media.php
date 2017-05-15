<?php
/**
 * Add this function to theme's functions.php
 * Show medias in tabular format.
 *
 * @param  bool $status  Status of function.
 * @return bool          Returns true tabular format is enabled from rtMedia settings.
 */
function rtmedia_enable_tabular_view( $status ) {
	global $rtmedia_query;
	if ( function_exists( 'rtm_is_document_table_view_enabled' ) && rtm_is_document_table_view_enabled() && isset( $rtmedia_query->action_query->action ) && 'edit' !== $rtmedia_query->action_query->action ) {
		if ( ( function_exists( 'is_rtmedia_album' ) && is_rtmedia_album() ) || ( function_exists( 'is_rtmedia_gallery' ) && is_rtmedia_gallery() ) ) {
			$status = true;
		}
	}
	return $status;
}
add_filter( 'rtmedia_other_files_is_document_tab', 'rtmedia_enable_tabular_view', 99 );
