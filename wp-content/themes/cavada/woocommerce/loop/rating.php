<?php
/**
 * Loop Rating
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product = cavada_get_product();

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
	return;
}
?>

<?php if ( $rating_html = $product->get_rating_html() ) : ?>
	<?php echo ent2ncr( $rating_html ); ?>
<?php endif; ?>
