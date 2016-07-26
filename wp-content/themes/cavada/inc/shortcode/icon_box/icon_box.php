<?php
vc_map( array(
	"name"        => esc_html__( "Icon Box", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "icon_box",
	"description" => "Heading",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon library', 'cavada' ),
			'value'       => array(
				esc_html__( 'Font Awesome', 'cavada' ) => 'fontawesome',
				esc_html__( 'Open Iconic', 'cavada' )  => 'openiconic',
				esc_html__( 'Typicons', 'cavada' )     => 'typicons',
				esc_html__( 'Entypo', 'cavada' )       => 'entypo',
				esc_html__( 'Linecons', 'cavada' )     => 'linecons',
				esc_html__( 'Custom Image', 'cavada' ) => 'custom_image',
			),
			'admin_label' => true,
			'param_name'  => 'type',
			'description' => esc_html__( 'Select icon library.', 'cavada' ),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'cavada' ),
			'param_name'  => 'icon_fontawesome',
			'value'       => 'fa fa-adjust', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false,
				'iconsPerPage' => 4000,
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'fontawesome',
			),
			'description' => esc_html__( 'Select icon from library.', 'cavada' ),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'cavada' ),
			'param_name'  => 'icon_openiconic',
			'value'       => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'openiconic',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'openiconic',
			),
			'description' => esc_html__( 'Select icon from library.', 'cavada' ),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'cavada' ),
			'param_name'  => 'icon_typicons',
			'value'       => 'typcn typcn-adjust-brightness', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'typicons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'typicons',
			),
			'description' => esc_html__( 'Select icon from library.', 'cavada' ),
		),
		array(
			'type'       => 'iconpicker',
			'heading'    => esc_html__( 'Icon', 'cavada' ),
			'param_name' => 'icon_entypo',
			'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
			'settings'   => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'entypo',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency' => array(
				'element' => 'type',
				'value'   => 'entypo',
			),
		),
		array(
			'type'        => 'iconpicker',
			'heading'     => esc_html__( 'Icon', 'cavada' ),
			'param_name'  => 'icon_linecons',
			'value'       => 'vc_li vc_li-heart', // default value to backend editor admin_label
			'settings'    => array(
				'emptyIcon'    => false, // default true, display an "EMPTY" icon?
				'type'         => 'linecons',
				'iconsPerPage' => 4000, // default 100, how many icons per/page to display
			),
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'linecons',
			),
			'description' => esc_html__( 'Select icon from library.', 'cavada' ),
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Upload Image', 'cavada' ),
			'param_name'  => 'icon_custom_image',
			'value'       => '', // default value to backend editor admin_label
			'dependency'  => array(
				'element' => 'type',
				'value'   => 'custom_image',
			),
			'description' => esc_html__( 'Select image from media library.', 'cavada' ),
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Font Size Icon", 'cavada' ),
			"param_name" => "font_size",
			"value"      => "",
		),
		array(
			"type"       => "colorpicker",
			"heading"    => esc_html__( "Color Icon", 'cavada' ),
			"param_name" => "color_icon",
			"value"      => "",
		),
		array(
			"type"       => "colorpicker",
			"heading"    => esc_html__( "Border Icon", 'cavada' ),
			"param_name" => "border_icon",
			"value"      => "",
		),
		array(
			"type"       => "textfield",
			"heading"    => esc_html__( "Width Icon Box", 'cavada' ),
			"param_name" => "width_icon",
			"value"      => "",
		),
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
			'std'         => 'h4'
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Heading color', 'cavada' ),
			'param_name' => 'heading_color',
			'value'      => ''
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Description', 'cavada' ),
			'param_name'  => 'content',
			'description' => esc_html__( 'Your description on heading', 'cavada' ),
			'value'       => "",
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon shape', 'cavada' ),
			'param_name'  => 'icon_style',
			'value'       => array(
				esc_html__( 'None', 'cavada' )    => '',
				esc_html__( 'Circle', 'cavada' )  => 'circle',
 			),
			'description' => esc_html__( 'Select background shape and style for icon.', 'cavada' )
		),

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon alignment', 'cavada' ),
			'param_name'  => 'align',
			'value'       => array(
				esc_html__( 'Left', 'cavada' )   => 'left',
				esc_html__( 'Right', 'cavada' )  => 'right',
				esc_html__( 'Center', 'cavada' ) => 'center',
			),
			'description' => esc_html__( 'Select icon alignment.', 'cavada' ),
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__( "Extra class name", "cavada" ),
			"param_name"  => "el_class",
			"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cavada" ),
		),
		cavada_vc_map_add_css_animation( true )
	),
	'js_view'     => 'VcIconElementView_Backend',
) );
function cavada_shortcode_icon_box( $atts, $content = null ) {
	$type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_custom_image = $el_class = $icon_style = $align = $style_icon =
	$icon_entypo = $icon_linecons = $css_animation = $css = $cavada_animation = $heading = $heading_type = $heading_color =
	$font_size = $color_icon = $width_icon = $border_icon  = $style_content = '';
	extract( shortcode_atts( array(
		'type'              => 'fontawesome',
		'icon_fontawesome'  => 'fa fa-adjust',
		'icon_openiconic'   => 'vc-oi vc-oi-dial',
		'icon_typicons'     => 'typcn typcn-adjust-brightness',
		'icon_entypo'       => 'entypo-icon entypo-icon-note',
		'icon_linecons'     => 'vc_li vc_li-heart',
		'icon_custom_image' => '',
		'heading'           => '',
		'heading_type'      => 'h4',
		'heading_color'     => '',
		'align'             => 'left',
		'icon_style'        => '',
		'font_size'         => '',
		'color_icon'        => '',
		'width_icon'        => '',
		'border_icon'           => '',
 		'el_class'          => '',
		'css_animation'     => '',
	), $atts ) );
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= ' icon-' . $align;
	vc_icon_element_fonts_enqueue( $type );
	$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';
	if ( $type == 'custom_image' ) {
		$link = wp_get_attachment_image_src( $iconClass, 'full' );
	}

	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	$html = '<div class="sc-icon-boxed' . $cavada_animation . '">';
	$style_icon .= $font_size ? 'font-size:' . $font_size . 'px;' : '';
	$style_icon .= $color_icon ? 'color:' . $color_icon . ';' : '';
	$style_icon .= $border_icon ? 'border:2px solid ' . $border_icon . ';' : '';
	$style_icon .= $width_icon ? 'width:' . $width_icon . 'px; height:' . $width_icon . 'px;line-height:' . $width_icon . 'px' : '';
	if ( $align != 'center' ) {
		$style_content = $width_icon ? ' style="width:calc(100% - ' . $width_icon . 'px)"' : '';
	}
	$style_css = $style_icon ? ' style="' . $style_icon . '"' : '';
	if ( $type == 'custom_image' ) {
		$html .= '<div class="box-icon icon-image ' . $icon_style . '"' . $style_css . '><img src="' . $link[0] . '"></div>';
	} else {
		$html .= '<div class="box-icon ' . $icon_style . '"' . $style_css . '><i class="vc_icon_element-icon ' . $iconClass . '"></i></div>';
	}
	if ( $content || $heading ) {
		$html .= '<div class="icon-box-content" ' . $style_content . '>';
	}
	if ( $heading && $heading_type ) {
		$style_heading = $heading_color ? ' style="color:' . $heading_color . '"' : '';
		$html .= '<' . $heading_type . $style_heading . ' class="title">' . $heading . '</' . $heading_type . '>';
	}
	if ( $content ) {
		$html .= '<div class="description"> ' . $content . '</div>';
	}
	if ( $content || $heading ) {
		$html .= '</div>';
	}
	$html .= '</div>';

	return $html;
}

?>