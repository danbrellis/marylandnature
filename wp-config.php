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
if ($_SERVER["HTTP_HOST"] === 'dev.marylandnature.org') {
  $db_name = 'dev_marylandnature';
	$username = 'fcurfqoxxt';
  $password = 'x7symVZx9U';
	$host = 'marylandnaturalistor.ipowermysql.com';
} else if ($_SERVER["HTTP_HOST"] === 'localhost') {
  $db_name = 'marylandnature';
  $username = 'root';
  $password = 'root';
  $host = 'localhost';
  define('WP_DEBUG', true);
  define('SITEORIGIN_PANELS_NOCACHE', true);
} else if ($_SERVER["HTTP_HOST"] === 'marylandnature.local') {
  $db_name = 'dev_marylandnature';
  $username = 'root';
  $password = '';
  $host = 'localhost';
  define('WP_DEBUG', true);
  define('SITEORIGIN_PANELS_NOCACHE', true);
}
/** The name of the database for WordPress */
define('DB_NAME', $db_name);

/** MySQL database username */
define('DB_USER', $username);

/** MySQL database password */
define('DB_PASSWORD', $password);

/** MySQL hostname */
define('DB_HOST', $host);

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
define('AUTH_KEY',         'in]5qgbAT^mUp^e+DMs:-7-idDk/NN9@+L%U1B<goM:5qunij,{|oea!<LVZ0gP)');
define('SECURE_AUTH_KEY',  '-L5B(!hm~X#=~o2-}N5R-#NkN;fL7UM:0hxc+,u1khzjfnW[ewZmxOf[OCedO+)[');
define('LOGGED_IN_KEY',    'QrN6JGXJgy]]N%z1` My_-}m&fM;D4?hye{yWa}A4uQM6O7,A:>N=SS552mWz)HH');
define('NONCE_KEY',        '>|+@p`g2!@_RqA_>1}vclLAAO-issh (WszjP2=k<E{/aT(_~&4gW2m^ak9sK>G2');
define('AUTH_SALT',        'fz1pjup,8N6%d}3:@c/e(flwzQZk4$A=24J8Uq1[7ANc]hBE_5m`OlYUqxqo11%l');
define('SECURE_AUTH_SALT', '5m[OgR)6k9wanHm0/_aw)e5B{Hu`vnXfq])) w_qEUoD{Pi5xU<`=Ok%}>w+vpQ|');
define('LOGGED_IN_SALT',   '3Mw{-a:N02iAMVe^!b#3hY{YPw[5C4RQI=wMc|/Bkk`c]FC5zp3KZGrC&[J5MR}#');
define('NONCE_SALT',       '9u;zeKvRmyRCDb7~v.{c&o6D[`!TssCTR2CZqlM)-fp=@WdzX^%A@pi=4z@6w ]:');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
