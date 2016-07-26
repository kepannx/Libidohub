<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

<?php
get_template_part( 'inc/templates/heading', 'top' );

if ( is_shop() && ( get_option( 'woocommerce_shop_page_display' ) == 'both' ) ) {
	$terms        = get_terms( 'product_cat' );
	$current_term = get_queried_object();
	if ( ! empty( $terms ) ) {
		// create a link which should link to the shop
		$all_link = get_post_type_archive_link( 'product' );
		echo '<div class="list-category-product"><ul>';
		foreach ( $terms as $key => $term ) {
			$link = get_term_link( $term, 'product_cat' );
			if ( ! is_wp_error( $link ) ) {
				$class_string = "";
				if ( ! empty( $current_term->name ) && $current_term->name === $term->name ) {
					$class_string = ' class="active"';
				} else {
					$class_string = ' class="inactive"';
				}

				echo '<li><a href="', $link, '"', $class_string, '>', $term->name, '</a></li>';
			}
		}
		echo '</ul></div>';
	}
}

do_action( 'cavada_wrapper_loop_start' );

/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>


<?php //do_action( 'woocommerce_archive_description' ); ?>

<?php if ( have_posts() ) : ?>
	<?php
	/**
	 * woocommerce_before_shop_loop hook
	 *
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );
	?>
	<div class="clear"></div>
	<?php woocommerce_product_loop_start(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<?php wc_get_template_part( 'content', 'product' ); ?>

	<?php endwhile; // end of the loop. ?>

	<?php woocommerce_product_loop_end(); ?>

	<?php
	/**
	 * woocommerce_after_shop_loop hook
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
	?>

<?php elseif ( ! woocommerce_product_subcategories( array(
	'before' => woocommerce_product_loop_start( false ),
	'after'  => woocommerce_product_loop_end( false )
) )
) : ?>

	<?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>

<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php
/**
 * woocommerce_sidebar hook
 *
 * @hooked woocommerce_get_sidebar - 10
 */

do_action( 'cavada_wrapper_loop_end' );

?>

<?php get_footer( 'shop' ); ?>