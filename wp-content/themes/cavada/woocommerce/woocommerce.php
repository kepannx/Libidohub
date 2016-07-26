<?php
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-smallscreen'] );    // Remove the smallscreen optimisation
	return $enqueue_styles;
}

// custom hook content product
add_action( 'woocommerce_shop_description', 'woocommerce_content_description', 20 );
if ( ! function_exists( 'woocommerce_content_description' ) ) {
	function woocommerce_content_description() {
		global $post;
		if ( ! $post->post_excerpt ) {
			return;
		}
		?>
		<div class="clear"></div>
		<div class="description">
			<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
		</div>
		<?php
	}
}
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) {
	function woocommerce_template_loop_product_thumbnail() {
		global $product;
		$attachment_ids = $product->get_gallery_attachment_ids();

		echo cavada_get_the_post_thumbnail( $product->ID, apply_filters( 'shop_catalog', 'shop_catalog' ), array( 'class' => 'primary-image vi-load' ) );
		if ( isset( $attachment_ids[0] ) ) {
			echo cavada_get_attachment_image( $attachment_ids[0], apply_filters( 'shop_catalog', 'shop_catalog' ), '', array(), false );
		}

	}
}
add_action( 'woocommerce_before_shortcode_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 12 );

add_action( 'woocommerce_after_shop_loop_item_title_price', 'woocommerce_template_loop_price', 10 );

add_action( 'woocommerce_custom_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_custom_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_stock', 11 );
if ( ! function_exists( 'woocommerce_template_single_stock' ) ) {
	function woocommerce_template_single_stock() {
		global $product;
		if ( $product->product_type == 'simple' ) {
			$availability      = $product->get_availability();
			$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
			echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
		}
	}
}


//////////////////////////////////////
add_filter( 'loop_shop_per_page', 'cavada_loop_shop_per_page' );
function cavada_loop_shop_per_page() {
	global $cavada_data;
	parse_str( $_SERVER['QUERY_STRING'], $params );
	if ( isset( $cavada_data['number_per_page'] ) && $cavada_data['number_per_page'] ) {
		$per_page = $cavada_data['number_per_page'];
	} else {
		$per_page = 12;
	}
	$pc = ! empty( $params['product_count'] ) ? $params['product_count'] : $per_page;

	return $pc;
}


// Override WooCommerce Widgets
add_action( 'widgets_init', 'cavada_override_woocommerce_widgets', 15 );
function cavada_override_woocommerce_widgets() {
	if ( class_exists( 'WC_Widget_Cart' ) ) {
		unregister_widget( 'WC_Widget_Cart' );
		include_once( 'widgets/class-wc-widget-cart.php' );
		register_widget( 'CAVADA_Custom_WC_Widget_Cart' );
	}
}


/*****************quick view*****************/

add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_title', 5 );

add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_rating', 15 );
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_loop_add_to_cart_quick_view', 20 );
add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_excerpt', 30 );


add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_meta', 7 );

add_action( 'woocommerce_single_product_summary_quick', 'woocommerce_template_single_sharing', 50 );

if ( ! function_exists( 'woocommerce_template_loop_add_to_cart_quick_view' ) ) {
	function woocommerce_template_loop_add_to_cart_quick_view() {
		global $product;
		do_action( 'woocommerce_' . $product->product_type . '_add_to_cart' );
	}
}

/* PRODUCT QUICK VIEW */
add_action( 'wp_head', 'lazy_ajax', 0, 0 );
function lazy_ajax() {
	?>
	<script type="text/javascript">
		/* <![CDATA[ */
		var ajaxurl = "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>";
		/* ]]> */
	</script>
	<?php
}

add_action( 'wp_ajax_jck_quickview', 'jck_quickview' );
add_action( 'wp_ajax_nopriv_jck_quickview', 'jck_quickview' );
/** The Quickview Ajax Output **/
function jck_quickview() {
	global $post, $product;
	$prod_id = $_POST["product"];
	$post    = get_post( $prod_id );
	$product = wc_get_product( $prod_id );
	ob_start();
	?>
	<?php wc_get_template( 'content-single-product-lightbox.php' ); ?>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	echo ent2ncr( $output );
	die();
}

/* End PRODUCT QUICK VIEW */

/* custom WC_Widget_Cart */
function cavada_get_current_cart_info() {
	global $woocommerce;
	$items = count( $woocommerce->cart->get_cart() );

	return array(
		$items,
		get_woocommerce_currency_symbol()
	);
}

add_filter( 'add_to_cart_fragments', 'cavada_add_to_cart_success_ajax' );
function cavada_add_to_cart_success_ajax( $count_cat_product ) {
	list( $cart_items ) = cavada_get_current_cart_info();
	if ( $cart_items < 0 ) {
		$cart_items = '0';
	} else {
		$cart_items = $cart_items;
	}
	$count_cat_product['#header-mini-cart .cart-items-number .wrapper-number-total'] = '<span class="wrapper-number-total"><span class="wrapper-items-number">' . $cart_items . '</span></span>';

	return $count_cat_product;
}


// Change the breadcrumb separator
add_filter( 'woocommerce_breadcrumb_defaults', 'cavada_change_breadcrumb_delimiter' );
function cavada_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '&bull;';

	return $defaults;
}


// add button compare before button wishlist in single product
$yith_woocompare = cavada_get_yith_woocompare();
if ( isset( $yith_woocompare ) ) {
	remove_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 35 );
	add_action( 'woocommerce_single_product_summary', array( $yith_woocompare->obj, 'add_compare_link' ), 30 );
}
/*Close link*/
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );