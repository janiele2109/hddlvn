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
define('DB_NAME', 'hddlvn');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'hbitnuwo3lsjaoylt1td65dutzjdhrzngi9udiqvyemjux3sgmwqqnasevy99mcg');
define('SECURE_AUTH_KEY',  'lpe4vtxes85jzq5egms1s3soaknpolewz5hozgx5monhqylbld0zrk3tllqez1rs');
define('LOGGED_IN_KEY',    'sea0gx0dan24nzbast0g2gbfqqy9nal0njsvhsl1a5ybgz0qrlvoqech4act7lgx');
define('NONCE_KEY',        'ilzsfmpf0rylwxs4oehqvqjkzfrqqmyfplbgngleceyocljk0emluolgrsd7t5aj');
define('AUTH_SALT',        'ndcszpzxucikwhcxojy20nehq17n0cyy6zq9rzabhmwjvyhdnip3cii38gsh90mq');
define('SECURE_AUTH_SALT', 'igjldg8u4umu6hlkx02pq8pjn1kb5nz2fyejrgv9bx8ttlxkkqflfgxdzrji0e0j');
define('LOGGED_IN_SALT',   'xqzophis9c4qiegdbtofyqm09onoosomp6pp09crmwllgi2t04klc2ijimzzusdh');
define('NONCE_SALT',       'yijgxj7nu9eoe7pycoj7axh86doqfnjcx3nzghrxxxvp2m9xnofss55xeimanhmu');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpwn_';

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
