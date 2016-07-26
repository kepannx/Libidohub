<?php
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/general.php";
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/header.php";
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/display.php";
if ( class_exists( 'WooCommerce' ) ) {
	include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/woocommerce.php";
}
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/styling.php";
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/typography.php";
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/footer.php";
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/custom-css.php";
include CAVADA_THEME_DIR . "/inc/admin/theme-options-sections/output.php";