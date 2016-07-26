<?php

/**
 * Class VI_WNOTIFICATION_Frontend_Logs
 */
class VI_WNOTIFICATION_Frontend_Logs {
	public function __construct() {
		add_action( 'template_redirect', array( $this, 'init' ) );
	}

	/**
	 * Detect IP
	 */
	public function init() {
		if ( ! isset( $_GET['link'] ) ) {
			return false;
		}
		if ( wp_verify_nonce( $_GET['link'], 'wocommerce_notification_click' ) ) {
			$this->save_click();
		} else {
			return false;
		}
	}

	/**
	 * Save click
	 */
	private function save_click() {
		/*Check Save Logs Option*/
		$params = new VI_WNOTIFICATION_Admin_Settings();
		if ( $params->get_field( 'save_logs' ) ) {
			if ( is_product() ) {
				global $post;
				$product_id = $post->ID;
				$file_name  = mktime( 0, 0, 0, date( "m" ), date( "d" ), date( "Y" ) ) . '.txt';
				$file_path  = VI_WNOTIFICATION_CACHE . $file_name;
				if ( is_file( $file_path ) ) {
					file_put_contents( $file_path, ',' . $product_id, FILE_APPEND );
				} else {
					file_put_contents( $file_path, $product_id );
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}