<?php
$the_query   = new WP_Query( $args );
$before_item = '<div class="item-product col-sm-' . intval( 12 / $products_on_row ) . '">';
$after_item  = '</div>';
$link_banner = wp_get_attachment_image_src( $banner, 'full' );
if ( $the_query->have_posts() ) :
	// The Loop
	echo '<div class="product-grid category-product-list row">';

	if ( $layout_style == 'slider' ) {
		echo '<div class="vi-product-slider">';
		$style_bg = '';
		if ( $primary_color && ( $tab_style == 'tab_style_3' ) ) {
			$style_bg = ' style="background:' . $primary_color . '"';
		}
		if ( $tab_style != 'tab_style_1' ) {
			echo '<div class="slider-nav">
				<span class="prev"' . $style_bg . '><i class="fa fa-angle-left"></i></span>
				<span class="next"' . $style_bg . '><i class="fa fa-angle-right"></i></span>
			</div>';
		}
		// arrow slider
		if ( $link_banner ) {
			echo ent2ncr( $before_item );
			echo '<img src="' . $link_banner[0] . '" alt="' . $heading . '">';
			echo ent2ncr( $after_item );
			$data_col = $products_on_row - 1;
			$col      = 12 - ( 12 / $products_on_row ) . ' row';
		} else {
			$data_col = $products_on_row;
			$col      = 12;
		}
		$data_item_row = 'data-item ="' . $data_col . '"';
		if ( $show_pagination == true ) {
			$data_item_row .= ' data-pagination ="' . $show_pagination . '"';
		} else {
			$data_item_row .= ' data-pagination ="false"';

		}
		echo '<div class="product-' . $layout_style . ' col-sm-' . $col . '"  ' . $data_item_row . '>';

	}


	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		echo ent2ncr( $before_item );
		?>
		<div class="product-top">
			<a href="<?php the_permalink(); ?>" class="product-image">
				<?php
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
					<?php echo '<li class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="fa fa-search"></i></a></li>'; ?>
					<?php if ( class_exists( 'YITH_WCWL' ) ) {
						echo '<li>' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
					} ?>
					<?php
					if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active_for_network( 'yith-woocommerce-compare/init.php' ) ) {
						echo '<li><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;action=yith-woocompare-add-product&amp;id=' . esc_attr( get_the_ID() ) . '" class="compare button" data-product_id="' . esc_attr( get_the_ID() ) . '" title="' . esc_html__( "Compare", "cavada" ) . '"></a></li>';
					}
					?>
				</ul>
			</div>
		</div>
		<div class="product-desc">
			<?php
			$cat_name = get_the_terms( get_the_ID(), 'product_cat' );
			if ( $cat_name ) {
				echo '<a href="' . get_term_link( $cat_name[0]->slug, "product_cat" ) . '" title="' . $cat_name[0]->name . '" class="cat-product">' . $cat_name[0]->name . '</a>';
			}
			?>
			<h3 class="product-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
		<?php
		echo ent2ncr( $after_item );
	endwhile;

	echo '</div>';


	if ( $layout_style == 'slider' ) {
		echo '</div>';
		echo '</div>';
	}
	// Reset Post Data
	wp_reset_postdata();
endif;