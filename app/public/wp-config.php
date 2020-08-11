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

define( 'DB_NAME', 'local' );


/** MySQL database username */

define( 'DB_USER', 'root' );


/** MySQL database password */

define( 'DB_PASSWORD', 'root' );


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

define( 'AUTH_KEY',         '{o^$2@(H2X/:7jvFSi%S+jRO/?s>RTJXvA-h|$OKYyr~v{l+Cad*SGtb{YYb(E9}' );

define( 'SECURE_AUTH_KEY',  'q+?Zg^hoi ;$.r8@M4%v@?LN*47d<L404M0xScvG u$oGlj0NuWu$t~&./Wr{4Zb' );

define( 'LOGGED_IN_KEY',    '#HU$eB_k-_HGH#.k<r!JH[wy{jd4)l<Y4d)2Y.B/%LfYI-tb`<O3u[awJZi~<dpo' );

define( 'NONCE_KEY',        'V6vdW$dTEX&!MHJx1brYA6%WjdM74-+N`Kq:^PVAg_/34`&D=CRQ?-Mm!rHmR%uC' );

define( 'AUTH_SALT',        ')PRD,mMGK@9,8_KMEMU-lg49XEvdlTM%tOX}@fh0$@h{Via6b;Z,Yami-djy1bw+' );

define( 'SECURE_AUTH_SALT', 'm]jesK3tw_hCTwFx9QA3J`1t1]R9FOTIh:$ejH6D-f)N]=EpCU<?m^d=*gurp?>U' );

define( 'LOGGED_IN_SALT',   '1(Y{QjXF46d+G(K)a$FZ{Sl/}sDAomhu]A^Ge%VriPty>`e+t<7ujB]n`)&BIulh' );

define( 'NONCE_SALT',       'K.Hhi705<D>d_sVymINTrQ=oqn]nLQD?780zm`TTGnx3o?)dj,^nvN;*+<Ch3_&j' );


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

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress

 */

define( 'WP_DEBUG', false );


/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

}


/** Sets up WordPress vars and included files. */

require_once( ABSPATH . 'wp-settings.php' );

