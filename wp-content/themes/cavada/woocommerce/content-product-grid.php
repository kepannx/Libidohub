<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product          = cavada_get_product();
$woocommerce_loop = cavada_get_woo_loop();
$wp_query         = cavada_get_wp_query();
$cavada_data  = cavada_get_data_themeoptions();
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid


// Ensure visibility
if ( !$product || !$product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop'] ++;

$column_product = 3;

//

// Extra post classes
$classes   = array();
$classes[] = 'item-product col-md-' . $column_product . ' col-sm-6';

?>
<li <?php post_class( $classes ); ?> itemscope itemtype="http://schema.org/Product">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<div class="product-top">
		<a href="<?php the_permalink(); ?>" class="product-image">
			<?php
			$int_post_date    = strtotime( get_the_date( 'Y/m/d' ) );
			$date_current     = current_time( 'Y/m/d' );
			$int_date_current = strtotime( $date_current );
			$date_between     = $int_date_current - $int_post_date;
			if ( $date_between < 30 * 24 * 60 * 60 ) {
				echo '<span class="new">'.esc_html__('New','cavada').'</span>';
			}
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</a>

		<div class="controls">
			<?php
			echo '<div class="add-to-cart">';
			/**
			 * woocommerce_after_shop_loop_item hook
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			echo '</div>';
			?>
			<ul class="icon-links">
				<?php if ( class_exists( 'YITH_WCWL' ) ) {
					echo '<li class="wish-list">' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
				} ?>
				<?php
				if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active_for_network( 'yith-woocommerce-compare/init.php' ) ) {
					echo '<li><a href="' . esc_url( get_permalink( $product->id ) ) . '&amp;action=yith-woocompare-add-product&amp;id=' . esc_attr( $product->id ) . '" class="compare button" data-product_id="' . esc_attr( $product->id ) . '" title="' . esc_html__( "Compare", "cavada" ) . '"></a></li>';
				}
				?>
				<?php echo '<li><div class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="fa fa-search"></i></a></div></li>'; ?>
			</ul>
		</div>
	</div>
	<div class="product-desc">
		<h3 class="product-title">
			<a href="<?php the_permalink(); ?>"><span><?php the_title(); ?></span></a>
			<?php
			/**
			 * @hooked woocommerce_template_loop_rating - 5
			 */
			do_action( 'woocommerce_after_shop_loop_item_title_price' );
			?>
		</h3>
		<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook
		 * @hooked overwrite woocommerce_template_loop_price - 10
		 */

		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</div>
</li>

