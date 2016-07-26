<?php
function cavada_remove_styles_sections() {
	global $wp_customize;
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
}

add_action( 'customize_register', 'cavada_remove_styles_sections', 20 );


//villtheme_excerpt_length
function cavada_excerpt_length() {
	global $cavada_data;
	if ( isset( $cavada_data['vi_archive_excerpt_length'] ) ) {
		$length = $cavada_data['vi_archive_excerpt_length'];
	} else {
		$length = '55';
	}

	return $length;
}

add_filter( 'excerpt_length', 'cavada_excerpt_length', 999 );
function cavada_wp_new_excerpt( $text ) {
	if ( $text == '' ) {
		$text           = get_the_content( '' );
		$text           = strip_shortcodes( $text );
		$text           = apply_filters( 'the_content', $text );
		$text           = str_replace( ']]>', ']]>', $text );
		$text           = strip_tags( $text );
		$text           = nl2br( $text );
		$excerpt_length = apply_filters( 'excerpt_length', 55 );
		$words          = explode( ' ', $text, $excerpt_length + 1 );
		if ( count( $words ) > $excerpt_length ) {
			array_pop( $words );
			array_push( $words, '' );
			$text = implode( ' ', $words );
		}
	}

	return $text;
}

remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'cavada_wp_new_excerpt' );

if ( ! function_exists( 'cavada_excerpt' ) ) {
	function cavada_excerpt( $limit ) {
		$text  = get_the_content( '' );
		$text  = strip_shortcodes( $text );
		$text  = apply_filters( 'the_content', $text );
		$text  = str_replace( ']]>', ']]>', $text );
		$text  = strip_tags( $text );
		$text  = nl2br( $text );
		$words = explode( ' ', $text, $limit + 1 );
		if ( count( $words ) > $limit ) {
			array_pop( $words );
			array_push( $words, '' );
			$text = implode( ' ', $words );
		}

		return $text;
	}
}

/************ List Comment ***************/
if ( ! function_exists( 'cavada_comment' ) ) {
	function cavada_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		if ( 'div' == $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo ent2ncr( $tag ) . ' ' ?><?php comment_class( 'description_comment' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="wrapper-comment">
			<?php
			echo '<div class="wrapper_avatar">';
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			echo '<i class="fa fa-mail-reply"></i>';
			comment_reply_link(
				array_merge(
					$args, array(
						'add_below' => $add_below,
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					)
				)
			);
			echo '</div>';
			?>

			<div class="comment-right">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'cavada' ) ?></em>
				<?php endif; ?>

				<div class="comment-extra-info">
					<div class="author"><?php printf( wp_kses( '<span class="author-name">%s</span>', 'cavada' ), get_comment_author_link() ) ?></div>
					<div class="date">
						<?php printf( get_comment_date(), get_comment_time() ) ?></div>
					<?php edit_comment_link( esc_html__( 'Edit', 'cavada' ), '', '' ); ?>
				</div>

				<div class="content-comment">
					<?php comment_text() ?>
				</div>
			</div>
		</div>
		<?php
	}
}
/************end list comment************/

add_filter( 'wp_nav_menu_args', 'cavada_select_main_menu' );
function cavada_select_main_menu( $args ) {
	global $post;
	if ( $post ) {
		if ( get_post_meta( $post->ID, 'select_menu_one_page', true ) != 'default' && ( $args['theme_location'] == 'primary' ) ) {
			$menu         = get_post_meta( $post->ID, 'select_menu_one_page', true );
			$args['menu'] = $menu;
		}
	}

	return $args;
}

// Remove Open Sans that WP adds from frontend
if ( ! function_exists( 'cavada_remove_wp_open_sans' ) ) :
	function cavada_remove_wp_open_sans() {
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
	}

	add_action( 'wp_enqueue_scripts', 'cavada_remove_wp_open_sans' );
endif;

/* * ******************************************************************
 * Breadcrumbs
 * ****************************************************************** */

