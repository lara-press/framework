<?php

if ( ! function_exists('larapress_get_the_query'))
{
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

if ( ! function_exists('larapress_use_permalink'))
{
    /**
     * Conditional function that checks if WP
     * is using a pretty permalink structure.
     *
     * @return bool True. False if not using permalink.
     */
    function larapress_use_permalink()
    {
        global $wp_rewrite;

        if ( ! $wp_rewrite->permalink_structure == '')
        {
            return true;
        }

        return false;
    }
}

if ( ! function_exists('larapress_add_filters'))
{
    /**
     * Helper that runs multiple add_filter
     * functions at once.
     *
     * @param array  $tags     Filter tags.
     * @param string $function The name of the global function to call.
     *
     * @return void
     */
    function larapress_add_filters(array $tags, $function)
    {
        foreach ($tags as $tag)
        {
            add_filter($tag, $function);
        }
    }
}

if ( ! function_exists('larapress_assets'))
{
    function larapress_assets($path = '')
    {
        return get_template_directory_uri() . '/assets' . ($path ? '/' . $path : $path);
    }
}
