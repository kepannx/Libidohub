<?php
/**
 * Single Product Up-Sells
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$product          = cavada_get_product();
$woocommerce_loop = cavada_get_woo_loop();
$upsells          = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) {
	return;
}
$posts_per_page = 4;
$meta_query     = WC()->query->get_meta_query();

$args     = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);
$products = new WP_Query( $args );


if ( $products->have_posts() ) : ?>

	<div class="upsells-products">
		<h2 class="sub-title"><span><?php esc_html_e( 'You May also like', 'cavada' ); ?></span></h2>

		<ul class="product-grid category-product-list row">

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product-grid' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();