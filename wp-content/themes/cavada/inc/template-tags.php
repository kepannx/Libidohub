<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package cavada
 */
if ( ! function_exists( 'cavada_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function cavada_paging_nav() {
		global $cavada_data;
		// Don't print empty markup if there's only one page.
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $GLOBALS['wp_query']->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 1,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_next' => false,
				'type'      => 'list'
			)
		);
		if ( ! isset( $cavada_data['ajax_settings_run'] ) ) {
			$cavada_data['ajax_settings_run'] = 0;
		}
		if ( $links ) {
			if ( $cavada_data['ajax_settings_run'] == 'no' || ! $cavada_data['ajax_settings_run'] ) {
				echo '<div class="wrapper-pagination col-sm-12"><div class="next-prev-btn">';
				posts_nav_link( ' ', esc_html__( 'PREVIOUS', 'cavada' ), esc_html__( 'NEXT', 'cavada' ) );
				echo '</div>'
				?>
				<div class="pagination loop-pagination">
					<?php echo ent2ncr( $links ); ?>
				</div>
				</div>
			<?php } else {
				echo '<div class="next-prev-btn">';
				echo next_posts_link( esc_html__( 'NEXT', 'cavada' ) );
				echo '</div>';
			} ?>
			<!-- .pagination -->
			<?php
		}
	}
endif;

