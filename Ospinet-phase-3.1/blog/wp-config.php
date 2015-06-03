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
define('DB_NAME', 'ospinet_wp');

/** MySQL database username */
define('DB_USER', 'ospinet_wpadmin');

/** MySQL database password */
define('DB_PASSWORD', '0$p!n3t');

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
define('AUTH_KEY',         'YXW3h:t/Bh|L.-`i]qJjmUz_/0=JmV@Vihxb c=6AL>wq{CY$1Wd3Cd-Lu~mTZzf');
define('SECURE_AUTH_KEY',  'qC41yT:znD> 1jlBp>M{_{XtN0%M;H# |&6-H4xBPj(,|Q}>?cibMayT_Y#{rN8<');
define('LOGGED_IN_KEY',    '{4,_Z`UmP5P84sxfguE:l+ pqQ~c? }(`CMmhI_]J7wef#&F`Og#vL(780(sr|Eu');
define('NONCE_KEY',        '%q>-wZB]O(DnmB!ag.:I{xF|+YgSDgDJ-px)Dz{VdG[nlU++e}m0q5-{K.Tm]%!6');
define('AUTH_SALT',        'Mof/)_:T|xX99Q(%$-n1;Ak|=96[+E/:-?m5r&pf# ~_so,h<;.bSJ!>lV1C!-DY');
define('SECURE_AUTH_SALT', '7tLce7.Ev&@>qwS[w8,]8W3hi|T;rM`%=@]G?Yjyq{b,$7+@+Gp0I4ad}sN#/v-G');
define('LOGGED_IN_SALT',   'X+}n9H?L^&ykC$%e}l-&{,JK!g-MYJ]O~<emMw1!%d1l|yAXx=$Jq5U` !%7ZZMO');
define('NONCE_SALT',       'P|5D-Cf1l0rI/8}v]=l)!?+IG+YCh!U^Y:TDJo5gO={}bKy?3<3_-0w 0o-a.?w;');

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
