<?php
$args       = array(
	'pad_counts'         => 1,
	'show_counts'        => 1,
	'hierarchical'       => 1,
	'hide_empty'         => 1,
	'show_uncategorized' => 1,
	'orderby'            => 'name',
	'menu_order'         => false
);
$terms      = get_categories( $args );
$categories = array( esc_html__( 'All', 'cavada' ) => 0 );
foreach ( $terms as $term ) {
	$categories[$term->name] = $term->term_id;
}
vc_map( array(
	"name"        => esc_html__( "List Post", 'cavada' ),
	"icon"        => "icon-ui-splitter-horizontal",
	"base"        => "list_posts",
	"description" => "list posts",
	"category"    => esc_html__( "Villatheme", 'cavada' ),
	"params"      => array(
		array(
			'type'        => 'dropdown',
			'admin_label' => true,
			'heading'     => esc_html__( 'Layout Shortcode', 'cavada' ),
			'param_name'  => 'style',
			'value'       => array(
				esc_html__( 'Style 01', 'cavada' ) => 'style_01',
				esc_html__( 'Style 02', 'cavada' ) => 'style_02',
				esc_html__( 'Style 03', 'cavada' ) => 'style_03',
				esc_html__( 'Style 04', 'cavada' ) => 'style_04'
			),
			'std'         => 'style_01',
		),

		array(
			'type'        => 'dropdown',
			'admin_label' => true,
			'heading'     => esc_html__( 'Category', 'cavada' ),
			'param_name'  => 'category',
			'value'       => $categories
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Limit', 'cavada' ),
			'param_name' => 'limit',
			'value'      => '4',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Posts on row', 'cavada' ),
			'param_name' => 'post_on_row',
			'value'      => '2',
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Length Description', 'cavada' ),
			'param_name' => 'length',
			'value'      => '10',
			"dependency" => Array( "element" => "style", "value" => array( 'style_02', 'style_04' ) ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Line Title', 'cavada' ),
			"description" => esc_html__( "Show Line after title", "cavada" ),
			'param_name'  => 'line_title',
			"dependency"  => Array( "element" => "style", "value" => array( 'style_02' ) ),
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Read More', 'cavada' ),
			"description" => esc_html__( "Show or hide read more button", "cavada" ),
			'param_name'  => 'read_more',
			"dependency"  => Array( "element" => "style", "value" => array( 'style_02', 'style_04' ) ),
		),
		array(
			"type"        => "dropdown",
			"heading"     => esc_html__( "Display", "cavada" ),
			"param_name"  => "display",
			"admin_label" => true,
			"value"       => array(
				esc_html__( "Random", "cavada" )  => "random",
				esc_html__( "Popular", "cavada" ) => "popular",
				esc_html__( "Recent", "cavada" )  => "recent",
				esc_html__( "oldest", "cavada" )  => "oldest"
			),
			"description" => esc_html__( "Select Orderby.", "cavada" )
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
function cavada_shortcode_list_posts( $atts, $content = null ) {
	$cavada_animation = $css_animation = $el_class = $category = $limit = $display = $post_on_row = $show_link =
	$button_text = $button_link = $style = $length = $line_title = $read_more = '';
	extract( shortcode_atts( array(
		'category'      => '',
		'limit'         => '6',
		'length'        => '10',
		'display'       => 'popular',
		'post_on_row'   => '2',
		'el_class'      => '',
		'style'         => 'style_01',
		'line_title'    => '',
		'read_more'     => '',
		'css_animation' => '',
	), $atts ) );
	ob_start();

	$image_size = 'full';
	if($style == 'style_04'){
		$image_size = 'medium';
 	}
	if ( $el_class ) {
		$cavada_animation .= ' ' . $el_class;
	}
	$cavada_animation .= ' ' . $style;
	$cavada_animation .= cavada_getCSSAnimation( $css_animation );
	?>

	<?php
	$query_atts['posts_per_page'] = $limit;
	if ( $category ) {
		$cats_id                 = explode( ',', $category );
		$query_atts['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'term_id',
				'terms'    => $cats_id
			)
		);
	}

	if ( $display == 'random' ) {
		$query_atts['orderby'] = 'rand';
	} elseif ( $display == 'popular' ) {
		$query_atts['orderby'] = 'comment_count';
	} elseif ( $display == 'recent' ) {
		$query_atts['orderby'] = 'post_date';
		$query_atts['order']   = 'ASC';
	} else {
		$query_atts['orderby'] = 'post_date';
		$query_atts['order']   = 'DESC';
	}
	$the_query = new WP_Query( $query_atts );
	if ( $the_query->have_posts() ) {
		?>
		<div class="list-posts row<?php echo esc_attr( $cavada_animation ) ?>">
			<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				?>
				<article class="archive-blog col-sm-<?php echo intval( 12 / $post_on_row ) ?>">
					<div class="content-inner">
						<?php do_action( 'cavada_entry_top', $image_size ); ?>
						<div class="entry-content">
							<?php
							if ( $style == 'style_01' ) {
								echo '<div class="article-date">

										<span class="day">' . get_the_date( 'd M' ) . '</span>
										<span class="month">' . get_the_date( 'Y' ) . '</span>
									</div>
								';
								echo '<header class="entry-header">';
								the_title( sprintf( '<h2 class="blog_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
								//cavada_posted_on();
								echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
								comments_popup_link( esc_html__( '(0)', 'cavada' ), esc_html__( '(1)', 'cavada' ), esc_html__( '(%)', 'cavada' ) );
								echo '</span>';
								echo '</header>';
								if ( $length ) {
									echo '<p>' . cavada_excerpt( $length ) . '</p>';
								}
							} elseif ( $style == 'style_02' ) {
								the_title( sprintf( '<h2 class="blog_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
								echo '<div class="entry-date">
										<span>' . get_the_date( 'd M, Y' ) . '</span>';
								echo '<span class="comments-link"> - ';
								comments_popup_link( esc_html__( '0 Comment', 'cavada' ), esc_html__( '1 Comment', 'cavada' ), esc_html__( '% Comments', 'cavada' ) );
								echo '</span>';
								echo '</div>';
								if ( $line_title == 'true' ) {
									echo '<span class="line-title"></span>';
								}
								if ( $length ) {
									echo '<p>' . cavada_excerpt( $length ) . '</p>';
								}
								if ( $read_more == 'true' ) {
									echo '<a class="btn btn-read-more" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'cavada' ) . '</a>';
								}
							} elseif ( $style == 'style_04' ) {
								the_title( sprintf( '<h2 class="blog_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
								echo '<div class="entry-date">
										<span>' . get_the_date( 'd M, Y' ) . '</span>';
								echo '<span class="comments-link"> - ';
								comments_popup_link( esc_html__( '0 Comment', 'cavada' ), esc_html__( '1 Comment', 'cavada' ), esc_html__( '% Comments', 'cavada' ) );
								echo '</span>';
								echo '</div>';
								if ( $length ) {
									echo '<p>' . cavada_excerpt( $length ) . '</p>';
								}
								if ( $read_more == 'true' ) {
									echo '<a class="btn-read-more" href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Read More', 'cavada' ) . '</a>';
								}
							} else {
								echo '<header class="entry-header">';
								the_title( sprintf( '<h2 class="blog_title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
								echo '<span class="comments-link"><i class="fa fa-comments"></i> ';
								comments_popup_link( esc_html__( '(0)', 'cavada' ), esc_html__( '(1)', 'cavada' ), esc_html__( '(%)', 'cavada' ) );
								echo '</span>';
								echo '</header>';
								echo '<div class="article-date">
										<span>' . esc_html__( 'Posted', 'cavada' ) . get_the_date( ' jS F, Y' ) . '</span>
 									</div>
								';
								if ( $length ) {
									echo '<p>' . cavada_excerpt( $length ) . '</p>';
								}
							}
							?>
						</div>
					</div>
				</article>
				<?php
			}
			?>
		</div>
	<?php }
	// Reset Post Data
	wp_reset_postdata();
	$output = ob_get_clean();

	return $output;
}

?>