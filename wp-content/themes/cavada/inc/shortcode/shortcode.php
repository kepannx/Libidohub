<?php

if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	WC_Post_types::register_taxonomies();
}

if ( ! function_exists( 'cavada_vc_map_category_product' ) ) {
	function cavada_vc_map_category_product() {
		$args       = array(
			'pad_counts'         => 1,
			'show_counts'        => 1,
			'hierarchical'       => 1,
			'hide_empty'         => 1,
			'show_uncategorized' => 1,
			'orderby'            => 'name',
			'menu_order'         => false
		);
		$terms      = get_terms( 'product_cat', $args );
		$categories = array( esc_html__( 'Select Category', 'cavada' ) => 0 );
		if ( is_wp_error( $terms ) ) {
			// error occurred
		} else if ( empty( $terms ) ) {
			// no terms were found
		} else {
			// process terms
			foreach ( $terms as $term ) {
				$categories[$term->name] = $term->term_id;
			}
		}
		$data = array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Category Product', 'cavada' ),
			'param_name'  => 'category_product',
			'admin_label' => true,
			'value'       => $categories,
		);

		return apply_filters( 'cavada_vc_map_category_product', $data );
	}
}

if ( ! function_exists( 'cavada_vc_map_add_css_animation' ) ) {
	function cavada_vc_map_add_css_animation( $label = true ) {
		$data = array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'CSS Animation', 'cavada' ),
			'param_name'  => 'css_animation',
			'admin_label' => $label,
			'value'       => array(
				__( 'No', 'cavada' )                 => '',
				__( 'Top to bottom', 'cavada' )      => 'top-to-bottom',
				__( 'Bottom to top', 'cavada' )      => 'bottom-to-top',
				__( 'Left to right', 'cavada' )      => 'left-to-right',
				__( 'Right to left', 'cavada' )      => 'right-to-left',
				__( 'Appear from center', 'cavada' ) => 'appear'
			),
			'description' => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).', 'cavada' )
		);

		return apply_filters( 'cavada_vc_map_add_css_animation', $data, $label );
	}
}

if ( ! function_exists( 'cavada_getCSSAnimation' ) ) {
	function cavada_getCSSAnimation( $css_animation ) {
		$output = '';
		if ( $css_animation != '' ) {
			wp_enqueue_script( 'waypoints' );
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}

		return $output;
	}
}
//////////////////////////////////////////////////////////////////
// Remove extra P tags
//////////////////////////////////////////////////////////////////
function cavada_shortcodes_formatter( $content ) {
	$block = join( "|", array( "banner_html" ) );
	// opening tag
	$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );
	// closing tag
	$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)/", "[/$2]", $rep );

	return $rep;
}

add_filter( 'the_content', 'cavada_shortcodes_formatter' );
add_filter( 'widget_text', 'cavada_shortcodes_formatter' );

// Link to shortcodes
require_once( get_template_directory() . '/inc/shortcode/heading/heading.php' );
require_once( get_template_directory() . '/inc/shortcode/testimonials/testimonials.php' );
require_once( get_template_directory() . '/inc/shortcode/icon_box/icon_box.php' );
require_once( get_template_directory() . '/inc/shortcode/list_posts/list_posts.php' );
require_once( get_template_directory() . '/inc/shortcode/deal_countdown/deal.php' );
require_once( get_template_directory() . '/inc/shortcode/woocommerce/woo_category_tabs.php' );

require_once( get_template_directory() . '/inc/shortcode/woocommerce/woo_product.php' );
require_once( get_template_directory() . '/inc/shortcode/banner/banner_html.php' );
require_once( get_template_directory() . '/inc/shortcode/social-links/social-links.php' );
require_once( get_template_directory() . '/inc/shortcode/video-background/video_background.php' );
require_once( get_template_directory() . '/inc/shortcode/google/vi_google_map.php' );
require_once( get_template_directory() . '/inc/shortcode/video-background/vi_video.php' );

// register short code
if ( function_exists( 'Register_Vi_Vc_Addon' ) ) {
	Register_Vi_Vc_Addon(
		array(
			'heading',
			'testimonials',
			'icon_box',
			'list_posts',
			'deal',
			'woo_category_tabs',
			//		'woo_category',
			'woo_product',
			'banner_html',
			'social_link',
			'video_background',
			'vi_google_map',
			'twitter_feed',
			'vi_video'
		), 'cavada'
	);
}
