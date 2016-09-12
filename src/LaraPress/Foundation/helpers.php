<?php

use LaraPress\Options\OptionManager;

if ( ! function_exists('larapress_get_the_query')) {
    /**
     * Return the WP Query variable.
     *
     * @return object The global WP_Query instance.
     */
    function larapress_get_the_query()
    {
        global $wp_query;

        return $wp_query;
    }
}

if ( ! function_exists('larapress_use_permalink')) {
    /**
     * Conditional function that checks if WP
     * is using a pretty permalink structure.
     *
     * @return bool True. False if not using permalink.
     */
    function larapress_use_permalink()
    {
        global $wp_rewrite;

        return ! empty($wp_rewrite->permalink_structure);
    }
}

if ( ! function_exists('larapress_assets')) {
    function larapress_assets($path = '')
    {
        return get_template_directory_uri() . '/assets' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('post')) {
    /**
     * @return \LaraPress\Posts\Post
     */
    function post()
    {
        return app('post');
    }
}

if ( ! function_exists('actions')) {
    /**
     * @return \LaraPress\Actions\Dispatcher
     */
    function actions()
    {
        return app('actions');
    }
}

if ( ! function_exists('filters')) {
    /**
     * @return \LaraPress\Filters\Dispatcher
     */
    function filters()
    {
        return app('filters');
    }
}

if ( ! function_exists('options')) {
    /**
     * @param null $key
     * @param null $default
     *
     * @return OptionManager|mixed
     */
    function options($key = null, $default = null)
    {
        return empty($key) ? app('options') : app('options')->get($key, $default);
    }
}