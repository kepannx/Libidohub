<?php
// Styling Options
$of_options[] = array(
	"name" => esc_html__( "Styling Options", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "icon-paint.png"
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
	"name"    => esc_html__( "Layout", "cavada" ),
	"desc"    => esc_html__( "Select a layout", "cavada" ),
	"id"      => "box_layout",
	"std"     => "wide",
	"type"    => "select",
	"mod"     => "mini",
	"options" => array(
		'boxed' => 'Boxed',
		'wide'  => 'Wide',
	)
);

$of_options[] = array(
	"name" => esc_html__( "Preload", "cavada" ),
	"id"   => "show_preload",
	"std"  => 1,
	"type" => "checkbox",
	"desc" => esc_html__( "Check this box to show  Preload", "cavada" ),
);

$of_options[] = array(
	"name" => esc_html__( "Body Background Color", "cavada" ),
	"desc" => esc_html__( "Pick a background color for the theme (default: #f6f6f6).", "cavada" ),
	"id"   => "body_background",
	"std"  => "#f6f6f6",
	"type" => "color"
);

$of_options[] = array(
	"name"  => esc_html__( "Background Pattern", "cavada" ),
	"desc"  => "",
	"id"    => "user_bg_pattern",
	"std"   => 0,
	"folds" => 1,
	"on"    => "Use",
	"off"   => esc_html__( "Don't Use", "cavada" ),
	"type"  => "switch"
);

$of_options[] = array(
	"name"    => esc_html__( "Select a Background Pattern", "cavada" ),
	"desc"    => "",
	"fold"    => "user_bg_pattern",
	"id"      => "bg_pattern",
	"type"    => "images",
	"options" => array(
		get_template_directory_uri() . "/images/patterns/pattern1.png"  => get_template_directory_uri() . "/images/patterns/pattern1.png",
		get_template_directory_uri() . "/images/patterns/pattern2.png"  => get_template_directory_uri() . "/images/patterns/pattern2.png",
		get_template_directory_uri() . "/images/patterns/pattern3.png"  => get_template_directory_uri() . "/images/patterns/pattern3.png",
		get_template_directory_uri() . "/images/patterns/pattern4.png"  => get_template_directory_uri() . "/images/patterns/pattern4.png",
		get_template_directory_uri() . "/images/patterns/pattern5.png"  => get_template_directory_uri() . "/images/patterns/pattern5.png",
		get_template_directory_uri() . "/images/patterns/pattern6.png"  => get_template_directory_uri() . "/images/patterns/pattern6.png",
		get_template_directory_uri() . "/images/patterns/pattern7.png"  => get_template_directory_uri() . "/images/patterns/pattern7.png",
		get_template_directory_uri() . "/images/patterns/pattern8.png"  => get_template_directory_uri() . "/images/patterns/pattern8.png",
		get_template_directory_uri() . "/images/patterns/pattern9.png"  => get_template_directory_uri() . "/images/patterns/pattern9.png",
		get_template_directory_uri() . "/images/patterns/pattern10.png" => get_template_directory_uri() . "/images/patterns/pattern10.png",
	)
);
$of_options[] = array(
	"name" => esc_html__( "Upload Background", "cavada" ),
	"desc" => esc_html__( "Upload your own background", "cavada" ),
	"id"   => "bg_pattern_upload",
	"type" => "media"
);
$of_options[] = array(
	"name"    => esc_html__( "Background Repeat", "cavada" ),
	"desc"    => "",
	"id"      => "bg_repeat",
	"std"     => "no-repeat",
	"type"    => "select",
	"options" => array(
		'repeat'    => 'repeat',
		'repeat-x'  => 'repeat-x',
		'repeat-y'  => 'repeat-y',
		'no-repeat' => 'no-repeat'
	)
);
$of_options[] = array(
	"name"    => esc_html__( "Background Position", "cavada" ),
	"desc"    => esc_html__( "Set postion for your background", "cavada" ),
	"id"      => "bg_position",
	"std"     => "center center",
	"type"    => "select",
	"options" => array(
		'left top'      => 'Left Top',
		'left center'   => 'Left Center',
		'left bottom'   => 'Left Bottom',
		'right top'     => 'Right Top',
		'right center'  => 'Right Center',
		'right bottom'  => 'Right Bottom',
		'center top'    => 'Center Top',
		'center center' => 'Center Center',
		'center bottom' => 'Center Bottom'
	)
);
$of_options[] = array(
	"name"    => esc_html__( "Background Attachment", "cavada" ),
	"desc"    => esc_html__( "Select the type of background attachment", "cavada" ),
	"id"      => "bg_attachment",
	"std"     => "inherit",
	"type"    => "select",
	"options" => array(
		'scroll'  => 'scroll',
		'fixed'   => 'fixed',
		'local'   => 'local',
		'initial' => 'initial',
		'inherit' => 'inherit'
	)
);

$of_options[] = array(
	"name" => esc_html__( "Theme Primary Color", "cavada" ),
	"desc" => esc_html__( "Pick the primary color for the theme.", "cavada" ),
	"id"   => "body_color_primary",
	"std"  => "#dc4f45",
	"type" => "color"
);