<?php

namespace LaraPress\Shortcodes;

interface SimpleShortcode
{
    public function shortcode();

    public function render($attributes, $content);
}