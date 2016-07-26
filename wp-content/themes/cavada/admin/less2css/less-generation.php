<?php

/**
 * This class generates custom CSS into static CSS file in uploads folder
 * and enqueue it in the frontend
 *
 * CSS is generated only when theme options is saved (changed)
 * Works with LESS (for unlimited color schemes)
 */
require "lessc.inc.php";


function themeoptions_variation( $cavada_data ) {
	$theme_options = array(
		'body_background',
		'body_color_primary',
		//typography
		'body_color',
		'body_font_size',
		'font_weight_body',
		'font_size_title_widget',
		'font_size_h1',
		'font_weight_h1',
		'font_style_h1',
		'text_transform_h1',
		'font_size_h2',
		'font_weight_h2',
		'font_style_h2',
		'text_transform_h2',
		'font_size_h3',
		'font_weight_h3',
		'font_style_h3',
		'text_transform_h3',
		'font_size_h4',
		'font_weight_h4',
		'font_style_h4',
		'text_transform_h4',
		'font_size_h5',
		'font_weight_h5',
		'font_style_h5',
		'text_transform_h5',
		'font_size_h6',
		'font_weight_h6',
		'font_style_h6',
		'text_transform_h6',
		'headings_color',
		//topbar
		'bg_topbar_color',
		'border_topbar_color',
		'topbar_color',
		//Header
		'bg_header_color',
		'border_menu_top',
		'border_menu_bottom',
		'header_text_color',
		'header_color_hover',
		'header_area_text_color',
		'header_area_bg_color',
		'font_size_main_menu',
		'font_weight_main_menu',
		'sticky_bg_main_menu_color',
		'sticky_main_menu_text_color',
		'sticky_main_menu_text_hover_color',
		'sub_menu_bg_color',
		'sub_menu_text_color',
		'sub_menu_text_color_hover',
		'bg_mobile_menu_color',
		'mobile_menu_text_color',
		'mobile_menu_text_hover_color',
		'width_logo',
		//'vi_background_color',
		//footer options
		'bg_footer_color',
		'title_footer_color',
		'text_footer_color',
		'footer_font_size',
		'footer_font_title_size',
		'bg_copyright_color',
		'text_copyright_color',
		'bg_top_footer_color',
		'border_footer_color',
		'border_style',
		'text_top_footer_color',
		'copyright_font_size',
		'404_color'
	);

	$config_less = '';
	foreach ( $theme_options AS $key ) {
		if ( isset( $cavada_data[$key] ) ) {
			$option_data = $cavada_data[$key];
		} else {
			$option_data = '';
		}
		if ( $option_data <> '' ) {
			$config_less .= "@{$key}: {$option_data};\n";
		}
	}

	$cavada_options = get_theme_mods();
	$cavada_options = apply_filters( 'of_options_after_load', $cavada_options );
	$font               = $font_heading = "'Helvetica Neue',Helvetica,Arial,sans-serif";
	if ( ( $cavada_options['wd_body_googlefont_enable'] == '0' ) && ( $cavada_options['wd_body_googlefont'] != 'Select Font' ) ) {
		$font = '"' . $cavada_options['wd_body_googlefont'] . '", Arial, Helvetica, sans-serif';
	} elseif ( ( $cavada_options['wd_body_googlefont_enable'] == '1' ) && ( $cavada_options['wd_body_family'] != 'Select Font' ) ) {
		$font = $cavada_options['wd_body_family'];
	}
	if ( ( $cavada_options['wd_heading_googlefont_enable'] == '0' ) && ( $cavada_options['wd_heading_googlefont'] != 'Select Font' ) ) {
		$font_heading = '"' . $cavada_options['wd_heading_googlefont'] . '", Arial, Helvetica, sans-serif';
	} elseif ( ( $cavada_options['wd_heading_googlefont_enable'] == '1' ) && ( $cavada_options['wd_heading_family'] != 'Select Font' ) ) {
		$font_heading = $cavada_options['wd_heading_family'];
	}
	$config_less .= "@body-font-family: {$font};\n";
	$config_less .= "@heading-font-family: {$font_heading};\n";

	return $config_less;
}

/**
 * Generate custom.css file from Theme Options
 * @return mixed|string
 */

function custom_css() {
	$cavada_options = get_theme_mods();
	$cavada_options = apply_filters( 'of_options_after_load', $cavada_options );

	$custom_css = '';
	if ( isset( $cavada_options['box_layout'] ) && $cavada_options['box_layout'] == 'boxed' ) {
		if ( isset( $cavada_options['bg_pattern_upload'] ) && $cavada_options['bg_pattern_upload'] <> '' ) {
			$custom_css .= ' body{background-image: url("' . $cavada_options['bg_pattern_upload'] . '"); }
						body{
							 background-repeat: ' . $cavada_options['bg_repeat'] . ';
							 background-position: ' . $cavada_options['bg_position'] . ';
							 background-attachment: ' . $cavada_options['bg_attachment'] . ';
						}
 		';
		}
		if ( ( isset( $cavada_options['user_bg_pattern'] ) && $cavada_options['user_bg_pattern'] == '1' ) && $cavada_options['bg_pattern'] <> '' ) {
			$custom_css .= ' body{background-image: url("' . $cavada_options['bg_pattern'] . '"); }
 		';
		}
	}
	if ( isset( $cavada_options['bg_404_images'] ) && $cavada_options['bg_404_images'] <> '' ) {
		$custom_css .= '.error404{background-image: url("' . $cavada_options['bg_404_images'] . '"); }';
	}
	$custom_css .= $cavada_options['css_custom'];
	$custom_css = str_replace( "\n", '', $custom_css );

	return $custom_css;
}

define( 'CAVADA_UPLOADS_FOLDER', trailingslashit( WP_CONTENT_DIR ) . 'uploads/' );


function generate( $theme_option_variations ) {
	WP_Filesystem();
	global $wp_filesystem; /* already initialised the Filesystem API previously */

	$css                    = "";
	$fileout                = CAVADA_THEME_DIR . "less/theme-options.less";
	$themeoptions_variation = themeoptions_variation( $theme_option_variations );
	$content_file_options   = $themeoptions_variation;

	$content_file_options .= $wp_filesystem->get_contents( $fileout );
	$compiler = new lessc;
	$compiler->setFormatter( 'compressed' );
	$css .= $compiler->compile( $content_file_options );
	$css .= custom_css();

	if ( is_multisite() ) {
		// Write the rest to specific site style-ID.css
		$site_ID = '-' . get_current_blog_id();
		if ( !$wp_filesystem->put_contents( CAVADA_UPLOADS_FOLDER . 'vi_cavada' . $site_ID . '.css', $css ) ) {
			@chmod( CAVADA_UPLOADS_FOLDER . 'vi_cavada' . $site_ID . '.css' );
			$wp_filesystem->put_contents( CAVADA_UPLOADS_FOLDER . 'vi_cavada' . $site_ID . '.css', $css );
		}
	} else {
		if ( !$wp_filesystem->put_contents( CAVADA_UPLOADS_FOLDER . 'vi_cavada.css', $css ) ) {
			@chmod( CAVADA_UPLOADS_FOLDER . 'vi_cavada.css' );
			$wp_filesystem->put_contents( CAVADA_UPLOADS_FOLDER . 'vi_cavada.css', $css );
		}
	}
}