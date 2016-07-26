<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'libihub');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'libid_hub');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'wF8rVMvuH3eA3AxA');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '4jVB=U&:KDus]%5rZppYC%Zdi.umhu,s*S;5qAIx.yQ6FDlw0M:5@dI C_.ibdYo');
define('SECURE_AUTH_KEY', ';M(<EWq^0_(FXfU9I+sw3i}AB?}qZmpnL%{kP+{Hjz4Nx-ZZ )abS>ied%%jV3-5');
define('LOGGED_IN_KEY', 'oB-n?c0/>dMqx9P+wXm,aktiECZfn.Z`z`mPG{0}v%v8pbWAa2Py,2ItMMR4,nhk');
define('NONCE_KEY', 'Q{?/bK?|r{v2O2>k/zl1F9K1R}Yynmo@TPvs+|yM@4m?_OS%E@t`H5fe->)/@r)+');
define('AUTH_SALT', 'gZsoQ!esgip`W}4f}-Z[{vB][:MnUBjY^AN+eSpw>4k~]W|2IqxE?KAn`fdP9E{o');
define('SECURE_AUTH_SALT', '7XE6,B6-mhN[*cBiCq34w:ESMUZnI>;-XEf57,w{F|Q:pNJ;cOsIv+Zi%1aNY-aW');
define('LOGGED_IN_SALT', '~6X`^d??T;fDZuVw>&pof%Qht-GaYd#xAf{CnHf&ZC=lMExV@B#U}a)r%rZ!4{W@');
define('NONCE_SALT', 'O{7NT{MshW*~Gj^;Mm_kK. ~2OkS9,y&~*|Kf@As8rGMZOVEnVwdr#nn(IKcy_.@');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'lb_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

