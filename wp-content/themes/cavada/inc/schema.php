<?php

/**
 * Class viSchema
 * Create schema.org
 */
class CAVADA_Schema {
	function __construct() {

	}


	/**
	 * Get meta image
	 *
	 * @param $attachment_id
	 * @param $size
	 *
	 * @return string
	 */
	public function get_image( $attachment_id, $size ) {

		$image_attributes = wp_get_attachment_image_src( $attachment_id, $size );
		$width            = '';
		$height           = '';
		$url              = '';

		if ( count( $image_attributes ) > 3 ) {
			$url    = $image_attributes[0];
			$width  = $image_attributes[1];
			$height = $image_attributes[2];
		}

		$meta = '';
//		$meta .= '<meta itemprop="url" content="' . esc_attr( $url ) . '" >';
//		$meta .= '<meta itemprop="width" content="' . esc_attr( $width ) . '" >';
//		$meta .= '<meta itemprop="height" content="' . esc_attr( $height ) . '">';

		return $meta;
	}


}