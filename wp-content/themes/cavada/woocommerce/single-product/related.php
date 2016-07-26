<?php
/**
 * Related Products
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
if ( empty( $product ) || ! $product->exists() ) {
	return;
}
$posts_per_page = 4;
$related        = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) {
	return;
}


$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $related,
	'post__not_in'        => array( $product->id )
) );

$products = new WP_Query( $args );

if ( $products->have_posts() ) : ?>
	<div class="related-products">
		<h2 class="sub-title"><span><?php esc_html_e( 'Related Products', 'cavada' ); ?></span></h2>
		<ul class="product-grid category-product-list row">
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php wc_get_template_part( 'content', 'product-grid' ); ?>
			<?php endwhile; // end of the loop. ?>
			<?php woocommerce_product_loop_end(); ?>
	</div>
<?php endif;
wp_reset_postdata();
