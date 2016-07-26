<?php


/********************cavada_entry_top**********************/
add_action( 'cavada_entry_top', 'cavada_post_formats' );

/**
 * Show entry format images, video, gallery, audio, etc.
 * @return void
 */

function cavada_post_formats( $size ) {
	$html   = '';
	$schema = new CAVADA_Schema();
	$meta   = '';
	switch ( get_post_format() ) {
		case 'image':
			$meta  = $schema->get_image( get_post_thumbnail_id( get_the_ID() ), $size );
			$image = cavada_get_image( array(
				'size'     => $size,
				'format'   => 'src',
				'meta_key' => 'image',
				'echo'     => false,
			) );
			if ( ! $image ) {
				break;
			}
			if ( is_single() ) {
				$html = sprintf( '<img src="%2$s" alt="%1$s">', the_title_attribute( 'echo=0' ), $image );
			} else {
				$html = sprintf(
					'<a class="post-image" href="%1$s" title="%2$s"><img src="%3$s" alt="%2$s"></a>',
					get_permalink(),
					the_title_attribute( 'echo=0' ),
					$image
				);
			}

			break;
		case 'gallery':
			$images = cavada_meta( 'images', "type=image&size=$size" );
			if ( empty( $images ) ) {
				break;
			}
			$html .= '<div class="flexslider">';
			$html .= '<ul class="slides">';
			foreach ( $images as $image ) {

				$meta_tmp = $schema->get_image( $image['ID'], $size );
				$html .= sprintf( '<li><img src="%s" alt="gallery">' . $meta_tmp . '</li>', $image['url'] );
			}
			$html .= '</ul>';
			$html .= '</div>';
			break;
		case 'audio':
			$audio = cavada_meta( 'audio' );
			if ( ! $audio ) {
				break;
			}

			// If URL: show oEmbed HTML or jPlayer
			if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
				if ( $oembed = @wp_oembed_get( $audio ) ) {
					$html .= $oembed;
				}
			} // If embed code: just display
			else {
				$html .= $audio;
			}
			break;
		case 'video':
			$video = cavada_meta( 'video' );
			if ( ! $video ) {
				break;
			}
			// If URL: show oEmbed HTML
			if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
				if ( $oembed = @wp_oembed_get( $video ) ) {
					$html .= $oembed;
				}
			} // If embed code: just display
			else {
				$html .= $video;
			}
			break;

		case 'link':
			$url   = cavada_meta( 'url' );
			$thumb = get_the_post_thumbnail( get_the_ID(), $size );
			$meta  = $schema->get_image( get_post_thumbnail_id( get_the_ID() ), $size );
			if ( empty( $thumb ) ) {
				return;
			}
			if ( $url ) {
				$html .= '<a class="post-image" href="' . $url . '">';
			}
			$html .= $thumb;
			if ( $url ) {
				$html .= '</a/>';
			}
			break;
		default:
			$thumb = get_the_post_thumbnail( get_the_ID(), $size );
			$meta  = $schema->get_image( get_post_thumbnail_id( get_the_ID() ), $size );
			if ( $thumb ) {
				if ( ! is_single() ) {
					$html .= '<a class="post-image" href="' . get_permalink() . '">';
				}
				$html .= $thumb;
				if ( ! is_single() ) {
					$html .= '</a>';
				}
			} else {
				$html .= '<img src="' . get_template_directory_uri() . '/images/image-demo.jpg">';
			}
	}
	if ( $html ) {
		echo '<div class="post-formats-wrapper">' . $html . $meta . '</div>';
	}
}

/**
 * Get post thumbnail src based on post formats
 * @return void
 */
function cavada_post_thumbnail_src( $size ) {
	$src = '';
	switch ( get_post_format() ) {
		case 'gallery':
			$images = cavada_meta( 'images', "type=image&size=$size" );

			if ( empty( $images ) ) {
				break;
			}

			$image = current( $images );
			$src   = $image['url'];
			break;
		default:
			$src = cavada_get_image( array(
				'size'     => $size,
				'format'   => 'src',
				'meta_key' => 'image',
				'echo'     => false,
			) );
			break;
	}

	return $src;
}

function cavada_meta( $key, $args = array(), $post_id = null ) {
	if ( ! function_exists( 'rwmb_meta' ) ) {
		return false;
	}

	return rwmb_meta( $key, $args, $post_id );
}

function cavada_get_image( $args = array() ) {
	$default = apply_filters(
		'cavada_get_image_default_args',
		array(
			'post_id'  => get_the_ID(),
			'size'     => 'thumbnail',
			'format'   => 'html', // html or src
			'attr'     => '',
			'meta_key' => '',
			'scan'     => true,
			'default'  => '',
			'echo'     => true,
		)
	);

	$args = wp_parse_args( $args, $default );

	if ( ! $args['post_id'] ) {
		$args['post_id'] = get_the_ID();
	}

	// Get image from cache
	$key         = md5( serialize( $args ) );
	$image_cache = wp_cache_get( $args['post_id'], 'cavada_get_image' );

	if ( ! is_array( $image_cache ) ) {
		$image_cache = array();
	}

	if ( empty( $image_cache[ $key ] ) ) {
		// Get post thumbnail
		if ( has_post_thumbnail( $args['post_id'] ) ) {
			$id   = get_post_thumbnail_id();
			$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
			list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
		}

		// Get the first image in the custom field
		if ( ! isset( $html, $src ) && $args['meta_key'] ) {
			$id = get_post_meta( $args['post_id'], $args['meta_key'], true );

			// Check if this post has attached images
			if ( $id ) {
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}
		}

		// Get the first attached image
		if ( ! isset( $html, $src ) ) {
			$image_ids = array_keys( get_children( array(
				'post_parent'    => $args['post_id'],
				'post_type'      => 'attachment',
				'post_mime_type' => 'image',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			) ) );

			// Check if this post has attached images
			if ( ! empty( $image_ids ) ) {
				$id   = $image_ids[0];
				$html = wp_get_attachment_image( $id, $args['size'], false, $args['attr'] );
				list( $src ) = wp_get_attachment_image_src( $id, $args['size'], false, $args['attr'] );
			}
		}

		// Get the first image in the post content
		if ( ! isset( $html, $src ) && ( $args['scan'] ) ) {
			preg_match( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );

			if ( ! empty( $matches ) ) {
				$html = $matches[0];
				$src  = $matches[1];
			}
		}

		// Use default when nothing found
		if ( ! isset( $html, $src ) && ! empty( $args['default'] ) ) {
			if ( is_array( $args['default'] ) ) {
				$html = @$args['html'];
				$src  = @$args['src'];
			} else {
				$html = $src = $args['default'];
			}
		}

		// Still no images found?
		if ( ! isset( $html, $src ) ) {
			return false;
		}

		$output = 'html' === strtolower( $args['format'] ) ? $html : $src;

		$image_cache[ $key ] = $output;
		wp_cache_set( $args['post_id'], $image_cache, 'cavada_get_image' );
	} // If image already cached
	else {
		$output = $image_cache[ $key ];
	}

	$output = apply_filters( 'cavada_get_image', $output, $args );

	if ( ! $args['echo'] ) {
		return $output;
	}

	echo ent2ncr( $output );
}
