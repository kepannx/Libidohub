<?php

/*
Class Name: VI_WNOTIFICATION_Admin_Admin
Author: Andy Ha (support@villatheme.com)
Author URI: http://villatheme.com
Copyright 2015 villatheme.com. All rights reserved.
*/

class VI_WNOTIFICATION_Admin_Admin {
	function __construct() {

		add_filter(
			'plugin_action_links_woocommerce-notification/woocommerce-notification.php', array(
				$this,
				'settings_link'
			)
		);
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'menu_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Init Script in Admin
	 */
	public function admin_enqueue_scripts() {
		$page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
		if ( $page == 'woocommerce-notification' ) {
			/*Stylesheet*/
			wp_enqueue_style( 'woocommerce-notification-image', VI_WNOTIFICATION_CSS . 'image.min.css' );
			wp_enqueue_style( 'woocommerce-notification-transition', VI_WNOTIFICATION_CSS . 'transition.min.css' );
			wp_enqueue_style( 'woocommerce-notification-form', VI_WNOTIFICATION_CSS . 'form.min.css' );
			wp_enqueue_style( 'woocommerce-notification-icon', VI_WNOTIFICATION_CSS . 'icon.min.css' );
			wp_enqueue_style( 'woocommerce-notification-dropdown', VI_WNOTIFICATION_CSS . 'dropdown.min.css' );
			wp_enqueue_style( 'woocommerce-notification-checkbox', VI_WNOTIFICATION_CSS . 'checkbox.min.css' );
			wp_enqueue_style( 'woocommerce-notification-segment', VI_WNOTIFICATION_CSS . 'segment.min.css' );
			wp_enqueue_style( 'woocommerce-notification-menu', VI_WNOTIFICATION_CSS . 'menu.min.css' );
			wp_enqueue_style( 'woocommerce-notification-tab', VI_WNOTIFICATION_CSS . 'tab.css' );
			wp_enqueue_style( 'woocommerce-notification-front', VI_WNOTIFICATION_CSS . 'woocommerce-notification.css' );
			wp_enqueue_style( 'woocommerce-notification', VI_WNOTIFICATION_CSS . 'woocommerce-notification-admin.css' );

			/*Script*/
			wp_enqueue_script( 'woocommerce-notification-dependsOn', VI_WNOTIFICATION_JS . 'dependsOn-1.0.2.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-notification-transition', VI_WNOTIFICATION_JS . 'transition.min.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-notification-dropdown', VI_WNOTIFICATION_JS . 'dropdown.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-notification-checkbox', VI_WNOTIFICATION_JS . 'checkbox.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-notification-tab', VI_WNOTIFICATION_JS . 'tab.js', array( 'jquery' ) );
			wp_enqueue_script( 'woocommerce-notification', VI_WNOTIFICATION_JS . 'woocommerce-notification-admin.js', array( 'jquery' ) );

			/*Color picker*/
			wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ), false, 1 );

			/*Custom*/
			$params           = new VI_WNOTIFICATION_Admin_Settings();
			$highlight_color  = $params->get_field( 'highlight_color' );
			$text_color       = $params->get_field( 'text_color' );
			$background_color = $params->get_field( 'background_color' );
			$custom_css       = "
                #message-purchased{
                        background-color: {$background_color};
                        color:{$text_color};
                }
                 #message-purchased a{
                        color:{$highlight_color};
                }
                ";
			wp_add_inline_style( 'woocommerce-notification', $custom_css );

		}
	}

	/**
	 * Link to Settings
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="admin.php?page=woocommerce-notification" title="' . __( 'Settings', 'woocommerce-notification' ) . '">' . __( 'Settings', 'woocommerce-notification' ) . '</a>';
		array_unshift( $links, $settings_link );

		return $links;
	}


	/**
	 * Function init when run plugin+
	 */
	function init() {
		/*Register post type*/

		load_plugin_textdomain( 'woocommerce-notification' );
		$this->load_plugin_textdomain();

	}


	/**
	 * load Language translate
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-notification' );
		// Admin Locale
		if ( is_admin() ) {
			load_textdomain( 'woocommerce-notification', VI_WNOTIFICATION_LANGUAGES . "woocommerce-notification-$locale.mo" );
		}

		// Global + Frontend Locale
		load_textdomain( 'woocommerce-notification', VI_WNOTIFICATION_LANGUAGES . "woocommerce-notification-$locale.mo" );
		load_plugin_textdomain( 'woocommerce-notification', false, VI_WNOTIFICATION_LANGUAGES );
	}

	/**
	 * Register a custom menu page.
	 */
	public function menu_page() {
		add_menu_page(
			esc_html__( 'WooCommerce Notification', 'woocommerce-notification' ),
			esc_html__( 'Woo Notification', 'woocommerce-notification' ),
			'manage_options',
			'woocommerce-notification',
			array( 'VI_WNOTIFICATION_Admin_Settings', 'page_callback' ),
			'dashicons-megaphone',
			2
		);

	}

}

?>