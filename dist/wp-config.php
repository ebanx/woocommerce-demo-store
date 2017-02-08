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
define('DB_NAME', 'ebanx_demo');

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
define('AUTH_KEY',         '|y/(ma!A[}cSpd$?+0l*rv!_b~(pjOB[yxIGmEz,}G#kDYMSG4|i%)syDRykQ5*M');
define('SECURE_AUTH_KEY',  'Pcb8e,SO8><Y`ZEBhu#M?QZ|m^g ;7rd{UnR2>kSG5Y$p,`VSh]QUO9Y gZX5U,1');
define('LOGGED_IN_KEY',    '9Tz}[9<?Wgx:+78!k2uTX4$CH?1jZw5nrXlH7EI3#zAqf5WH3hvZd72;m]:#(IfZ');
define('NONCE_KEY',        'yiOp|s,C!y`bo><5px[4_+zIvIr|jx*@01Q@5?bZavJ],X ?X53x;d,/W!t<EtI=');
define('AUTH_SALT',        '(BQOY!v-r/58$Tu^!Uer1/)9e.:-cEG`akEJf`B}lq}9l6z=e`<UOI A]Oa:0Gez');
define('SECURE_AUTH_SALT', 'N7UGEHMO0ZhYI6m0C;ia:E94rcp;x@?B @)S$MoEZ.g8~xZIBr0m1qVR-L9pLA$S');
define('LOGGED_IN_SALT',   '8<gWo|v)!<Hy!)y^1n1.9P_hLhhU8ExFS[_*.q&)13+#a9P3s^DN1mRe#-7Az^I8');
define('NONCE_SALT',       'v^ALRk3P@%CW4$/|Rk3*|Ar,|30D}g2;8`b~ KzQoiZoKv)k72Hnk]tAsELK9Njv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ebxds_';

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
