<?php

/**
 * Class CAVADA_Ajax
 * Class load ajax
 */
class CAVADA_Ajax {
	public function __construct() {
		/*Woocommerce cagegory tab*/
		/*Get category*/
		add_action( 'wp_ajax_vi_get_category', array( $this, 'cavada_get_category_callback' ) );
		add_action( 'wp_ajax_nopriv_vi_get_category', array( $this, 'cavada_get_category_callback' ) );
		/*Get product*/
		add_action( 'wp_ajax_vi_get_product', array( $this, 'cavada_get_product_callback' ) );
		add_action( 'wp_ajax_nopriv_vi_get_product', array( $this, 'cavada_get_product_callback' ) );

		/*Search ajax*/
		add_action( 'wp_ajax_vi_ajax_search', array( $this, 'ajax_search_callback' ) );
		add_action( 'wp_ajax_nopriv_vi_ajax_search', array( $this, 'ajax_search_callback' ) );
		/*Init ajax if site working with AJAX*/
		add_action( 'wp_enqueue_scripts', array( $this, 'ajax_product_scripts' ) );
	}

	/**
	 * Ajax search
	 */
	public function ajax_search_callback() {
		global $wpdb;
		$keyword = filter_input( INPUT_POST, 'keyword', FILTER_SANITIZE_STRING );
		$limit   = filter_input( INPUT_POST, 'limit', FILTER_SANITIZE_NUMBER_INT );
		$results = array();
		if ( $keyword ) {
			$keyword = strtoupper( $keyword );
			$ids     = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE (UCASE(post_title) LIKE '%$keyword%' OR UCASE(post_content) LIKE '%$keyword%' )AND post_type IN ('post','product') AND post_status='publish'" ) );
			if ( count( $ids ) > 0 ) {
				$showmore = false;
				if ( count( $ids ) > $limit ) {
					$showmore = true;
				}
				$search_query = array(
					'post__in'       => $ids,
					'order'          => 'DESC',
					'orderby'        => 'date',
					'post_type'      => array( 'post', 'product' ),
					'posts_per_page' => $limit
				);

				$search = new WP_Query( $search_query );
				$search = $search->posts;

				foreach ( $search as $kb ) {

					$results[] = array(
						'id'        => $kb->ID,
						'title'     => $this->cavada_search_highlight( $keyword, $kb->post_title ),
						'guid'      => get_permalink( $kb->ID ),
						'date'      => mysql2date( 'M d Y', $kb->post_date ),
						'post_type' => $kb->post_type
					);
				}

				if ( $showmore ) {
					$results[] = array(
						'id'        => '',
						'title'     => esc_html__( 'Show more', 'cavada' ),
						'guid'      => get_search_link( $keyword ),
						'date'      => '',
						'post_type' => 'showmore'
					);
				}
			} else {
				$results[] = array(
					'id'        => '',
					'title'     => esc_html__( 'Your search did not match any posts and products.', 'cavada' ),
					'guid'      => '#',
					'date'      => '',
					'post_type' => ''
				);
			}
			ob_end_clean();
			echo json_encode( $results );
		}
		die;
	}

	/**
	 * Function replace keyword in paragraph
	 *
	 * @param string $keyword
	 * @param string $string
	 *
	 * @return string
	 */
	public function cavada_search_highlight( $keyword = '', $string = '' ) {
		if ( $keyword ) {
			$keyword = strip_tags( $keyword );
			$string  = preg_replace( "/{$keyword}/iu", "<span class='vi-lighter'>$0</span>", $string );
		}

		return $string;
	}

	/**
	 * Init ajax
	 */
	public function ajax_product_scripts() {
		global $cavada_data;

		if ( ! isset( $cavada_data['ajax_settings_run'] ) ) {
			return;
		}
		if ( $cavada_data['ajax_settings_run'] == 'no' || ! $cavada_data['ajax_settings_run'] ) {
			return;
		}

		if ( is_archive() || is_home() ) {
			if ( cavada_get_dev_mode() ) {
				wp_enqueue_script( 'cavada-jquery-jscroll-min', get_template_directory_uri() . '/assets/js/jquery.jscroll.js', array(), '3022016' );
				wp_enqueue_script( 'cavada-jquery-ajax', get_template_directory_uri() . '/assets/js/jquery.ajax-load-page.js', array(), '3022016', true );
			} else {
				wp_enqueue_script( 'cavada-jquery-jscroll-min', get_template_directory_uri() . '/assets/js/jquery.jscroll.min.js', array(), '3022016' );
				wp_enqueue_script( 'cavada-jquery-ajax', get_template_directory_uri() . '/assets/js/jquery.ajax-load-page.min.js', array(), '3022016', true );
			}
		}

	}

