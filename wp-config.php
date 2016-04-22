<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'nerdStudies_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '|KMvwNIcXfz{@8%|k$i[%do&;.huh,bGrR&u-Er`fP _jF^gdt$s<YZL_wTKTdih');
define('SECURE_AUTH_KEY',  '<EO5kTX$_B2}M;2.8H*R7^@kWEJH#yT&Rp^ghXzt6f*wulQbx/)jUM;4K_wY}.}|');
define('LOGGED_IN_KEY',    'EdlPyFKEQ8L~TD{Dpi:^n:t,Crm,{(Vjk|511.:Rf`g#J`CJhD5oP4;*!CUq0<83');
define('NONCE_KEY',        'vK@AaKj=fZW?Y@1yuTlSI jFc]:cXx-|-Hs?_uIlj5])c^H/U$PiJ],9GT:O0[/(');
define('AUTH_SALT',        'X`yUe^H*_)0PDuK>NjR|I=_?h-e.Y|TW~=>NuqaiN&h@Yb|?|og/r_SOAOAt-A;5');
define('SECURE_AUTH_SALT', 'Tc5G]zs_9$wB1N*[QYymZe-6z9I 7g7 S-Tz8#pUX+4R]MvN_q)>UIW3zEmVlV!g');
define('LOGGED_IN_SALT',   'Der.!5kk!Iq.wkjPt]]:20$|Lo&@jbG*f[[Lhh|%1i~OwrW/kK3?pI`di]1[9*<I');
define('NONCE_SALT',       'UcntP^7VWwLc0SjsJIqmU$1PUYWC&?~Hq%R_@BGA%Z0 IR%B?fZaF(;CjO+#OMh{');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
