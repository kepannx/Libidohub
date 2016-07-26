<?php
/**
 * Single Product title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$product = cavada_get_product();
?>
<h1 class="product_title entry-title"><?php the_title(); ?></h1>

<div class="single-price">
	<p class="price"><?php echo ent2ncr($product->get_price_html()); ?></p>
</div>