<?php
define( 'CAVADA_HOME_URL', trailingslashit( home_url( '/' ) ) );
define( 'CAVADA_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'CAVADA_THEME_URL', trailingslashit( get_template_directory_uri() ) );
if ( is_multisite() ) {
	define( 'CAVADA_UPLOADS_URL', network_home_url() . 'wp-content/uploads/' );
} else {
	define( 'CAVADA_UPLOADS_URL', site_url() . '/wp-content/uploads/' );
}

/**
 * cavada functions and definitions.
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package cavada
 */

if ( ! function_exists( 'cavada_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function cavada_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on cavada, use a find and replace
		 * to change 'cavada' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'cavada', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'woocommerce' );

		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'cavada' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support( 'post-formats', array( 'image', 'gallery', 'video', 'audio', 'link' ) );

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'cavada_custom_background_args', array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
	}
endif; // cavada_setup
add_action( 'after_setup_theme', 'cavada_setup' );
/**
 * Function add Theme Options
 */
function cavada_admin_bar_render() {
	global $wp_admin_bar, $cavada_data;
	$wp_admin_bar->add_menu(
		array(
			'parent' => 'site-name',// use 'false' for a root menu, or pass the ID of the parent menu
			'id'     => 'smof_options',// link ID, defaults to a sanitized title value
			'title'  => esc_html__( 'Theme Options', 'cavada' ),// link title
			'href'   => admin_url( 'themes.php?page=optionsframework' ),// name of file
			'meta'   => false
		)
	);
}

add_action( 'wp_before_admin_bar_render', 'cavada_admin_bar_render' );
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function cavada_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'cavada_content_width', 640 );
}

