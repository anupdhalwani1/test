<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ospinet_wp-rev');

/** MySQL database username */
define('DB_USER', 'ospinet_wpreview');

/** MySQL database password */
define('DB_PASSWORD', 'W04dpr33$rev!ews');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'o<(eY3]5=d0fBfxfST/LQ6yXQ8|1Am$Ty~`^Lpk-{XG-C=UvW|zq#vfpLnq3V`y^');
define('SECURE_AUTH_KEY',  'N[43<JsM9]>#5|(?nN_tsMj]HOqD;!|gcA+~S{/Ge{w0,:>jJVl%xr+onna-eIi$');
define('LOGGED_IN_KEY',    'U|,5p>qdg|fX*dI0J(W&`EoydqKONU-?)VJ gM9_}#gQ|7(24C}DpB)U3qpGh|W%');
define('NONCE_KEY',        'kw?OE7Tc}%Y*[|$YVR`C/}e#&tun;SOd$B/pa:#k=J|S13mnMhmVXxvSwWOMq|cd');
define('AUTH_SALT',        ';oxfh%,U^( `ce+dG<|Rw}k?+-o|l_iLGQRaGH3Ow]JFkN|a@4w?:4;UIGLBd-NE');
define('SECURE_AUTH_SALT', '#[$4:b0+PDs|Y)++$_;@~B+Ko%TEZeh(Rb&_Ow|t2#tO=s}J}ybHP|9{.X1O:@JD');
define('LOGGED_IN_SALT',   '8qqFa)$_i1|dmWZ=z+ax=y!Q%|#D+0MQ-y3K9QFSN|+[|Ug?J.EtY/a/#JS}^&!h');
define('NONCE_SALT',       'R$ $D!qlp<MVG?VQRr=U?P<{NZJa[;k@D[N>|i~@^Jb;~X[|%(+nPxII2+V`/MN*');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
