<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* 
 * cachechecker code
 * new in AO 2.0
 * 
 * daily cronned job (filter to change freq. + filter to disable)
 * checks if cachesize is > 0.5GB (filter to change maxsize)
 * if so an option is set
 * if that option is set, notice on admin is shown
 * 
 */

if (is_admin()) {
	add_action('plugins_loaded','vi_cachechecker_setup');
}

function vi_cachechecker_setup() {
	$doCacheCheck = (bool) apply_filters( 'vi_filter_cachecheck_do', true);
	$cacheCheckSchedule = wp_get_schedule( 'vi_cachechecker' );
	if (!$cacheCheckSchedule && $doCacheCheck) {
		$AOCCfreq = apply_filters('vi_filter_cachecheck_frequency','daily');
		if (!in_array($AOCCfreq,array('hourly','daily','monthly'))) {
			$AOCCfreq='daily';
		}
		wp_schedule_event(time(), $AOCCfreq, 'vi_cachechecker');
	} else if ($cacheCheckSchedule && !$doCacheCheck) {
		wp_clear_scheduled_hook( 'vi_cachechecker' );
	}
}

add_action('vi_cachechecker', 'vi_cachechecker_cronjob');
function vi_cachechecker_cronjob() {
	$maxSize = (int) apply_filters( "vi_filter_cachecheck_maxsize", 512000);
	$doCacheCheck = (bool) apply_filters( "vi_filter_cachecheck_do", true);
	$statArr=viCache::stats();
	$cacheSize=round($statArr[1]/1024);
	if (($cacheSize>$maxSize) && ($doCacheCheck)) {
		update_option("vi_cachesize_notice",true);
	}
}

add_action('admin_notices', 'vi_cachechecker_notice');
function vi_cachechecker_notice() {
	if ((bool) get_option("vi_cachesize_notice",false)) {
		$statArr=viCache::stats();
		$cacheSize=round($statArr[1]/1024);
		echo '<div class="update-nag">';
		_e('Autoptimize\'s cache size is getting big, consider purging the cache.<br /><br />Have a look at <a href="https://wordpress.org/plugins/vi/faq/" target="_blank">the Autoptimize FAQ</a> to see how you can keep the cache size under control.', 'dukan' );
		echo '</div>';
		update_option("vi_cachesize_notice",false);
	}
}