	/**
	 * Get category
	 */
	public function cavada_get_category_callback() {
		$msg   = array();
		$id    = filter_input( INPUT_POST, 'data', FILTER_VALIDATE_INT );
		$limit = filter_input( INPUT_POST, 'limit', FILTER_VALIDATE_INT );
		if ( $id ) {
			$limit = intval( $limit ) ? $limit : 5;
			$args  = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => $id
					)
				),
				'posts_per_page' => $limit
			);
		} else {
			$limit = intval( $limit ) ? $limit : 5;
			$args  = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => $limit
			);
		}

		$products = new WP_Query( $args );

		if ( $products->have_posts() ) {
			$results = array();
			while ( $products->have_posts() ) {
				$products->the_post();
				$prd            = new WC_Product_Simple( get_the_ID() );
				$product        = new stdClass();
				$product->id    = get_the_ID();
				$product->title = the_title( '<a href="' . get_the_permalink( $product->id ) . '" title="' . get_the_title( $product->id ) . '">', '</a>', false );

				/*Get price*/
				ob_start();
				woocommerce_template_single_price();
				$product->price = ob_get_clean();

				$product->rate = $prd->get_rating_html();

				$product->add_to_cart = '<ul class="icon-links"><li>' . apply_filters(
						'woocommerce_loop_add_to_cart_link',
						sprintf(
							'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button add_to_cart_button %s product_type_%s">%s</a>',
							esc_url( $prd->add_to_cart_url() ),
							esc_attr( $prd->id ),
							esc_attr( $prd->get_sku() ),
							$prd->is_purchasable() ? 'add_to_cart_button' : '',
							esc_attr( $prd->product_type ),
							esc_html( $prd->add_to_cart_text() )
						),
						$prd
					);
				$product->add_to_cart .= '</li>';
				if ( class_exists( 'YITH_WCWL' ) ) {
					$product->add_to_cart .= '<li>' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
				}
				if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active_for_network( 'yith-woocommerce-compare/init.php' ) ) {
					$product->add_to_cart .= '<li><a href="' . esc_url( get_permalink( $product->id ) ) . '&amp;action=yith-woocompare-add-product&amp;id=' . esc_attr( $product->id ) . '" class="compare button" data-product_id="' . esc_attr( $product->id ) . '" title="' . esc_html__( "Compare", "cavada" ) . '"></a></li>';
				}
				$product->add_to_cart .= '<li class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="fa fa-eye"></i></a></li>';

				$image_url_product = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'full' );
				$product->thumb    = $product->image = '';
				if ( $image_url_product ) {
					$product->thumb = cavada_img_product_ajax( 170, 180, $image_url_product[0] );
					$product->image = '<a href="' . get_the_permalink( $product->id ) . '" title="' . get_the_title( $product->id ) . '">' . cavada_img_product_ajax( 480, 600, $image_url_product[0] ) . '</a>';
				}

				ob_start();
				the_content();
				$product->content = ob_get_clean();
				$results[]        = $product;
			}
			$msg['check'] = 'done';
			$msg['msg']   = $results;
		} else {
			$msg['check'] = 'error';
			$msg['msg']   = esc_html__( 'Products not found', 'cavada' );
		}
		ob_end_clean();
		echo json_encode( $msg );
		die;
	}

	/**
	 * Get product
	 */
	public function cavada_get_product_callback() {
		$msg = array();
		$id  = filter_input( INPUT_POST, 'data', FILTER_VALIDATE_INT );
		if ( $id ) {
			$args     = array(
				'post_type'   => 'product',
				'post_status' => 'publish',
				'p'           => $id
			);
			$products = new WP_Query( $args );

			if ( $products->have_posts() ) {
				$results = '';
				while ( $products->have_posts() ) {
					$products->the_post();
					$prd            = new WC_Product_Simple( get_the_ID() );
					$product        = new stdClass();
					$product->id    = get_the_ID();
					$product->title = the_title( '<a href="' . get_the_permalink( $product->id ) . '" title="' . get_the_title( $product->id ) . '">', '</a>', false );

					/*Get price*/
					ob_start();
					woocommerce_template_single_price();
					$product->price = ob_get_clean();

					$product->rate = $prd->get_rating_html();

					$product->add_to_cart = '<ul class="icon-links"><li>' . apply_filters(
							'woocommerce_loop_add_to_cart_link',
							sprintf(
								'<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button add_to_cart_button %s product_type_%s">%s</a>',
								esc_url( $prd->add_to_cart_url() ),
								esc_attr( $prd->id ),
								esc_attr( $prd->get_sku() ),
								$prd->is_purchasable() ? 'add_to_cart_button' : '',
								esc_attr( $prd->product_type ),
								esc_html( $prd->add_to_cart_text() )
							),
							$prd
						);
					$product->add_to_cart .= '</li>';
					if ( class_exists( 'YITH_WCWL' ) ) {
						$product->add_to_cart .= '<li>' . do_shortcode( '[yith_wcwl_add_to_wishlist]' ) . '</li>';
					}
					if ( is_plugin_active( 'yith-woocommerce-compare/init.php' ) || is_plugin_active_for_network( 'yith-woocommerce-compare/init.php' ) ) {
						$product->add_to_cart .= '<li><a href="' . esc_url( get_permalink( $product->id ) ) . '&amp;action=yith-woocompare-add-product&amp;id=' . esc_attr( $product->id ) . '" class="compare button" data-product_id="' . esc_attr( $product->id ) . '" title="' . esc_html__( "Compare", "cavada" ) . '"></a></li>';
					}
					$product->add_to_cart .= '<li class="quick-view" data-prod="' . esc_attr( get_the_ID() ) . '"><a href="javascript:;"><i class="fa fa-eye"></i></a></li>';

					$image_url_product = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'full' );
					$product->thumb    = $product->image = '';
					if ( $image_url_product ) {
						$product->image = '<a href="' . get_the_permalink( $product->id ) . '" title="' . get_the_title( $product->id ) . '">' . cavada_img_product_ajax( 480, 600, $image_url_product[0] ) . '</a>';
					}

					ob_start();
					the_content();
					$product->content = ob_get_clean();
					$results          = $product;
				}
				$msg['check'] = 'done';
				$msg['msg']   = $results;
			} else {
				$msg['check'] = 'error';
				$msg['msg']   = esc_html__( 'Products not found', 'cavada' );
			}
		} else {
			$msg['check'] = 'error';
			$msg['msg']   = esc_html__( 'Products not found', 'cavada' );
		}
		ob_end_clean();
		echo json_encode( $msg );
		die;
	}


}

new CAVADA_Ajax();