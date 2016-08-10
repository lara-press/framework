<?php

function option($key = null)
{
    static $options;

    if ( ! isset($options)) {
        $options = get_fields('option');
    }

    return $key == null ? $options : (isset($options[$key]) ? $options[$key] : null);
}


if ( ! function_exists('webpack')) {
    /**
     * Get the path to a versioned Webpack file.
     *
     * @param  string $extension
     * @param  string $bundle
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    function webpack($extension, $bundle = 'vendor')
    {
        static $manifest = null;

        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('dist/manifest.json')), true);
        }

        if (isset($manifest[$bundle][$extension])) {
            return $manifest[$bundle][$extension];
        }

        throw new InvalidArgumentException("File {$bundle}.{$extension} not defined in asset manifest.");
    }
}
