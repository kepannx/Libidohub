<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package cavada
 */

?><!DOCTYPE html>
<?php
$cavada_data = cavada_get_data_themeoptions();
$class_header    = '';
if ( isset( $cavada_data['rtl_support'] ) && $cavada_data['rtl_support'] == '1' ) {
	$class_header_body .= 'rtl';
}
?>
<html <?php language_attributes(); ?> <?php if ( isset( $cavada_data['rtl_support'] ) && $cavada_data['rtl_support'] == '1' ) {
	echo "dir=\"rtl\"";
} ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php
	if ( isset( $cavada_data['config_att_sticky'] ) && $cavada_data['config_att_sticky'] == 'sticky_custom' ) {
		$class_header .= ' bg-custom-sticky';
	}
	if ( isset( $cavada_data['header_sticky'] ) && $cavada_data['header_sticky'] == 1 ) {
		$class_header .= ' sticky-header';
	}
	if ( isset( $cavada_data['header_position'] ) ) {
		$class_header .= ' ' . $cavada_data['header_position'];
	}
	if ( isset( $cavada_data['header_style'] ) ) {
		$class_header .= ' ' . $cavada_data['header_style'];
	}
	if ( isset( $cavada_data['choose_header'] ) ) {
		$class_header .= ' ' . $cavada_data['choose_header'];
	}
	if ( isset( $cavada_data['menu_align'] ) ) {
		$class_header .= ' ' . $cavada_data['menu_align'];
	}
	if ( isset( $cavada_data['text_transform_menu'] ) ) {
		$class_header .= ' menu-text-' . $cavada_data['text_transform_menu'];
	}
	?>
 	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( isset( $cavada_data['show_preload'] ) && $cavada_data['show_preload'] == '1' ) { ?>
	<div id="preload">
		<div class="preload-inner">
			<?php do_action( 'cavada_logo' ); ?>
			<div class="clear"></div>
			<div class="loading-inner">
				<span class="loading-1"></span>
				<span class="loading-2"></span>
				<span class="loading-3"></span>
			</div>
		</div>
	</div>
<?php } ?>

<div id="wrapper-container" class="wrapper-container">
	<div class="content-pusher<?php
	if ( isset( $cavada_data['box_layout'] ) && $cavada_data['box_layout'] == "boxed" ) {
		echo ' boxed-area';
	} ?>">
		<header id="masthead" class="site-header affix-top<?php echo esc_attr( $class_header ); ?>">
			<?php
			if ( isset( $cavada_data['user_top_bar'] ) && $cavada_data['user_top_bar'] == '1' ) {
				get_template_part( 'inc/header/topbar' );
			}
			?>
			<div class="wrapper-navigation">
				<?php
				if ( isset( $cavada_data['header_style'] ) && $cavada_data['header_style'] ) {
					get_template_part( 'inc/header/' . $cavada_data['header_style'] );
				} else {
					get_template_part( 'inc/header/header_v1' );
				}
				?>
			</div>
		</header>