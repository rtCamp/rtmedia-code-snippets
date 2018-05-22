<?php

//Function to add entry in wp_rtamazon_s3_media table for all attachments.

/**
 * set /?do=now at the end of site your URL to fire this script.
 */
/**
 * Function return attachment data needed for s3 table upload.
 *
 * @return array $attachment_data_array Attachment data array.
 */
function get_attachments_s3_array() {
	$args = array(
			'post_type'      => 'attachment',
			'post_status'    => 'inherit',
			'posts_per_page' => -1,
			'post__in'       => array(2230),
		);
	$final_attachment_data = array();
    $attachment_data       = get_posts( $args );

	if( ! empty( $attachment_data ) ) {

        $attachment_data_array = array();

		foreach ( $attachment_data as $key => $value ) {

			$single_attachment_data['blog_id']  = 1;
            $single_attachment_data['media_id'] = $value->ID;

            $url_host = parse_url( $value->guid );

			$single_attachment_data['obj_key'] = $url_host['path'];
            $single_attachment_data['wp_url']  = $value->guid;

			$bucket         = rtamazon_s3_get_bucket_name();
			$rtawss3_client = new RTAWSS3_Client();
			$key            = $url_host['path'];
            $s3_url         = $rtawss3_client->rtawss3_get_object_url( $bucket, $key );

			$single_attachment_data['s3_url']     = $s3_url;
			$single_attachment_data['bucket']     = $bucket;
			$single_attachment_data['parent_id']  = null;
			$single_attachment_data['media_size'] = null;
			$single_attachment_data['status']     = 'moved';
			//set parent attachment data.
			$attachment_data_array[] = $single_attachment_data;
		}
		if ( ! empty( $attachment_data_array ) ) {
			//set child attachment data.
			$final_attachment_data = add_child_attchments( $attachment_data_array );
		}
	}
	return $final_attachment_data;
}
/**
 * Render child attachment data based on given attachment array.
 *
 * @param array $attachment_data parent attachment data to be store in s3 DB table.
 */
function add_child_attchments( $attachment_data ) {

	if ( ! empty( $attachment_data ) ) {
		foreach ( $attachment_data as $parent_key => $parent_value ) {

			$child_attachment_array = array();
			if ( ! empty( $parent_value['media_id'] ) ) {

                $attachment_meta_data = wp_get_attachment_metadata( $parent_value['media_id'] );

				if ( ! empty( $attachment_meta_data['sizes'] ) ) {

					foreach ( $attachment_meta_data['sizes'] as $_meta_key => $_meta_value ) {
						$child_attachment_array               = $parent_value;
						$child_attachment_array['media_id']   = null;
                        $child_attachment_array['media_size'] = $_meta_key;

						$child_url_array = explode( '/', $parent_value['wp_url'] );
						array_pop( $child_url_array );
                        array_push( $child_url_array, $_meta_value['file'] );
]
						$child_url                        = implode( '/',$child_url_array );
						$child_attachment_array['wp_url'] = $child_url;
                        $url_host                         = parse_url( $child_url );

						$child_attachment_array['obj_key'] = $url_host['path'];
						$bucket                            = rtamazon_s3_get_bucket_name();

                        $rtawss3_client = new RTAWSS3_Client();
						$key            = $url_host['path'];
                        $s3_url         = $rtawss3_client->rtawss3_get_object_url( $bucket, $key );

						$child_attachment_array['s3_url']    = $s3_url;
						$child_attachment_array['parent_id'] = $parent_value['media_id'];
						$attachment_data[]                   = $child_attachment_array;
					}
				}
			}
		}
	}
	return $attachment_data;
}
/**
 * Function insert data in amazon s3 table and set /?do=now in your URL to fire this script.
 */
function save_amazons3_attachment_data() {

	if ( isset( $_GET['do'] ) && 'now' === $_GET['do'] ){

		global $wpdb;
		$table_name      = $wpdb->prefix . 'rtamazon_s3_media';
        $attachment_data = get_attachments_s3_array();

		if( ! empty( $attachment_data ) ) {
			foreach ( $attachment_data as $key => $value ) {
				$format = array( '%d','%d','%s','%s','%s','%s','%d','%s','%s' );
				$wpdb->insert( $table_name, $value, $format );
			}
		}
	}
}
add_action( 'init','save_amazons3_attachment_data' );