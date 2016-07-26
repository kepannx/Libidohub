<?php
vc_map( array(
	"name"        => esc_html__( "Social Links", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "social_link",
	"description" => "Social_link",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Face Url", "cavada" ),
			"param_name" => "face_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Twitter Url", "cavada" ),
			"param_name" => "twitter_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Google Url", "cavada" ),
			"param_name" => "google_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Dribble Url", "cavada" ),
			"param_name" => "dribble_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Linkedin Url", "cavada" ),
			"param_name" => "linkedin_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Instagram Url", "cavada" ),
			"param_name" => "instagram_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Youtube Url", "cavada" ),
			"param_name" => "youtube_url",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Behance Url", "cavada" ),
			"param_name" => "behance_url",
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__( "Extra class name", "cavada" ),
			"param_name"  => "el_class",
			"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cavada" ),
		),
		cavada_vc_map_add_css_animation( true )
	)
) );


function cavada_shortcode_social_link( $atts, $content = null ) {
	$cavada_animation = $css_animation = $el_class = $face_url = $twitter_url =
	$google_url = $html = $dribble_url = $linkedin_url = $instagram_url = $behance_url = $youtube_url = '';
	extract( shortcode_atts( array(
		'face_url'      => '',
		'twitter_url'   => '',
		'google_url'    => '',
		'dribble_url'   => '',
		'linkedin_url'  => '',
		'instagram_url' => '',
		'behance_url'   => '',
		'youtube_url'   => '',
		'el_class'      => '',
		'css_animation' => '',
	), $atts ) );
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	$html .= '<ul class="cavada_social_links' . $cavada_animation . '">';

	if ( $face_url != '' ) {
		$html .= '<li><a class="face hasTooltip" href="' . esc_url( $face_url ) . '" ><i class="fa fa-facebook"></i></a></li>';
	}
	if ( $twitter_url != '' ) {
		$html .= '<li><a class="twitter hasTooltip" href="' . esc_url( $twitter_url ) . '"  ><i class="fa fa-twitter"></i></a></li>';
	}
	if ( $google_url != '' ) {
		$html .= '<li><a class="google hasTooltip" href="' . esc_url( $google_url ) . '"  ><i class="fa fa-google-plus"></i></a></li>';
	}
	if ( $dribble_url != '' ) {
		$html .= '<li><a class="dribble hasTooltip" href="' . esc_url( $dribble_url ) . '"  ><i class="fa fa-dribbble"></i></a></li>';
	}
	if ( $linkedin_url != '' ) {
		$html .= '<li><a class="linkedin hasTooltip" href="' . esc_url( $linkedin_url ) . '"  ><i class="fa fa-linkedin"></i></a></li>';
	}

	if ( $instagram_url != '' ) {
		$html .= '<li><a class="instagram hasTooltip" href="' . esc_url( $instagram_url ) . '"  ><i class="fa fa-instagram"></i></a></li>';
	}
	if ( $youtube_url != '' ) {
		$html .= '<li><a class="youtube hasTooltip" href="' . esc_url( $youtube_url ) . '"  ><i class="fa fa-youtube"></i></a></li>';
	}
	if ( $behance_url != '' ) {
		$html .= '<li><a class="behance hasTooltip" href="' . esc_url( $behance_url ) . '"  ><i class="fa fa-behance"></i></a></li>';
	}
	$html .= '</ul>';

	return $html;
}

?>