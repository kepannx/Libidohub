<?php

vc_map( array(
	"name"        => esc_html__( "Video Background", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "video_background",
	"description" => "Video Background",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Heading", 'cavada' ),
			"param_name" => "heading",
			"value"      => "",
		),

		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading color', 'cavada' ),
			'param_name' => 'heading_color',
			'value'      => ''
		),
		array(
			"type"       => "textarea_html",
			"heading"    => esc_html__( "Content", 'cavada' ),
			"param_name" => "content",
			"value"      => "",
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'link Video (mp4/webm)', 'cavada' ),
			'param_name' => 'link_video',
			'value'      => '',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'link Video (ogg)', 'cavada' ),
			'param_name' => 'link_ogg',
			'value'      => '',
		),
		cavada_vc_map_add_css_animation( true )
	)
) );
function cavada_shortcode_video_background( $atts, $content = null ) {
	$heading = $heading_type = $heading_color = $link_video = $link_ogg = $css_animation = $cavada_animation = '';
	extract( shortcode_atts( array(
		'heading'       => '',
		'heading_color' => '',
		'link_video'    => '',
		'link_ogg'      => '',
		'css_animation' => ''
	), $atts ) );
	$cavada_animation = cavada_getCSSAnimation( $css_animation );
	$heading_type         = 'h3';
	$html                 = '<div class="vi-video-background' . $cavada_animation . '">';
	$html .= '<div class="content-video"><span class="bg-video-play"></span>';
	if ( $heading && $heading_type ) {
		$style_heading = $heading_color ? ' style="color:' . $heading_color . '"' : '';
		$html .= '<' . $heading_type . $style_heading . ' class="title-video">' . $heading . '</' . $heading_type . '>';
	}
	if ( $content ) {
		$html .= '<div class="desc-video">' . $content . '</div>';
	}
	$html .= '</div>';
	if ( $link_video || $link_ogg ) {
		$html .= '<video loop muted class="full-screen-video">';
		if ( $link_video ) {
			$html .= '<source src = "' . $link_video . '" type = "video/mp4" >';
		}
		if ( $link_ogg ) {
			$html .= '<source src = "' . $link_ogg . '" type = "video/ogg" >';
		}
		$html .= '</video>';
	}
	$html .= '</div>';

	return $html;
}

?>