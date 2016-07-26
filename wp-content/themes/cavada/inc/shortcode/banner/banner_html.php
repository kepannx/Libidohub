<?php
vc_map(
	array(
		"name"        => esc_html__( "Banner Html", 'cavada' ),
		"icon"        => "icon-ui-splitter-horizontal",
		"base"        => "banner_html",
		"description" => "banner html",
		"category"    => esc_html__( "Villatheme", 'cavada' ),
		"params"      => array(
			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Heading", "cavada" ),
				"param_name" => "title",
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
				'heading'    => esc_html__( 'Background Text', 'cavada' ),
				'param_name' => 'bg_text_color',
				'value'      => ''
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text color', 'cavada' ),
				'param_name' => 'text_color',
				'value'      => ''
			),

			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Link Url", "cavada" ),
				"param_name" => "link_url",
			),
			array(
				'type'        => 'checkbox',
				'heading'     => 'Button Text Link',
				'admin_label' => false,
				'param_name'  => 'show_text_link',
				'description' => esc_html__( 'show button', 'cavada' )
			),
			array(
				"type"       => "textfield",
				"heading"    => esc_html__( "Text Link", "cavada" ),
				"param_name" => "text_url",
				'dependency' => array(
					'element' => 'show_text_link',
					'value'   => array( 'true' )
				),
			),
			array(
				'type'        => 'attach_image',
				'heading'     => esc_html__( 'Upload Image', 'cavada' ),
				'param_name'  => 'custom_image',
				'value'       => '',
				'description' => esc_html__( 'Select image from media library.', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Text align', 'cavada' ),
				'param_name'  => 'text_align',
				'value'       => array(
					esc_html__( 'Text Center', 'cavada' )        => 'text-center',
					esc_html__( 'Text Center Left', 'cavada' )   => 'text-left',
					esc_html__( 'Text Center Right', 'cavada' )  => 'text-right',
					esc_html__( 'Text Bottom Center', 'cavada' ) => 'text-bottom-center',
					esc_html__( 'Text Bottom Left', 'cavada' )   => 'text-bottom-left',
					esc_html__( 'Text Bottom Right', 'cavada' )  => 'text-bottom-right',
				),
				'std'         => 'text-left'
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Margin Bottom', 'cavada' ),
				'admin_label' => false,
				'param_name'  => 'between_bottom',
				'description' => esc_html__( 'gap between bottom.', 'cavada' ),
				'dependency'  => array(
					'element' => 'text_align',
					'value'   => array( 'text-bottom-right', 'text-bottom-left', 'text-bottom-center' )
				),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Effect', 'cavada' ),
				'param_name'  => 'effect',
				'value'       => array(
					esc_html__( 'No Effect', 'cavada' )  => 'default',
					esc_html__( 'Image Zoom', 'cavada' ) => 'image-zoom',
				),
				'std'         => 'default'
			),
			array(
				"type"        => "textfield",
				"heading"     => esc_html__( "Extra class name", "cavada" ),
				"param_name"  => "el_class",
				"description" => esc_html__( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "cavada" ),
			),
			cavada_vc_map_add_css_animation( true ),
			array(
				"type"        => "textfield",
				'admin_label' => false,
				"heading"     => esc_html__( "Sub Heading", 'cavada' ),
				"param_name"  => "sub_heading",
				"value"       => "",
				'group'       => esc_html__( 'Sub Heading', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => false,
				'heading'     => esc_html__( 'Sub Heading type', 'cavada' ),
				'param_name'  => 'sub_heading_type',
				'value'       => array(
					esc_html__( 'H2', 'cavada' ) => 'h2',
					esc_html__( 'H3', 'cavada' ) => 'h3',
					esc_html__( 'H4', 'cavada' ) => 'h4',
					esc_html__( 'H5', 'cavada' ) => 'h5',
					esc_html__( 'H6', 'cavada' ) => 'h6',
					esc_html__( 'p', 'cavada' )  => 'p',
				),
				'std'         => 'h3',
				'group'       => esc_html__( 'Sub Heading', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Position', 'cavada' ),
				'param_name'  => 'sub_position',
				'value'       => array(
					esc_html__( 'Above Heading', 'cavada' ) => 'above_heading',
					esc_html__( 'Below Heading', 'cavada' ) => 'below_heading'
				),
				'std'         => 'above_heading',
				'group'       => esc_html__( 'Sub Heading', 'cavada' ),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text color', 'cavada' ),
				'param_name' => 'sub_text_color',
				'value'      => '',
				'group'      => esc_html__( 'Sub Heading', 'cavada' ),

			),
			/*Description*/
			array(
				"type"        => "textfield",
				'admin_label' => false,
				"heading"     => esc_html__( "Description", 'cavada' ),
				"param_name"  => "description",
				"value"       => "",
				'group'       => esc_html__( 'Description', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => true,
				'heading'     => esc_html__( 'Position', 'cavada' ),
				'param_name'  => 'desc_position',
				'value'       => array(
					esc_html__( 'Above Heading', 'cavada' )     => 'above_heading',
					esc_html__( 'Above Sub Heading', 'cavada' ) => 'above_sub_heading',
					esc_html__( 'Bottom', 'cavada' )            => 'bottom',
				),
				'std'         => 'bottom',
				'group'       => esc_html__( 'Description', 'cavada' ),
			),
			array(
				'type'        => 'iconpicker',
				'heading'     => esc_html__( 'Icon', 'cavada' ),
				'param_name'  => 'icon_fontawesome',
				'value'       => '', // default value to backend editor admin_label
				'settings'    => array(
					'emptyIcon'    => false,
					'iconsPerPage' => 4000,
				),
				'description' => esc_html__( 'Select icon from library.', 'cavada' ),
				'group'       => esc_html__( 'Description', 'cavada' ),
			),
			array(
				'type'        => 'dropdown',
				'admin_label' => false,
				'heading'     => esc_html__( 'Description type', 'cavada' ),
				'param_name'  => 'desc_heading_type',
				'value'       => array(
					esc_html__( 'H2', 'cavada' ) => 'h2',
					esc_html__( 'H3', 'cavada' ) => 'h3',
					esc_html__( 'H4', 'cavada' ) => 'h4',
					esc_html__( 'H5', 'cavada' ) => 'h5',
					esc_html__( 'H6', 'cavada' ) => 'h6',
					esc_html__( 'p', 'cavada' )  => 'p',
				),
				'std'         => 'p',
				'group'       => esc_html__( 'Description', 'cavada' ),
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__( 'Text color', 'cavada' ),
				'param_name' => 'desc_text_color',
				'value'      => '',
				'group'      => esc_html__( 'Description', 'cavada' ),

			),
		)
	)
);


function cavada_shortcode_banner_html( $atts, $content = null ) {
	$cavada_animation = $css_animation = $el_class = $title = $link_url = $heading_type = $text_color = $sub_heading_type =
	$text_link = $html = $custom_image = $link_images = $effect = $text_align = $heading_style = $sub_heading =
	$sub_position = $sub_text_color = $bg_text_color = $style_heading = $style_css = $between_bottom = $show_text_link = $text_url = '';
	extract(
		shortcode_atts(
			array(
				'title'             => '',
				'heading_type'      => 'h2',
				'sub_heading'       => '',
				'sub_heading_type'  => 'h3',
				'sub_position'      => 'above_heading',
				'sub_text_color'    => '',
				'show_text_link'    => '',
				'text_url'          => '',
				'text_color'        => '',
				'bg_text_color'     => '',
				'text_link'         => '',
				'link_url'          => '',
				'custom_image'      => '',
				'text_align'        => 'text-left',
				'between_bottom'    => '',
				'effect'            => 'default',
				'el_class'          => '',
				'css_animation'     => '',
				'description'       => '',
				'desc_position'     => 'bottom',
				'icon_fontawesome'  => '',
				'desc_heading_type' => 'p',
				'desc_text_color'   => ''
			), $atts
		)
	);
	if ( $desc_text_color ) {
		$style = 'style="color:' . esc_attr( $desc_text_color ) . '"';
	} else {
		$style = '';
	}
	if ( $description ) {
		if ( $icon_fontawesome ) {
			$icon = '<i class="' . esc_attr( $icon_fontawesome ) . ' fa-fw"></i> ';
		} else {
			$icon = '';
		}
		$description = '<' . $desc_heading_type . ' class="description" ' . $style . '>' . $icon . esc_html( $description ) . '</' . $desc_heading_type . '>';
	}
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	if ( $custom_image ) {
		$image       = wp_get_attachment_image_src( $custom_image, 'full' );
		$link_images = $image[0];
	}
	if ( $link_images ) {
		$image       = '<img  src="' . $link_images . '" class="img-responsive" alt="" >';
		$class_image = 'image-banner ';
	} else {
		$image =  '';
		$class_image ='banner-html-no-image ';
	}

	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	if ( $between_bottom == true ) {
		$cavada_animation .= ' between_bottom';
	}
	$before_link = $after_link = $sub_title_css = $button = '';

	$style_heading .= $text_color ? 'color:' . $text_color . ';' : '';
	$style_heading .= $bg_text_color ? 'background-color:' . $bg_text_color . ';' : '';
	$style_css .= $style_heading ? ' style="' . $style_heading . '"' : '';
	$sub_title_css .= $sub_text_color ? ' style="color:' . $sub_text_color . '"' : '';

	if ( $sub_heading_type && $sub_heading ) {
		$sub_heading = '<' . $sub_heading_type . ' class="sub-title"' . $sub_title_css . '>' . $sub_heading . '</' . $sub_heading_type . '>';
		if ( $desc_position == 'above_sub_heading' ) {
			$sub_heading = $description . $sub_heading;
		}
	}

	if ( $link_url ) {
		$before_link = '<a href="' . $link_url . '">';
		$after_link  = '</a>';
	}
	if ( $show_text_link == true && $text_url && $link_url ) {
		$button = '<a href="' . $link_url . '" class="btn btn-default">' . $text_url . '</a>';
	}
	$html .= '
		<div class="' . $class_image . $effect . '"><div class="promo-banner' . $cavada_animation . '">' . $before_link . $image . $after_link . '
	        <div class="text-container ' . $text_align . '">
				<div class="text-hover"' . $style_css . '>';
	if ( $sub_position == 'above_heading' ) {
		$html .= $sub_heading;
	}
	if ( $desc_position == 'above_heading' ) {
		$html .= $description;
	}
	$html .= '<' . $heading_type . ' class="title">' . $before_link . $title . $after_link . '</' . $heading_type . '>';
	if ( $sub_position == 'below_heading' ) {
		$html .= $sub_heading;
	}
	if ( $desc_position == 'bottom' ) {
		$html .= $description;
	}
	$html .= $button;
	$html .= '</div>
	        </div>
		</div></div>
	';

	return $html;
}

?>