function cavada_breadcrumbs() {
	global $wp_query, $post;
	$show_on = get_option( 'show_on_front' );
	$page_id = get_option( 'page_for_posts' );

	$delimiter = "<i class='separate'>&bull;</i>";
	echo '<ul class="vi-breadcrumb">';
	echo '<li><i class="fa fa-fw fa-home"></i><a href="' . esc_url( home_url( '/' ) ) . '" class="home"><span>' . esc_html__( "Home", 'cavada' ) . '</span></a>' . $delimiter . '</li>';
	if ( is_category() ) {
		$catTitle = single_cat_title( "", false );
		$cat      = get_cat_ID( $catTitle );
		echo '<li>' . get_category_parents( $cat, true, $delimiter ) . '</li>';
	} elseif ( is_post_type_archive() ) {
		echo '<li>' . post_type_archive_title( '', false ) . $delimiter . '</li>';
	} elseif ( is_tax() ) {
		echo '<li>' . single_term_title( '', false ) . $delimiter . '</li>';
	} elseif ( is_search() ) {
		echo '<li>' . esc_html__( "Search Result", "cavada" ) . $delimiter . '</li>';
	} elseif ( is_404() ) {
		echo '<li>' . esc_html__( "404 Not Found", "cavada" ) . $delimiter . '</li>';
	} elseif ( is_single( $post ) ) {
		if ( get_post_type() == 'post' ) {
			$category    = get_the_category();
			$category_id = get_cat_ID( $category[0]->cat_name );
			echo '<li>' . cavada_get_category_parents( $category_id, true, $delimiter ) . '</li>';
			echo '<li>' . the_title( '', '', false ) . $delimiter . '</li>';
		} else {
			echo '<li>' . get_post_type() . $delimiter . '</li>';
			echo '<li>' . get_the_title() . $delimiter . '</li>';
		}
	} elseif ( is_page() || ( $show_on == 'page' && $wp_query->queried_object_id == $page_id ) ) {
		$post = $wp_query->get_queried_object();
		if ( $post->post_parent == 0 ) {
			echo "<li>" . the_title( '', '', false ) . $delimiter . "</li>";
		} else {
			$ancestors = array_reverse( get_post_ancestors( $post->ID ) );
			array_push( $ancestors, $post->ID );
			foreach ( $ancestors as $ancestor ) {
				if ( $ancestor != end( $ancestors ) ) {
					echo '<li><a href="' . get_permalink( $ancestor ) . '"><span>' . strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) . '</span></a>' . $delimiter . '</li>';
				} else {
					echo '<li>' . strip_tags( apply_filters( 'single_post_title', get_the_title( $ancestor ) ) ) . $delimiter . '</li>';
				}
			}
		}

	} elseif ( is_attachment() ) {
		$parent = get_post( $post->post_parent );
		if ( $parent->post_type == 'page' || $parent->post_type == 'post' ) {
			$cat = get_the_category( $parent->ID );
			$cat = $cat[0];
			echo '<li>' . get_category_parents( $cat, true, $delimiter ) . '</li>';
		}

		echo '<li><a href="' . get_permalink( $parent ) . '"><span>' . $parent->post_title . '</span></a>' . $delimiter . '</li>';
		echo '<li>' . get_the_title() . $delimiter . '</li>';
	}

	// End the UL
	echo "</ul>";
}

/**
 * Retrieve category parents with separator.
 *
 * @since 1.2.0
 *
 * @param int    $id        Category ID.
 * @param bool   $link      Optional, default is false. Whether to format with link.
 * @param string $separator Optional, default is '/'. How to separate categories.
 * @param bool   $nicename  Optional, default is false. Whether to use nice name for display.
 * @param array  $visited   Optional. Already linked to categories to prevent duplicates.
 *
 * @return string|WP_Error A list of category parents on success, WP_Error on failure.
 */
