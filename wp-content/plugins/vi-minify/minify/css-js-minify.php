<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

define( 'VI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Load config class
include( VI_PLUGIN_DIR . 'classes/viConfig.php' );

// Do we gzip when caching (needed early to load viCache.php)
define( 'VI_CACHE_NOGZIP', 1 );

// Load cache class
include( VI_PLUGIN_DIR . '/classes/viCache.php' );

// wp-content dir, dirname of AO cache dir and AO-prefix can be overridden in wp-config.php
if ( ! defined( 'VI_CACHE_CHILD_DIR' ) ) {
	define( 'VI_CACHE_CHILD_DIR', '/cache/vi/' );
}
if ( ! defined( 'VI_WP_CONTENT_NAME' ) ) {
	define( 'VI_WP_CONTENT_NAME', '/wp-content' );
}
if ( ! defined( 'VI_CACHEFILE_PREFIX' ) ) {
	define( 'VI_CACHEFILE_PREFIX', 'vi_' );
}

// Plugin dir constants (plugin url's defined later to accomodate domain mapped sites)
if ( is_multisite() ) {
	$blog_id = get_current_blog_id();
	define( 'VI_CACHE_DIR', WP_CONTENT_DIR . VI_CACHE_CHILD_DIR . $blog_id . '/' );
} else {
	define( 'VI_CACHE_DIR', WP_CONTENT_DIR . VI_CACHE_CHILD_DIR );
}
define( 'VI_CACHE_DELAY', true );
define( 'VI_ROOT_DIR', str_replace( VI_WP_CONTENT_NAME, '', WP_CONTENT_DIR ) );

// Initialize the cache at least once
$conf = viConfig::instance();

function vi_cache_unavailable_notice() {
	echo '<div class="error"><p>';
	_e( 'Autoptimize cannot write to the cache directory (default: /wp-content/cache/vi), please fix to enable CSS/ JS optimization!', 'dukan' );
	echo '</p></div>';
}


// Set up the buffering
function vi_start_buffering() {
	if ( is_user_logged_in() ) {
		return false;
	}
	$vi_noptimize = false;

	// noptimize in qs to get non-optimized page for debugging
	if ( array_key_exists( "vi_noptimize", $_GET ) ) {
		if ( $_GET["vi_noptimize"] === "1" ) {
			$vi_noptimize = true;
		}
	}

	// check for DONOTMINIFY constant as used by e.g. WooCommerce POS
	if ( defined( 'DONOTMINIFY' ) && ( constant( 'DONOTMINIFY' ) === true || constant( 'DONOTMINIFY' ) === "true" ) ) {
		$vi_noptimize = true;
	}

	// filter you can use to block autoptimization on your own terms
	$vi_noptimize = (bool) apply_filters( 'vi_filter_noptimize', $vi_noptimize );

	if ( ! is_feed() && ! $vi_noptimize && ! is_admin() ) {
		// Config element
		$conf = viConfig::instance();

		// Load our base class
		include( VI_PLUGIN_DIR . 'classes/viBase.php' );

		if ( $conf->get( 'vi_js' ) ) {
			include( VI_PLUGIN_DIR . 'classes/viScripts.php' );
			if ( ! class_exists( 'JSMin' ) ) {
				if ( defined( 'VI_LEGACY_MINIFIERS' ) ) {
					@include( VI_PLUGIN_DIR . 'classes/external/php/jsmin-1.1.1.php' );
				} else {
					@include( VI_PLUGIN_DIR . 'classes/external/php/minify-2.1.7-jsmin.php' );
				}
			}
			if ( ! defined( 'CONCATENATE_SCRIPTS' ) ) {
				define( 'CONCATENATE_SCRIPTS', false );
			}
			if ( ! defined( 'COMPRESS_SCRIPTS' ) ) {
				define( 'COMPRESS_SCRIPTS', false );
			}
		}

		if ( $conf->get( 'vi_css' ) ) {
			include( VI_PLUGIN_DIR . 'classes/viStyles.php' );
			if ( defined( 'VI_LEGACY_MINIFIERS' ) ) {
				if ( ! class_exists( 'Minify_CSS_Compressor' ) ) {
					@include( VI_PLUGIN_DIR . 'classes/external/php/minify-css-compressor.php' );
				}
			} else {
				if ( ! class_exists( 'CSSmin' ) ) {
					@include( VI_PLUGIN_DIR . 'classes/external/php/yui-php-cssmin-2.4.8-4_fgo.php' );
				}
			}
			if ( ! defined( 'COMPRESS_CSS' ) ) {
				define( 'COMPRESS_CSS', false );
			}
		}

		// Now, start the real thing!
		ob_start( 'vi_end_buffering' );
	}
}

// Action on end, this is where the magic happens
function vi_end_buffering( $content ) {

	if ( stripos( $content, "<html" ) === false || stripos( $content, "<xsl:stylesheet" ) !== false ) {
		return $content;
	}

	// load URL constants as late as possible to allow domain mapper to kick in
	if ( function_exists( "domain_mapping_siteurl" ) ) {
		define( 'VI_WP_SITE_URL', domain_mapping_siteurl( get_current_blog_id() ) );
		define( 'VI_WP_CONTENT_URL', str_replace( get_original_url( VI_WP_SITE_URL ), VI_WP_SITE_URL, content_url() ) );
	} else {
		define( 'VI_WP_SITE_URL', site_url() );
		define( 'VI_WP_CONTENT_URL', content_url() );
	}

	if ( is_multisite() ) {
		$blog_id = get_current_blog_id();
		define( 'VI_CACHE_URL', VI_WP_CONTENT_URL . VI_CACHE_CHILD_DIR . $blog_id . '/' );
	} else {
		define( 'VI_CACHE_URL', VI_WP_CONTENT_URL . VI_CACHE_CHILD_DIR );
	}
	define( 'VI_WP_ROOT_URL', str_replace( VI_WP_CONTENT_NAME, '', VI_WP_CONTENT_URL ) );

	// Config element
	$conf = viConfig::instance();

	// Choose the classes
	$classes = array();
	if ( $conf->get( 'vi_js' ) ) {
		$classes[] = 'viScripts';
	}
	if ( $conf->get( 'vi_css' ) ) {
		$classes[] = 'viStyles';
	}


	// Set some options
	$classoptions = array(
		'viScripts' => array(
			'justhead'       => $conf->get( 'vi_js_justhead' ),
			'forcehead'      => $conf->get( 'vi_js_forcehead' ),
			'trycatch'       => $conf->get( 'vi_js_trycatch' ),
			'js_exclude'     => $conf->get( 'vi_js_exclude' ),
			'cdn_url'        => $conf->get( 'vi_cdn_url' ),
			'include_inline' => $conf->get( 'vi_js_include_inline' )
		),
		'viStyles'  => array(
			'justhead'       => $conf->get( 'vi_css_justhead' ),
			'datauris'       => $conf->get( 'vi_css_datauris' ),
			'defer'          => $conf->get( 'vi_css_defer' ),
			'defer_inline'   => $conf->get( 'vi_css_defer_inline' ),
			'inline'         => $conf->get( 'vi_css_inline' ),
			'css_exclude'    => $conf->get( 'vi_css_exclude' ),
			'cdn_url'        => $conf->get( 'vi_cdn_url' ),
			'include_inline' => $conf->get( 'vi_css_include_inline' ),
			'nogooglefont'   => $conf->get( 'vi_css_nogooglefont' )
		)
	);

	$content = apply_filters( 'vi_filter_html_before_minify', $content );
	// Run the classes
	foreach ( $classes as $name ) {
		$instance = new $name( $content );
		if ( $instance->read( $classoptions[$name] ) ) {
			$instance->minify();
			$instance->cache();
			$content = $instance->getcontent();
		}
		unset( $instance );
	}
	$content = apply_filters( 'vi_html_after_minify', $content );

	return $content;
}

function vi_flush_pagecache( $nothing ) {
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		if ( is_multisite() ) {
			$blog_id = get_current_blog_id();
			wp_cache_clear_cache( $blog_id );
		} else {
			wp_cache_clear_cache();
		}
	} else if ( has_action( 'cachify_flush_cache' ) ) {
		do_action( 'cachify_flush_cache' );
	} else if ( function_exists( 'w3tc_pgcache_flush' ) ) {
		w3tc_pgcache_flush(); // w3 total cache
	} else if ( function_exists( 'hyper_cache_invalidate' ) ) {
		hyper_cache_invalidate(); // hypercache
	} else if ( function_exists( 'wp_fast_cache_bulk_delete_all' ) ) {
		wp_fast_cache_bulk_delete_all(); // wp fast cache
	} else if ( class_exists( "WpFastestCache" ) ) {
		$wpfc = new WpFastestCache(); // wp fastest cache
		$wpfc->deleteCache();
	} else if ( class_exists( "c_ws_plugin__qcache_purging_routines" ) ) {
		c_ws_plugin__qcache_purging_routines::purge_cache_dir(); // quick cache
	} else if ( class_exists( "zencache" ) ) {
		zencache::clear(); // zen cache
	} else if ( file_exists( WP_CONTENT_DIR . '/wp-cache-config.php' ) && function_exists( 'prune_super_cache' ) ) {
		// fallback for WP-Super-Cache
		global $cache_path;
		if ( is_multisite() ) {
			$blog_id = get_current_blog_id();
			prune_super_cache( get_supercache_dir( $blog_id ), true );
			prune_super_cache( $cache_path . 'blogs/', true );
		} else {
			prune_super_cache( $cache_path . 'supercache/', true );
			prune_super_cache( $cache_path, true );
		}
	}
}

add_action( 'vi_flush_pagecache', 'vi_flush_pagecache', 10, 1 );

if ( viCache::cacheavail() ) {

	$conf = viConfig::instance();

	if ( ( $conf->get( 'vi_js' ) || $conf->get( 'vi_css' ) ) ) {
		// Hook to wordpress
		if ( defined( 'VI_INIT_EARLIER' ) ) {
			add_action( 'init', 'vi_start_buffering', - 1 );
		} else {

			add_action( 'template_redirect', 'vi_start_buffering', 2 );
		}
	}
}

include_once( 'classlesses/viCacheChecker.php' );

// Do not pollute other plugins
unset( $conf );
