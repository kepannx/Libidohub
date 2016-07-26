<?php
$args                          = array(
	'pad_counts'         => 1,
	'show_counts'        => 1,
	'hierarchical'       => 1,
	'hide_empty'         => 1,
	'show_uncategorized' => 1,
	'orderby'            => 'name',
	'menu_order'         => false
);
$terms                         = get_terms( 'product_cat', $args );
$categories                    = array();
$categories['Select category'] = '';
if ( is_wp_error( $terms ) ) {
	// error occurred
} else {
	if ( empty( $terms ) ) {
		// no terms were found
	} else {
		// process terms
		foreach ( $terms as $term ) {
			$categories[$term->name] = $term->term_id;
		}
	}
}

vc_map(
	array(
		"name"        => esc_html__( "Vi Product", 'cavada' ),
		"icon"        => "icon-ui-splitter-horizontal",
		"base"        => "woo_product",
		"description" => "Show category product",
		"category"    => esc_html__( "Villatheme", 'cavada' ),
		"params"      => array(
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__( "Show", "cavada" ),
				"param_name"  => "show",
				"admin_label" => true,
				"value"       => array(
					esc_html__( "All Products", "cavada" )      => "",
					esc_html__( "Featured Products", "cavada" ) => "featured",
					esc_html__( "On-sale Products", "cavada" )  => "onsale",
					esc_html__( "Category Products", "cavada" ) => "cats"
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Product Category', 'cavada' ),
				'param_name'  => 'product_category',
				'value'       => $categories,
				"dependency"  => Array( "element" => "show", "value" => array( "cats" ) ),

			),
			array(
				"type"        => "dropdown",
				"heading"     => esc_html__( "Order by", "cavada" ),
				"param_name"  => "orderby",
				"admin_label" => true,
				"value"       => array(
					esc_html__( "Date", "cavada" )   => "date",
					esc_html__( "Price", "cavada" )  => "price",
					esc_html__( "Random", "cavada" ) => "rand",
					esc_html__( "Sales", "cavada" )  => "sales"
				),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Order', 'cavada' ),
				'param_name' => 'order',
				'std'        => 'desc',
				'value'      => array(
					esc_html__( 'DESC', 'cavada' ) => 'desc',
					esc_html__( 'ASC', 'cavada' )  => 'asc'
				)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Style', 'cavada' ),
				'param_name' => 'style',
				'std'        => 'pain',
				'value'      => array(
					esc_html__( 'Pain', 'cavada' )   => 'pain',
					esc_html__( 'Slider', 'cavada' ) => 'slider'
				)
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Show Pagination', 'cavada' ),
				'param_name' => 'show_pagination',
				'value'      => '',
				"dependency" => Array( "element" => "style", "value" => array( 'slider' ) )
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Layout', 'cavada' ),
				'param_name' => 'layout',
				'std'        => 'layout_01',
				'value'      => array(
					esc_html__( 'Layout 01', 'cavada' ) => 'layout_01',
					esc_html__( 'Layout 02', 'cavada' ) => 'layout_02'
				),
				"dependency" => Array( "element" => "style", "value" => array( 'pain' ) )
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Limit", 'cavada' ),
				"param_name"  => "limit",
				"value"       => "6",
				'description' => esc_html__( 'Product number will be shown.', 'cavada' ),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Products on row', 'cavada' ),
				'param_name' => 'products_on_row',
				'value'      => '3',
			),

			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Extra class name", "cavada" ),
				"param_name"  => "el_class",
				"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cavada" ),
			),

			cavada_vc_map_add_css_animation( true ),

			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Heading Style', 'cavada' ),
				'param_name'  => 'heading_style',
				'value'       => array(
					esc_html__( 'Style 01', 'cavada' ) => 'style_01',
					esc_html__( 'Style 02', 'cavada' ) => 'style_02',
					esc_html__( 'Style 03', 'cavada' ) => 'style_03',
				),
				'std'         => 'style_01',
				'group'       => esc_html__( 'Style Heading', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Heading Align', 'cavada' ),
				'param_name'  => 'heading_align',
				'value'       => array(
					esc_html__( 'Left', 'cavada' )   => 'text_left',
					esc_html__( 'Center', 'cavada' ) => 'text_center'
				),
				'std'         => 'text_left',
				'group'       => esc_html__( 'Style Heading', 'cavada' ),
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_03' )
				),
			),

			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Heading", 'cavada' ),
				"param_name" => "heading",
				"value"      => "",
				'group'      => esc_html__( 'Style Heading', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Heading type', 'cavada' ),
				'param_name'  => 'heading_type',
				'value'       => array(
					esc_html__( 'H2', 'cavada' ) => 'h2',
					esc_html__( 'H3', 'cavada' ) => 'h3',
					esc_html__( 'H4', 'cavada' ) => 'h4',
					esc_html__( 'H5', 'cavada' ) => 'h5',
					esc_html__( 'H6', 'cavada' ) => 'h6'
				),
				'std'         => 'h2',
				'group'       => esc_html__( 'Style Heading', 'cavada' ),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Heading color', 'cavada' ),
				'param_name' => 'heading_color',
				'value'      => '',
				'group'      => esc_html__( 'Style Heading', 'cavada' ),
			),
			array(
				"type"        => "textfield",
				'admin_label' => true,
				"heading"     => esc_html__( "Sub Heading", 'cavada' ),
				"param_name"  => "sub_heading",
				"value"       => "",
				'group'       => esc_html__( 'Style Heading', 'cavada' ),
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Sub Heading type', 'cavada' ),
				'param_name'  => 'sub_heading_type',
				'value'       => array(
					esc_html__( 'P', 'cavada' )  => 'p',
					esc_html__( 'H2', 'cavada' ) => 'h2',
					esc_html__( 'H3', 'cavada' ) => 'h3',
					esc_html__( 'H4', 'cavada' ) => 'h4',
					esc_html__( 'H5', 'cavada' ) => 'h5',
					esc_html__( 'H6', 'cavada' ) => 'h6'
				),
				'std'         => 'h3',
				'group'       => esc_html__( 'Style Heading', 'cavada' ),
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Sub Heading color', 'cavada' ),
				'param_name' => 'sub_heading_color',
				'value'      => '',
				'group'      => esc_html__( 'Style Heading', 'cavada' ),
				"dependency" => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Position Description', 'cavada' ),
				'param_name'  => 'pos',
				'value'       => array(
					esc_html__( 'Default', 'cavada' )      => '',
					esc_html__( 'Before Title', 'cavada' ) => 'before_title',
				),
				'std'         => '',
				'group'       => esc_html__( 'Style Heading', 'cavada' ),
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
			),
		)
	)
);

