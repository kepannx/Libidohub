<?php
// Typography
$of_options[] = array(
	"name" => esc_html__( "Typography", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "icon-typography.gif"

);

$of_options[] = array(
	"name" => esc_html__( "Body Info", "cavada" ),
	"desc" => "",
	"id"   => "body_info",
	"std"  => esc_html__( "Body Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Body", "cavada" ),
	"desc"  => esc_html__( "Using google font for your body font", "cavada" ),
	"id"    => "wd_body_googlefont_enable",
	"std"   => 0,
	"folds" => 1,
	"on"    => "Family Font",
	"off"   => "Google Font",
	"type"  => "switchs"
);

$of_options[] = array(
	"name"     => esc_html__( "Standard Font", "cavada" ),
	"desc"     => esc_html__( "Specify the body font properties.Using in case google font disabed", "cavada" ),
	"id"       => "wd_body_family",
	"position" => "left",
	"fold"     => "wd_body_googlefont_enable",
	"std"      => "Open Sans",
	"type"     => "select",
	"options"  => $cavada_fonts
);

$of_options[] = array(
	"name"     => esc_html__( "Google Font", "cavada" ),
	"desc"     => esc_html__( "This font going to overwrite the default font.", "cavada" ),
	"id"       => "wd_body_googlefont",
	"position" => "right",
	"std"      => "Open Sans",
	"type"     => "select_google_font",
	"fold"     => "wd_body_googlefont_enable",
	"preview"  => array(
		"text" => "This is my font preview!",
		"size" => "25px"
	),
	"options"  => $google_fonts
);

$of_options[] = array(
	"name" => esc_html__( "Body Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for the Headings.", "cavada" ),
	"id"   => "body_color",
	"std"  => "#333",
	"type" => "color"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px) Body", "cavada" ),
	"id"    => "body_font_size",
	"std"   => "14",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "mini",
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_body",
	"std"     => "normal",
	"type"    => "select",
	"mod"     => "mini",
	"options" => $font_weight
);

