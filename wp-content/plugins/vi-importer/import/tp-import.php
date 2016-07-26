<?php

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	define( 'WP_LOAD_IMPORTERS', true );
}
@session_start();

$type = $_REQUEST['type'];
/**
 * GET DEMODATA PACKAGE FROM REMOTE SERVER
 */

if ( $type == 'download' ) {
	ob_start();
	$demodata   = $_REQUEST['demodata'];
	$demo_datas = apply_filters( 'villatheme_import_data_array', array() );
	if ( isset( $demo_datas[$demodata] ) ) {
		$package_url = isset( $demo_datas[$demodata]['package_url'] ) ? $demo_datas[$demodata]['package_url'] : '';
		$data_dir    = isset( $demo_datas[$demodata]['data_dir'] ) ? $demo_datas[$demodata]['data_dir'] : '';

		if ( ! $package_url && $data_dir ) {
			if ( is_dir( $data_dir ) ) {
				WP_Filesystem();
				$upload_dir   = wp_upload_dir();
				$demodata_dir = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'vi-data-demo' . DIRECTORY_SEPARATOR . $demodata;
				if ( is_dir( $demodata_dir ) ) {
					rmdir( $demodata_dir );
				}
				if ( ! wp_mkdir_p( $demodata_dir ) ) {
					$response = array(
						'step'    => 'download',
						'next'    => 'extract',
						'return'  => false,
						'message' => sprintf( esc_html__( 'Cannot create directory "%"', 'vi-importer' ), $demodata_dir ),
					);
					echo json_encode( $response );
					exit();
				}
				$res_copy_dir = copy_dir( $data_dir, $demodata_dir );
				if ( copy_dir( $data_dir, $demodata_dir ) ) {
					$_SESSION['villatheme-demodata-dir'] = $demodata_dir;
				} else {
					$_SESSION['villatheme-demodata-dir'] = $data_dir;
				}
				// remove cache directory before run import
				$data_cache_dir = $_SESSION['villatheme-demodata-dir'] . '/data/cache';
				if ( is_dir( $data_cache_dir ) ) {
					rmdir( $data_cache_dir ); // create cache directory 
				}

				$wooimport_file = $_SESSION['villatheme-demodata-dir'] . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'woocommerce' . DIRECTORY_SEPARATOR . 'setting.txt';
				$next_step      = is_file( $wooimport_file ) ? 'woo_setting' : 'core';
				$log            = ob_get_clean();
				$response       = array(
					'step'    => 'download',
					'next'    => $next_step,
					'return'  => true,
					'message' => 'Demo data is already downloaded',
					'log'     => $log,
				);
				echo json_encode( $response );
				exit();
			} else {
				$log      = ob_get_clean();
				$response = array(
					'step'    => 'download',
					'next'    => 'error',
					'return'  => false,
					'message' => 'Demo data directory not found',
					'log'     => $log,
				);
				echo json_encode( $response );
				exit();
			}
			exit();
		}
		$filename     = pathinfo( $package_url, PATHINFO_BASENAME );
		$file_content = file_get_contents( $package_url );
		if ( ! $file_content ) {
			$response = array(
				'step'    => 'download',
				'next'    => 'extract',
				'return'  => false,
				'message' => sprintf( esc_html__( 'Cannot get demo data package from %', 'vi-importer' ), $package_url )
			);
			echo json_encode( $response );
			exit();
		}

		$upload_dir                                 = wp_upload_dir();
		$demodata_dir                               = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'vi-data-demo' . DIRECTORY_SEPARATOR . $demodata;
		$_SESSION['villatheme-demodata-dir']        = $demodata_dir;
		$_SESSION['villatheme-demodata-file']       = $filename;
		$_SESSION['villatheme-demodata-downloaded'] = false;

		if ( ! wp_mkdir_p( $demodata_dir ) ) {
			$response = array(
				'step'    => 'download',
				'next'    => 'extract',
				'return'  => false,
				'message' => sprintf( esc_html__( 'Cannot create directory "%"', 'vi-importer' ), $demodata_dir ),
			);
			echo json_encode( $response );
			exit();
		}

		if ( ! file_put_contents( $demodata_dir . DIRECTORY_SEPARATOR . $filename, $file_content ) ) {
			$response = array(
				'step'    => 'download',
				'next'    => 'extract',
				'return'  => false,
				'message' => sprintf( esc_html__( 'Cannot store file "%s"', 'vi-importer' ), $demodata_dir . DIRECTORY_SEPARATOR . $filename ),
			);
			echo json_encode( $response );
			exit();
		}
		$log                                        = ob_end_clean();
		$_SESSION['villatheme-demodata-downloaded'] = true;
		$response                                   = array(
			'step'    => 'download',
			'next'    => 'extract',
			'return'  => true,
			'message' => sprintf( esc_html__( 'Download demo data package success "%s"', 'vi-importer' ), $demodata_dir . DIRECTORY_SEPARATOR . $filename ),
			'log'     => $log,
		);
		echo json_encode( $response );
		exit();
	}

} elseif ( $type == 'extract' ) {
	ob_start();
	$file_zip  = preg_replace( '/[\\/]/i', DIRECTORY_SEPARATOR, $_SESSION['villatheme-demodata-dir'] . DIRECTORY_SEPARATOR . $_SESSION['villatheme-demodata-file'] );
	$unzip_dir = dirname( $file_zip );
	WP_Filesystem();
	$unzipfile = unzip_file( $file_zip, $unzip_dir );
	if ( $unzipfile === true ) {
		$wooimport_file = $unzip_dir . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'woocommerce' . DIRECTORY_SEPARATOR . 'setting.txt';
		$next_step      = is_file( $wooimport_file ) ? 'woo_setting' : 'core';
		$log            = ob_get_clean();
		$response       = array(
			'step'    => 'extract',
			'next'    => $next_step,
			'return'  => true,
			'message' => sprintf( esc_html__( 'Extract demo data package to "%s" success', 'vi-importer' ), $unzip_dir ),
			'log'     => $log,
		);
		echo json_encode( $response );
		exit();
	} else {
		$log      = ob_get_clean();
		$response = array(
			'step'    => 'extract',
			'next'    => 'error',
			'return'  => false,
			'message' => esc_html__( 'There was an error unzipping demo data file.', 'vi-importer' ),
			'log'     => $log,
		);
		echo json_encode( $response );
		exit();
	}
}

