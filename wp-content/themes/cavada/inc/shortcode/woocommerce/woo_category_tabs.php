<?php
/**
 * WooCommerce Category Tabs
 * Tab or Load Ajax
 */

$args = array(
	'pad_counts'         => 1,
	'show_counts'        => 1,
	'hierarchical'       => 1,
	'hide_empty'         => 1,
	'show_uncategorized' => 1,
	'orderby'            => 'name',
	'menu_order'         => false
);

$terms      = get_terms( 'product_cat', $args );
$categories = array();
foreach ( $terms as $term ) {
	$categories[$term->name] = $term->term_id;
}

vc_map( array(
	"name"        => esc_html__( "Vi Product Tabs", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "woo_category_tabs",
	"description" => "Show all products in category in tab or load ajax",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Tab Style', 'cavada' ),
			'param_name' => 'tab_style',
			'std'        => 'tab_style_01',
			'value'      => array(
				esc_html__( 'Style 01', 'cavada' ) => 'tab_style_1',
				esc_html__( 'Style 02', 'cavada' ) => 'tab_style_2',
				esc_html__( 'Style 03', 'cavada' ) => 'tab_style_3'
			)
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Heading', 'cavada' ),
			'param_name' => 'heading',
			'value'      => '',
			"dependency" => Array( "element" => "tab_style", "value" => array( 'tab_style_1', 'tab_style_3' ) ),
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
			"dependency"  => Array( "element" => "tab_style", "value" => array( 'tab_style_1' ) ),
		),
		// Custom query tab
		array(
			'type'        => 'multi_dropdown',
			'heading'     => esc_html__( 'Product Category', 'cavada' ),
			'param_name'  => 'product_category',
			'description' => esc_html__( 'Add category product by title.', 'cavada' ),
			'value'       => $categories
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Primary color', 'cavada' ),
			'param_name' => 'primary_color',
			'std'        => '',
			"dependency" => Array( "element" => "tab_style", "value" => array( 'tab_style_3' ) ),
		),

		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'cavada' ),
			'param_name'  => 'icon_fontawesome',
			'value'       => 'fa fa-adjust', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false,
				'iconsPerPage' => 4000,
			),
			'description' => esc_html__( 'Select icon from library.', 'cavada' ),
			"dependency"  => Array( "element" => "tab_style", "value" => array( 'tab_style_3' ) ),
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
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Limit', 'cavada' ),
			'param_name'  => 'limit',
			'value'       => '5',
			"description" => esc_html__( "Total products on tabs", "cavada" ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Products on row', 'cavada' ),
			'param_name' => 'products_on_row',
			'value'      => '3',
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Layout Style', 'cavada' ),
			'param_name' => 'layout_style',
			'std'        => 'pain',
			'value'      => array(
				esc_html__( 'Pain', 'cavada' )   => 'pain',
				esc_html__( 'Slider', 'cavada' ) => 'slider'
			),
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Banner', 'cavada' ),
			'param_name'  => 'banner',
			'value'       => '',
			'description' => esc_html__( 'Select image from media library.', 'cavada' ),
			"dependency"  => Array( "element" => "layout_style", "value" => array( 'slider' ) )
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Show Pagination', 'cavada' ),
			'param_name' => 'show_pagination',
			'value'      => '',
			"dependency" => Array( "element" => "layout_style", "value" => array( 'slider' ) )
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__( "Extra class name", "cavada" ),
			"param_name"  => "el_class",
			"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cavada" ),
		),
		cavada_vc_map_add_css_animation( true )
	)
) );

