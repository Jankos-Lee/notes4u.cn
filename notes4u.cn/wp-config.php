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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'Wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'easy0226.' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ':pvDPFK!xr4(Z){q9Tr4(5>tn+G;sMelLr5so0.};/#nLDdl@zN76%/?,&U?F]Dd' );
define( 'SECURE_AUTH_KEY',  'YCh_+&;N.},b^YZm*T]h/,B209#Z)[9^G5Z:zN&JhM}@7%yF`&Lyzam&Ck1WRnhT' );
define( 'LOGGED_IN_KEY',    'p#er}Ujws]k~BEL`d]pad&mKU|wCbNL<c_665-NF yaj{T*TL5Nq)12Z^yLNtDza' );
define( 'NONCE_KEY',        '8by/%{T;jWSr Vedd0$BTN>E:i -zFdq=A2*QUF$V?4k}.OOc^D:D}=/tS|[-KVh' );
define( 'AUTH_SALT',        'QAX=<KM_9OJdO6;F~zbfj3=t8K4iG?q)0y %](fyJ3q=Ts,0ms1fd}A^MT3r$DUK' );
define( 'SECURE_AUTH_SALT', '46R86FIkZCxM[/^ol>f P|-4xs,b,< E5RmXdo ^RvoeG;bEr)w2G/ .vY-6CtIR' );
define( 'LOGGED_IN_SALT',   'y`5A-I8S0v|~SWl5;ON.4aPE(EZ)rc0$F{LcL/m#@w>ky;+#I}bDDeuvbMaQBxZ_' );
define( 'NONCE_SALT',       '9>?,S{dO2&wV/2v$^U%(aoA(d[3CvG=AG]VB&DL>^?paqE#$ {-]=Rbi04VU+{(h' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
