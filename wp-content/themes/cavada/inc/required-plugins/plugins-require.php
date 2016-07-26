<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @package       TGM-Plugin-Activation
 * @subpackage    Example
 * @version       2.3.6
 * @author        Thomas Griffin <thomas@thomasgriffinmedia.com>
 * @author        Gary Jones <gamajo@gamajo.com>
 * @copyright     Copyright (c) 2012, Thomas Griffin
 * @license       http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link          https://github.com/thomasgriffin/TGM-Plugin-Activation
 */
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once CAVADA_THEME_DIR . 'inc/required-plugins/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'cavada_register_required_plugins', 0, 1 );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function cavada_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'Contact Form 7',
			// The plugin name
			'slug'     => 'contact-form-7',
			'required' => false,
		),
		array(
			'name'     => 'MailChimp for WordPress',
			// The plugin name
			'slug'     => 'mailchimp-for-wp',
			'required' => false,
		),
		array(
			'name'     => 'Instagram Feed',
			// The plugin name
			'slug'     => 'instagram-feed',
			'required' => false,
		),
		array(
			'name'     => 'Meta Box',
			// The plugin name
			'slug'     => 'meta-box',
			'required' => true,
		),
		array(
			'name'     => 'WooCommerce',
			// The plugin name
			'slug'     => 'woocommerce',
			'required' => true,

		),
		array(
			'name'     => 'YITH WooCommerce Wishlist',
			// The plugin name
			'slug'     => 'yith-woocommerce-wishlist',
			'required' => false,
		),
		array(
			'name'               => 'Villatheme - Importer',
			// The plugin name
			'slug'               => 'vi-importer',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/vi-importer.zip',
			'version'            => '1.0.6',
			// The plugin source
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'WooCommerce Notification',
			// The plugin name
			'slug'               => 'woocommerce-notification',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/woocommerce-notification.zip',
			'version'            => '1.0.2',
			// The plugin source
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Villatheme - Minify',
			// The plugin name
			'slug'               => 'vi-minify',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/vi-minify.zip',
			'version'            => '1.0.3',
			// The plugin source
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Villatheme - Testimonials',
			// The plugin name
			'slug'               => 'cavada-testimonials',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/villatheme-testimonials.zip',
			'version'            => '1.0',
			// The plugin source
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),

		array(
			'name'               => 'Villatheme - Visual Composer Addon',
			// The plugin name
			'slug'               => 'vi-vc-addon',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/vi-vc-addon.zip',
			'version'            => '1.0.3',
			// The plugin source
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Revolution Slider',
			// The plugin name
			'slug'               => 'revslider',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/revslider.zip',
			'version'            => '5.2.5.6',
			// The plugin source
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Visual Composer',
			// The plugin name
			'slug'               => 'js_composer',
			// The plugin slug (typically the folder name)
			'source'             => CAVADA_THEME_DIR . '/inc/required-plugins/plugins/js_composer.zip',
			'version'            => '4.12',
			// The plugin source
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
	);


	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'cavada',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'install-required-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.


	);

	tgmpa( $plugins, $config );
}