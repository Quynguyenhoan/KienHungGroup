<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
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
define( 'DB_NAME', 'kienhunggroup' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'l)>gM^JW{KuRX7^sw:^]JeCxzTTg|i><ZGOuwtvRO}&c%qEUKKepfO&I5i&gDuQ+' );
define( 'SECURE_AUTH_KEY',  'gR%6JEXQ=<IF`QtT7,0iB@WAqx5+Y)7<Bi8sMEEwbhOGl]o;V_2{d4T%gcvn@ xH' );
define( 'LOGGED_IN_KEY',    '/>q6E=&FFMPc)r.g.M.CUfz[*k|y eU%R.gA0]QWN/B4yH1VR8/{iFUv<73lYb5=' );
define( 'NONCE_KEY',        '~c[TI]{6moo?u+ACf|=Csp8 (n*qr5F25bnnP2:PD>bkPTX)q[6-@sGxL/jY-tL6' );
define( 'AUTH_SALT',        'lUJ(%pX;R.;D3)VZP]8%:t&(^U<LrTHpyEn#Phv01O;RlxKhx$V ^0iRDk^4` P9' );
define( 'SECURE_AUTH_SALT', 'KNIyrGxR/j7#bxS3{!onrRA 6xq2qx)`*D*-O9X:Jua5s~%ZZ1]c97rmE3h;Z=36' );
define( 'LOGGED_IN_SALT',   'uPW|]24BRg-<Pqq_~jg4s^hpSu3^6fzNYT?m_Yha,DB+;g[:L=ofX@dq~w*9fL#d' );
define( 'NONCE_SALT',       '3<Zv+ns##/E)F|Bgd5K1qrh,RrOQ3=zayu@U,K%@@!}eWRaZU,uItX|,.(Rb0^Ok' );

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


putenv('GOOGLE_MAP_API_KEY=your_actual_api_key_here');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
