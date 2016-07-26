<?php
vc_map( array(
		"name"     => esc_html__( "Vi Video", 'cavada' ),
		"icon"     => "icon-ui-splitter-horizontal",
		"base"     => "vi_video",
		"category" => esc_html__( "Villatheme", 'cavada' ),
		"params"   => array(
			array(
				'type'        => 'attach_image',
				'heading'     => esc_html__( 'Image default', 'cavada' ),
				'param_name'  => 'image_default',
				'description' => esc_html__( 'Please select image default', 'cavada' ),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Image size', 'cavada' ),
				'param_name'  => 'image_size',
				'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size.', 'cavada' ),
				'value'       => 'thumbnail'
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Links Video', 'cavada' ),
				'param_name'  => 'custom_links',
				'description' => esc_html__( 'Enter links video', 'cavada' ),
				'admin_label' => true
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
function cavada_shortcode_vi_video( $atts ) {
	$custom_links = $el_class = $css_animation = $cavada_animation = $video_html = $img_html = $img = '';
	extract( shortcode_atts( array(
		'image_default' => '',
		'image_size'    => 'thumbnail',
		'custom_links'  => '',
		'el_class'      => '',
		'css_animation' => ''
	), $atts ) );
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	/**
	 * Image
	 */
	if ( $image_default ) {
		$img = wp_get_attachment_image( $image_default, $image_size );
	}
	if ( $img ) {

		$img_html .= '<div class="video-inner"><a href="#" data-toggle="modal" data-target=".modal-vi-video">' . $img . '</a></div>';
	}

	$array_vimeo = array(
		'frameborder' => '0',
		'title'       => '0',
		'byline'      => '0',
		'portrait'    => '0'
	);
	/*Modal*/
	ob_start();
	wp_enqueue_script( 'cavada-bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '3.3.6', true );

	?>
	<!-- Modal -->
	<div class="modal fade modal-vi-video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<?php if ( $oembed = @wp_oembed_get( $custom_links, $array_vimeo ) ) {
						echo '<div class="videoWrapper">' . $oembed . '</div>';
					} ?>
				</div>

			</div>
		</div>
	</div>
	<?php
	$video_html = ob_get_clean();

	/*HTML Output*/
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );
	$html = '<div class="vi-video' . esc_attr( $cavada_animation ) . '">' . $img_html . $video_html . '</div>';

	return $html;
}


?>