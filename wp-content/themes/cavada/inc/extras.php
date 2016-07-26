<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package cavada
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function cavada_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.

	global $cavada_data;
	$class_header_body = '';
	if ( isset( $cavada_data['header_position'] ) ) {
		$class_header_body .= ' wrapper-' . $cavada_data['header_position'];
	}
	if ( isset( $cavada_data['header_style'] ) ) {
		$class_header_body .= ' wrapper-' . $cavada_data['header_style'];
	}
	if ( isset( $cavada_data['choose_header'] ) ) {
		$class_header_body .= ' wrapper-' . $cavada_data['choose_header'];
	}

	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// add 'class-name' to the $classes array
	$classes[] = $class_header_body;

	return $classes;
}

add_filter( 'body_class', 'cavada_body_classes' );
