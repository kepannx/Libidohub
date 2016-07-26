<?php
if ( ! function_exists( 'cavada_wrapper_layout' ) ) :
	function cavada_wrapper_layout() {
		global $cavada_data, $wp_query;
		$using_custom_layout = $wrapper_layout = $cat_ID = '';
		$class_col           = 'col-sm-9 alignright';

		if ( get_post_type() == "product" ) {
			$prefix = 'villa_woo';
		} else {
			if ( is_front_page() || is_home() ) {
				$prefix = 'villa_front_page';
			} else {
				$prefix = 'villa_archive';
			}
		}
		// get id category
		$cat_obj = $wp_query->get_queried_object();
		if ( isset( $cat_obj->term_id ) ) {
			$cat_ID = $cat_obj->term_id;
		}
		// get layout
		if ( is_page() || is_single() ) {
			$postid = get_the_ID();
			if ( isset( $cavada_data[ $prefix . '_single_layout' ] ) ) {
				$wrapper_layout = $cavada_data[ $prefix . '_single_layout' ];
			}
			/***********custom layout*************/
			$using_custom_layout = get_post_meta( $postid, 'custom_layout', true );
			if ( $using_custom_layout ) {
				$wrapper_layout = get_post_meta( $postid, 'layout', true );
			}
		} else {
			if ( isset( $cavada_data[ $prefix . '_cate_layout' ] ) ) {
				$wrapper_layout = $cavada_data[ $prefix . '_cate_layout' ];
			}

			/***********custom layout*************/
			$using_custom_layout = cavada_get_tax_meta( $cat_ID, 'vi_layout', true );
			if ( $using_custom_layout <> '' ) {
				$wrapper_layout = cavada_get_tax_meta( $cat_ID, 'vi_layout', true );
			}
		}
		if ( $wrapper_layout == 'full-content' ) {
			$class_col = "col-sm-12 full-width";
		}
		if ( $wrapper_layout == 'sidebar-right' ) {
			$class_col = "col-sm-9 alignleft";
		}
		if ( $wrapper_layout == 'sidebar-left' ) {
			$class_col = 'col-sm-9 alignright';
		}

		return $class_col;
	}
endif;
add_action( 'cavada_wrapper_loop_start', 'cavada_wrapper_loop_start' );
if ( ! function_exists( 'cavada_wrapper_loop_start' ) ) :
	function cavada_wrapper_loop_start() {
		global $wp_query;
		$post_type        = get_post_type();
		$class_no_padding = $schema_sigle = '';

		if ( is_page() || is_single() ) {
			$mtb_no_padding = get_post_meta( get_the_ID(), 'vi_no_padding', true );
			if ( $mtb_no_padding ) {
				$class_no_padding = ' no-padding-top';
			}

		}
		if ( ( is_page() || is_single() ) && get_post_type() != "product" ) {
			if ( is_page() ) {
				$schema_sigle = 'itemscope="itemscope" itemtype="https://schema.org/CreativeWork"';
			} else {
				$schema_sigle = 'itemscope itemtype="http://schema.org/Article"';
			}
		}
		$class_col = cavada_wrapper_layout();
		// setting product
		if ( get_post_type() == "product" ) {
			$cat_ID = '';


			$cat_obj = $wp_query->get_queried_object();
			if ( isset( $cat_obj->term_id ) ) {
				$cat_ID                = $cat_obj->term_id;
				$default_layout_custom = cavada_get_tax_meta( $cat_ID, 'vi_layout_default', true );
				if ( $default_layout_custom != '' ) {
					$default_layout = $default_layout_custom;
				}
			}
		}

		echo '<div class="site-content' . $class_no_padding . '"><div class="container"><div class="row"><main id="main" class="site-main ' . $class_col . ' ' . $post_type . '" role="main" ' . $schema_sigle . '>';
	}
endif;
add_action( 'cavada_wrapper_loop_end', 'cavada_wrapper_loop_end' );
if ( ! function_exists( 'cavada_wrapper_loop_end' ) ) :
	function cavada_wrapper_loop_end() {
		$class_col = cavada_wrapper_layout();
		echo '</main>';
		if ( $class_col != 'col-sm-12 full-width' ) {
			if ( get_post_type() == "product" ) {
				get_sidebar( 'shop' );
			} else {
				get_sidebar();
			}
		}
		echo '</div></div></div>';
	}
endif;