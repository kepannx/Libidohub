<?php
// css custom
$of_options[] = array(
	"name" => esc_html__( "Custom CSS", "cavada" ),
	"type" => "heading",
	"icon" => CAVADA_ADMIN_IMAGES . "css.png"
);
$of_options[] = array(
	"name" => esc_html__( "Custom CSS", "cavada" ),
	"desc" => "",
	"id"   => "css_custom",
	"std"  => ".class_custom{}",
	"type" => "textarea"
);
