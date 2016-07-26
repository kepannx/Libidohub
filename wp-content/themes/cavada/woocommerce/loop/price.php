<?php
/**
 * Loop Price
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = cavada_get_product();
if ( $price_html = $product->get_price_html() ) : ?>
	<span class="price">

		<?php echo ent2ncr($price_html); ?>
	</span>
<?php endif; ?>

