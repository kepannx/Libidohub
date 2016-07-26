<?php
// General Settings
$of_options[] = array(
	"name" => esc_html__( "Menu Options", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "icon-header.png"
);

$of_options[] = array(
	"name" => esc_html__( "Topbar Options", "cavada" ),
	"desc" => "",
	"id"   => "Topbar_info",
	"std"  => esc_html__( "Topbar Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Show or Hide Topbar", "cavada" ),
	"desc"  => "",
	"id"    => "user_top_bar",
	"std"   => 0,
	"folds" => 1,
	"on"    => esc_html__( "Show", "cavada" ),
	"off"   => esc_html__( "Hide", "cavada" ),
	"type"  => "switch"
);

$of_options[] = array(
	"name" => esc_html__( "Background", "cavada" ),
	"desc" => esc_html__( "Pick a color", "cavada" ),
	"fold" => "user_top_bar",
	"id"   => "bg_topbar_color",
	"std"  => "rgba(153, 153, 153, 1)",
	"type" => "color-rgba"
);
$of_options[] = array(
	"name" => "Border-color",
	"desc" => "Pick a color",
	"fold" => "user_top_bar",
	"id"   => "border_topbar_color",
	"std"  => "#999",
	"type" => "color-rgba"
);
$of_options[] = array(
	"name" => esc_html__( "Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a color", "cavada" ),
	"fold" => "user_top_bar",
	"id"   => "topbar_color",
	"std"  => "#999",
	"type" => "color"
);
$of_options[] = array(
	"name" => esc_html__( "Header Options", "cavada" ),
	"desc" => "",
	"id"   => "header_info",
	"std"  => esc_html__( "Header Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);
$of_options[] = array(
	"name" => esc_html__( "Header Background Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for header", "cavada" ),
	"id"   => "header_area_bg_color",
	"std"  => "rgba(0,0,0,0)",
	"type" => "color-rgba"
);

$of_options[] = array(
	"name" => esc_html__( "Header Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for header", "cavada" ),
	"id"   => "header_area_text_color",
	"std"  => "#ddd",
	"type" => "color"
);
$of_options[] = array(
	"name"    => esc_html__( "Select a Header Style", 'cavada' ),
	"desc"    => "",
	"id"      => "header_style",
	"std"     => "header_v2",
	"type"    => "images",
	"options" => array(
		"header_v1" => get_template_directory_uri( 'template_directory' ) . "/images/patterns/header1.jpg",
		"header_v2" => get_template_directory_uri( 'template_directory' ) . "/images/patterns/header2.jpg"
	)
);

$of_options[] = array(
	"name"    => esc_html__( "Choose Header", 'cavada' ),
	"desc"    => "",
	"id"      => "choose_header",
	"std"     => "header_v1_01",
	"type"    => "images",
	"fold"    => "header_v1",
	"options" => array(
		"header_v1_01" => get_template_directory_uri( 'template_directory' ) . "/images/patterns/header/header_v1_01.jpg",
		"header_v1_02" => get_template_directory_uri( 'template_directory' ) . "/images/patterns/header/header_v1_02.jpg",
		"header_v1_03" => get_template_directory_uri( 'template_directory' ) . "/images/patterns/header/header_v1_03.jpg",
		"header_v1_04" => get_template_directory_uri( 'template_directory' ) . "/images/patterns/header/header_v1_04.jpg",
	)
);

$of_options[] = array(
	"name"    => esc_html__( "Header Position", 'cavada' ),
	"id"      => "header_position",
	"std"     => "default",
	"type"    => "select",
	"mod"     => "mini",
	"options" => array(
		'header_default' => esc_html__( 'Default', 'cavada' ),
		'header_overlay' => esc_html__( 'OverLay', 'cavada' ),
	),
);
$of_options[] = array(
	"name"  => esc_html__( "Header Full Width", "cavada" ),
	"desc"  => "",
	"id"    => "menu_layout",
	"std"   => 0,
	"folds" => 1,
	"on"    => esc_html__( "yes", "cavada" ),
	"off"   => esc_html__( "no", "cavada" ),
	"type"  => "switch"
);

$of_options[] = array(
	"name" => esc_html__( "Menu Options", "cavada" ),
	"desc" => "",
	"id"   => "menu_info",
	"std"  => esc_html__( "Menu Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);
$of_options[] = array(
	"name"    => esc_html__( "Menu Align", 'cavada' ),
	"id"      => "menu_align",
	"std"     => "menu_left",
	"type"    => "select",
	"mod"     => "mini",
	"options" => array(
		'menu_text_left'   => esc_html__( 'Left', 'cavada' ),
		'menu_text_right'  => esc_html__( 'Right', 'cavada' ),
		'menu_text_center' => esc_html__( 'Center', 'cavada' ),
	),
);
$of_options[] = array(
	"name"  => esc_html__( "Show Mega Menu Widget Area", "cavada" ),
	"desc"  => "",
	"id"    => "show_megamenu",
	"std"   => 1,
	"folds" => 1,
	"on"    => esc_html__( "yes", "cavada" ),
	"off"   => esc_html__( "no", "cavada" ),
	"type"  => "switch"
);
$of_options[] = array(
	"name" => esc_html__( "Quantity MegaMenu Widgets", "cavada" ),
	"desc" => esc_html__( "It will create widget postions.", "cavada" ),
	"fold" => "show_megamenu",
	"id"   => "quantity_widgets",
	"std"  => "2",
	"type" => "text",
	"mod"  => "mini",
);


$of_options[] = array(
	"name" => esc_html__( "Menu Background Color", "cavada" ),
	"desc" => esc_html__( "Pick a background color for menu", "cavada" ),
	"id"   => "bg_header_color",
	"std"  => "rgba(0,0,0,0)",
	"type" => "color-rgba"
);

$of_options[] = array(
	"name" => esc_html__( "Border Top Main Menu", "cavada" ),
	"desc" => esc_html__( "Pick a border color for menu", "cavada" ),
	"id"   => "border_menu_top",
	"std"  => "rgba(0,0,0,0)",
	"type" => "color-rgba"
);

$of_options[] = array(
	"name" => esc_html__( "Border Bottom Main Menu", "cavada" ),
	"desc" => esc_html__( "Pick a border color for menu", "cavada" ),
	"id"   => "border_menu_bottom",
	"std"  => "rgba(0,0,0,0)",
	"type" => "color-rgba"
);

$of_options[] = array(
	"name" => esc_html__( "Menu Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for menu", "cavada" ),
	"id"   => "header_text_color",
	"std"  => "#fff",
	"type" => "color"
);

$of_options[] = array(
	"name" => esc_html__( "Menu Text Hover Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for menu when hover", "cavada" ),
	"id"   => "header_color_hover",
	"std"  => "#999",
	"type" => "color"
);

$of_options[] = array(
	"name"    => esc_html__( "Menu Font Size", "cavada" ),
	"desc"    => esc_html__( "Default is 12", "cavada" ),
	"id"      => "font_size_main_menu",
	"mod"     => "mini",
	"std"     => "12",
	"type"    => "select",
	"options" => $font_sizes
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_main_menu",
	"std"     => "normal",
	"type"    => "select",
	"mod"     => "mini",
	"options" => $font_weight
);
$of_options[] = array(
	"name" => esc_html__( "Text Transform", "cavada" ),
	"desc" => "",
	"id"   => "text_transform_menu",
	"std"  => "none",
	"type" => "select",
	"mod"  => "mini",

	"options" => $text_transform
);
$of_options[] = array(
	"name" => esc_html__( "Sticky Menu", "cavada" ),
	"desc" => "",
	"id"   => "sticky_menu_opt",
	"std"  => esc_html__( "Sticky Menu", "cavada" ),
	"icon" => true,
	"type" => "info"
);
$of_options[] = array(
	"name"  => esc_html__( "Sticky Menu On Scroll", "cavada" ),
	"desc"  => "",
	"id"    => "header_sticky",
	"std"   => 0,
	"folds" => 1,
	"on"    => "show",
	"off"   => "hide",
	"type"  => "switch"
);

$of_options[] = array(
	'name'      => esc_html__( 'Config Sticky Menu?', 'cavada' ),
	'desc'      => '',
	'id'        => 'config_att_sticky',
	'fold'      => 'header_sticky',
	'data_show' => 'sticky_custom',
	'mod'       => 'select_show_or_hide',
	'options'   => array(
		'sticky_same'   => 'The same with main menu',
		'sticky_custom' => 'Custom'
	),
	'type'      => 'select'
);

$of_options[] = array(
	'name' => esc_html__( 'Sticky Background color', 'cavada' ),
	'desc' => esc_html__( 'Pick a background color for main menu', 'cavada' ),
	'id'   => 'sticky_bg_main_menu_color',
	'std'  => 'rgba(0,0,0,0.9)',
	'type' => 'color-rgba',
	"fold" => "sticky_custom",
);

$of_options[] = array(
	'name' => esc_html__( 'Text color', 'cavada' ),
	'desc' => esc_html__( 'Pick a text color for main menu', 'cavada' ),
	'id'   => 'sticky_main_menu_text_color',
	'std'  => '#9d9d9d',
	'type' => 'color',
	"fold" => "sticky_custom",
);

$of_options[] = array(
	'name' => esc_html__( 'Text Hover color', 'cavada' ),
	'desc' => esc_html__( 'Pick a text hover color for main menu', 'cavada' ),
	'id'   => 'sticky_main_menu_text_hover_color',
	'std'  => '#ffffff',
	'type' => 'color',
	"fold" => "sticky_custom",
);

$of_options[] = array(
	"name" => esc_html__( "Sub Menu", "cavada" ),
	"desc" => "",
	"id"   => "display_sub_menu",
	"std"  => esc_html__( "Sub Menu", "cavada" ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name" => esc_html__( "Background color", "cavada" ),
	"desc" => esc_html__( "Pick a background color for sub menu", "cavada" ),
	"id"   => "sub_menu_bg_color",
	"std"  => "rgba(38, 38, 38,1)",
	"type" => "color-rgba"
);

$of_options[] = array(
	"name" => esc_html__( "Text color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for sub menu", "cavada" ),
	"id"   => "sub_menu_text_color",
	"std"  => "#bababa",
	"type" => "color",
);
$of_options[] = array(
	"name" => esc_html__( "Text color hover", "cavada" ),
	"desc" => esc_html__( "Pick a text color hover for sub menu", "cavada" ),
	"id"   => "sub_menu_text_color_hover",
	"std"  => "#9d9d9d",
	"type" => "color"
);


// main menu

$of_options[] = array(
	"name" => esc_html__( "Mobile Menu", "cavada" ),
	"desc" => "",
	"id"   => "display_mobile_menu",
	"std"  => esc_html__( "Mobile Menu", "cavada" ),
	"icon" => true,
	"type" => "info"
);


$of_options[] = array(
	"name" => esc_html__( "Background color", "cavada" ),
	"desc" => esc_html__( "Pick a background color for main menu", "cavada" ),
	"id"   => "bg_mobile_menu_color",
	"std"  => "rgba(122,35,35,1)",
	"type" => "color-rgba"
);


$of_options[] = array(
	"name" => esc_html__( "Text color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for main menu", "cavada" ),
	"id"   => "mobile_menu_text_color",
	"std"  => "#999999",
	"type" => "color"
);


$of_options[] = array(
	"name" => esc_html__( "Text Hover color", "cavada" ),
	"desc" => esc_html__( "Pick a text hover color for main menu", "cavada" ),
	"id"   => "mobile_menu_text_hover_color",
	"std"  => "#fff",
	"type" => "color"
);