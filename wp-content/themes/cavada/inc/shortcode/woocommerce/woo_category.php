<?php
vc_map( array(
	"name"        => esc_html__( "Category Product", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "woo_category",
	"description" => "Show category product",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		cavada_vc_map_category_product(),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Upload Custom Image', 'cavada' ),
			'param_name'  => 'custom_image',
			'value'       => '',
			'description' => esc_html__( 'Select image from media library.', 'cavada' ),
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


function cavada_shortcode_woo_category( $atts, $content = null ) {
	$cavada_animation = $css_animation = $el_class = $product_category = $category_product = $html = $custom_image = $link_images = '';
	extract( shortcode_atts( array(
		'category_product' => '',
		'custom_image'     => '',
		'el_class'         => '',
		'css_animation'    => '',
	), $atts ) );
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );

	$category_product = 37;
	if ( $category_product ) {
		$term        = get_term_by( 'id', $category_product, 'product_cat', 'ARRAY_A' );
		$term['url'] = get_term_link( $term['slug'], 'product_cat' );
		//get product category thumbnail
		$term['cat_thumb_url'] = wp_get_attachment_url( get_woocommerce_term_meta( $category_product, 'thumbnail_id', true ) );
		if ( $custom_image ) {
			$image       = wp_get_attachment_image_src( $custom_image, 'full' );
			$link_images = $image[0];
		} else {
			$link_images = $term['cat_thumb_url'];
		}
		if ( $el_class ) {
			$cavada_animation .= ' ' . $el_class;
		}
		$html .= '<div class="effect-one"><div class="promo-banner' . $cavada_animation . '">
   		<a href="' . $term['url'] . '"><img alt="' . $term['name'] . '" src="' . $link_images . '" class="img-responsive"></a>
    	<div class="text-container text-bottom-right">
			<div class="text-hover">
       			 <h2 class="title-cats">' . $term['name'] . '</h2>
				<a class="a-default pull-right" href="' . $term['url'] . '">'.esc_html__('SHOP NOW','cavada').'</a>
			</div>
        </div>
	</div></div>';
	}
	return $html;
}
?>