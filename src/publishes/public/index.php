<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', false);

/** Loads the WordPress Environment and Template */
require(dirname(__FILE__) . '/cms/wp-blog-header.php');

do_action('template_redirect');

$response = $kernel->handle(
    $request = $_GLOBAL['__request']
);

$response->send();

$kernel->terminate($request, $response);