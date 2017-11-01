<?php
/**
 * Add this function to theme's functions.php
 *
 * Send failed notification mail to particular id.
 * By this filter two mail will be sent
 * 1. To site administrator
 * 2. To specified email id on line 19
 *
 * If you want to send mail only to administrator, then change line 19
 * to $email_ids = array();
 *
 * @param array  $email_ids Array of email ids.
 * @param string $job_id    Job id.
 * @return array            Array of particular email ids.
 */
function rtmc_nofity_to_custom_id( $email_ids, $job_id ) {

	$email_ids = array( 'YOUR_EMAIL_ID' ); // Set your id to whome you want to send your failed notification.

	return $email_ids;
}
add_filter( 'rtt_nofity_transcoding_failed', 'rtmc_nofity_to_custom_id', 99, 2 );