// check cache directory
$data_cache_dir = $_SESSION['villatheme-demodata-dir'] . '/data/cache';
if ( ! is_dir( $data_cache_dir ) ) {
	wp_mkdir_p( $data_cache_dir ); // create cache directory 
}

//define( 'POST_COUNT', VILLA_INC . 'inc/admin/data/cache/count.txt' );
//define( 'MENU_MAPPING', VILLA_INC . 'inc/admin/data/cache/menus.txt' );
//define( 'MENU_ITEM_ORPHANS', VILLA_INC . 'inc/admin/data/cache/menu_item_orphans.txt' );
//define( 'PROCESS_TERM', VILLA_INC . 'inc/admin/data/cache/process_term.txt' );
//define( 'PROCESS_POSTS', VILLA_INC . 'inc/admin/data/cache/process_posts.txt' );
//define( 'MENU_MISSING', VILLA_INC . 'inc/admin/data/cache/menu_missing.txt' );
//define( 'URL_REMAP', VILLA_INC . 'inc/admin/data/cache/url_remap.txt' );
//define( 'POST_ORPHANS', VILLA_INC . 'inc/admin/data/cache/post_orphans.txt' );
//define( 'FEATURE_IMAGES', VILLA_INC . 'inc/admin/data/cache/feature_images.txt' );
//define( 'REV_IMPORT', VILLA_INC . 'inc/admin/data/cache/rev.txt' );
//define( 'MENU_CONFIG', VILLA_INC . 'inc/admin/data/menus.txt' );
//define( 'MENU_READING_CONFIG', VILLA_INC . 'inc/admin/data/menu_reading.txt' );