$of_options[] = array(
	"name" => esc_html__( "Headings Info", "cavada" ),
	"desc" => "",
	"id"   => "headings_info",
	"std"  => esc_html__( "Headings Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);

$of_options[] = array(
	"name" => esc_html__( "Font Size Title Widget", "cavada" ),
	"id"   => "font_size_title_widget",
	"std"  => "16",
	"min"  => "1",
	"step" => "1",
	"max"  => "100",
	"type" => "sliderui",
//	"class" => "select25",
);

$of_options[] = array(
	"name"  => esc_html__( "Font Heading", "cavada" ),
	"desc"  => esc_html__( "Using google font for your body font", "cavada" ),
	"id"    => "wd_heading_googlefont_enable",
	"std"   => 0,
	"folds" => 1,
	"on"    => "Family Font",
	"off"   => "Google Font",
	"type"  => "switchs"
);

$of_options[] = array(
	"name"     => esc_html__( "Standard Font", "cavada" ),
	"desc"     => esc_html__( "Specify the body font properties.Using in case google font disabed", "cavada" ),
	"id"       => "wd_heading_family",
	"position" => "left",
	"fold"     => "wd_heading_googlefont_enable",
	"std"      => "Open Sans",
	"type"     => "select",
	"options"  => $cavada_fonts
);

$of_options[] = array(
	"name"     => esc_html__( "Google Font", "cavada" ),
	"desc"     => esc_html__( "This font going to overwrite the default font.", "cavada" ),
	"id"       => "wd_heading_googlefont",
	"position" => "right",
	"std"      => "Open Sans",
	"type"     => "select_google_font",
	"fold"     => "wd_heading_googlefont_enable",
	"preview"  => array(
		"text" => esc_html__( "This is my font preview!", "cavada" ),
		"size" => "25px"
	),
	"options"  => $google_fonts
);

$of_options[] = array(
	"name" => esc_html__( "Heading Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for the Headings.", "cavada" ),
	"id"   => "headings_color",
	"std"  => "#3f3f3f",
	"type" => "color-rgba"
);

$of_options[] = array(
	"name"  => esc_html__( "Font H1", "cavada" ),
	"desc"  => "",
	"id"    => "font_h1",
	"class" => "ds_font",
	"std"   => esc_html__( "Font H1", "cavada" ),
	"icon"  => true,
	"type"  => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", "cavada" ),
	"id"    => "font_size_h1",
	"std"   => "36",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "select25",
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight H1", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_h1",
	"std"     => "700",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_weight
);

$of_options[] = array(
	"name"    => esc_html__( "Font Style", "cavada" ),
	"desc"    => "",
	"id"      => "font_style_h1",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_style
);

$of_options[] = array(
	"name"    => esc_html__( "Text Transform", "cavada" ),
	"desc"    => "",
	"id"      => "text_transform_h1",
	"std"     => "none",
	"type"    => "select",
	"class"   => "select25",
	"options" => $text_transform
);

$of_options[] = array(
	"name"  => esc_html__( "Font H2", "cavada" ),
	"desc"  => "",
	"id"    => "font_h2",
	"class" => "ds_font",
	"std"   => esc_html__( "Font H2", "cavada" ),
	"icon"  => true,
	"type"  => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", "cavada" ),
	"id"    => "font_size_h2",
	"std"   => "32",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "select25",
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight H2", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_h2",
	"std"     => "700",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_weight
);

$of_options[] = array(
	"name"    => esc_html__( "Font Style", "cavada" ),
	"desc"    => "",
	"id"      => "font_style_h2",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_style
);

$of_options[] = array(
	"name"    => esc_html__( "Text Transform", "cavada" ),
	"desc"    => "",
	"id"      => "text_transform_h2",
	"std"     => "none",
	"type"    => "select",
	"class"   => "select25",
	"options" => $text_transform
);

$of_options[] = array(
	"name"  => esc_html__( "Font H3", "cavada" ),
	"desc"  => "",
	"id"    => "font_h3",
	"class" => "ds_font",
	"std"   => esc_html__( "Font H3", "cavada" ),
	"icon"  => true,
	"type"  => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", "cavada" ),
	"id"    => "font_size_h3",
	"std"   => "28",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "select25",
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight H3", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_h3",
	"std"     => "400",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_weight
);

$of_options[] = array(
	"name"    => esc_html__( "Font Style", "cavada" ),
	"desc"    => "",
	"id"      => "font_style_h3",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_style
);

$of_options[] = array(
	"name"    => esc_html__( "Text Transform", "cavada" ),
	"desc"    => "",
	"id"      => "text_transform_h3",
	"std"     => "none",
	"type"    => "select",
	"class"   => "select25",
	"options" => $text_transform
);

$of_options[] = array(
	"name"  => esc_html__( "Font H4", "cavada" ),
	"desc"  => "",
	"id"    => "font_h4",
	"class" => "ds_font",
	"std"   => esc_html__( "Font H4", "cavada" ),
	"icon"  => true,
	"type"  => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", "cavada" ),
	"id"    => "font_size_h4",
	"std"   => "22",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "select25",
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight H4", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_h4",
	"std"     => "400",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_weight
);

$of_options[] = array(
	"name"    => esc_html__( "Font Style", "cavada" ),
	"desc"    => "",
	"id"      => "font_style_h4",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_style
);

$of_options[] = array(
	"name"    => esc_html__( "Text Transform", "cavada" ),
	"desc"    => "",
	"id"      => "text_transform_h4",
	"std"     => "none",
	"type"    => "select",
	"class"   => "select25",
	"options" => $text_transform
);

$of_options[] = array(
	"name"  => esc_html__( "Font H5", "cavada" ),
	"desc"  => "",
	"id"    => "font_h5",
	"class" => "ds_font",
	"std"   => esc_html__( "Font H5", "cavada" ),
	"icon"  => true,
	"type"  => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", "cavada" ),
	"id"    => "font_size_h5",
	"std"   => "18",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "select25",
);


$of_options[] = array(
	"name"    => esc_html__( "Font Weight H5", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_h5",
	"std"     => "400",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_weight
);

$of_options[] = array(
	"name"    => esc_html__( "Font Style", "cavada" ),
	"desc"    => "",
	"id"      => "font_style_h5",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_style
);

$of_options[] = array(
	"name"    => esc_html__( "Text Transform", "cavada" ),
	"desc"    => "",
	"id"      => "text_transform_h5",
	"std"     => "none",
	"type"    => "select",
	"class"   => "select25",
	"options" => $text_transform
);

$of_options[] = array(
	"name"  => esc_html__( "Font H6", "cavada" ),
	"desc"  => "",
	"id"    => "font_h6",
	"class" => "ds_font",
	"std"   => esc_html__( "Font H6", "cavada" ),
	"icon"  => true,
	"type"  => "info"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", "cavada" ),
	"id"    => "font_size_h6",
	"std"   => "16",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "select25",
);

$of_options[] = array(
	"name"    => esc_html__( "Font Weight H6", "cavada" ),
	"desc"    => "",
	"id"      => "font_weight_h6",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_weight
);

$of_options[] = array(
	"name"    => esc_html__( "Font Style", "cavada" ),
	"desc"    => "",
	"id"      => "font_style_h6",
	"std"     => "normal",
	"type"    => "select",
	"class"   => "select25",
	"options" => $font_style
);

$of_options[] = array(
	"name"    => esc_html__( "Text Transform", "cavada" ),
	"desc"    => "",
	"id"      => "text_transform_h6",
	"std"     => "none",
	"type"    => "select",
	"class"   => "select25",
	"options" => $text_transform
);