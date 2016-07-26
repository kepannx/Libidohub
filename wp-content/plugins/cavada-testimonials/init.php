<?php
/*
Plugin Name: Villatheme - Testimonials
Plugin URI: http://villatheme.com
Description: A plugin that allows you to show off your testimonials.
Author: Villatheme
Version: 1.0
Author URI: http://villatheme.com
*/
	
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !defined('VI_TESTIMONIALS_VERSION')) {
    define( 'VI_TESTIMONIALS_VERSION', '1.0' );
}

if( !defined('TESTIMONIALS_PLUGIN_URL')) {
    define( 'TESTIMONIALS_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ));
}

if( !defined('TESTIMONIALS_PLUGIN_PATH')) {
    define( 'TESTIMONIALS_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ));
}


require_once 'vi-testimonials.php';