add_action( 'after_setup_theme', 'cavada_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function cavada_widgets_init() {
	global $cavada_data;
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'cavada' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Position on the left or right of content. It will not show on shop page.', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Bar Left', 'cavada' ),
			'id'            => 'topbar_left',
			'description'   => esc_html__( 'Position on the top left of site', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="%2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Bar Right', 'cavada' ),
			'id'            => 'topbar_right',
			'description'   => esc_html__( 'Position on the top right of site', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="%2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	if ( isset( $cavada_data['header_style'] ) && $cavada_data['header_style'] == 'header_v1' ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Header Left', 'cavada' ),
				'id'            => 'header_left',
				'description'   => esc_html__( 'Position on the left of header', 'cavada' ),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Header Right', 'cavada' ),
				'id'            => 'header_right',
				'description'   => esc_html__( 'Position on the right of header', 'cavada' ),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}

	register_sidebar(
		array(
			'name'          => esc_html__( 'Menu Right', 'cavada' ),
			'id'            => 'menu_right',
			'description'   => esc_html__( 'Position on the right of menu', 'cavada' ),
			'before_widget' => '<li id="%1$s" class="%2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Top Footer', 'cavada' ),
			'id'            => 'top_footer',
			'description'   => esc_html__( 'Position on the top of footer', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'cavada' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Position on the footer of site.', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	/*Copyright*/
	register_sidebar(
		array(
			'name'          => esc_html__( 'Copyright', 'cavada' ),
			'id'            => 'copyright',
			'description'   => esc_html__( 'Position the bottom center of site  ', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	if ( isset( $cavada_data['copyright_style'] ) && $cavada_data['copyright_style'] == 'center' ) {

		register_sidebar(
			array(
				'name'          => 'Copyright right ',
				'id'            => 'copyright_right',
				'description'   => esc_html__( 'On the right of Copyright.', 'cavada' ),
				'before_widget' => '<aside id="%1$s" class="%2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
	/*WooCommerce*/
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop', 'cavada' ),
			'id'            => 'shop',
			'description'   => esc_html__( 'Position on the left of shop content page.', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);
	/**
	 * Shop top
	 */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Top', 'cavada' ),
			'id'            => 'shop_top',
			'description'   => esc_html__( 'Position on the top of shop content page.', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title"><span>',
			'after_title'   => '</span></h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Coming soon', 'cavada' ),
			'id'            => 'comingsoon',
			'description'   => esc_html__( 'Position on coming soon page.', 'cavada' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	/**
	 * Megamenu
	 */

	if ( isset( $cavada_data['show_megamenu'] ) && $cavada_data['show_megamenu'] ) {
		$widgets = intval( $cavada_data['quantity_widgets'] );

		if ( $widgets ) {
			for ( $i = 1; $i <= $widgets; $i ++ ) {
				register_sidebar(
					array(
						'name'          => 'Mega Menu ' . $i,
						'id'            => 'megamenu_' . $i,
						'description'   => esc_html__( 'Visual position to make megamenu.', 'cavada' ),
						'before_widget' => '<aside id="%1$s" class="%2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					)
				);
			}
		}
	}

}

add_action( 'widgets_init', 'cavada_widgets_init' );

if ( ! function_exists( 'cavada_fonts_url' ) ) :
	/**
	 * Register Google fonts for cavada.
	 *
	 * Create your own cavada_fonts_url() function to override in a child theme.
	 *
	 * @since cavada 1.0
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function cavada_fonts_url() {
		global $cavada_data;
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';
		if ( isset( $cavada_data['wd_body_googlefont_enable'] ) && $cavada_data['wd_body_googlefont_enable'] == 0 ) {
			$fonts[] = $cavada_data['wd_body_googlefont'] . ':300,300italic,400,400italic,500,600,700,800';
		}
		if ( isset( $cavada_data['wd_heading_googlefont'] ) && $cavada_data['wd_heading_googlefont'] == 0 ) {
			$fonts[] = $cavada_data['wd_heading_googlefont'] . ':300,300italic,400,400italic,500,600,700,800';
		};
		if ( $fonts ) {
			$fonts_url = add_query_arg(
				array(
					'family' => urlencode( implode( '|', $fonts ) ),
					'subset' => urlencode( $subsets ),
				), 'https://fonts.googleapis.com/css'
			);
		}

		return $fonts_url;
	}
endif;

function cavada_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

add_action( 'wp_head', 'cavada_javascript_detection', 0 );
/**
 * Enqueue scripts and styles.
 */
function cavada_scripts() {
	global $current_blog, $cavada_data;
	wp_enqueue_style( 'cavada-fonts', cavada_fonts_url(), array(), null );

	wp_enqueue_style( 'cavada-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.4' );
	wp_enqueue_style( 'cavada-font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.5' );

	wp_enqueue_style( 'cavada-style', get_stylesheet_uri(), array(), '3022016' );

	if ( is_multisite() ) {
		if ( is_file( CAVADA_UPLOADS_FOLDER . 'vi_cavada-' . $current_blog->blog_id . '.css' ) ) {
			wp_enqueue_style( 'cavada-cavada', CAVADA_UPLOADS_URL . 'vi_cavada-' . $current_blog->blog_id . '.css', array() );
		}
	} else {
		if ( is_file( CAVADA_UPLOADS_FOLDER . 'vi_cavada.css' ) ) {
			wp_enqueue_style( 'cavada-cavada', CAVADA_UPLOADS_URL . 'vi_cavada.css', array() );
		} else {
			wp_enqueue_style( 'cavada-cavada', get_template_directory_uri() . '/assets/css/vi_cavada.css', array() );
		}
	}
	if ( isset( $cavada_data['rtl_support'] ) && $cavada_data['rtl_support'] == '1' ) {
		wp_enqueue_style( 'cavada-rtl', get_template_directory_uri() . '/rtl.css', array(), '3022016' );
	}

	if ( cavada_get_dev_mode() ) {
		wp_enqueue_script( 'cavada-jquery-unveil', get_template_directory_uri() . '/assets/js/jquery.unveil.js', array( 'jquery' ), '3022016', true );
	} else {
		wp_enqueue_script( 'cavada-jquery-unveil', get_template_directory_uri() . '/assets/js/jquery.unveil.min.js', array( 'jquery' ), '3022016', true );
	}
	if ( get_post_type() == 'product' && is_single() ) {
		if ( cavada_get_dev_mode() ) {
			wp_enqueue_script( 'cavada-jquery-magnify', get_template_directory_uri() . '/assets/js/jquery.magnify.js', array( 'jquery' ), '1.3.1', true );
		} else {
			wp_enqueue_script( 'cavada-jquery-magnify', get_template_directory_uri() . '/assets/js/jquery.magnify.min.js', array( 'jquery' ), '1.3.1', true );
		}
		wp_enqueue_style( 'cavada-magnify', get_template_directory_uri() . '/assets/css/magnify.min.css' );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	wp_enqueue_script( 'cavada-main-min', get_template_directory_uri() . '/assets/js/main.min.js', array( 'jquery' ), '3022016', true );
	wp_enqueue_script( 'cavada-sideNav', get_template_directory_uri() . '/assets/js/sideNav.min.js', array( 'jquery' ), '3022016', true );
	wp_enqueue_script( 'cavada-theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery' ), '3022016', true );
	//	if ( cavada_get_dev_mode() ) {
	//		wp_enqueue_script( 'cavada-custom-script', get_template_directory_uri() . '/assets/js/custom-script.js', array( 'jquery' ), '3022016', true );
	//	} else {
	//		wp_enqueue_script( 'cavada-custom-script', get_template_directory_uri() . '/assets/js/custom-script.min.js', array( 'jquery' ), '3022016', true );
	//	}

	/*Remove style*/
	wp_dequeue_style( 'sb_instagram_icons' );
	wp_dequeue_style( 'yith-wcwl-font-awesome' );
}

add_action( 'wp_enqueue_scripts', 'cavada_scripts' );

//require get_template_directory() . '/admin/less2css/less2css.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Custom functions.
 */
require get_template_directory() . '/inc/custom-functions.php';
/**
 * Theme options.
 */

include CAVADA_THEME_DIR . 'admin/index.php';
/**
 * required-plugins
 */
require_once CAVADA_THEME_DIR . 'inc/required-plugins/plugins-require.php';

/**
 * Display Setting front end
 */
require_once CAVADA_THEME_DIR . 'inc/global/wrapper-before-after.php';

/**
 * Display Mega menu
 */

require_once CAVADA_THEME_DIR . 'inc/megamenu/class-megamenu.php';

/**
 * Display logo
 */
require_once CAVADA_THEME_DIR . 'inc/global/logo.php';


/**
 * Add Meta box
 */
require_once CAVADA_THEME_DIR . 'inc/meta-box/meta-boxes.php';

/**
 * Add tax meta
 */
require_once CAVADA_THEME_DIR . 'inc/tax-meta.php';

/**
 * Add list post
 */
require_once CAVADA_THEME_DIR . 'inc/list-post.php';

/**
 * Add Widgets
 */
require_once CAVADA_THEME_DIR . 'inc/widgets.php';

/**
 * Add ajax file
 */
require_once CAVADA_THEME_DIR . 'inc/ajax.php';
require_once CAVADA_THEME_DIR . 'inc/aq_resizer.php';


/**
 * Scheme.org
 */
require_once CAVADA_THEME_DIR . 'inc/schema.php';
if ( function_exists( 'vc_map' ) ) {
	require get_template_directory() . '/inc/shortcode/shortcode.php';
}

/**
 * Add WooCommerce Setting
 */

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/woocommerce/woocommerce.php';
}

add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

/*Add ajax url*/
/**
 * Init URL Ajax
 */
add_action( 'wp_print_scripts', 'cavada_ajax_url' );
function cavada_ajax_url() {
	echo '<script type="text/javascript">
		var vi_ajax_url ="' . get_site_url() . '/wp-admin/admin-ajax.php";
		</script>';
}

// Hard Crop
if ( false === get_option( "medium_crop" ) ) {
	add_option( "medium_crop", "1" );
} else {
	update_option( "medium_crop", "1" );
}
if ( false === get_option( "large_crop" ) ) {
	add_option( "large_crop", "1" );
} else {
	update_option( "large_crop", "1" );
}

function cavada_img_product_ajax( $width, $height, $img_url ) {
	if ( $img_url ) {
		$data        = @getimagesize( $img_url );
		$width_data  = $data[0];
		$height_data = $data[1];
		if ( ! ( $width_data > $width ) && ! ( $height_data > $height ) ) {
			return '<img src="' . $img_url . '" alt="" />';
		} else {
			$crop       = ( $height_data < $height ) ? false : true;
			$image_crop = aq_resize( $img_url, $width, $height, $crop );

			return '<img src="' . $image_crop . '" alt="" />';
		}
	}
}

/*Widget*/
add_action( 'widgets_init', 'cavada_remove_widget', 10 );
function cavada_remove_widget() {
	unregister_widget( 'WC_Widget_Layered_Nav' );
	if ( class_exists( 'CAVADA_Widget_Layered_Nav' ) ) {
		register_widget( 'CAVADA_Widget_Layered_Nav' );
	}
}

/**
 * @param            $attachment_id
 * @param string     $size
 * @param bool|false $icon
 * @param string     $attr
 *
 * @return string
 */
function cavada_get_attachment_image( $attachment_id, $size = 'thumbnail', $icon = false, $attr = '', $placeholder_img = true ) {
	global $cavada_data;
	if ( isset( $cavada_data['turn_on_lazy_load'] ) ) {
		if ( ! $cavada_data['turn_on_lazy_load'] ) {
			return wp_get_attachment_image( $attachment_id, $size, $icon, $attr );
		}
	} else {
		return wp_get_attachment_image( $attachment_id, $size, $icon, $attr );
	}
	if ( ! isset( $cavada_data['vi_woo_placeholder_image'] ) ) {
		$cavada_data['vi_woo_placeholder_image'] = '';
	}
	$image_id = cavada_get_image_id( $cavada_data['vi_woo_placeholder_image'] ) ? cavada_get_image_id( $cavada_data['vi_woo_placeholder_image'] ) : '';

	$html = $temp_image = '';
	if ( $image_id && $placeholder_img ) {
		$temp_image = wp_get_attachment_image( $image_id, $size, $icon, array( 'class' => 'vi-placeholder' ) );

	}
	$image = wp_get_attachment_image_src( $attachment_id, $size, $icon );
	if ( $image ) {
		list( $src, $width, $height ) = $image;
		$hwstring   = image_hwstring( $width, $height );
		$size_class = $size;
		if ( is_array( $size_class ) ) {
			$size_class = join( 'x', $size_class );
		}
		$attachment   = get_post( $attachment_id );
		$default_attr = array(
			'src'      => "",
			'data-src' => $src,
			'class'    => "attachment-$size_class size-$size_class vi-load",
			'alt'      => "",
			'content'  => $src
			// Use Alt field first
		);

		$attr = wp_parse_args( $attr, $default_attr );

		// Generate 'srcset' and 'sizes' if not already present.
		if ( empty( $attr['srcset'] ) ) {
			$image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );

			if ( is_array( $image_meta ) ) {
				$size_array = array( absint( $width ), absint( $height ) );
				$srcset     = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attachment_id );
				$sizes      = wp_calculate_image_sizes( $size_array, $src, $image_meta, $attachment_id );

				if ( $srcset && ( $sizes || ! empty( $attr['sizes'] ) ) ) {
					$attr['srcset'] = $srcset;

					if ( empty( $attr['sizes'] ) ) {
						$attr['sizes'] = $sizes;
					}
				}
			}
		}

		/**
		 * Filter the list of attachment image attributes.
		 *
		 * @since 2.8.0
		 *
		 * @param array        $attr       Attributes for the image markup.
		 * @param WP_Post      $attachment Image attachment post.
		 * @param string|array $size       Requested size. Image size or array of width and height values
		 *                                 (in that order). Default 'thumbnail'.
		 */
		$attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
		$attr = array_map( 'esc_attr', $attr );
		$html = rtrim( "<img $hwstring" );
		foreach ( $attr as $name => $value ) {
			$html .= " $name=" . '"' . $value . '"';
		}
		$html .= ' />';
	}


	return $temp_image . $html;
}

/**
 * Get attachment ID from URL
 *
 * @param $image_url
 *
 * @return bool
 */
function cavada_get_image_id( $image_url ) {
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
	if ( count( array_filter( $attachment ) ) ) {
		return $attachment[0];
	} else {
		return false;
	}
}

/**
 * @param null   $post
 * @param string $size
 * @param string $attr
 * @param bool   $placeholder_img
 *
 * @return mixed|string|void
 */
function cavada_get_the_post_thumbnail( $post = null, $size = 'post-thumbnail', $attr = '', $placeholder_img = true ) {
	global $cavada_data;
	$post = get_post( $post );
	if ( ! $post ) {
		return '';
	}
	$post_thumbnail_id = get_post_thumbnail_id( $post );

	/**
	 * Filter the post thumbnail size.
	 *
	 * @since 2.9.0
	 *
	 * @param string|array $size The post thumbnail size. Image size or array of width and height
	 *                           values (in that order). Default 'post-thumbnail'.
	 */
	$size = apply_filters( 'post_thumbnail_size', $size );

	if ( $post_thumbnail_id ) {

		/**
		 * Fires before fetching the post thumbnail HTML.
		 *
		 * Provides "just in time" filtering of all filters in wp_get_attachment_image().
		 *
		 * @since 2.9.0
		 *
		 * @param int          $post_id           The post ID.
		 * @param string       $post_thumbnail_id The post thumbnail ID.
		 * @param string|array $size              The post thumbnail size. Image size or array of width
		 *                                        and height values (in that order). Default 'post-thumbnail'.
		 */
		do_action( 'begin_fetch_post_thumbnail_html', $post->ID, $post_thumbnail_id, $size );
		if ( in_the_loop() ) {
			update_post_thumbnail_cache();
		}

		if ( isset( $cavada_data['turn_on_lazy_load'] ) ) {
			if ( ! $cavada_data['turn_on_lazy_load'] ) {
				$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
			} else {
				$html = cavada_get_attachment_image( $post_thumbnail_id, $size, false, $attr, $placeholder_img );
			}
		} else {
			$html = wp_get_attachment_image( $post_thumbnail_id, $size, false, $attr );
		}


		/**
		 * Fires after fetching the post thumbnail HTML.
		 *
		 * @since 2.9.0
		 *
		 * @param int          $post_id           The post ID.
		 * @param string       $post_thumbnail_id The post thumbnail ID.
		 * @param string|array $size              The post thumbnail size. Image size or array of width
		 *                                        and height values (in that order). Default 'post-thumbnail'.
		 */
		do_action( 'end_fetch_post_thumbnail_html', $post->ID, $post_thumbnail_id, $size );

	} else {
		$html = '';
	}

	/**
	 * Filter the post thumbnail HTML.
	 *
	 * @since 2.9.0
	 *
	 * @param string       $html              The post thumbnail HTML.
	 * @param int          $post_id           The post ID.
	 * @param string       $post_thumbnail_id The post thumbnail ID.
	 * @param string|array $size              The post thumbnail size. Image size or array of width and height
	 *                                        values (in that order). Default 'post-thumbnail'.
	 * @param string       $attr              Query string of attributes.
	 */

	return apply_filters( 'post_thumbnail_html', $html, $post->ID, $post_thumbnail_id, $size, $attr );
}

/**
 * Get Developer Mode status
 * @return bool
 */
function cavada_get_dev_mode() {
	global $cavada_data;
	if ( isset( $cavada_data['turn_on_dev_mode'] ) ) {
		if ( $cavada_data['turn_on_dev_mode'] ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/*Import data*/
add_filter( 'villatheme_import_data_array', 'cavada_import_data_array' );
function cavada_import_data_array( $data ) {
	$demo_datas_dir = get_template_directory() . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'data';
	$data           = array(
		'default'   => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'default',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Default', 'cavada' )
		),
		'fashion'   => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'fashion',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Fashion', 'cavada' )
		),
		'clothes'   => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'clothes',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Clothes', 'cavada' )
		),
		'food'      => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'food',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Food', 'cavada' )
		),
		'furniture' => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'furniture',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Furniture', 'cavada' )
		),
		'kid'       => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'kid',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Kid', 'cavada' )
		),
		'lingeries' => array(
			'data_dir'      => $demo_datas_dir . DIRECTORY_SEPARATOR . 'lingeries',
			'thumbnail_url' => '',
			'title'         => esc_html__( 'Lingeries', 'cavada' )
		)
	);

	return $data;
}

add_filter( 'cavada_import_options', 'cavada_import_options' );
function cavada_import_options( $data ) {
	return '<select class="demo-data" id="demodata-selecter">
				<option>' . esc_html__( 'Please select demo', 'cavada' ) . '</option>
				<option value="default">' . esc_html__( 'Default', 'cavada' ) . '</option>
				<option value="fashion">' . esc_html__( 'Fashion', 'cavada' ) . '</option>
				<option value="clothes">' . esc_html__( 'Clothes', 'cavada' ) . '</option>
				<option value="kid">' . esc_html__( 'Kid', 'cavada' ) . '</option>
				<option value="food">' . esc_html__( 'Food', 'cavada' ) . '</option>
				<option value="furniture">' . esc_html__( 'Furniture', 'cavada' ) . '</option>
				<option value="lingeries">' . esc_html__( 'Lingeries', 'cavada' ) . '</option>
			</select>
			<br/>';
}

/**
 * Get ThemeOptions
 * @return array|mixed|void
 */
function cavada_get_data_themeoptions() {
	global $cavada_data;

	return $cavada_data;
}

/**
 * Get current post data
 * @return WP_Post
 */
function cavada_get_post() {
	global $post;

	return $post;
}

/**
 * Get current product data
 * @return WC_Product|WC_Product_Simple
 */
function cavada_get_product() {
	global $product;

	return $product;
}

/**
 * Get Woocommerce loop
 * @return mixed
 */
function cavada_get_woo_loop() {
	global $woocommerce_loop;

	return $woocommerce_loop;
}

/**
 * Get wp query
 * @return WP_Query
 */
function cavada_get_wp_query() {
	global $wp_query;

	return $wp_query;
}

/**
 * Get yith woocompare
 * @return mixed
 */
function cavada_get_yith_woocompare() {
	global $yith_woocompare;

	return $yith_woocompare;
}

/**
 * get WooCommerce global
 * @return mixed
 */
function cavada_get_woo() {
	global $woocommerce;

	return $woocommerce;
}

if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
	// Output old, custom favicon feature.
}
//Remove section in customize
add_action( 'wp_footer', 'cavada_tracking_code' );
/**
 * Print tracking code in footer
 */
function cavada_tracking_code() {
	$tracking_code = cavada_get_option( 'tracking_code' );
	echo '<div class="wrapper-tracking-code">' . $tracking_code . '</div>';
}

/**
 * Get Option Private from Theme Options
 *
 * @param string $name
 * @param string $value_default
 *
 * @return string
 */
function cavada_get_option( $name = '', $value_default = '' ) {
	$data = cavada_get_data_themeoptions();
	if ( isset( $data[$name] ) ) {
		return $data[$name];
	} else {
		return $value_default;
	}
}