define( 'POST_COUNT', $_SESSION['villatheme-demodata-dir'] . '/data/cache/count.txt' );
define( 'POST_COUNT_TEST', $_SESSION['villatheme-demodata-dir'] . '/data/cache/count_test.txt' );
define( 'MENU_MAPPING', $_SESSION['villatheme-demodata-dir'] . '/data/cache/menus.txt' );
define( 'MENU_ITEM_ORPHANS', $_SESSION['villatheme-demodata-dir'] . '/data/cache/menu_item_orphans.txt' );
define( 'PROCESS_TERM', $_SESSION['villatheme-demodata-dir'] . '/data/cache/process_term.txt' );
define( 'PROCESS_POSTS', $_SESSION['villatheme-demodata-dir'] . '/data/cache/process_posts.txt' );
define( 'MENU_MISSING', $_SESSION['villatheme-demodata-dir'] . '/data/cache/menu_missing.txt' );
define( 'URL_REMAP', $_SESSION['villatheme-demodata-dir'] . '/data/cache/url_remap.txt' );
define( 'POST_ORPHANS', $_SESSION['villatheme-demodata-dir'] . '/data/cache/post_orphans.txt' );
define( 'FEATURE_IMAGES', $_SESSION['villatheme-demodata-dir'] . '/data/cache/feature_images.txt' );

define( 'REV_IMPORT', $_SESSION['villatheme-demodata-dir'] . '/data/cache/rev.txt' );
define( 'EXIST_REV_IMPORT', $_SESSION['villatheme-demodata-dir'] . '/data/revslider/' );

define( 'MENU_CONFIG', $_SESSION['villatheme-demodata-dir'] . '/data/menus.txt' );
define( 'MENU_READING_CONFIG', $_SESSION['villatheme-demodata-dir'] . '/data/menu_reading.txt' );

// Load Importer API
require_once ABSPATH . 'wp-admin/includes/import.php';
if ( file_exists( ABSPATH . 'wp-content/plugins/revslider/revslider_admin.php' ) && class_exists( 'UniteBaseAdminClassRev' ) ) {
	require_once( ABSPATH . 'wp-content/plugins/revslider/revslider_admin.php' );
}
$tp_importerError = false;
$import_filepath  = $_SESSION['villatheme-demodata-dir'] . '/data/demodata.xml';
if ( vi_importer_require() ) {
	$import_settingpath = $_SESSION['villatheme-demodata-dir'] . '/data/setting.json';
} else {
	$import_settingpath = $_SESSION['villatheme-demodata-dir'] . '/data/setting.txt';
}
$import_woo_setting = $_SESSION['villatheme-demodata-dir'] . '/data/woocommerce/setting.txt';
$widgets_json       = $_SESSION['villatheme-demodata-dir'] . '/data/widget/widget_data.json'; // widgets data file
//check if wp_importer, the base importer class is available, otherwise include it
if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) ) {
		require_once( $class_wp_importer );
	} else {
		echo '1';
		$tp_importerError = true;
	}
}

//check if the wp import class is available, this class handles the wordpress XML files. If not include it
//make sure to exclude the init function at the end of the file in kriesi_importer
if ( ! class_exists( 'WP_Import' ) ) {
	$class_wp_import = plugin_dir_path( __FILE__ ) . 'wordpress-importer.php';
	if ( file_exists( $class_wp_import ) ) {
		require_once( $class_wp_import );
	} else {
		echo $class_wp_import;
		$tp_importerError = true;
	}
}

