<?php
vc_map( array(
	"name"        => esc_html__( "Testimonial", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "testimonials",
	"description" => "Testimonial",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		array(
			'type'        => 'dropdown',
			'admin_label' => true,
			'heading'     => esc_html__( 'Select Layout', 'cavada' ),
			'param_name'  => 'select_layout',
			'value'       => array(
				esc_html__( 'Layout 01', 'cavada' ) => 'layout_01',
				esc_html__( 'Layout 02', 'cavada' ) => 'layout_02',
				esc_html__( 'Layout 03', 'cavada' ) => 'layout_03',
				esc_html__( 'Layout 04', 'cavada' ) => 'layout_04'
			),
			'std'         => 'layout_01'
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Testimonial Background color', 'cavada' ),
			'param_name' => 'bg_color',
			'value'      => '',
			'dependency' => array( 'element' => 'select_layout', 'value' => 'layout_01', )
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Testimonial color', 'cavada' ),
			'param_name' => 'testimonial_color',
			'value'      => ''
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Number Post', 'cavada' ),
			'param_name' => 'number_post',
			'value'      => '4',
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
function cavada_shortcode_testimonials( $atts, $content = null ) {
	$number_post = $cavada_animation = $css_animation = $el_class = $separator_style = $testimonial_color = $bg_color = $select_layout = '';
	extract( shortcode_atts( array(
		'testimonial_color' => '',
		'bg_color'          => '',
		'number_post'       => '4',
		'el_class'          => '',
		'css_animation'     => '',
		'select_layout'     => 'layout_01',
	), $atts ) );
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	$testomonial_args = array(
		'post_type'      => 'testimonials',
		'posts_per_page' => $number_post
	);
	$lop_testimonial  = new WP_Query( $testomonial_args );

	$html                    = '<div class="vi-testimonials ' . $select_layout . $cavada_animation . '">';
	$testimonial_color_style = $testimonial_style = $style_arrow = '';
	$testimonial_color_style .= $testimonial_color ? 'color:' . $testimonial_color . ';' : '';
	if ( $select_layout == 'layout_01' ) {
		$testimonial_color_style .= $bg_color ? 'background-color:' . $bg_color . ';' : '';
		$style_arrow = $bg_color ? ' style="border-top: 10px solid ' . $bg_color . '"' : '';
	}
	$testimonial_style = $testimonial_color_style ? ' style="' . $testimonial_color_style . '"' : '';

	if ( $lop_testimonial->have_posts() ) {
		$html .= '<div class="vi-inner-testimonials">';
		while ( $lop_testimonial->have_posts() ): $lop_testimonial->the_post();
			$html .= '<div class="item_testimonial"' . $testimonial_style . '>';

			if ( $select_layout == 'layout_04' ) {
				if ( has_post_thumbnail() ) {
					$html .= '<div class="avatar-testimonial">';
					$html .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
					$html .= '</div>';
				}
			}

			$web_link        = get_post_meta( get_the_ID(), 'website_url', true );
			$before_web_link = $after_web_link = '';
			if ( $web_link <> '' ) {
				$before_web_link = '<a href="' . $web_link . '">';
				$after_web_link  = "</a>";
			}
			$regency = get_post_meta( get_the_ID(), 'regency', true );
			if ( $select_layout == 'layout_01' ) {
				if ( has_post_thumbnail() ) {
					$html .= '<div class="avatar-testimonial">';
					$html .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
					$html .= '</div>';
				}
			}

			$html .= '<div class="testimonial_content">';
			$html .= '<span class="arrow"' . $style_arrow . '></span>';
			$html .= get_the_content();
			$html .= '</div>';

			$html .= '<div class="testimonial-footer">';
			if ( $select_layout == 'layout_02' || $select_layout == 'layout_03' ) {
				if ( has_post_thumbnail() ) {
					$html .= '<div class="avatar-testimonial">';
					$html .= get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
					$html .= '</div>';
				}
			}
			$html .= '<div class="title-regency">';
			$html .= '<h5> ' . $before_web_link . the_title( ' ', ' ', false ) . $after_web_link . ' </h5>';
			if ( $regency <> '' ) {
				$html .= '<div class="regency">' . $regency . '</div>';
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		endwhile;
		$html .= '</div>';
	}
	wp_reset_postdata();

	$html .= '</div>';

	return $html;
}

?>