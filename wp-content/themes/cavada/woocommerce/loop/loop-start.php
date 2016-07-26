<?php
/**
 * Product Loop Start
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */
$cavada_data = cavada_get_data_themeoptions();
//product_style
?>
<ul class="<?php if ( isset( $cavada_data['product_style'] ) ) {
	echo esc_attr( $cavada_data['product_style'] );
} else {
	echo 'product-grid';
} ?> category-product-list row">