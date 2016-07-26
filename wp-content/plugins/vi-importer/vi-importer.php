<?php
/*
Plugin Name: Villatheme - Importer
Plugin URI: http://villatheme.com
Description: Importer data demo by One Click what is custom by Villatheme.
Version: 1.0.6
Author: Villatheme(admin@villatheme.com)
Author URI: http://villatheme.com
Copyright 2016 Villatheme.com. All rights reserved.
*/
if ( ! defined( 'VILLA_INC' ) ) {
	define( 'VILLA_INC', get_template_directory() . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR );
}
if ( ! defined( 'VILLA_ADMIN_DIR' ) ) {
	define( 'VILLA_ADMIN_DIR', get_template_directory() . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR );
}
define( 'VI_IMPORTER_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "vi-importer" . DIRECTORY_SEPARATOR );
define( 'VI_IMPORTER_LANGUAGES', VI_IMPORTER_DIR . "languages" . DIRECTORY_SEPARATOR );

class Vi_Plugin_Importer {
	public function __construct() {
		add_action( 'wp_ajax_vi_install_demo', array( $this, 'vi_install_demo' ) );
		add_action( 'init', array( $this, 'init' ) );
		if ( vi_importer_require() ) {
			add_action( 'admin_menu', array( $this, 'menu_page_callback' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'admin_print_scripts', array( $this, 'custom_script' ) );

		}
	}

	/**
	 * Custom Script
	 */
	public function custom_script() {
		$theme_slug = ucfirst( get_option( 'stylesheet' ) ); ?>
		<script type="text/javascript">
			var villatheme_themeoptions_link = '<?php echo add_query_arg( array( 'page' => $theme_slug ), admin_url( 'admin.php' ) )  ?>';
		</script>
	<?php }

	/**
	 * Init script
	 */
	public function admin_enqueue_scripts() {
		$page = isset( $_GET['page'] ) ? $_GET['page'] : '';
		if ( $page == 'villatheme_install_demo_data' ) {
			wp_enqueue_style( 'vi-importer-admin', plugin_dir_url( 'vi-importer/css' ) . 'css/vi-importer-admin.css' );
			wp_enqueue_script( 'vi-importer-admin', plugin_dir_url( 'vi-importer/js' ) . 'js/vi-importer-admin.js', array( 'jquery' ) );
		}
	}

	public function menu_page_callback() {
		add_menu_page(
			esc_html__( 'Install Demo Data', 'vi-importer' ),
			esc_html__( 'Install Demo Data', 'vi-importer' ),
			'manage_options',
			'villatheme_install_demo_data',
			array( $this, 'one_click_page' ),
			plugins_url( 'vi-importer/images/icon.png' ),
			2
		);
	}

	public function one_click_page() {
		$items = apply_filters( 'villatheme_import_data_array', array() ); ?>
		<h2><?php esc_html_e( 'Install Demo Data', 'vi-importer' ) ?></h2>
		<p class="description"><?php esc_html_e( 'One click install demo data is developed and custom by Villatheme.', 'vi-importer' ) ?></p>
		<?php if ( count( $items ) ) { ?>
			<div class="vi-importer-wrapper">
				<?php foreach ( $items as $k => $item ) { ?>
					<div class="vi-importer-item">
						<?php if ( $item['thumbnail_url'] ) { ?>
							<div class="item-image">
								<img src="<?php echo esc_url( $item['thumbnail_url'] ) ?>">
							</div>
						<?php } ?>
						<div class="item-title">
							<?php if ( $item['title'] ) { ?>
								<?php echo esc_html( $item['title'] ) ?>
							<?php } ?>
						</div>
						<div class="item-button">
							<a class="button vi-import-action" data-id="<?php esc_attr_e( $k ) ?>"><?php esc_html_e( 'INSTALL', 'vi-importer' ) ?></a>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
		<div style="display:none;width: 345px" class="vi-process-bar">
			<div style="display: none;" class="vi-import-download">
				<span class="text-note vi-process-title"><?php esc_html_e( 'Download demo data package...', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-extract">
				<span class="text-note"><?php esc_html_e( 'Extract demo data package...', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-woo_setting">
				<span class="text-note"><?php esc_html_e( 'WooCommerce Setting', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-core">
				<span class="text-note"><?php esc_html_e( 'Import Pages, Ports, Categories..', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-widgets">
				<span class="text-note"><?php esc_html_e( 'Add widgets...', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-setting">
				<span class="text-note"><?php esc_html_e( 'Reset theme options...', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-menus">
				<span class="text-note"><?php esc_html_e( 'Setup menus...', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div style="display: none;" class="vi-import-slider">
				<span class="text-note"><?php esc_html_e( 'Setup slider...', 'vi-importer' ) ?></span>
				<div class="meter">
					<span style="width: 0px"></span>
				</div>
				<span class="text-note"><?php esc_html__( 'If import slider don\'t finish you can import manual', 'vi-importer' ) ?></span>
				<div class="vi-process-messase" style="font-size: smaller;"></div>
			</div>
			<div id="vi-process-error-messase"></div>
		</div>
	<?php }

	/**
	 * Function init when run plugin+
	 */
	public function init() {
		load_plugin_textdomain( 'vi-importer' );
		$this->load_plugin_textdomain();
	}

	/**
	 * load Language translate
	 */
	protected function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'vi-importer' );
		// Admin Locale
		if ( is_admin() ) {
			load_textdomain( 'vi-importer', VI_IMPORTER_LANGUAGES . "vi-importer-$locale.mo" );
		}

		// Global + Frontend Locale
		load_textdomain( 'vi-importer', VI_IMPORTER_LANGUAGES . "vi-importer-$locale.mo" );
		load_plugin_textdomain( 'vi-importer', false, VI_IMPORTER_LANGUAGES );
	}

	public function vi_install_demo() {
		if ( current_user_can( 'manage_options' ) ) {

			require_once plugin_dir_path( __FILE__ ) . 'import/tp-import.php';
			die;
		}
	}
}

new Vi_Plugin_Importer();

/**
 * Check Redux framework active
 * @return bool
 */
function vi_importer_require() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'redux-framework/redux-framework.php' ) ) {
		return true;
	} else {
		return false;
	}
}