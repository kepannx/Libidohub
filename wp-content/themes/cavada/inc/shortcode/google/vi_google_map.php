<?php
vc_map(
	array(
		"name"        => esc_html__( "Vi Google Map", 'cavada' ),
		"icon"        => "icon-ui-splitter-horizontal",
		"base"        => "vi_google_map",
		"description" => "Show google map",
		"category"    => esc_html__( "Villatheme", 'cavada' ),
		"params"      => array(
			array(
				"type"        => "textfield",
				'admin_label' => true,
				"heading"     => esc_html__( "Title", 'cavada' ),
				"param_name"  => "title",
				"value"       => "",
				'description' => esc_html__( 'Title on marker.', 'cavada' ),
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Latitude", 'cavada' ),
				"param_name"  => "lat",
				"value"       => "40.6700",
				'description' => esc_html__( 'Latitude is a geographic coordinate that specifies the north-south position of a point on the Earth\'s surface.', 'cavada' ),
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Longitude", 'cavada' ),
				"param_name"  => "long",
				"value"       => "-73.9400",
				'description' => esc_html__( 'Longitude is a geographic coordinate that specifies the east-west position of a point on the Earth\'s surface.', 'cavada' ),
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Zoom", 'cavada' ),
				"param_name"  => "zoom",
				"value"       => "14",
				'description' => esc_html__( 'Longitude is a geographic coordinate that specifies the east-west position of a point on the Earth\'s surface.', 'cavada' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Show Title', 'cavada' ),
				'param_name' => 'show_title',
				'value'      => array(
					__( 'No', 'cavada' )  => '0',
					__( 'Yes', 'cavada' ) => '1',
				),
				'std'        => '1'
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__( 'Show Marker', 'cavada' ),
				'param_name' => 'show_marker',
				'value'      => array(
					__( 'No', 'cavada' )  => '0',
					__( 'Yes', 'cavada' ) => '1',
				),
				'std'        => '1'
			),
			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Width", 'cavada' ),
				"param_name" => "width",
				"value"      => "100%"
			),
			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Height", 'cavada' ),
				"param_name" => "height",
				"value"      => "400px"
			),
			cavada_vc_map_add_css_animation( true )
		)
	)
);


/**
 * Register shortcode
 *
 */
function cavada_shortcode_vi_google_map( $atts, $content = null ) {
	$show_title = $title = $zoom = $lat = $long = $show_marker = $width = $height = '';
	extract(
		shortcode_atts(
			array(
				'title'       => '',
				'lat'         => '40.6700',
				'long'        => '-73.9400',
				'zoom'        => 14,
				'show_marker' => 1,
				'show_title'  => 1,
				'height'      => '400px',
				'width'       => '100%'
			), $atts
		)
	);
	ob_start();
	$data = '';
	wp_enqueue_script( 'cavada-google-map', "https://maps.googleapis.com/maps/api/js?sensor=false", array('jquery'),'3022016', false );
	if ( cavada_get_dev_mode() ) {
		wp_enqueue_script( 'cavada-jquery-shortcode-gmap-script', get_template_directory_uri() . "/assets/js/shortcode-gmap.js", array('jquery'),'3022016', false );
	} else {
		wp_enqueue_script( 'cavada-jquery-shortcode-gmap-script', get_template_directory_uri() . "/assets/js/shortcode-gmap.min.js", array('jquery'),'3022016', false );
	}
	if ( $show_title ) {
		$data = 'data-title="' . esc_attr( $title ) . '"';
	}
	$data .= ' data-zoom="' . esc_attr( $zoom ) . '"';
	$data .= ' data-lat="' . esc_attr( $lat ) . '"';
	$data .= ' data-long="' . esc_attr( $long ) . '"';
	$data .= ' data-marker="' . esc_attr( $show_marker ) . '"';

	echo '<div class="vi-google-map"><div id="vi_gmap"  ' . $data . ' style="width: ' . $width . ';height: ' . $height . '"></div></div>';

	$output = ob_get_clean();

	return $output;
}

?>