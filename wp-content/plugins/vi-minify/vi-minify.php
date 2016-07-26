<?php
/*
Plugin Name: Villatheme - Minify
Plugin URI: http://villatheme.com
Description: Minify CSS, HTML, Images and developer mode.
Version: 1.0.3
Author: Villatheme(admin@villatheme.com)
Author URI: http://villatheme.com
Copyright 2016 Villatheme.com. All rights reserved.
*/
/**
 * require
 */
define( 'VI_MINIFY_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "vi-minify" . DIRECTORY_SEPARATOR );
define( 'VI_MINIFY_LANGUAGES', VI_MINIFY_DIR . "languages" . DIRECTORY_SEPARATOR );
//require_once( ABSPATH . 'wp-includes/pluggable.php' );
require_once plugin_dir_path( __FILE__ ) . 'minify/html-minify.php';
require_once plugin_dir_path( __FILE__ ) . 'minify/css-js-minify.php';

new Vi_Plugins_Minify();
if ( ! defined( 'VILLATHEME_ADMIN_IMAGES' ) ) {
	define( 'VILLATHEME_ADMIN_IMAGES', get_template_directory_uri() . '/admin/assets/images/' );
}

class Vi_Plugins_Minify {
	public function __construct() {
		add_filter( 'villatheme_themeoptions_output', array( $this, 'vi_themeoptions_output' ) );
		add_action( 'wp_before_admin_bar_render', array( $this, 'vi_admin_bar_render' ) );
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Function init when run plugin+
	 */
	public function init() {
		load_plugin_textdomain( 'vi-minify' );
		$this->load_plugin_textdomain();
	}

	/**
	 * load Language translate
	 */
	protected function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'vi-minify' );
		// Admin Locale
		if ( is_admin() ) {
			load_textdomain( 'vi-minify', VI_MINIFY_LANGUAGES . "vi-minify-$locale.mo" );
		}

		// Global + Frontend Locale
		load_textdomain( 'vi-minify', VI_MINIFY_LANGUAGES . "vi-minify-$locale.mo" );
		load_plugin_textdomain( 'vi-minify', false, VI_MINIFY_LANGUAGES );
	}

	/**
	 * Add clear cache button
	 */
	public function vi_admin_bar_render() {
		global $wp_admin_bar, $villatheme_data;
		if ( isset( $villatheme_data['vi_css'] ) || isset( $villatheme_data['vi_js'] ) ) {
			//			if ( $villatheme_data['vi_css'] || $villatheme_data['vi_js'] ) {
			if ( $villatheme_data['vi_css'] ) {
				$wp_admin_bar->add_menu(
					array(
						'parent' => 'site-name',// use 'false' for a root menu, or pass the ID of the parent menu
						'id'     => 'smof_output_options',// link ID, defaults to a sanitized title value
						'title'  => esc_html__( 'Clear Cache', 'dukan' ),// link title
						'href'   => admin_url( '?vi_cache_clean=1' ),// name of file
						'meta'   => false
					)
				);
			}
		}
	}

	/**
	 * Add options
	 *
	 * @param $of_options
	 *
	 * @return array
	 */
	public function vi_themeoptions_output( $of_options ) {
		if ( ! defined( 'VILLATHEME_ADMIN_IMAGES' ) ) {
			return $of_options;
		}
		/**
		 * Minify Options
		 */
		$of_options[] = array(
			"name" => "Output",
			"type" => "heading",
			"icon" => VILLATHEME_ADMIN_IMAGES . "ico-view.png"
		);
		$of_options[] = array(
			"name" => esc_html__( "Developer", "vi-minify" ),
			"desc" => "",
			"id"   => "developer",
			"std"  => esc_html__( "Developer", "vi-minify" ),
			"icon" => true,
			"type" => "info"
		);
		$of_options[] = array(
			"name" => esc_html__( "Turn on Developer mode", "vi-minify" ),
			"desc" => "",
			"id"   => "turn_on_dev_mode",
			"std"  => 0,
			"on"   => esc_html__( "Yes", "vi-minify" ),
			"off"  => esc_html__( "No", "vi-minify" ),
			"type" => "switch"
		);

		$of_options[] = array(
			"name" => esc_html__( "Images", "vi-minify" ),
			"desc" => "",
			"id"   => "images",
			"std"  => esc_html__( "Images", "vi-minify" ),
			"icon" => true,
			"type" => "info"
		);
		$of_options[] = array(
			"name"  => esc_html__( "Lazy load", "vi-minify" ),
			"desc"  => "",
			"id"    => "turn_on_lazy_load",
			"std"   => 0,
			"folds" => 1,
			"on"    => esc_html__( "Yes", "vi-minify" ),
			"off"   => esc_html__( "No", "vi-minify" ),
			"type"  => "switch"
		);
		$of_options[] = array(
			'name' => esc_html__( 'Placeholder image', "vi-minify" ),
			'id'   => 'vi_woo_placeholder_image',
			'type' => 'media',
			'desc' => esc_html__( 'Select your placeholder image', "vi-minify" ),
			"fold" => "turn_on_lazy_load",

		);
		/**
		 * HTML
		 */
		$of_options[] = array(
			"name" => esc_html__( "HTML", "vi-minify" ),
			"desc" => "",
			"id"   => "html",
			"std"  => esc_html__( "HTML", "vi-minify" ),
			"icon" => true,
			"type" => "info"
		);
		$of_options[] = array(
			"name"  => esc_html__( "Turn on HTML minify", "vi-minify" ),
			"desc"  => "",
			"id"    => "turn_on_minify_html",
			"std"   => 0,
			"folds" => 1,
			"on"    => esc_html__( "Yes", "vi-minify" ),
			"off"   => esc_html__( "No", "vi-minify" ),
			"type"  => "switch"
		);
		$of_options[] = array(
			"name" => "Ignore CSS",
			"id"   => "ignore_css",
			"std"  => 0,
			"fold" => 'turn_on_minify_html',
			"type" => "checkbox",
			"desc" => ""
		);
		$of_options[] = array(
			"name" => "Ignore JS",
			"id"   => "ignore_js",
			"fold" => 'turn_on_minify_html',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => ""
		);
		$of_options[] = array(
			"name" => "Ignore Comments",
			"id"   => "ignore_comments",
			"fold" => 'turn_on_minify_html',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => ""
		);
		/**
		 * CSS
		 */
		$of_options[] = array(
			"name"  => esc_html__( "CSS", "vi-minify" ),
			"desc"  => "",
			"id"    => "css",
			"std"   => esc_html__( "CSS", "vi-minify" ),
			"icon"  => true,
			"type"  => "info",
			"folds" => 1
		);
		$of_options[] = array(
			"name" => esc_html__( "Turn on CSS minify", "vi-minify" ),
			"desc" => "",
			"id"   => "vi_css",
			"std"  => 0,
			"on"   => esc_html__( "Yes", "vi-minify" ),
			"off"  => esc_html__( "No", "vi-minify" ),
			"type" => "switch"
		);
		$of_options[] = array(
			"name" => esc_html__( 'Generate data: URIs for images', 'dukan' ),
			"id"   => "vi_css_datauris",
			"fold" => 'vi_css',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__( 'Enable this to include small background-images in the CSS itself instead of as seperate downloads.', 'dukan' )
		);
		$of_options[] = array(
			"name" => esc_html__( 'Remove Google Fonts', 'dukan' ),
			"id"   => "vi_css_nogooglefont",
			"fold" => 'vi_css',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__( 'Check this if you don\'t need or want Google Fonts being loaded.', 'dukan' )
		);
		$of_options[] = array(
			"name" => esc_html__( 'Also aggregate inline CSS', 'dukan' ),
			"id"   => "vi_css_include_inline",
			"fold" => 'vi_css',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__( 'Check this option for Autoptimize to also aggregate CSS in the HTML.', 'dukan' )
		);
		$of_options[] = array(
			"name" => esc_html__( 'Inline and Defer CSS', 'dukan' ),
			"id"   => "vi_css_defer",
			"fold" => 'vi_css',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__( 'Inline "above the fold CSS" while loading the main autoptimized CSS only after page load. Check the FAQ before activating this option!', 'dukan' )
		);
		$of_options[] = array(
			"name" => esc_html__( 'Inline all CSS', 'dukan' ),
			"id"   => "vi_css_inline",
			"fold" => 'vi_css',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__( 'Inlining all CSS can improve performance for sites with a low pageviews/ visitor-rate, but may slow down performance otherwise.', 'dukan' )
		);
		$of_options[] = array(
			"name" => esc_html__( 'Inline all CSS', 'dukan' ),
			"id"   => "vi_css_exclude",
			"fold" => 'vi_css',
			"std"  => 'admin-bar.min.css, dashicons.min.css,js_composer_front_custom.css',
			"type" => "text",
			"desc" => esc_html__( 'A comma-seperated list of CSS you want to exclude from being optimized.', 'dukan' )
		);
		/**
		 * Javascript
		 */
		/*
		$of_options[] = array(
			"name" => esc_html__( "JavaScript", "vi-minify" ),
			"desc" => "",
			"id"   => "javascript",
			"std"  => esc_html__( "JavaScript", "vi-minify" ),
			"icon" => true,
			"type" => "info"
		);
		$of_options[] = array(
			"name" => esc_html__( "Turn on JavaScript minify", "vi-minify" ),
			"desc" => "",
			"id"   => "vi_js",
			"std"  => 0,
			"on"   => esc_html__( "Yes", "vi-minify" ),
			"off"  => esc_html__( "No", "vi-minify" ),
			"type" => "switch"
		);
		$of_options[] = array(
			"name" => esc_html__( 'Force JavaScript in <head>', 'dukan' ),
			"id"   => "vi_js_forcehead",
			"fold" => 'vi_js',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__(
				'
		Load JavaScript early, reducing the chance of JS-errors but making it render blocking. You can disable this if you\'re not aggregating inline JS and you want JS to be deferred.', 'dukan'
			)
		);
		$of_options[] = array(
			"name" => esc_html__( 'Also aggregate inline JS', 'dukan' ),
			"id"   => "vi_js_include_inline",
			"fold" => 'vi_js',
			"std"  => 0,
			"type" => "checkbox",
			"desc" => esc_html__( 'Check this option for Autoptimize to also aggregate JS in the HTML. If this option is not enabled, you might have to "force JavaScript in head".', 'dukan' )
		);
		//$of_options[] = array(
		//	"name" => esc_html__( 'Exclude scripts from Autoptimize', 'dukan' ),
		//	"id"   => "vi_js_exclude",
		//	"fold" => 'vi_js',
		//	"std"  => 's_sid,smowtion_size,sc_project,WAU_,wau_add,comment-form-quicktags,edToolbar,ch_client,seal.js',
		//	"type" => "text",
		//	"desc" => esc_html__( 'A comma-seperated list of scripts you want to exclude from being optimized, for example \'whatever.js, another.js\' (without the quotes) to exclude those scripts from being aggregated and minimized by Autoptimize.', 'dukan' )
		//);
		//$of_options[] = array(
		//	"name" => esc_html__( 'Add try-catch wrapping', 'dukan' ),
		//	"id"   => "vi_js_trycatch",
		//	"fold" => 'vi_js',
		//	"std"  => 0,
		//	"type" => "checkbox",
		//	"desc" => esc_html__( 'If your scripts break because of a JS-error, you might want to try this.', 'dukan' )
		//);
		/**
		 * Folder info
		 */

		$of_options[] = array(
			"name" => esc_html__( "Cache information", "vi-minify" ),
			"desc" => "",
			"id"   => "cache_information",
			"std"  => esc_html__( "Cache information", "vi-minify" ),
			"icon" => true,
			"type" => "info"
		);
		$AOstatArr    = viCache::stats();
		$AOcacheSize  = round( $AOstatArr[1] / 1024 );

		$of_options[] = array(
			"options" => array(
				'Cache folder'              => htmlentities( VI_CACHE_DIR ),
				'Can we write ?'            => viCache::cacheavail() ? esc_html__( 'Yes', 'dukan' ) : esc_html__( 'No', 'dukan' ),
				'Cached styles and scripts' => $AOstatArr[0] . " files, totalling " . $AOcacheSize . " Kbytes (calculated at " . date( "H:i e", $AOstatArr[2] ) . ")"
			),
			"type"    => "list_information"
		);

		return $of_options;
	}
}
