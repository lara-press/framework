<?php

define('ABSPATH', __DIR__ . '/cms/');

define('LARAPRESS_TEXTDOMAIN', 'larapress');

require __DIR__ . '/../bootstrap/autoload.php';

try {
    Dotenv::load(dirname(__DIR__));
} catch (\InvalidArgumentException $e) {
    // we probably don't have an .env file yet
}

/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_NAME', env('DB_DATABASE'));
define('DB_USER', env('DB_USERNAME'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_TABLE_PREFIX', $table_prefix = env('DB_TABLE_PREFIX', 'wp_'));

// WordPress URLs
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', WP_HOME . '/cms');

// Development
define('SAVEQUERIES', env('SAVE_QUERIES', false));
define('WP_DEBUG', env('APP_DEBUG', false));
define('SCRIPT_DEBUG', env('SCRIPT_DEBUG', false));

/*
|--------------------------------------------------------------------------
| Content Directory
|--------------------------------------------------------------------------
*/
define('WP_CONTENT_DIR', __DIR__ . '/content');
define('WP_CONTENT_URL', WP_HOME . '/content');

/*
|--------------------------------------------------------------------------
| Authentication unique keys and salts
|--------------------------------------------------------------------------
*/
/**
 * @link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service
 */
define('AUTH_KEY', 'put your unique phrase here');
define('SECURE_AUTH_KEY', 'put your unique phrase here');
define('LOGGED_IN_KEY', 'put your unique phrase here');
define('NONCE_KEY', 'put your unique phrase here');
define('AUTH_SALT', 'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT', 'put your unique phrase here');
define('NONCE_SALT', 'put your unique phrase here');

/*
|--------------------------------------------------------------------------
| Custom settings
|--------------------------------------------------------------------------
*/
define('WP_AUTO_UPDATE_CORE', false);
define('DISALLOW_FILE_EDIT', true);

define('WP_DEFAULT_THEME', 'larapress');

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let's turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight these users.
|
*/

require_once(ABSPATH . 'wp-settings.php');
