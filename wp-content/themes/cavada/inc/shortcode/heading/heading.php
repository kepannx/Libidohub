<?php
vc_map(
	array(
		"name"        => esc_html__( "Heading", 'cavada' ),
		"icon"        => "icon-ui-splitter-horizontal",
		"base"        => "heading",
		"description" => "Heading",
		"category"    => esc_html__( "Villatheme", 'cavada' ),
		"params"      => array(
			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Heading", 'cavada' ),
				"param_name" => "heading",
				"value"      => "",
				"holder"     => "div"
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Heading type', 'cavada' ),
				'param_name'  => 'heading_type',
				'value'       => array(
					esc_html__( 'H2', 'cavada' ) => 'h2',
					esc_html__( 'H3', 'cavada' ) => 'h3',
					esc_html__( 'H4', 'cavada' ) => 'h4',
					esc_html__( 'H5', 'cavada' ) => 'h5',
					esc_html__( 'H6', 'cavada' ) => 'h6'
				),
				'std'         => 'h2'
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Heading color', 'cavada' ),
				'param_name' => 'heading_color',
				'value'      => ''
			),

			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Heading Style', 'cavada' ),
				'param_name'  => 'heading_style',
				'value'       => array(
					esc_html__( 'Style 01', 'cavada' ) => 'style_01',
					esc_html__( 'Style 02', 'cavada' ) => 'style_02',
					esc_html__( 'Style 03', 'cavada' ) => 'style_03',
					esc_html__( 'Style 04', 'cavada' ) => 'style_04'
				),
				'std'         => 'style_01'
			),
			array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'cavada' ),
				'param_name'  => 'icon_fontawesome',
				'value'       => 'fa fa-automobile', // default value to backend editor admin_label
				'settings'    => array(
					'emptyIcon'    => false,
					'iconsPerPage' => 4000,
				),
				'dependency'  => array(
					'element' => 'heading_style',
					'value'   => 'style_04',
				),
				'description' => esc_html__( 'Select icon from library.', 'cavada' ),
			),
			array(
				"type"        => "textarea",
				'admin_label' => true,
				"heading"     => esc_html__( "Description", 'cavada' ),
				"param_name"  => "description",
				"value"       => "",
				'dependency'  => array(
					'element' => 'heading_style',
					'value'   => 'style_04',
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Heading Align', 'cavada' ),
				'param_name'  => 'heading_align',
				'value'       => array(
					esc_html__( 'Left', 'cavada' )   => 'text_left',
					esc_html__( 'Center', 'cavada' ) => 'text_center'
				),
				'std'         => 'text_left',
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_03', 'style_04' )
				),
			),
			array(
				"type"        => "textfield",
				'admin_label' => true,
				"heading"     => esc_html__( "Sub Heading", 'cavada' ),
				"param_name"  => "sub_heading",
				"value"       => "",
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Sub Heading color', 'cavada' ),
				'param_name' => 'sub_heading_color',
				'value'      => '',
				"dependency" => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Position Description', 'cavada' ),
				'param_name'  => 'pos',
				'value'       => array(
					esc_html__( 'Default', 'cavada' )      => '',
					esc_html__( 'Before Title', 'cavada' ) => 'before_title',
				),
				'std'         => '',
				"dependency"  => Array(
					"element" => "heading_style",
					"value"   => array( 'style_02' )
				),
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
function cavada_shortcode_heading( $atts, $content = null ) {
	$sub_heading = $heading = $heading_type = $sub_heading_color = $heading_color = $pos = $heading_style =
	$signature_color = $bg_separator_color = $css_animation = $cavada_animation = $el_class = $star = $heading_align = '';
	extract(
		shortcode_atts(
			array(
				'heading'           => '',
				'heading_align'     => 'text_left',
				'heading_type'      => 'h2',
				'heading_color'     => '',
				'sub_heading'       => '',
				'sub_heading_color' => '',
				'heading_style'     => 'style_01',
				'pos'               => '',
				'el_class'          => '',
				'css_animation'     => '',
				'icon_fontawesome'  => 'fa fa-automobile',
				'description'       => ''
			), $atts
		)
	);
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	if ( $heading_style == 'style_03' || $heading_style == 'style_04' ) {
		$cavada_animation .= ' ' . $heading_align;
	}

	// heading
	$style_heading = $heading_color ? ' style="color:' . $heading_color . '"' : '';
	$title_heading = ( $heading && $heading_type ) ? '<' . $heading_type . $style_heading . ' class="title"><span>' . $heading . '</span></' . $heading_type . '>' : '';
	// sub heading
	$style_heading = $sub_heading_color ? ' style="color:' . $sub_heading_color . '"' : '';
	$sub_head      = $sub_heading ? '<div class="description"' . $style_heading . '><span>' . $sub_heading . '</span></div>' : '';

	$cavada_animation .= cavada_getCSSAnimation( $css_animation );
	$html = '<div class="vi-heading heading-' . $heading_style . $cavada_animation . '">';
	if ( $pos == 'before_title' ) {
		$html .= $sub_head;
	}
	/* Title */
	$html .= $title_heading;
	if ( $heading_style == 'style_04' ) {
		if ( $icon_fontawesome ) {
			$html .= '<div class="heading-icon"> <i class="' . esc_attr( $icon_fontawesome ) . '"></i></div>';
		}
		if ( $description ) {
			$html .= '<div class="heading-desc">' . $description . '</div>';
		}
		$html .= $sub_head;
	}
	/* Icon */
	if ( $pos == '' ) {
		$html .= $sub_head;
	}

	$html .= '</div>';

	return $html;
}

?>