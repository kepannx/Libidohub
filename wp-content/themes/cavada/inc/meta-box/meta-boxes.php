<?php

add_filter( 'rwmb_meta_boxes', 'cavada_register_meta_boxes' );
function cavada_register_meta_boxes( $meta_boxes ) {
	// Post Formats
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Image', 'cavada' ),
		'id'     => 'cavada-meta-box-post-format-image',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name'             => esc_html__( 'Image', 'cavada' ),
				'id'               => 'image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
		),
	);
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Gallery', 'cavada' ),
		'id'     => 'cavada-meta-box-post-format-gallery',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Images', 'cavada' ),
				'id'   => 'images',
				'type' => 'image_advanced',
			),
		),
	);
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Video', 'cavada' ),
		'id'     => 'cavada-meta-box-post-format-video',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Video URL or Embeded Code', 'cavada' ),
				'id'   => 'video',
				'type' => 'textarea',
			),
		)
	);
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Audio', 'cavada' ),
		'id'     => 'cavada-meta-box-post-format-audio',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Audio URL or Embeded Code', 'cavada' ),
				'id'   => 'audio',
				'type' => 'textarea',
			),
		)
	);
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Quote', 'cavada' ),
		'id'     => 'cavada-meta-box-post-format-quote',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'Quote', 'cavada' ),
				'id'   => 'quote',
				'type' => 'textarea',
			),
			array(
				'name' => esc_html__( 'Author', 'cavada' ),
				'id'   => 'author',
				'type' => 'text',
			),
			array(
				'name' => esc_html__( 'Author URL', 'cavada' ),
				'id'   => 'author_url',
				'type' => 'url',
			),
		)
	);
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Post Format: Link', 'cavada' ),
		'id'     => 'cavada-meta-box-post-format-link',
		'pages'  => array( 'post' ),
		'fields' => array(
			array(
				'name' => esc_html__( 'URL', 'cavada' ),
				'id'   => 'url',
				'type' => 'url',
			),
			array(
				'name' => esc_html__( 'Text', 'cavada' ),
				'id'   => 'text',
				'type' => 'text',
			),
		)
	);

	// Display Settings
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Display Settings', 'cavada' ),
		'pages'  => get_post_types(), // All custom post types
		'fields' => array(
//			array(
//				'name' => esc_html__( 'Featured Title Area?', 'cavada' ),
//				'id'   => 'heading_title',
//				'type' => 'heading',
//			),
			array(
				'name'  => esc_html__( 'Breadcrumbs Options', 'cavada' ),
				'id'    => 'vi_user_featured_title',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle',

			),
//			array(
//				'name'   => esc_html__( 'Custom Title and Subtitle', 'cavada' ),
//				'id'     => 'custom_title_subtitle',
//				'type'   => 'heading',
//				'before' => '<div style="margin-left: 25px; padding-left: 25px; border-width: 0 0 0 3px; border-style: solid; border-color: #ddd">',
//			),
//			array(
//				'name'  => esc_html__( 'Hide Title and Subtitle', 'cavada' ),
//				'id'    => 'vi_hide_title_and_subtitle',
//				'type'  => 'checkbox',
//				'class' => 'checkbox-toggle reverse',
//			),
//			array(
//				'name'   => esc_html__( 'Custom Title', 'cavada' ),
//				'id'     => 'vi_custom_title',
//				'type'   => 'text',
//				'desc'   => esc_html__( 'Leave empty to use post title', 'cavada' ),
//				'before' => '<div>',
//			),
//			array(
//				'name'  => esc_html__( 'Subtitle', 'cavada' ),
//				'id'    => 'vi_subtitle',
//				'type'  => 'text',
//				'after' => '</div>',
//			),
//			array(
//				'name' => esc_html__( 'Custom Heading Background', 'cavada' ),
//				'id'   => 'custom_headding_bg',
//				'type' => 'heading',
//			),
//			array(
//				'name' => esc_html__( 'Update images', 'cavada' ),
//				'id'   => 'vi_top_image',
//				'type' => 'file_input',
//				'desc' => sprintf( esc_html__( 'This will overwrite page layout settings in', 'cavada' ) . ' <a href="%s" target="_blank">' . esc_html__( 'Theme Options', 'cavada' ) . '</a>.', admin_url( 'themes.php?page=optionsframework' ) ),
//			),
			array(
				'name' => esc_html__( 'Background Color', 'cavada' ),
				'id'   => 'vi_bg_color',
				'type' => 'color',
				'before' => '<div style="margin-left: 25px; padding-left: 25px; border-width: 0 0 0 3px; border-style: solid; border-color: #ddd">',

			),
			array(
				'name' => esc_html__( 'Text Color', 'cavada' ),
				'id'   => 'vi_text_color',
				'type' => 'color',

			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumbs?', 'cavada' ),
				'id'    => 'vi_hide_breadcrumbs',
				'type'  => 'checkbox',
				'after' => '</div>',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'cavada' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name'  => esc_html__( 'Use Custom Layout?', 'cavada' ),
				'id'    => 'custom_layout',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle',
				'desc'  => sprintf( esc_html__( 'This will overwrite page layout settings in', 'cavada' ) . ' <a href="%s" target="_blank">' . esc_html__( 'Theme Options', 'cavada' ) . '</a>.', admin_url( 'themes.php?page=optionsframework' ) ),
			),
			array(
				'name'    => esc_html__( 'Select Layout', 'cavada' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'std'     => 'sidebar-left',
				'class'   => 'hidden-layout-portfolio',
				'options' => array(
					'full-content'  => CAVADA_THEME_URL . 'images/layout/body-full.png',
					'sidebar-left'  => CAVADA_THEME_URL . 'images/layout/sidebar-left.png',
					'sidebar-right' => CAVADA_THEME_URL . 'images/layout/sidebar-right.png',
				),
				'before'  => '<div>',
				'after'   => '</div>',
			),
			array(
				'name'  => esc_html__( 'No Padding Content', 'cavada' ),
				'id'    => 'vi_no_padding',
				'type'  => 'checkbox',
				'class' => 'checkbox-toggle',

			),
		)
	);

	// Coming Soon
	$meta_boxes[]           = array(
		'title'  => esc_html__( 'Coming Soon Settings', 'cavada' ),
		'pages'  => array( 'page' ), // All custom post types
		'fields' => array(
			array(
				'name' => esc_html__( 'Logo Page', 'cavada' ),
				'id'   => 'coming_soon_logo',
				'type' => 'file_input',
				'desc' => esc_html__( 'Upload your logo', 'cavada' )
			),
			array(
				'name'    => esc_html__( 'Cover Color', 'cavada' ),
				'id'      => 'cover_color',
				'type'    => 'select',
				'options' => array(
					'black'  => esc_html__( 'Black', 'cavada' ),
					'blue'   => esc_html__( 'Blue', 'cavada' ),
					'green'  => esc_html__( 'Green', 'cavada' ),
					'orange' => esc_html__( 'Orange', 'cavada' ),
					'red'    => esc_html__( 'Red', 'cavada' ),
				),
				'default' => 'black',
			),
			array(
				'name' => esc_html__( 'Text Color', 'cavada' ),
				'id'   => 'text_color',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Date Option', 'cavada' ),
				'id'   => 'coming_soon_date',
				'type' => 'date',
				'desc' => esc_html__( 'Choose a date', 'cavada' ),
			),

			array(
				'name' => esc_html__( 'Copyright Text', 'cavada' ),
				'id'   => 'text_copyright',
				'type' => 'text',
				'std'  => 'Powered By <a href="#">cavada</a> &copy; 2015',
			),

		)
	);
	$menus                  = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$menu_select['default'] = 'Default Menu';
	foreach ( $menus as $menu ) {
		$menu_select[$menu->term_id] = $menu->name;
	}
	// Coming Soon

	$meta_boxes[] = array(
		'title'  => esc_html__( 'Select Menu One Page', 'cavada' ),
		'pages'  => array( 'page' ), // All custom post types
		'fields' => array(
			array(
				'name'    => esc_html__( 'Select Menu', 'cavada' ),
				'id'      => 'select_menu_one_page',
				'type'    => 'select',
				'options' => $menu_select
			),
		)
	);
	// Blank Page
	$meta_boxes[] = array(
		'title'  => esc_html__( 'Blank Page Settings', 'cavada' ),
		'pages'  => array( 'page' ), // All custom post types
		'fields' => array(
			array(
				'name' => esc_html__( 'Custom Title', 'cavada' ),
				'id'   => 'custom_title',
				'type' => 'text',
			),
			array(
				'name' => esc_html__( 'Text Color', 'cavada' ),
				'id'   => 'text_color',
				'type' => 'color',
			),
			array(
				'name' => esc_html__( 'Link Contact', 'cavada' ),
				'id'   => 'link_contact',
				'type' => 'text',
			),
		)
	);

	return $meta_boxes;
}

add_action( 'admin_enqueue_scripts', 'cavada_admin_script_meta_box' );

/**
 * Enqueue script for handling actions with meta boxes
 *
 * @return void
 * @since 1.0
 */
function cavada_admin_script_meta_box() {
	wp_enqueue_script( 'cavada-meta-box', CAVADA_THEME_URL . 'js/admin/meta-boxes.js', array( 'jquery' ), '3022016', true );
}
