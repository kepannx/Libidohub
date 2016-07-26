<?php
vc_map(
	array(
		"name"        => esc_html__( "Deal Of Day", 'cavada' ),
		"icon"        => "icon-ui-splitter-horizontal",
		"base"        => "deal",
		"description" => "Give you a timer countdown",
		"category"    => esc_html__( "Villatheme", 'cavada' ),
		"params"      => array(
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__( 'Title', 'cavada' ),
				'param_name' => 'title',
				'value'      => '',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Title color', 'cavada' ),
				'param_name' => 'title_color',
				'value'      => ''
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => esc_html__( 'Description', 'cavada' ),
				'param_name' => 'content',
				'value'      => '',
			),
			array(
				'type'        => 'datepicker',
				'heading'     => esc_html__( 'End Date', 'cavada' ),
				'param_name'  => 'end_date',
				'value'       => '',
				"description" => esc_html__( "Set end date to show timer countdown.", "cavada" ),
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Link Text", "cavada" ),
				"param_name"  => "link_text",
				"description" => esc_html__( "Show this text on link button.", "cavada" ),

			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Link", "cavada" ),
				"param_name"  => "link",
				'value'       => '#',
				"description" => esc_html__( "Link address", "cavada" ),

			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Extra class name", "cavada" ),
				"param_name"  => "el_class",
				"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cavada" ),
			),
			cavada_vc_map_add_css_animation( true )
		)
	)
);
function cavada_shortcode_deal( $atts, $content = null ) {

	$cavada_animation = $css_animation = $el_class = $end_date = $title_color = $title = $sub_title =
	$sub_title_color = $description = $link = $link_text = '';
	extract(
		shortcode_atts(
			array(
				'title'         => '',
				'title_color'   => '',
				'description'   => '',
				'end_date'      => '',
				'link_text'     => '',
				'link'          => '#',
				'css_animation' => '',
				'el_class'      => ''
			), $atts
		)
	);
	if ( cavada_get_dev_mode() ) {
		wp_enqueue_script( 'cavada-mb-commingsoon-script', get_template_directory_uri() . '/assets/js/jquery.mb-comingsoon.js', array('jquery'), '3022016' );
	} else {
		wp_enqueue_script( 'cavada-mb-commingsoon-script', get_template_directory_uri() . '/assets/js/jquery.mb-comingsoon.min.js', array('jquery'), '3022016' );
	}
	$current_time = strtotime( current_time( "Y-m-d G:i:s" ) );
	$end_date     = strtotime( $end_date );

	if ( $end_date < $current_time ) {
		return false;
	}
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	$html = '<div class="vi-dealofday' . $cavada_animation . '">';
	if ( $title ) {
		$title_css = $title_color ? ' style="color:' . $title_color . '"' : '';
		$html .= '<h2 ' . $title_css . '>' . esc_html( $title ) . '</h2>';
	}

	if ( $content ) {
		$html .= '<div class="dealofday-description">' . $content . '</div>';
	}
	/*Translate*/
	$localization = esc_html__( 'days', 'cavada' ) . ',' . esc_html__( 'hours', 'cavada' ) . ',' . esc_html__( 'minutes', 'cavada' ) . ',' . esc_html__( 'seconds', 'cavada' );
	$html .= '<div class="dealofday-timer" data-year="' . date( "Y", $end_date ) . '" data-month="' . date( "m", $end_date ) . '" data-date="' . date( "d", $end_date ) . '" data-hour="' . date( "G", $end_date ) . '" data-min="' . date( "i", $end_date ) . '" data-sec="' . date( "s", $end_date ) . '" data-gmt="' . get_option( 'gmt_offset' ) . '" data-text="' . $localization . '"></div>';
	if ( $link && $link_text ) {
		$html .= '<div class="dealofday-link"><a href="' . esc_url( $link ) . '">' . esc_html( $link_text ) . '</a></div>';
	}
	$html .= '</div>';

	return $html;
}

?>