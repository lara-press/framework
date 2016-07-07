<?php

function option($key = null)
{
    static $options;

    if ( ! isset($options)) {
        $options = get_fields('option');
    }

    return $key == null ? $options : (isset($options[$key]) ? $options[$key] : null);
}