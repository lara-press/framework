<?php

namespace LaraPress\Shortcodes;

abstract class DynamicShortcode
{
    abstract public function shortcodes();

    abstract public function render($shortcode, $attributes, $content);

    protected function getIdFromShortcode($shortcode)
    {
        return str_replace(static::key(), '', $shortcode);
    }
}