<?php
require_once( "tax-meta-class/Tax-meta-class.php" );
if ( is_admin() ) {
	/*
   * prefix of meta keys, optional
   */
	$prefix = 'vi_';
	/*
   * configure your meta box
   */
	$config = array(
		'id'             => 'category__meta_box',
		// meta box id, unique per meta box
		'title'          => 'Category Meta Box',
		// meta box title
		'pages'          => array( 'category', 'product_cat', 'our_team_category', 'post_tag', 'tribe_events_cat' ),
		// taxonomy name, accept categories, post_tag and custom taxonomies
		'context'        => 'normal',
		// where the meta box appear: normal (default), advanced, side; optional
		'fields'         => array(),
		// list of meta fields (can be added by field arrays)
		'local_images'   => false,
		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => false
		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$my_meta = new CAVADA_Tax_Meta_Class( $config );

	$config_product = array(
		'id'             => 'category_product_meta_box',
		// meta box id, unique per meta box
		'title'          => 'Category Meta Box',
		// meta box title
		'pages'          => array( 'product_cat' ),
		// taxonomy name, accept categories, post_tag and custom taxonomies
		'context'        => 'normal',
		// where the meta box appear: normal (default), advanced, side; optional
		'fields'         => array(),
		// list of meta fields (can be added by field arrays)
		'local_images'   => false,
		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => false
		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$my_meta_product = new CAVADA_Tax_Meta_Class( $config_product );
	$my_meta_product->addSelect( $prefix . 'layout_column', array(
		''  => esc_html__( 'Default', 'cavada' ),
		'1' => '1',
		'2' => '2',
		'3' => '3',
		'4' => '4',
	), array( 'name' => esc_html__( 'Select Grid Column ', 'cavada' ), 'std' => array( '' ) ) );
	$my_meta_product->Finish();

	/*
	 * Add fields to your meta box
	 */
	$my_meta->addSelect(
		$prefix . 'layout', array(
		''              => esc_html__( 'Using in Theme Option', 'cavada' ),
		'full-content'  => esc_html__( 'No Sidebar', 'cavada' ),
		'sidebar-left'  => esc_html__( 'Left Sidebar', 'cavada' ),
		'sidebar-right' => esc_html__( 'Right Sidebar', 'cavada' )
	),
		array( 'name' => esc_html__( 'Custom Layout ', 'cavada' ), 'std' => array( '' ) )
	);

	$my_meta->addSelect(
		$prefix . 'custom_heading', array(
		''       => esc_html__( 'Using in Theme Option', 'cavada' ),
		'custom' => esc_html__( 'Custom', 'cavada' ),
	), array( 'name' => esc_html__( 'Custom Heading ', 'cavada' ), 'std' => array( '' ) )
	);

	//$my_meta->addImage( $prefix . 'cate_top_image', array( 'name' => esc_html__( 'Heading Background Image', 'cavada' ) ) );
	$my_meta->addColor( $prefix . 'cate_heading_bg_color', array( 'name' => esc_html__( 'Heading Background Color', 'cavada' ) ) );
	$my_meta->addColor( $prefix . 'cate_heading_text_color', array( 'name' => esc_html__( 'Heading Text Color', 'cavada' ) ) );
	//$my_meta->addCheckbox( $prefix . 'cate_hide_title', array( 'name' => esc_html__( 'Hide Title', 'cavada' ) ) );
	$my_meta->addCheckbox( $prefix . 'cate_hide_breadcrumbs', array( 'name' => esc_html__( 'Hide Breadcrumbs?', 'cavada' ) ) );
	$my_meta->Finish();

	/*
	 * Product attibute
	 */
	$prefix = 'vi_';
	/*
	   * configure your meta box
	   */
	$config = array(
		'id'             => 'category__meta_box',
		// meta box id, unique per meta box
		'title'          => 'Category Meta Box',
		// meta box title
		'pages'          => array( 'pa_color' ),
		// taxonomy name, accept categories, post_tag and custom taxonomies
		'context'        => 'normal',
		// where the meta box appear: normal (default), advanced, side; optional
		'fields'         => array(),
		// list of meta fields (can be added by field arrays)
		'local_images'   => false,
		// Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => false
		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$my_meta = new CAVADA_Tax_Meta_Class( $config );

	$my_meta->addSelect(
		$prefix . 'hidden_text', array(
		'0' => 'Yes',
		'1' => 'No'
	), array(
			'name' => esc_html__( 'Hidden Text', 'cavada' ),
			'std'  => 0
		)
	);

	$my_meta->addColor(
		$prefix . 'background_color',
		array(
			'name' => esc_html__( 'Background Color', 'cavada' ),
			'std'  => ''
		)
	);

	$my_meta->Finish();

}
