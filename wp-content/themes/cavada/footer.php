<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package cavada
 */
$cavada_data  = cavada_get_data_themeoptions();
$footer_fullwidth = $copyright_fullwidth = $footer_top_fullwidth = $footer_class = '';
if ( isset( $cavada_data['footer_fullwidth'] ) && $cavada_data['footer_fullwidth'] == 1 ) {
	$footer_fullwidth = '-fluid';
}
if ( isset( $cavada_data['copyright_fullwidth'] ) && $cavada_data['copyright_fullwidth'] == 1 ) {
	$copyright_fullwidth = '-fluid';
}
if ( isset( $cavada_data['show_footer_top'] ) && $cavada_data['show_footer_top'] == 1 ) {
	$footer_top_fullwidth = '-fluid';
}
if ( isset( $cavada_data['style_title'] ) ) {
	$footer_class .= ' ' . $cavada_data['style_title'];
}
if ( isset( $cavada_data['border_position'] ) ) {
	$footer_class .= ' ' . $cavada_data['border_position'];
}
?>
<?php
if ( isset( $cavada_data['show_footer_top'] ) && $cavada_data['show_footer_top'] == '1' ) {
	if ( is_active_sidebar( 'top_footer' ) ) : ?>
		<div class="top_footer<?php
		if ( isset( $cavada_data['style_title'] ) ) {
			echo ' ' . $cavada_data['style_title'];
		}
		?>">
			<div class="container<?php echo esc_attr( $footer_top_fullwidth ); ?>">
				<div class="row">
					<?php dynamic_sidebar( 'top_footer' ); ?>
				</div>
			</div>
		</div>
		<?php
	endif;
}
?>

<footer id="footer" class="site-footer">
	<?php if ( is_active_sidebar( 'footer' ) ) : ?>
		<div class="footer<?php echo esc_attr( $footer_class ); ?>">
			<div class="container<?php echo esc_attr( $footer_fullwidth ); ?>">
				<div class="row">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<!--==============================powered=====================================-->
	<?php if ( isset( $cavada_data['footer_text'] ) || is_active_sidebar( 'copyright' ) ) { ?>
		<div id="powered">
			<div class="container<?php echo esc_attr( $copyright_fullwidth ); ?>">
				<div class="row">
					<div class="powered-table">
						<?php
						if ( isset( $cavada_data['copyright_style'] ) && ( $cavada_data['copyright_style'] == 'right' || $cavada_data['copyright_style'] == 'left' ) ) {
							$class_footer = 6;
						} else {
							$class_footer = '12 text-center';
						}
						if ( isset( $cavada_data['copyright_style'] ) && $cavada_data['copyright_style'] == 'left' ) {
							echo '<div class="col-sm-' . esc_attr( $class_footer ) . ' copyright-' . $cavada_data['copyright_style'] . '"><p class="text-copyright">' . $cavada_data['footer_text'] . '</p></div>';
						}
						$clas_copyright = '';
						if ( isset( $cavada_data['copyright_style'] ) && $cavada_data['copyright_style'] == 'center' ) {
							if ( is_active_sidebar( 'copyright_right' ) && is_active_sidebar( 'copyright' ) ) {
								$class_footer   = 4;
								$clas_copyright = 'text-center';
							} elseif ( is_active_sidebar( 'copyright_right' ) || is_active_sidebar( 'copyright' ) ) {
								$class_footer = 6;
							}
						}
						if ( is_active_sidebar( 'copyright' ) ) { ?>
							<div class="col-sm-<?php echo esc_attr( $class_footer ); ?> copyright">
								<?php dynamic_sidebar( 'copyright' ); ?>
							</div>
						<?php }

						if ( isset( $cavada_data['copyright_style'] ) && $cavada_data['copyright_style'] != 'left' ) {
							echo '<div class="col-sm-' . esc_attr( $class_footer ) . ' ' . esc_attr( $clas_copyright ) . '"><p class="text-copyright">' . $cavada_data['footer_text'] . '</p></div>';
						}
						if ( isset( $cavada_data['copyright_style'] ) && $cavada_data['copyright_style'] == 'center' ) {
							if ( is_active_sidebar( 'copyright_right' ) ) { ?>
								<div class="col-sm-<?php echo esc_attr( $class_footer ); ?>  copyright copyright_right">
									<?php dynamic_sidebar( 'copyright_right' ); ?>
								</div>
							<?php }
						}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</footer>
</div></div><!-- .wrapper-container -->
<!-- .box-area -->

<?php
if ( isset( $cavada_data['totop_show'] ) && $cavada_data['totop_show'] == 1 ) { ?>
	<a id='topcontrol' class="scroll-to-top" title="<?php esc_attr_e( 'Go To Top', 'cavada' ); ?>"><i class="fa fa-arrow-up"></i></a>
<?php } ?>

<?php wp_footer(); ?>
</body>
</html>