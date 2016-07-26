<?php
$of_options[] = array(
	"name" => esc_html__( "General Settings", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "icon-settings.png"
);
/* Start oneClick */
$of_options[]  = array(
	"name" => esc_html__( "Backup And Restore Options", 'cavada' ),
	"id"   => "make_demo",
	"std"  => "",
	"type" => "import",
	"desc" => esc_html__( 'When click "Make site demo button. Your site will be made same site demo with your old data what will be kept"', 'cavada' ),
);
$of_options[]  = array(
	"name" => esc_html__( "Register Menu Navigation", 'cavada' ),
	"desc" => esc_html__( "Input menu name register. Foreach menu on a line", "cavada" ),
	"id"   => "reg_nav",
	"std"  => "Primary,Main menu\nFooter Menu\nSecondary menu",
	"type" => "textarea"
);
$title_page    = '';
$page_on_front = get_option( 'page_on_front', 0 );
$show_on_front = get_option( 'show_on_front', 'posts' );
if ( $page_on_front ) {
	$title_page = get_the_title( $page_on_front );
}

$of_options[] = array(
	"name" => esc_html__( "Front Page Displays", "cavada" ),
	"desc" => esc_html__( "Posts or page", "cavada" ),
	"id"   => "show_on_front",
	"std"  => $show_on_front,
	"type" => "hidden"
);
$of_options[] = array(
	"name" => esc_html__( "Page on front", "cavada" ),
	"desc" => esc_html__( "Page's ID", "cavada" ),
	"id"   => "page_on_front",
	"std"  => $page_on_front . ',' . @$title_page,
	"type" => "hidden"
);
/* End oneClick */

$logo         = get_template_directory_uri( 'template_directory' ) . '/images/logo.png';
$favicon      = get_template_directory_uri( 'template_directory' ) . '/images/favicon.png';
$of_options[] = array(
	"name" => esc_html__( "Header Logo", "cavada" ),
	"desc" => esc_html__( "Enter URL or Upload an image file as your logo.", "cavada" ),
	"id"   => "cavada_logo",
	"std"  => $logo,
	"type" => "media"
);
$of_options[] = array(
	"name" => esc_html__( "Header Logo(Retina)", "cavada" ),
	"desc" => esc_html__( "Enter URL or Upload an image file as your logo.", "cavada" ),
	"id"   => "cavada_logo_retina",
	"std"  => $logo,
	"type" => "media"
);
$of_options[] = array(
	"name" => esc_html__( "Sticky Header Logo ", "cavada" ),
	"desc" => esc_html__( "Enter URL or Upload an image file as your sticky header logo. user for header style 1,3", "cavada" ),
	"id"   => "cavada_sticky_logo",
	"std"  => $logo,
	"type" => "media"
);
$of_options[] = array(
	"name" => esc_html__( "Sticky Header Logo(Retina) ", "cavada" ),
	"desc" => esc_html__( "Enter URL or Upload an image file as your sticky header logo. user for header style 1,3", "cavada" ),
	"id"   => "cavada_sticky_logo_retina",
	"std"  => $logo,
	"type" => "media"
);
$of_options[] = array(
	"name" => esc_html__( "Width Logo", "cavada" ),
	"id"   => "width_logo",
	"std"  => "153",
	"min"  => "30",
	"step" => "1",
	"max"  => "650",
	"type" => "sliderui"
);

//$of_options[] = array(
//	"name" => esc_html__( "RTL Support", "cavada" ),
//	"desc" => "",
//	"id"   => "rtl_support_header",
//	"std"  => esc_html__( "RTL Support", "cavada" ),
//	"icon" => true,
//	"type" => "info"
//);
//$of_options[] = array(
//	"name" => "",
//	"desc" => esc_html__( "Enable/Disable", "cavada" ),
//	"id"   => "rtl_support",
//	"std"  => 0,
//	"type" => "checkbox"
//);
?>