function cavada_get_category_parents( $id, $link = false, $separator = '/', $nicename = false, $visited = array() ) {
	$chain  = '';
	$parent = get_term( $id, 'category' );
	if ( is_wp_error( $parent ) ) {
		return $parent;
	}

	if ( $nicename ) {
		$name = $parent->slug;
	} else {
		$name = $parent->name;
	}

	if ( $parent->parent && ( $parent->parent != $parent->term_id ) && ! in_array( $parent->parent, $visited ) ) {
		$visited[] = $parent->parent;
		$chain .= get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
	}

	if ( $link ) {
		$chain .= '<a href="' . esc_url( get_category_link( $parent->term_id ) ) . '"><span">' . $name . '</span></a>' . $separator;
	} else {
		$chain .= $name . $separator;
	}

	return $chain;
}


/* Share Product */
add_action( 'woocommerce_share', 'cavada_wooshare' );

function cavada_wooshare() {
	global $cavada_data;
	$html = '';
	if ( ( isset( $cavada_data['woo_sharing_facebook'] ) && $cavada_data['woo_sharing_facebook'] == 1 ) ||
		( isset( $cavada_data['woo_sharing_twitter'] ) && $cavada_data['woo_sharing_twitter'] == 1 ) ||
		( isset( $cavada_data['woo_sharing_pinterest'] ) && $cavada_data['woo_sharing_pinterest'] == 1 ) ||
		( isset( $cavada_data['woo_sharing_google'] ) && $cavada_data['woo_sharing_google'] ) == 1
	) {
		$html .= '<ul class="woo_share_social">';
		$html .= '<li class="text">' . esc_html__( 'Share', 'cavada' ) . '</li>';
		if ( $cavada_data['woo_sharing_facebook'] == 1 ) {
			$html .= '<li><a target="_blank" class="facebook" href="' . esc_url( 'https://www.facebook.com/sharer.php?s=100&amp;p[title]=' . get_the_title() . '&amp;p[url]=' . urlencode( get_permalink() ) . '&amp;p[images][0]=' . urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ) ) . '" title="' . esc_html__( 'Facebook', 'cavada' ) . '"><i class="fa fa-facebook"></i></a></li>';
		}
		if ( $cavada_data['woo_sharing_twitter'] == 1 ) {
			$html .= '<li><a target="_blank" class="twitter" href="' . esc_url( 'https://twitter.com/share?url=' . urlencode( get_permalink() ) . '&amp;text=' . esc_attr( get_the_title() ) ) . '" title="' . esc_html__( 'Twitter', 'cavada' ) . '"><i class="fa fa-twitter"></i></a></li>';
		}
		if ( $cavada_data['woo_sharing_pinterest'] == 1 ) {
			$html .= '<li><a target="_blank" class="pinterest" href="' . esc_url( 'http://pinterest.com/pin/create/button/?url=' . urlencode( get_permalink() ) . '&amp;description=' . get_the_excerpt() . '&media=' . urlencode( wp_get_attachment_url( get_post_thumbnail_id() ) ) ) . '" onclick="window.open(this.href); return false;" title="' . esc_html__( 'Pinterest', 'cavada' ) . '"><i class="fa fa-pinterest"></i></a></li>';
		}
		if ( $cavada_data['woo_sharing_google'] == 1 ) {
			$html .= '<li><a target="_blank" class="googleplus" href="' . esc_url( 'https://plus.google.com/share?url=' . urlencode( get_permalink() ) . '&amp;title=' . esc_attr( get_the_title() ) ) . '" title="' . esc_html__( 'Google Plus', 'cavada' ) . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><i class="fa fa-google"></i></a></li>';
		}
		$html .= '</ul>';
	}
	echo ent2ncr( $html );
}

/**
 * Get visitor of single page
 *
 * @param null $post_id Post ID
 *
 * @return int
 */
function get_blog_visitor( $post_id = null ) {
	global $post;
	if ( ! $post_id ) {
		$post_id = $post->ID;
	}
	if ( $post_id ) {
		$visitor = get_post_meta( $post_id, 'vi_visitor', true );

		return $visitor ? $visitor : 0;
	} else {
		return 0;
	}
}

add_editor_style();
?>