if ( $tp_importerError !== false ) {
	echo "The Auto importing script could not be loaded. please use the wordpress importer and import the XML file that is located in your themes folder manually.";
} else {
	if ( class_exists( 'WP_Import' ) ) {
		include_once( plugin_dir_path( __FILE__ ) . 'tp-import-class.php' );
	}
	//	var_dump($import_filepath);
	//echo "\n";
	//var_dump(is_file( $import_filepath ));
	//if (!is_file($import_filepath) || !is_file($import_settingpath)) {
	//	die;
	if ( ! is_file( $import_filepath ) ) {
		$response = array(
			'step'    => 'check_demo_data_files',
			'next'    => '',
			'return'  => false,
			'message' => 'The XML file containing the demo content is not available or could not be read in <pre>' . get_template_directory() . '</pre><br/> You might want to try to set the file permission to chmod 777.<br/>If this doesn\'t work please use the wordpress importer and import the XML file (should be located in your themes folder: dummy.xml) manually <a href="/wp-admin/import.php">here.</a>',
			'logs'    => ent2ncr( $import_filepath ) . ' not found',
		);
		echo json_encode( $response );
	} else {
		if ( ! isset( $custom_export ) ) {

			$wp_import = new ob_wp_import();
			$type      = $_REQUEST['type'];

			ob_start();
			switch ( trim( $type ) ) {
				case 'woo_setting':
					if ( is_file( $import_woo_setting ) ) {
						if ( ! $wp_import->import_woosetting( $import_woo_setting ) ) {
							ob_end_clean();
							echo ent2ncr( $return->get_error_message() );

							return;
						}
					}
					$log      = ob_get_clean();
					$response = array(
						'step'    => 'woo_setting',
						'next'    => 'core',
						'return'  => true,
						'message' => esc_html__( 'Import woo setting success', 'vi-importer' ),
						'logs'    => $log,
					);
					echo json_encode( $response );
					//					echo 'core';

					break;
				case 'core':
					$wp_import->fetch_attachments = true;
					if ( $wp_import->import( $import_filepath ) == 0 ) {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'core',
							'next'    => 'core',
							'return'  => true,
							'message' => '',
							'logs'    => $log,
						);
						echo json_encode( $response );

						//						echo 'core';
						return;
					}
					$log      = ob_get_clean();
					$response = array(
						'step'    => 'core',
						'next'    => 'widgets',
						'return'  => true,
						'message' => '',
						'logs'    => $log,
					);
					echo json_encode( $response );
					//					echo 'widgets';

					break;

				case 'menus':
					$next_step = is_dir( EXIST_REV_IMPORT ) ? 'slider' : 'done';

					if ( ! $wp_import->set_menus() ) {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'menus',
							'next'    => 'error',
							'return'  => false,
							'message' => esc_html__( 'Error on importing menus', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'error';
					} else {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'menus',
							'next'    => $next_step,
							'return'  => true,
							'message' => esc_html__( 'Import menus success', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'slider';
					}
					break;

				case 'widgets':
					$widgets_json = $_SESSION['villatheme-demodata-dir'] . '/data/widget/widget_data.json'; // widgets data file

					$widgets_json = file_get_contents( $widgets_json );

					if ( ! $wp_import->import_widgets( $widgets_json ) ) {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'widgets',
							'next'    => 'error',
							'return'  => false,
							'message' => esc_html__( 'Error on importing widgets', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'error';
					} else {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'widgets',
							'next'    => 'setting',
							'return'  => true,
							'message' => esc_html__( 'Importing widgets success', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'setting';
					}
					break;
				case 'setting':
					if ( ! is_file( $import_settingpath ) ) {
						echo 'File not found "' . $import_settingpath . '"';
					}
					if ( ! $wp_import->set_options( $import_settingpath ) ) {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'setting',
							'next'    => 'error',
							'return'  => false,
							'message' => esc_html__( 'Error on import setting', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'error';
					} else {
						$wp_import->updateTaxCount();
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'setting',
							'next'    => 'menus',
							'return'  => true,
							'message' => esc_html__( 'Import setting success', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'menus';
					}
					break;
				case 'slider':
					$check_slider = $wp_import->import_revslider();
					if ( ! $check_slider ) {
						$log = ob_get_clean();
						if ( class_exists( 'RevSlider' ) ) {
							$response = array(
								'step'    => 'slider',
								'next'    => 'revolution_error',
								'return'  => false,
								'message' => esc_html__( 'Import slide error', 'vi-importer' ),
								'logs'    => $log,
							);
							echo json_encode( $response );
							//                          echo 'revolution_error';
						} else {
							$response = array(
								'step'    => 'slider',
								'next'    => 'done',
								'return'  => false,
								'message' => esc_html__( 'Slide is not imported', 'vi-importer' ),
								'logs'    => $log,
							);
							echo json_encode( $response );
							//                          echo 'done';
						}
					} elseif ( $check_slider == 1 ) {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'slider',
							'next'    => 'slider',
							'return'  => true,
							'message' => '',
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'slider';
					} else {
						$log      = ob_get_clean();
						$response = array(
							'step'    => 'slider',
							'next'    => 'done',
							'return'  => true,
							'message' => esc_html__( 'Import demo data success', 'vi-importer' ),
							'logs'    => $log,
						);
						echo json_encode( $response );
						//						echo 'done';
					}
					break;
			}
		}
	}
}




