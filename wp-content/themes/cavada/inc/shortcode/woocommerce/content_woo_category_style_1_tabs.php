<div class="row">
	<div class="col-md-4 tab-thumb-image">
		<?php
		$i = 0;
		if ( $products->have_posts() ) {
			while ( $products->have_posts() ) {
				if ( $i < 1 ) {
					$products->the_post();
					?>
					<a href="<?php the_permalink(); ?>">
 						<?php
						$image_url_product = wp_get_attachment_image_src( get_post_thumbnail_id( $products->ID ), 'full' );
						if ( $image_url_product ) {
							echo img_product_ajax( 480, 600, $image_url_product[0] );
 						}
						?>
					</a>
				<?php } else {
					break;
				}
				$i ++;
			}
		} ?>
	</div>
	<div class="col-md-8">
		<div class="product-content">
			<div class="row text-middle">
				<div class="col-md-9 col-sm-9 col-xs-12">
					<?php
					$product = new WC_Product_Simple( get_the_ID() );
					?>
					<h2 class="product-name">
						<a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
					</h2>
					<?php
					if ( $rating_html = $product->get_rating_html() ) : ?>
						<div class="product-rating">
							<?php echo ent2ncr( $rating_html ); ?>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12 text-right">
					<div class="price-box">
						<span class="price"><?php echo woocommerce_template_single_price() ?></span>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="product-description"><?php the_excerpt() ?></div>
			<div class="controls-list">
				<ul class="icon-links">
					<li>
						<?php
						echo apply_filters( 'woocommerce_loop_add_to_cart_link',
							sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button add_to_cart_button %s product_type_%s">%s</a>',
								esc_url( $product->add_to_cart_url() ),
								esc_attr( $product->id ),
								esc_attr( $product->get_sku() ),
								$product->is_purchasable() ? 'add_to_cart_button' : '',
								esc_attr( $product->product_type ),
								esc_html( $product->add_to_cart_text() ) ),
							$product );
						?>
					</li>

					<?php if ( class_exists( 'YITH_WCWL' ) ) {
						echo '<li>' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
					} ?>
					<?php
					if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active_for_network( 'yith-woocommerce-compare/init.php' ) ) {
						echo '<li><a href="' . esc_url( get_permalink( $product->id ) ) . '&amp;action=yith-woocompare-add-product&amp;id=' . esc_attr( $product->id ) . '" class="compare button" data-product_id="' . esc_attr( $product->id ) . '" title="' . esc_html__( "Compare", "cavada" ) . '"></a></li>';
					}
					?>
					<?php echo '<li class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="fa fa-eye"></i></a></li>'; ?>

				</ul>
			</div>
		</div>
		<div class="products-thumbs">
			<div class="customNavigation vi-slider-navigation">
				<a class="prev text-center"><i class="fa fa-angle-left"></i></a>
				<a class="next text-center"><i class="fa fa-angle-right"></i></a>
			</div>
			<div class="related-products-slider">
				<?php
				wp_reset_postdata();
				$products = new WP_Query( $args );
				if ( $products->have_posts() ) {
					/*Slider*/
					wp_enqueue_script( 'jquery-owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), '', false );
					wp_enqueue_script( 'shortcode-woo-category-tabs', get_template_directory_uri() . '/assets/js/shortcode.woo_category_tabs.min.js', array(), '', true );
					while ( $products->have_posts() ) {
						$products->the_post(); ?>
						<div data-id="<?php echo get_the_ID() ?>" class="item item-product post-<?php echo get_the_ID() ?>">
							<?php
							$image_url_product = wp_get_attachment_image_src( get_post_thumbnail_id( $products->ID ), 'full' );
							if ( $image_url_product ) {
								echo img_product_ajax( 170, 180, $image_url_product[0] );
 							}
							?>
 						<?php
					}
 					wp_reset_postdata();
				} ?>
			</div>
		</div>
	</div>
</div>