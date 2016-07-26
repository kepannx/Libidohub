<?php
/**
 * Shop breadcrumb
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.3.0
 * @see           woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

	echo ent2ncr($wrap_before);

	foreach ( $breadcrumb as $key => $crumb ) {


		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo ent2ncr($before);
			echo '<a href="' . esc_url( $crumb[1] ) . '"><span>' . esc_html( $crumb[0] ) . '</span></a>';
			echo ent2ncr($after);
		} else {
			echo '<li>';
			echo esc_html( $crumb[0] );
			echo '</li>';

		}


		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<li><i class="separate">';
			echo ent2ncr($delimiter);
			echo '</i></li>';
		}

	}
	echo ent2ncr($wrap_after);
}
