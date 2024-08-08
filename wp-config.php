<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp_ashafeeds' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
// define( 'DB_HOST', '192.168.1.8' );
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '2Ph=3V(n.ZLkdP|L=3?,4A|n0WFfp1GiETgOUqYGCe48PQ75^hoDHc2;$OqXY95i' );
define( 'SECURE_AUTH_KEY',  '<iv6>v[=E+z}A]i-bf-;</ks*U?,uG-01mo3`?u^Va_p 1xF|tQ/=4!(Fc!klU?.' );
define( 'LOGGED_IN_KEY',    'pu{&*wNVno,Oz#3O*hgub*{NTs`(}bA:_ps]WESvtVkEv2936boB}-><.[CM(.B3' );
define( 'NONCE_KEY',        'wm{<sneLG,?6L)3o3X!0;x90|`r<Bd7%-0^aM_ eu&]?x=K1!_N-~xSl|*,q1iip' );
define( 'AUTH_SALT',        'c23P]-Gvf9 lF&W!=bccF-xw4!36 t7x!jMtyV{%$`hE6$h04]o]K=F1p)ch.P00' );
define( 'SECURE_AUTH_SALT', '<2O^x~X<J4g(BuP{qS`l;uhx_F)RBrndcFxmBLC6^X?k@|CK|ggWQYAV*6CyFls8' );
define( 'LOGGED_IN_SALT',   'IK>MIy,1rl]Ah!AsJT2J!6%3]l$+OLZRopeLVUI,cI4/O2u+ZcgW74*tLbd~f4Iq' );
define( 'NONCE_SALT',       'i `3#9;_{^*BR9(z*q)bR?Q@6yByk>^GT GDM,T8?=_OH.*Xm4dZi:^:?dMs@S(F' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