if ( ! function_exists( 'cavada_the_post_navigation' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 */
	function cavada_the_post_navigation() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<div class="nav-links post-navigation" role="navigation">
			<?php
			previous_post_link( '<div class="nav-previous">%link</div>', esc_html__( 'PREVIOUS POST', 'cavada' ) );
			next_post_link( '<div class="nav-next">%link</div>', esc_html__( 'NEXT POST', 'cavada' ) );
			cavada_wooshare();
			?>

		</div>
		<!-- .nav-links -->
		<?php
	}
endif;

if ( ! function_exists( 'cavada_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function cavada_posted_on() {
		global $cavada_data;
		echo '<div class="entry-meta">';
		$byline = sprintf(
			esc_html_x( 'Write by %s', 'post author', 'cavada' ), '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"><i class="fa fa-user"></i>' . $byline . '</span>'; // WPCS: XSS OK.
		echo '<span class="article-date">
			<i class="fa fa-clock-o"></i><span class="day">' . get_the_date( get_option( 'date_format' ) ) . '</span>
		</span>';
		echo '<span class="article-visitor">
			<i class="fa fa-eye"></i>' . get_blog_visitor() . ' (' . esc_html__( 'Views', 'cavada' ) . ')
		</span>';

		if ( comments_open() || get_comments_number() ) {
			echo '<span class="comments-link"><i class="fa fa-comments"></i>';
			comments_popup_link( esc_html__( '0', 'cavada' ), esc_html__( '1', 'cavada' ), esc_html__( '%', 'cavada' ) );
			echo '</span>';
		}
		$cavada_logo     = $cavada_data['cavada_logo'];
		$cavada_logo_src = $cavada_logo; // For the default value
		if ( is_numeric( $cavada_logo ) ) {
			$logo_attachment     = wp_get_attachment_image_src( $cavada_logo, 'full' );
			$cavada_logo_src = $logo_attachment[0];
		}
		if ( $cavada_logo_src ) {
			$cavada_logo_size = @getimagesize( $cavada_logo_src );
		} else {
			$cavada_logo_size = 0;
		}
		$width = $height = '';
		if ( $cavada_logo_size ) {
			if ( $cavada_logo_size[0] ) {
				$width = $cavada_logo_size[0];
			}
			if ( $cavada_logo_size[1] ) {
				$height = $cavada_logo_size[1];
			}
		}

//		echo '<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
//			<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
//			      <meta itemprop="url" content="' . $cavada_logo_src . '">
//			      <meta itemprop="width" content="' . $width . '">
//			      <meta itemprop="height" content="' . $height . '">
//		    </div>
//					<meta itemprop="name" content="' . esc_html( get_the_author() ) . '">
//			  </div>';
		echo '</div>';
	}
endif;

if ( ! function_exists( 'cavada_archive_entry_footer' ) ) :
	function cavada_archive_entry_footer() {
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'cavada' ) );
		if ( $tags_list ) {
			printf( '<div class="tags-links"><i class="fa fa-tag"></i> ' . esc_html__( 'Tag: %1$s', 'cavada' ) . '</div>', $tags_list );
		}
	}
endif;

if ( ! function_exists( 'cavada_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function cavada_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'cavada' ) );
			if ( $categories_list && cavada_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in: %1$s', 'cavada' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'cavada' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged: %1$s', 'cavada' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit', 'cavada' ), ''
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function cavada_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'cavada_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'cavada_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so cavada_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so cavada_categorized_blog should return false.
		return false;
	}
}

if ( ! function_exists( 'cavada_the_archive_title' ) ) :
	/**
	 * Shim for `the_archive_title()`.
	 *
	 * Display the archive title based on the queried object.
	 *
	 *
	 * @param string $before Optional. Content to prepend to the title. Default empty.
	 * @param string $after  Optional. Content to append to the title. Default empty.
	 */
	function cavada_the_archive_title( $before = '', $after = '' ) {
		if ( is_category() ) {
			$title = sprintf( esc_html__( '%s', 'cavada' ), single_cat_title( '', false ) );
		} elseif ( is_tag() ) {
			$title = sprintf( esc_html__( '%s', 'cavada' ), single_tag_title( '', false ) );
		} elseif ( is_author() ) {
			$title = sprintf( esc_html__( 'Author: %s', 'cavada' ), '<span class="vcard">' . get_the_author() . '</span>' );
		} elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Year: %s', 'cavada' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'cavada' ) ) );
		} elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Month: %s', 'cavada' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'cavada' ) ) );
		} elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Day: %s', 'cavada' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'cavada' ) ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = esc_html_x( 'Asides', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = esc_html_x( 'Galleries', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = esc_html_x( 'Images', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = esc_html_x( 'Videos', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = esc_html_x( 'Quotes', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = esc_html_x( 'Links', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = esc_html_x( 'Statuses', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = esc_html_x( 'Audio', 'post format archive title', 'cavada' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = esc_html_x( 'Chats', 'post format archive title', 'cavada' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = sprintf( esc_html__( '%s', 'cavada' ), post_type_archive_title( '', false ) );
		} elseif ( is_tax() ) {
			$tax   = get_taxonomy( get_queried_object()->taxonomy );
			$title = sprintf( '%2$s', 'cavada', single_term_title( '', false ) );
		} else {
			$title = esc_html__( 'Archives', 'cavada' );
		}

		/**
		 * Filter the archive title.
		 *
		 * @param string $title Archive title to be displayed.
		 */
		//$title = apply_filters( 'get_the_archive_title', $title );

		if ( ! empty( $title ) ) {
			echo ent2ncr( $before . $title . $after );  // WPCS: XSS OK.
		}
	}
endif;

if ( ! function_exists( 'cavada_archive_description' ) ) :
	/**
	 * Shim for `the_archive_description()`.
	 *
	 * Display category, tag, or term description.
	 *
	 * @param string $before Optional. Content to prepend to the description. Default empty.
	 * @param string $after  Optional. Content to append to the description. Default empty.
	 */
	function cavada_archive_description( $before = '', $after = '' ) {
		$description = apply_filters( 'get_the_archive_description', term_description() );

		if ( ! empty( $description ) ) {
			/**
			 * Filter the archive description.
			 *
			 * @see term_description()
			 *
			 * @param string $description Archive description to be displayed.
			 */
			echo ent2ncr( $before . $description . $after );  // WPCS: XSS OK.
		}
	}
endif;

/**
 * Flush out the transients used in cavada_categorized_blog.
 */
function cavada_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'cavada_categories' );
}

add_action( 'edit_category', 'cavada_category_transient_flusher' );
add_action( 'save_post', 'cavada_category_transient_flusher' );
