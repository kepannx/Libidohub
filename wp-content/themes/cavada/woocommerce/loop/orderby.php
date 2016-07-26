<?php
/**
 * Show options for ordering
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$cavada_data = cavada_get_data_themeoptions();
if ( ! isset( $cavada_data['ajax_settings_run'] ) ) {
	$cavada_data['ajax_settings_run'] = 0;
}
?>

<div class="shop-top">
	<a href="#" class="shop-top-button btn btn-default pull-right"><?php esc_html_e( 'Filter', 'cavada' ) ?></a>

	<div id="shop-top" class="widget-area">
		<?php

		if ( isset( $cavada_data['ajax_settings_run'] ) && ( $cavada_data['ajax_settings_run'] == 'no' || ! $cavada_data['ajax_settings_run'] ) ) { ?>
			<form class="woocommerce-ordering" method="get">
				<select name="orderby" class="orderby">
					<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
						<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
					<?php endforeach; ?>
				</select>
				<?php
				// Keep query string vars intact
				foreach ( $_GET as $key => $val ) {
					if ( 'orderby' === $key || 'submit' === $key ) {
						continue;
					}
					if ( is_array( $val ) ) {
						foreach ( $val as $innerVal ) {
							echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
						}
					} else {
						echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
					}
				}
				?>
			</form>
		<?php } else { ?>
			<?php
			if ( is_ssl() ) {
				$link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			} else {
				$link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			}
			?>
			<aside class="col-sm-3">
				<h3 class="widget-title">
					<span><em class="first"><?php echo esc_html__( 'Order', 'cavada' ) ?></em> <?php echo esc_html__( 'By', 'cavada' ) ?></span>
				</h3>
				<ul class="orderby-ajax list-unstyled">

					<?php foreach ( $catalog_orderby_options as $id => $name ) {
						$link = add_query_arg( 'orderby', $id, $link );
						?>
						<li>
							<a class="<?php echo selected( $orderby, $id, false ) ? 'active' : '' ?>" data-id="<?php echo esc_attr( $id ); ?>" href="<?php echo esc_url( $link ) ?>"><?php echo esc_html( $name ); ?></a
						</li>
					<?php } ?>
				</ul>
			</aside>
		<?php } ?>
		<?php
		$class_col = cavada_wrapper_layout();
		if ( $class_col == 'col-sm-12 full-width' ) {
			if ( get_post_type() == "product" && is_archive() ) {
				dynamic_sidebar( 'shop_top' );
			}
		}
		?>
	</div>
</div>