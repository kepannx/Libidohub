<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
$product         = cavada_get_product();
$post            = cavada_get_post();
$cavada_data = cavada_get_data_themeoptions();
?>
<div id="content" class="quickview woocommerce">
	<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" class="product-info">
		<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/variation-form.min.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/assets/js/jquery.flexslider-min.js"></script>

		<script type="text/javascript">
			jQuery(function ($) {
				if (jQuery().flexslider && jQuery("#carousel").length >= 1) {
					var e = 100;
					if (typeof jQuery("#carousel").data("flexslider") != "undefined") {
						jQuery("#carousel").flexslider("destroy");
						jQuery("#slider").flexslider("destroy")
					}
					jQuery("#carousel").flexslider({
						animation    : "slide",
						controlNav   : !1,
						directionNav : 1,
						animationLoop: !1,
						slideshow    : !1,
						itemWidth    : 100,
						itemMargin   : 20,
						touch        : !1,
						useCSS       : !1,
						asNavFor     : "#slider",
						smoothHeight : !1
					});
					jQuery("#slider").flexslider({
						animation    : "slide",
						controlNav   : !1,
						directionNav : !1,
						animationLoop: !1,
						slideshow    : !1,
						smoothHeight : !1,
						touch        : !0,
						useCSS       : !1,
						sync         : "#carousel"
					})

				}
			});

		</script>
		<div class="left col-sm-6">

			<div id="slider" class="flexslider">
				<ul class="slides">
					<?php
					if ( has_post_thumbnail() ) {
						$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
						$image_title      = esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
						$attachment_count = count( $product->get_gallery_attachment_ids() );
						echo '<li>';
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $post->ID );
						echo '</li>';
					}
					$attachment_ids = $product->get_gallery_attachment_ids();
					?>
					<?php
					$loop = 0;
					foreach ( $attachment_ids as $attachment_id ) {
						$image_link = wp_get_attachment_url( $attachment_id );
						if ( ! $image_link ) {
							continue;
						}
						$classes[]   = 'image-' . $attachment_id;
						$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image_title = esc_attr( get_the_title( $attachment_id ) );
						echo '<li>';
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '%s', $image ), $post->ID );
						echo '</li>';
						$loop ++;
					}
					?>
				</ul>
			</div>
			<div id="carousel" class="flexslider thumbnail_product">
				<ul class="slides">
					<!-- items mirrored twice, total of 12 -->
					<?php
					if ( has_post_thumbnail() ) {

						$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
						$image_title      = esc_attr( get_the_title( get_post_thumbnail_id() ) );
						$image_link       = wp_get_attachment_url( get_post_thumbnail_id() );
						$attachment_count = count( $product->get_gallery_attachment_ids() );

						if ( $attachment_count > 0 ) {
							$gallery = '[product-gallery]';
						} else {
							$gallery = '';
						}

						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<li>%s</li>', $image ), $post->ID );

					}
					?>
					<?php

					$loop = 0;


					foreach ( $attachment_ids as $attachment_id ) {

						$image_link = wp_get_attachment_url( $attachment_id );

						if ( ! $image_link ) {
							continue;
						}

						$classes[] = 'image-' . $attachment_id;

						$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
						$image_class = esc_attr( implode( ' ', $classes ) );
						$image_title = esc_attr( get_the_title( $attachment_id ) );

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li>%s</li>', $image ), $attachment_id, $post->ID, $image_class );

						$loop ++;
					}

					?>        </ul>
			</div>
		</div>
		<div class="right col-sm-6">
			<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary_quick' );
			?>

		</div>
		<div class="clear"></div>
		<?php echo '<a href="' . esc_attr( get_the_permalink( $product->id ) ) . '" target="_top" class="quick-view-detail">' . esc_html__( 'View Detail', 'cavada' ) . '</a><div class="clear"></div>'; ?>
	</div>
	<!-- #product-<?php the_ID(); ?> -->
</div>