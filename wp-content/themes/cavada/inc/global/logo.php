<?php
add_action( 'cavada_logo', 'cavada_logo', 1 );
// logo
if ( ! function_exists( 'cavada_logo' ) ) :
	function cavada_logo() {
		global $cavada_data;
		$cavada_data = get_theme_mods();
		$cavada_data = apply_filters( 'of_options_after_load', $cavada_data );
		if ( isset( $cavada_data['cavada_logo'] ) && $cavada_data['cavada_logo'] <> '' ) {
			$cavada_logo     = $cavada_data['cavada_logo'];
			$cavada_logo_src = $cavada_logo; // For the default value
			if ( is_numeric( $cavada_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $cavada_logo, 'full' );
				$cavada_logo_src = $logo_attachment[0];
			}
			$cavada_logo_size = @getimagesize( $cavada_logo_src );
			$logo_size        = $cavada_logo_size[3];
			$site_title       = esc_attr( get_bloginfo( 'name', 'display' ) );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="no-sticky-logo"><img src="' . $cavada_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' /></a>';
		} else {
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="no-sticky-logo">' . esc_attr( get_bloginfo( 'name' ) ) . '</a>';
		}
	}
endif;
add_action( 'cavada_sticky_logo', 'cavada_sticky_logo', 1 );

// get sticky logo
if ( ! function_exists( 'cavada_sticky_logo' ) ) :
	function cavada_sticky_logo() {
		global $cavada_data;
		$cavada_data = get_theme_mods();
		$cavada_data = apply_filters( 'of_options_after_load', $cavada_data );
		if ( isset( $cavada_data['cavada_sticky_logo'] ) && $cavada_data['cavada_sticky_logo'] <> '' ) {
			$cavada_logo_stick_logo     = $cavada_data['cavada_sticky_logo'];
			$cavada_logo_stick_logo_src = $cavada_logo_stick_logo; // For the default value
			if ( is_numeric( $cavada_logo_stick_logo ) ) {
				$logo_attachment            = wp_get_attachment_image_src( $cavada_logo_stick_logo, 'full' );
				$cavada_logo_stick_logo_src = $logo_attachment[0];
			}
			$cavada_logo_size = @getimagesize( $cavada_logo_stick_logo_src );
			$logo_size        = $cavada_logo_size[3];
			$site_title       = esc_attr( get_bloginfo( 'name', 'display' ) );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
					<img src="' . $cavada_logo_stick_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' /></a>';
		} elseif ( isset( $cavada_data['cavada_logo'] ) && $cavada_data['cavada_logo'] <> '' ) {
			$cavada_logo     = $cavada_data['cavada_logo'];
			$cavada_logo_src = $cavada_logo; // For the default value
			if ( is_numeric( $cavada_logo ) ) {
				$logo_attachment = wp_get_attachment_image_src( $cavada_logo, 'full' );
				$cavada_logo_src = $logo_attachment[0];
			}
			$cavada_logo_size = @getimagesize( $cavada_logo_src );
			$logo_size        = $cavada_logo_size[3];
			$site_title       = esc_attr( get_bloginfo( 'name', 'display' ) );
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
				<img src="' . $cavada_logo_src . '" alt="' . $site_title . '" ' . $logo_size . ' /></a>';
		}
		$cavada_data['cavada_sticky_logo'] = isset( $cavada_data['cavada_sticky_logo'] ) ? $cavada_data['cavada_sticky_logo'] : '';
		$cavada_data['cavada_logo']        = isset( $cavada_data['cavada_logo'] ) ? $cavada_data['cavada_logo'] : '';
		if ( $cavada_data['cavada_sticky_logo'] == '' && $cavada_data['cavada_logo'] == '' ) {
			echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . ' - ' . esc_attr( get_bloginfo( 'description' ) ) . '" rel="home" class="sticky-logo">
			' . esc_attr( get_bloginfo( 'name' ) ) . '</a>';;
		}
	}
endif; // cavada_sticky_logo
