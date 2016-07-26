<?php
/*
Plugin Name: Villatheme - Visual Composer Addon
Plugin URI: http://villatheme.com
Description: Shortcode extend of Visual Composer
Version: 1.0.3
Author: Villatheme(admin@villatheme.com)
Author URI: http://villatheme.com
Copyright 2016 Villatheme.com. All rights reserved.
*/
ob_start();
@session_start();

function Register_Vi_Vc_Addon( $args, $prefix = 'villatheme' ) {
	if ( is_array( $args ) ) {
		for ( $i = 0; $i < count( $args ); $i ++ ) {
			if ( $prefix ) {
				add_shortcode( $args[$i], $prefix . '_shortcode_' . $args[$i] );
			}
		}
	}
}

/**
 * Add multi select field
 */
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'multi_dropdown', 'villatheme_multi_dropdown_settings_field' );
}

function villatheme_multi_dropdown_settings_field( $settings, $value ) {
	if ( ! is_array( $value ) ) {
		$value = $value ? $value : '';
		$value = array_filter( explode( ',', $value ) );
	}
	$output = '<div class="my_param_block">';

	$output .= '<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select ' . esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" multiple="multiple">';

	if ( ! empty( $settings['value'] ) ) {
		foreach ( $settings['value'] as $index => $data ) {
			if ( is_numeric( $index ) && ( is_string( $data ) || is_numeric( $data ) ) ) {
				$option_label = $data;
				$option_value = $data;
			} elseif ( is_numeric( $index ) && is_array( $data ) ) {
				$option_label = isset( $data['label'] ) ? $data['label'] : array_pop( $data );
				$option_value = isset( $data['value'] ) ? $data['value'] : array_pop( $data );
			} else {
				$option_value = $data;
				$option_label = $index;
			}
			$selected            = '';
			$option_value_string = (string) $option_value;
			$value_string        = $value;
			if ( '' !== $value && in_array( $option_value_string, $value_string ) ) {
				$selected = ' selected="selected"';
			}
			$option_class = str_replace( '#', 'hash-', $option_value );
			$output .= '<option class="' . esc_attr( $option_class ) . '" value="' . esc_attr( $option_value ) . '"' . $selected . '>'
				. htmlspecialchars( $option_label ) . '</option>';
		}
	}
	$output .= '</select>';
	$output .= '</div>'; // This is html markup that will be outputted in content elements edit form
	return $output;
}

/**
 * Add multi select field
 */
if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'datepicker', 'villatheme_datepicker_field', WP_PLUGIN_URL . '/vi-vc-addon/vc_extend/datepicker.js' );
}
function villatheme_datepicker_field( $settings, $value ) {
	$value = (string) $value;

	$output = '<div class="my_param_block">'
		. '<input name="' . esc_attr( $settings['param_name'] ) . '" class="vc_param_datepicker wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />'
		. '</div>';

	return $output;
}

require_once plugin_dir_path( __FILE__ ) . 'widgets/tweet.php';
require_once plugin_dir_path( __FILE__ ) . 'shortcode/twitter-feed.php';
define( 'VI_VC_ADDON_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "vi-vc-addon" . DIRECTORY_SEPARATOR );
define( 'VI_VC_ADDON_LANGUAGES', VI_VC_ADDON_DIR . "languages" . DIRECTORY_SEPARATOR );

class VILLATHEME_Plugin_Widget {
	public function __construct() {
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Function init when run plugin+
	 */
	public function init() {
		load_plugin_textdomain( 'vi-vc-addon' );
		$this->load_plugin_textdomain();
	}

	/**
	 * load Language translate
	 */
	protected function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'vi-vc-addon' );
		// Admin Locale
		if ( is_admin() ) {
			load_textdomain( 'vi-vc-addon', VI_VC_ADDON_LANGUAGES . "vi-vc-addon-$locale.mo" );
		}

		// Global + Frontend Locale
		load_textdomain( 'vi-vc-addon', VI_VC_ADDON_LANGUAGES . "vi-vc-addon-$locale.mo" );
		load_plugin_textdomain( 'vi-vc-addon', false, VI_VC_ADDON_LANGUAGES );
	}

	public function widgets_init() {
		register_widget( 'VILLATHEME_Tweets_Widget' );
	}
}

new VILLATHEME_Plugin_Widget();