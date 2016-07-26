<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class viConfig {
	private $config = null;
	static private $instance = null;

	//Singleton: private construct
	private function __construct() {
		if ( is_admin() ) {
			//Add the admin page and settings
			//Clean cache?
			if ( isset( $_GET['vi_cache_clean'] ) ) {
				if ( $_GET['vi_cache_clean'] ) {
					viCache::clearall();
					//wp_redirect( admin_url() );
				}
			}
		}
	}

	static public function instance() {
		//Only one instance
		if ( self::$instance == null ) {
			self::$instance = new viConfig();
		}

		return self::$instance;
	}


	public function get( $key ) {

		$villatheme_data = get_theme_mods();

		if ( ! is_array( $this->config ) ) {
			//Default config
			$config = array(

				'vi_js'                 => 0,
				'vi_js_exclude'         => "s_sid, smowtion_size, sc_project, WAU_, wau_add, comment-form-quicktags, edToolbar, ch_client, seal.js",
				'vi_js_trycatch'        => 0,
				'vi_js_justhead'        => 0,
				'vi_js_include_inline'  => 0,
				'vi_js_forcehead'       => 1,
				'vi_css'                => 0,
				'vi_css_exclude'        => "admin-bar.min.css, dashicons.min.css,js_composer_front_custom.css",
				'vi_css_justhead'       => 0,
				'vi_css_include_inline' => 0,
				'vi_css_defer'          => 0,
				'vi_css_defer_inline'   => "",
				'vi_css_inline'         => 0,
				'vi_css_datauris'       => 0,
				'vi_css_nogooglefont'   => 0,
				'vi_cdn_url'            => "",
				'vi_cache_nogzip'       => 1,
				'vi_show_adv'           => 0
			);

			//Override with user settings

			foreach ( $config as $k => $name ) {

				if ( isset( $villatheme_data[ $k ] ) ) {
					//It was set before!
					$config[ $k ] = $villatheme_data[ $k ];
				}
			}

			//Save for next question
			$this->config = $config;
		}

		if ( isset( $this->config[ $key ] ) ) {

			return $this->config[ $key ];
		}

		return false;
	}
}
