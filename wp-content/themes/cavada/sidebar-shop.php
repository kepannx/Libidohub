<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package cavada
 */

if ( ! is_active_sidebar( 'shop' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area col-sm-3" role="complementary">
	<?php dynamic_sidebar( 'shop' ); ?>
</div><!-- #secondary -->