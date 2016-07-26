<?php
/*
Plugin Name: WooCommerce Notification
Plugin URI: http://villatheme.com
Description: Increase conversion rate by highlighting other customers that have bought products.
Version: 1.0.2
Author: Andy Ha (villatheme.com)
Author URI: http://villatheme.com
Copyright 2016 VillaTheme.com. All rights reserved.
*/
@session_start();
define( 'VI_WNOTIFICATION_VERSION', '1.0.2' );
/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	$init_file = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "woocommerce-notification" . DIRECTORY_SEPARATOR . "includes" . DIRECTORY_SEPARATOR . "define.php";
	require_once $init_file;
}

/**
 * Class VI_WNOTIFICATION
 */
class VI_WNOTIFICATION {
	public function __construct() {
		register_activation_hook( __FILE__, array( $this, 'install' ) );
		register_deactivation_hook( __FILE__, array( $this, 'uninstall' ) );
		add_action( 'admin_notices', array( $this, 'global_note' ) );


	}

	function global_note() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			?>
			<div id="message" class="error">
				<p><?php _e( 'Please install WooCommerce and active. WooCommerce Notification is going to working.', 'woocommerce-notification' ); ?></p>
			</div>
			<?php
		}
	}

	/**
	 * When active plugin Function will be call
	 */
	public function install() {
		global $wp_version;
		if ( version_compare( $wp_version, "2.9", "<" ) ) {
			deactivate_plugins( basename( __FILE__ ) ); // Deactivate our plugin
			wp_die( "This plugin requires WordPress version 2.9 or higher." );
		}
		$json_data = '{"enable":"0","enable_mobile":"1","conditional_tags":"","archive_page":"1","order_threshold_num":"30","order_threshold_time":"0","virtual_name":"Oliver\r\nJack\r\nHarry\r\nJacob\r\nCharlie","virtual_time":"10","country":"1","virtual_city":"New York City\r\nLos Angeles\r\nChicago\r\nDallas-Fort Worth\r\nHouston\r\nPhiladelphia\r\nWashington, D.C.","virtual_country":"United States","ipfind_auth_key":"","message_purchased":"Someone in {city}, {country} purchased a {product_with_link} {time_ago}","message_checkout":"","highlight_color":"#020202","text_color":"#020202","background_color":"#ffffff","image_position":"0","position":"0","show_close_icon":"1","loop":"1","next_time":"60","notification_per_page":"30","initial_delay":"5","display_time":"5","sound_enable":"1","sound":"cool.mp3","save_logs":"1","history_time":"30"}';
		if ( ! get_option( 'wnotification_params', '' ) ) {
			update_option( 'wnotification_params', json_decode( $json_data, true ) );
		}
	}

	/**
	 * When deactive function will be call
	 */
	public function uninstall() {

	}
}

new VI_WNOTIFICATION();