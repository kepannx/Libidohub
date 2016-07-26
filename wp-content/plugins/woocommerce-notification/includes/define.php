<?php

define( 'VI_WNOTIFICATION_DIR', WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . "woocommerce-notification" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_ADMIN', VI_WNOTIFICATION_DIR . "admin" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_FRONTEND', VI_WNOTIFICATION_DIR . "frontend" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_LANGUAGES', VI_WNOTIFICATION_DIR . "languages" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_INCLUDES', VI_WNOTIFICATION_DIR . "includes" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_TEMPLATES', VI_WNOTIFICATION_DIR . "templates" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_CACHE', WP_CONTENT_DIR . "/cache/woonotification/" );

define( 'VI_WNOTIFICATION_SOUNDS', VI_WNOTIFICATION_DIR . "sounds" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_SOUNDS_URL', WP_PLUGIN_URL . "/woocommerce-notification/sounds/" );

define( 'VI_WNOTIFICATION_CSS', WP_PLUGIN_URL . "/woocommerce-notification/css/" );
define( 'VI_WNOTIFICATION_CSS_DIR', VI_WNOTIFICATION_DIR . "css" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_JS', WP_PLUGIN_URL . "/woocommerce-notification/js/" );
define( 'VI_WNOTIFICATION_JS_DIR', VI_WNOTIFICATION_DIR . "js" . DIRECTORY_SEPARATOR );
define( 'VI_WNOTIFICATION_IMAGES', WP_PLUGIN_URL . "/woocommerce-notification/images/" );


/*Include functions file*/
if ( is_file( VI_WNOTIFICATION_INCLUDES . "functions.php" ) ) {
	require_once VI_WNOTIFICATION_INCLUDES . "functions.php";
}
/*Include functions file*/
if ( is_file( VI_WNOTIFICATION_INCLUDES . "mobile_detect.php" ) ) {
	require_once VI_WNOTIFICATION_INCLUDES . "mobile_detect.php";
}

vi_include_folder( VI_WNOTIFICATION_ADMIN, 'VI_WNOTIFICATION_Admin_' );
vi_include_folder( VI_WNOTIFICATION_FRONTEND, 'VI_WNOTIFICATION_Frontend_' );
?>