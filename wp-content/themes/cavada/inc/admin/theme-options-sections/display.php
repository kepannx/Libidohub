<?php

$of_options[] = array(
	"name" => esc_html__( "Display Settings", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "ico-view.png"
);
$of_options[] = array(
	"name" => esc_html__( "Ajax", "cavada" ),
	"desc" => "",
	"id"   => "ajax_settings",
	"std"  => esc_html__( "Pagination", 'cavada' ),
	"icon" => true,
	"type" => "info"
);
$of_options[] = array(
	"name"    => esc_html__( "Run AJAX", "cavada" ),
	"desc"    => esc_html__( "Your site is going to working with AJAX", "cavada" ),
	"id"      => "ajax_settings_run",
	"std"     => "0",
	"type"    => "select",
	"options" => array(
		'yes' => esc_html__( 'Yes', 'cavada' ),
		'no'  => esc_html__( 'No', 'cavada' )
	)
);
$url          = get_template_directory_uri( 'template_directory' ) . '/images/layout/';
$of_options[] = array(
	"name" => esc_html__( "Archive Display Settings", 'cavada' ),
	"desc" => "",
	"id"   => "archive_display_settings",
	"std"  => esc_html__( "Archive Display Settings", 'cavada' ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name"    => esc_html__( "Select Layout Default", 'cavada' ),
	"desc"    => esc_html__( "Select layout for Archive Page.", 'cavada' ),
	"id"      => "villa_archive_cate_layout",
	"std"     => "full-content",
	"type"    => "images",
	"options" => array(
		'full-content'  => $url . 'body-full.png',
		'sidebar-left'  => $url . 'sidebar-left.png',
		'sidebar-right' => $url . 'sidebar-right.png'
	)
);
$of_options[] = array(
	"name" => esc_html__( "Hide Breadcrumbs?", "cavada" ),
	"id"   => "vi_archive_cate_hide_breadcrumbs",
	"std"  => 0,
	"type" => "checkbox",
	"desc" => esc_html__( "Check this box to hide/unhide Breadcrumbs", "cavada" ),
);


$of_options[] = array(
	'name' => esc_html__( 'Background Heading Color', 'cavada' ),
	'id'   => 'vi_archive_cate_heading_bg_color',
	'type' => 'color-rgba',
	'std'  => 'rgba(244, 244, 244, 1)'
);

$of_options[] = array(
	'name' => esc_html__( 'Text Color Heading', 'cavada' ),
	'id'   => 'vi_archive_cate_heading_text_color',
	'type' => 'color',
	'std'  => '#383838',
);

$of_options[] = array(
	"name" => esc_html__( "Excerpt Length", 'cavada' ),
	"id"   => "vi_archive_excerpt_length",
	"std"  => "15",
	"min"  => "1",
	"step" => "1",
	"max"  => "80",
	"type" => "sliderui",
	"desc" => esc_html__( "Enter the number of words you want to cut from the content to be the excerpt of search and archive and portfolio page.", 'cavada' ),
);

$of_options[] = array(
	"name" => esc_html__( 'Post and Page Display Settings', 'cavada' ),
	"desc" => "",
	"id"   => "display_settings",
	"std"  => esc_html__( 'Post and Page Display Settings', 'cavada' ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name"    => esc_html__( 'Select Layout Default', 'cavada' ),
	"desc"    => esc_html__( 'Select layout for Post and Page.', 'cavada' ),
	"id"      => "villa_archive_single_layout",
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
	"id"   => "vi_archive_single_hide_breadcrumbs",
	"std"  => 0,
	"type" => "checkbox",
	"desc" => esc_html__( "Check this box to hide/unhide Breadcrumbs", "cavada" ),
);

$of_options[] = array(
	'name' => esc_html__( 'Background Heading Color', 'cavada' ),
	'id'   => 'vi_archive_single_heading_bg_color',
	'type' => 'color-rgba',
	'std'  => 'rgba(244, 244, 244, 1)'
);

$of_options[] = array(
	'name' => esc_html__( 'Text Color Heading', 'cavada' ),
	'id'   => 'vi_archive_single_heading_text_color',
	'type' => 'color',
	'std'  => '#383838',
);

$of_options[] = array(
	"name" => esc_html__( '404 Settings', 'cavada' ),
	"desc" => "",
	"id"   => "404_settings",
	"std"  => esc_html__( '404 Settings', 'cavada' ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name" => esc_html__( "Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for the Headings.", "cavada" ),
	"id"   => "404_color",
	"std"  => "#383838",
	"type" => "color"
);