<?php

namespace LaraPress\Shortcodes;

interface DynamicShortcode
{
    /**
     * @return Shortcode[]
     */
    public function shortcodes();

    public function render(Shortcode $shortcode);
}