function cavada_shortcode_woo_product( $atts, $content = null ) {
	$product_category = $style = $show_link = $orderby = $order = $limit = $button_text = $cavada_animation =
	$products_on_row = $class_slider = $data_item_row = $bg_color = $el_class = $style_heading = $sub_heading =
	$css_animation = $show = $button_link = $heading = $heading_type = $heading_color = $heading_style = $show_pagination =
	$custom_image = $sub_heading_color = $pos = $star = $sub_heading_type = $border_color = $layout = $heading_align = '';
	extract(
		shortcode_atts(
			array(
				'heading'           => '',
				'heading_type'      => 'h2',
				'heading_color'     => '',
				'heading_style'     => 'style_01',
				'heading_align'     => 'text_left',
				'border_color'      => '',
				'custom_image'      => '',
				'sub_heading_color' => '',
				'sub_heading'       => '',
				'sub_heading_type'  => 'h3',
				'pos'               => '',
				'product_category'  => '',
				'show'              => '',
				'style'             => 'pain',
				'layout'            => 'layout_01',
				'show_pagination'   => '',
				'limit'             => 6,
				'products_on_row'   => 3,
				'orderby'           => 'date',
				'order'             => 'desc',
				'el_class'          => '',
				'css_animation'     => ''
			), $atts
		)
	);
	ob_start();
	$before_item = $after_item = $arrow_slider = $style_border_color = '';
	$before_item = '<div class="item-product col-sm-' . intval( 12 / $products_on_row ) . '">';
	$after_item  = '</div>';

	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	$query_args = array(
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'post_type'      => 'product',
		'no_found_rows'  => 1,
		'order'          => $order == 'asc' ? 'asc' : 'desc'
	);

	$query_args['meta_query'] = array();

	if ( $show == 'cats' && $product_category <> '' ) {
		$cats_id                 = explode( ',', $product_category );
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $cats_id
			)
		);
	}

	switch ( $show ) {
		case 'featured' :
			$query_args['meta_query'][] = array(
				'key'   => '_featured',
				'value' => 'yes'
			);
			break;
		case 'onsale' :
			$product_ids_on_sale    = wc_get_product_ids_on_sale();
			$product_ids_on_sale[]  = 0;
			$query_args['post__in'] = $product_ids_on_sale;
			break;
	}

	switch ( $orderby ) {
		case 'price' :
			$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
			break;
		case 'rand' :
			$query_args['orderby'] = 'rand';
			break;
		case 'sales' :
			$query_args['meta_key'] = 'total_sales';
			$query_args['orderby']  = 'meta_value_num';
			break;
		default :
			$query_args['orderby'] = 'date';
	}

	?>
	<div class="woocommerce product-<?php echo esc_attr( $layout ); ?> vi-product-<?php echo esc_attr( $style . $cavada_animation ); ?>">
		<?php
		// heading
		$style_heading = $heading_color ? ' style="color:' . $heading_color . '"' : '';
		$title_heading = ( $heading && $heading_type ) ? '<' . $heading_type . $style_heading . ' class="title"><span>' . $heading . '</span></' . $heading_type . '>' : '';
		// sub heading
		$style_heading = $sub_heading_color ? ' style="color:' . $sub_heading_color . '"' : '';
		$sub_head      = ( $sub_heading && $sub_heading_type ) ? '<' . $sub_heading_type . ' class="description"' . $style_heading . '><span>' . $sub_heading . '</span></' . $sub_heading_type . '>' : '';

		$the_query = new WP_Query( $query_args );
		if ( $the_query->have_posts() ) :
			// arrow slider
			if ( $style == 'slider' ) {
				$col      = 12;
				$data_col = $products_on_row;
				$class_slider  = " product-slider col-sm-$col";
				$data_item_row = 'data-item ="' . $data_col . '"';
				if ( $show_pagination == true ) {
					$data_item_row .= ' data-pagination ="' . $show_pagination . '"';
				} else {
					$data_item_row .= ' data-pagination ="false"';

				}
				$arrow_slider = '<div class="slider-nav">
										<span class="prev"><i class="fa fa-angle-left"></i></span>
										<span class="next"><i class="fa fa-angle-right"></i></span>
									</div>';
			}
			if ( $heading_style == 'style_03' ) {
				$heading_align = ' ' . $heading_align;
			} else {
				$heading_align = '';
			}
			if ( $sub_head <> '' || $title_heading <> '' || $arrow_slider <> '' ) {
				echo '<div class="vi-heading heading-' . $heading_style . $heading_align . '">';
				if ( $pos == 'before_title' ) {
					echo ent2ncr( $sub_head );
				}
				echo ent2ncr( $title_heading );
				if ( $pos == '' ) {
					echo ent2ncr( $sub_head );
				}
				if ( $heading_style != 'style_03' ) {
					echo ent2ncr( $arrow_slider );
				}
				echo '</div>';
			}

			// The Loop
			echo '<div class="product-grid category-product-list row">';


			if ( $style == 'slider' ) {
				echo '<div class="' . $class_slider . '" ' . $data_item_row . '>';
			}
			// end title
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
						do_action( 'woocommerce_before_shortcode_shop_loop_item_title' );
						//do_action( 'woocommerce_before_shop_loop_item_title' );
						global $post, $product;
						if ( $layout == 'layout_01' ) {
							$size_images = 'shop_catalog';
						} else {
							$size_images = 'thumbnail';
						}
						if ( has_post_thumbnail() ) {
							echo cavada_get_the_post_thumbnail( $product->ID, $size_images, array( 'class' => 'primary-image vi-load' ) );
						} elseif ( wc_placeholder_img_src() ) {
							echo wc_placeholder_img( $size_images );
						}
						$attachment_ids = $product->get_gallery_attachment_ids();
						if ( isset( $attachment_ids[0] ) ) {
							echo cavada_get_attachment_image( $attachment_ids[0], apply_filters( $size_images, 'shop_catalog' ), '', '', false );
						}
						?>
					</a>
					<?php
					if ( $layout == 'layout_01' ) {
						?>
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
									echo '<li>' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
								} ?>
								<?php
								if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active_for_network( 'yith-woocommerce-compare/init.php' ) ) {
									echo '<li><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '&amp;action=yith-woocompare-add-product&amp;id=' . esc_attr( get_the_ID() ) . '" class="compare button" data-product_id="' . esc_attr( get_the_ID() ) . '" title="' . esc_html__( "Compare", "cavada" ) . '"></a></li>';
								}
								?>
								<?php echo '<li class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="fa fa-search"></i></a></li>'; ?>
							</ul>
						</div>
					<?php } ?>
				</div>
				<div class="product-desc">
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
			// Reset Post Data
			wp_reset_postdata();

			if ( $style == 'slider' ) {
				echo '</div>';
			}
 			echo '</div>';
		endif;
 		?>
	</div>
	<?php
	$content = ob_get_clean();

	return ent2ncr( $content );
}

?>