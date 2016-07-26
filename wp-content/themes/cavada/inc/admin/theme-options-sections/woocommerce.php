<?php
//  WooCommerce

$of_options[] = array(
	"name" => esc_html__( "WooCommerce", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "woo_icon.png"
);
$of_options[] = array(
	"name" => esc_html__( "Product", "cavada" ),
	"desc" => "",
	"id"   => "product_info",
	"std"  => esc_html__( "Product", "cavada" ),
	"icon" => true,
	"type" => "info"
);
$of_options[] = array(
	"name" => esc_html__( "Number of Products per Page", "cavada" ),
	"id"   => "number_per_page",
	"std"  => "9",
	"min"  => "1",
	"step" => "1",
	"max"  => "30",
	"type" => "sliderui",
	"desc" => esc_html__( "Insert the number of posts to display per page.", "cavada" ),
);
$of_options[] = array(
	'name'      => esc_html__( 'Select Product Style', 'cavada' ),
	'desc'      => '',
	'id'        => 'product_style',
	'data_show' => 'product-grid',
	"mod"       => "mini",
	'mod'       => 'select_show_or_hide',
	'options'   => array(
		'product-list' => 'List',
		'product-grid' => 'Gird'
	),
	'type'      => 'select'
);
$of_options[] = array(
	"name"    => esc_html__( "Column", "cavada" ),
	"desc"    => esc_html__( "Select a column", "cavada" ),
	"id"      => "villa_woo_layout_column",
	"std"     => "4",
	"type"    => "select",
	"mod"     => "mini",
	"fold"    => "product-grid",
	"options" => array(
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
	)
);

$of_options[] = array(
	"name" => esc_html__( "Archive Products", "cavada" ),
	"desc" => "",
	"id"   => "archive_products_settings",
	"std"  => esc_html__( "Archive Products", "cavada" ),
	"icon" => true,
	"type" => "info"
);
$url          = get_template_directory_uri( 'template_directory' ) . '/images/layout/';

$of_options[] = array(
	"name"    => esc_html__( "Layout", "cavada" ),
	"desc"    => esc_html__( "Select layout for Product Page.", "cavada" ),
	"id"      => "villa_woo_cate_layout",
	"std"     => "sidebar-left",
	"type"    => "images",
	"options" => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	)
);


$of_options[] = array(
	"name" => esc_html__( "Hide Breadcrumbs?", "cavada" ),
	"id"   => "vi_woo_cate_hide_breadcrumbs",
	"std"  => 0,
	"type" => "checkbox",
	"desc" => esc_html__( "Check this box to hide/unhide Breadcrumbs", "cavada" ),
);


$of_options[] = array(
	'name' => esc_html__( 'Background Heading Color', 'cavada' ),
	'id'   => 'vi_woo_cate_heading_bg_color',
	'type' => 'color-rgba',
	'std'  => 'rgba(244, 244, 244, 1)'
);

$of_options[] = array(
	'name' => esc_html__( 'Text Color Heading', 'cavada' ),
	'id'   => 'vi_woo_cate_heading_text_color',
	'type' => 'color',
	'std'  => '#383838',
);

$of_options[] = array(
	"name" => esc_html__( "Single Products", "cavada" ),
	"desc" => "",
	"id"   => "single_products_settings",
	"std"  => esc_html__( "Single Products", "cavada" ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name"    => esc_html__( "Layout", "cavada" ),
	"desc"    => esc_html__( "Select layout for Single Product.", "cavada" ),
	"id"      => "villa_woo_single_layout",
	"std"     => "sidebar-left",
	"type"    => "images",
	"options" => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	)
);

$of_options[] = array(
	"name" => esc_html__( "Hide Breadcrumbs?", "cavada" ),
	"id"   => "vi_woo_single_hide_breadcrumbs",
	"std"  => 0,
	"type" => "checkbox",
	"desc" => esc_html__( "Check this box to hide/unhide Breadcrumbs", "cavada" ),
);

$of_options[] = array(
	'name' => esc_html__( 'Background Heading Color', 'cavada' ),
	'id'   => 'vi_woo_single_heading_bg_color',
	'type' => 'color-rgba',
	'std'  => 'rgba(244, 244, 244, 1)'
);

$of_options[] = array(
	'name' => esc_html__( 'Text Color Heading', 'cavada' ),
	'id'   => 'vi_woo_single_heading_text_color',
	'type' => 'color',
	'std'  => '#383838',
);

//  Share
$of_options[] = array(
	"name" => esc_html__( "Share Social", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "social_sharing.png"
);

$of_options[] = array(
	'name' => esc_html__( 'Facebook', 'cavada' ),
	'id'   => 'woo_sharing_facebook',
	'type' => 'checkbox',
	"desc" => esc_html__( "Check this box to hide/unhide", 'cavada' ),
	'std'  => true,
);

$of_options[] = array(
	'name' => esc_html__( 'Twitter', 'cavada' ),
	'id'   => 'woo_sharing_twitter',
	'type' => 'checkbox',
	"desc" => esc_html__( "Check this box to hide/unhide", 'cavada' ),
	'std'  => true,
);

$of_options[] = array(
	'name' => esc_html__( 'Pinterest', 'cavada' ),
	'id'   => 'woo_sharing_pinterest',
	'type' => 'checkbox',
	"desc" => esc_html__( "Check this box to hide/unhide", 'cavada' ),
	'std'  => true,
);

$of_options[] = array(
	'name' => esc_html__( 'Google', 'cavada' ),
	'id'   => 'woo_sharing_google',
	'type' => 'checkbox',
	"desc" => esc_html__( "Check this box to hide/unhide", 'cavada' ),
	'std'  => true,
);