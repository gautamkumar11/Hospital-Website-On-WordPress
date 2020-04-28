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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'kjF2O >^rqEq37R9G7:!R&D-s|qeHr4H_42B4W6@fg`y,2e2xEF[US2+f$9Cv#&M');
define('SECURE_AUTH_KEY',  'u,tr7Ck0y=_rJsVhBuRr{m0RMnn0/=hI}n+;H&hKpd(`&shpp.tk6S<myyOw5uK>');
define('LOGGED_IN_KEY',    'O*0)X$aze.)os?=v-aP`RR34flP2NB5dF{QWQQnGfcH|rs7?}kE+Cr[aTB$QvA[P');
define('NONCE_KEY',        'oY0r1iuA=e~e TRzz$H0wIvnscek8{z+x1y&jBUL!d;c1V<P(xx*3Jnf{L=@(5lo');
define('AUTH_SALT',        'uIj2uG>a;m#qA5HmT,!.[>L?O_^]R 3a ;D%qBJ0bm;eQ,k*|.cl+lPOKU2H`s%}');
define('SECURE_AUTH_SALT', '}Q@3vX5j&IgxItwdf)QgHdHD?f-N0!:c5+I{21f5zv{q&R{aS<)lKd*C^~iHMtu@');
define('LOGGED_IN_SALT',   'W=sQ#Hjh;Im/FVREN3L]y{31qt{GKP Ti&2ks`pDQd#%6k*Qk3=(:2P-|(pN]KDY');
define('NONCE_SALT',       '@AzBLXWAz/H[[~4*1={U Z8_!jD^,_uD0UisBB8Rd.wB)Q^fXER;:ReI?n;I- 3>');

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