function cavada_shortcode_woo_category_tabs( $atts, $content = null ) {
	$cavada_animation = $css_animation = $el_class = $product_category = $order = $orderby = $before_item = $after_item = $arrow_slider = $style_color =
	$limit = $layout = $style = $products_on_row = $show_link = $button_text = $button_link = $layout_style = $class_shortcode = $tab_style =
	$heading_type = $heading = $show_pagination = $banner = $data_item_row = $primary_color = $icon_fontawesome = $icon = $style_icon = '';
	extract( shortcode_atts( array(
		'heading'          => '',
		'heading_type'     => 'h2',
		'banner'           => '',
		'primary_color'    => '',
		'product_category' => '',
		'icon_fontawesome' => 'fa fa-adjust',
		'tab_style'        => 'tab_style_01',
		'limit'            => '5',
		'orderby'          => 'date',
		'order'            => 'desc',
		'style'            => 'style_1',
		'products_on_row'  => '3',
		'layout_style'     => 'pain',
		'show_pagination'  => '',
		'el_class'         => '',
		'css_animation'    => '',
	), $atts ) );
	$layout          = 'tabs';
	$class_shortcode = time() . '-1-' . rand( 0, 100 );
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= ' ' . $tab_style;
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );
	if ( $tab_style == 'tab_style_3' ) {
		$heading_type = 'h3';
		vc_icon_element_fonts_enqueue( 'fontawesome' );
		$iconClass = isset( ${"icon_fontawesome"} ) ? esc_attr( ${"icon_fontawesome"} ) : 'fa fa-adjust';
		if ( $primary_color ) {
			$style_icon = ' style="background:' . $primary_color . '"';
		}
		$icon = '<span class="icon-title"' . $style_icon . '><em class="' . $iconClass . '"></em></span>';
	}

	$title_heading = $heading ? '<li class="title-shorcode"><' . $heading_type . ' class="title">' . $icon . '<span>' . $heading . '</span></' . $heading_type . '></li>' : '';

	$categories = array();
	if ( $product_category ) {
		$categories = explode( ',', $product_category );
	}
	$args     = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'order'          => $order,
		'orderby'        => $orderby,
		'posts_per_page' => $limit
	);
	$products = new WP_Query( $args );

	if ( $products ) {
		$html = '<div class="vi-woocommerce-product-category-tabs woocommerce' . $cavada_animation . '">';
		$html .= '<div id="preload-ajax" class="center"> <div class="preload-inner"> <div class="loading-inner"> <span class="loading-1"></span> <span class="loading-2"></span> <span class="loading-3"></span> </div> </div> </div>';
	}

	ob_start();
	if ( $primary_color && ( $tab_style == 'tab_style_3' ) ) {
		$style_color = ' style="border-top:1px solid ' . $primary_color . '; color:' . $primary_color . '"';
	}
	?>
	<ul class="nav nav-tabs vi-woo-cate-tabs<?php if ( $style == 'style_1' ) {
		echo ' vi-' . $layout;
	} ?>" <?php echo ent2ncr( $style_color ) ?>>

		<?php
		if ( $tab_style != 'tab_style_02' ) {
			echo ent2ncr( $title_heading );
		}

		if ( $style == 'style_1' ) {
			echo '<li role="presentation" class="active"><a href="#all' . $class_shortcode . '" data-id="0" data-limit="' . $limit . '">' . esc_html__( "All", "cavada" ) . '</a></li>';
		}
		?>

		<?php
		if ( count( $categories ) ) {
			$i = 1;
			foreach ( $categories as $category ) {
				$tmp_term = get_term( $category, 'product_cat' );
				?>
				<li role="presentation"<?php if ( $style == 'style_2' && $i == 1 ) {
					echo ' class="active"';
				} ?>>
					<a href="#<?php echo esc_attr( $tmp_term->slug . $class_shortcode ) ?>" data-id="<?php echo esc_attr( $tmp_term->term_id ) ?>" data-limit="<?php echo esc_attr( $limit ) ?>">
						<?php echo esc_html( @$tmp_term->name ); ?>
					</a>
				</li>
				<?php
				$i ++;
			}
		}
		?>
	</ul>

	<div class="tab-content woocommerce">
		<?php if ( $style == 'style_1' ) { ?>
			<div role="tabpanel" class="tab-pane active" <?php if ( $layout == 'tabs' ) {
				echo 'id="all' . $class_shortcode . '"';
			} ?>>
				<?php include CAVADA_THEME_DIR . "/inc/shortcode/woocommerce/content_woo_category_style_2_tabs.php"; ?>
			</div>
		<?php } ?>

		<?php if ( $layout == 'tabs' ) { ?>
			<?php
			if ( count( $categories ) ) {
				$j = 1;
				foreach ( $categories as $category ) {
					$tmp_term = get_term( $category, 'product_cat' );
					$args     = array(
						'post_type'      => 'product',
						'post_status'    => 'publish',
						'order'          => $order,
						'orderby'        => $orderby,
						'tax_query'      => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'id',
								'terms'    => $tmp_term->term_id
							)
						),
						'posts_per_page' => $limit
					);
					$products = new WP_Query( $args );
					?>
					<div role="tabpanel" class="tab-pane<?php if ( $style == 'style_2' && $j == 1 ) {
						echo ' active';
					} ?>" id="<?php echo esc_attr( $tmp_term->slug . $class_shortcode ); ?>">
						<?php include CAVADA_THEME_DIR . "/inc/shortcode/woocommerce/content_woo_category_style_2_tabs.php"; ?>
					</div>
					<?php
					$j ++;
				}
			}
			?>
		<?php } ?>
	</div>

	<?php
	$tabs = ob_get_clean();
	$html .= $tabs . '</div>';

	return $html;
}

?>