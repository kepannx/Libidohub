<?php
//Footer Options
$of_options[] = array(
	"name" => esc_html__( "Footer Options", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "icon-footer.png"
);

$of_options[] = array(
	"name"  => esc_html__( "Show or Hide Footer Top", "cavada" ),
	"desc"  => "",
	"id"    => "show_footer_top",
	"std"   => 0,
	"folds" => 1,
	"on"    => esc_html__( "Show", "cavada" ),
	"off"   => esc_html__( "Hide", "cavada" ),
	"type"  => "switch"
);
$of_options[] = array(
	"name" => esc_html__( "Full Width", 'cavada' ),
	"desc" => esc_html__( "Full Width", 'cavada' ),
	"fold" => "show_footer_top",
	"id"   => "footer_top_fullwidth",
	"std"  => 0,
	"type" => "checkbox"
);
$of_options[] = array(
	"name" => esc_html__( "Background", "cavada" ),
	"desc" => esc_html__( "Pick a color", "cavada" ),
	"fold" => "show_footer_top",
	"id"   => "bg_top_footer_color",
	"std"  => "#999",
	"type" => "color"
);

$of_options[] = array(
	"name" => esc_html__( "Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a color", 'cavada' ),
	"fold" => "show_footer_top",
	"id"   => "text_top_footer_color",
	"std"  => "#7a7a7a",
	"type" => "color"
);

$of_options[] = array(
	"name" => esc_html__( "Footer Options", "cavada" ),
	"desc" => "",
	"id"   => "footer_options",
	"std"  => esc_html__( "Footer Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);
$of_options[] = array(
	"name" => esc_html__( "Full Width", 'cavada' ),
	"desc" => esc_html__( "Full Width", 'cavada' ),
	"id"   => "footer_fullwidth",
	"std"  => 0,
	"type" => "checkbox"
);
$of_options[] = array(
	"name" => esc_html__( "Background Color", "cavada" ),
	"desc" => esc_html__( "Pick a background color.", "cavada" ),
	"id"   => "bg_footer_color",
	"std"  => "#383838",
	"type" => "color"
);
$of_options[] = array(
	"name"    => esc_html__( "Border Position", 'cavada' ),
	"id"      => "border_position",
	"std"     => "top",
	"type"    => "select",
	"mod"     => "mini",
	"options" => array(
		'border_top'    => esc_html__( 'Top', 'cavada' ),
		'border_bottom' => esc_html__( 'Bottom', 'cavada' ),
	)
);
$of_options[] = array(
	"name"    => esc_html__( "Border Style", 'cavada' ),
	"id"      => "border_style",
	"std"     => "top",
	"type"    => "select",
	"mod"     => "mini",
	"options" => array(
		'solid'  => 'solid',
		'dotted' => 'dotted',
		'dashed' => 'dashed',
		'double' => 'double',
	)
);
$of_options[] = array(
	"name" => esc_html__( "Border Color", "cavada" ),
	"desc" => esc_html__( "Pick a border color.", "cavada" ),
	"id"   => "border_footer_color",
	"std"  => "#383838",
	"type" => "color"
);

$of_options[] = array(
	"name" => esc_html__( "Title Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for Title Footer", "cavada" ),
	"id"   => "title_footer_color",
	"std"  => "#fff",
	"type" => "color"
);
$of_options[] = array(
	"name"    => esc_html__( "Style Title", 'cavada' ),
	"id"      => "style_title",
	"std"     => "default",
	"type"    => "select",
	"mod"     => "mini",
	"options" => array(
		''              => esc_html__( 'Default', 'cavada' ),
		'title_style_1' => esc_html__( 'Style 01', 'cavada' ),
		'title_style_2' => esc_html__( 'Style 02', 'cavada' ),
		'title_style_3' => esc_html__( 'Style 03', 'cavada' ),
	)
);
$of_options[] = array(
	"name" => esc_html__( "Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for Footer", "cavada" ),
	"id"   => "text_footer_color",
	"std"  => "#b9b9b9",
	"type" => "color"
);
$of_options[] = array(
	"name"  => esc_html__( "Font Size Title (px)", 'cavada' ),
	"id"    => "footer_font_title_size",
	"std"   => "18",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "mini",
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", 'cavada' ),
	"id"    => "footer_font_size",
	"std"   => "13",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "mini",
);

$of_options[] = array(
	"name" => esc_html__( "Copyright Options", "cavada" ),
	"desc" => "",
	"id"   => "copyright_options",
	"std"  => esc_html__( "Copyright Options", "cavada" ),
	"icon" => true,
	"type" => "info"
);

$cavadadate   = getdate( date( "U" ) );
$of_options[] = array(
	"name" => esc_html__( "Copyright Text", "cavada" ),
	"desc" => esc_html__( "Enter copyright text", "cavada" ),
	"id"   => "footer_text",
	"std"  => "All rights reserved Copyright &copy; $cavadadate[year] - Designed by Villatheme",
	"type" => "textarea"
);

$of_options[] = array(
	"name"    => esc_html__( "Copyright Text Style", "cavada" ),
	"id"      => "copyright_style",
	"std"     => "right",
	"type"    => "select",
	"options" => array(
		'left'   => esc_html__( 'Left', 'cavada' ),
		'right'  => esc_html__( 'Right', 'cavada' ),
		'bottom' => esc_html__( 'Bottom', 'cavada' ),
		'center' => esc_html__( 'Center', 'cavada' )
	)
);
$of_options[] = array(
	"name" => esc_html__( "Full Width", 'cavada' ),
	"desc" => "Full Width",
	"id"   => "copyright_fullwidth",
	"std"  => 0,
	"type" => "checkbox"
);
$of_options[] = array(
	"name" => esc_html__( "Background Color", "cavada" ),
	"desc" => esc_html__( "Pick a background color.", "cavada" ),
	"id"   => "bg_copyright_color",
	"std"  => "#222222",
	"type" => "color"
);

$of_options[] = array(
	"name" => esc_html__( "Text Color", "cavada" ),
	"desc" => esc_html__( "Pick a text color for Copyright", "cavada" ),
	"id"   => "text_copyright_color",
	"std"  => "#7a7a7a",
	"type" => "color"
);

$of_options[] = array(
	"name"  => esc_html__( "Font Size (px)", 'cavada' ),
	"id"    => "copyright_font_size",
	"std"   => "13",
	"min"   => "1",
	"step"  => "1",
	"max"   => "100",
	"type"  => "sliderui",
	"class" => "mini",
);

$of_options[] = array(
	"name"  => esc_html__( "Back To Top", "cavada" ),
	"desc"  => "",
	"id"    => "totop_show",
	"std"   => 1,
	"folds" => 1,
	"on"    => esc_html__( "show", "cavada" ),
	"off"   => esc_html__( "hide", "cavada" ),
	"type"  => "switch"
);

$of_options[] = array(
	"name" => esc_html__( "Tracking code", "cavada" ),
	"desc" => esc_html__( "You can put tracking code eg: Google analytic, facebook....Please fill in <script></script>", "cavada" ),
	"id"   => "tracking_code",
	"std"  => "",
	"type" => "textarea"
);