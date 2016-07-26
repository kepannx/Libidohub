<?php
$wp_query        = cavada_get_wp_query();
$cavada_data = cavada_get_data_themeoptions();
/***********custom Top Images*************/
$text_color = $custom_title = $subtitle = $bg_color = $bg_header = $class_full = $text_color_header =
$bg_image = $vi_custom_heading = $cate_top_image_src = $front_title = '';

$hide_breadcrumbs = $hide_title = 0;
// color theme options
$cat_obj = $wp_query->get_queried_object();

if ( isset( $cat_obj->term_id ) ) {
	$cat_ID = $cat_obj->term_id;
} else {
	$cat_ID = "";
}

if ( get_post_type() == "product" ) {
	$prefix = 'vi_woo';
} else {
	$prefix = 'vi_archive';
}
$text_color = $bg_color = $cate_top_image_src = '';

// single and archive
if ( is_page() || is_single() ) {
	$prefix_inner = '_single_';

} else {
	if ( is_front_page() || is_home() ) {
		$prefix       = 'vi';
		$prefix_inner = '_front_page_';
		if ( isset( $cavada_data[$prefix . $prefix_inner . 'custom_title'] ) && $cavada_data[$prefix . $prefix_inner . 'custom_title'] <> '' ) {
			$front_title = $cavada_data[$prefix . $prefix_inner . 'custom_title'];
		}
	} else {
		$prefix_inner = '_cate_';
	}
}
// get data for theme customizer
if ( isset( $cavada_data[$prefix . $prefix_inner . 'heading_text_color'] ) && $cavada_data[$prefix . $prefix_inner . 'heading_text_color'] <> '' ) {
	$text_color = $cavada_data[$prefix . $prefix_inner . 'heading_text_color'];
}

if ( isset( $cavada_data[$prefix . $prefix_inner . 'heading_bg_color'] ) && $cavada_data[$prefix . $prefix_inner . 'heading_bg_color'] <> '' ) {
	$bg_color = $cavada_data[$prefix . $prefix_inner . 'heading_bg_color'];
}


if ( isset( $cavada_data[$prefix . $prefix_inner . 'hide_breadcrumbs'] ) ) {
	$hide_breadcrumbs = $cavada_data[$prefix . $prefix_inner . 'hide_breadcrumbs'];
}

if ( is_page() || is_single() ) {
	$postid               = get_the_ID();
	$using_custom_heading = get_post_meta( $postid, 'vi_user_featured_title', true );
	if ( $using_custom_heading ) {
		$hide_breadcrumbs = get_post_meta( $postid, 'vi_hide_breadcrumbs', true );
		$text_color_1     = get_post_meta( $postid, 'vi_text_color', true );
		if ( $text_color_1 <> '' ) {
			$text_color = $text_color_1;
		}
		$bg_color_1 = get_post_meta( $postid, 'vi_bg_color', true );
		if ( $bg_color_1 <> '' ) {
			$bg_color = $bg_color_1;
		}
	}
} else {
	$vi_custom_heading = cavada_get_tax_meta( $cat_ID, 'vi_custom_heading', true );

	if ( $vi_custom_heading == 'custom' ) {
		$text_color_1 = cavada_get_tax_meta( $cat_ID, 'vi_cate_heading_text_color', true );
		$bg_color_1   = cavada_get_tax_meta( $cat_ID, 'vi_cate_heading_bg_color', true );
		if ( $text_color_1 != '#' ) {
			$text_color = $text_color_1;
		}
		if ( $bg_color_1 != '#' ) {
			$bg_color = $bg_color_1;
		}
		$hide_breadcrumbs = cavada_get_tax_meta( $cat_ID, 'vi_cate_hide_breadcrumbs', true );
	}
}

// css
$c_css_style = $css_line = '';
$c_css_style .= ( $text_color != '' ) ? 'color: ' . $text_color . ';' : '';
$c_css_style .= ( $bg_color != '' ) ? 'background-color: ' . $bg_color . ';' : '';

//css background and color
$c_css = ( $c_css_style != '' ) ? 'style="' . $c_css_style . '"' : '';

if ( $hide_breadcrumbs != '1' ) { ?>
	<div class="top_site_main"<?php echo ent2ncr( $c_css ); ?>>
		<div class="banner-wrapper container">
			<div class="breadcrumbs-wrapper" itemscope itemtype="http://schema.org/BreadcrumbList">
				<?php
				if ( get_post_type() == 'product' ) {
					$array = array(
						'before'      => '<div>',
						'after'       => '</div>',
						'wrap_before' => '<div class="woocommerce-breadcrumb vi-breadcrumb">',
						'wrap_after'  => '</div>',
					);
					woocommerce_breadcrumb( $array );
				} else {
					cavada_breadcrumbs();
				}
				?>
			</div>
		</div>

	</div>
<?php } ?>
