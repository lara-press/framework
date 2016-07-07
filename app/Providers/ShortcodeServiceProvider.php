<?php

namespace App\Providers;

use LaraPress\Shortcodes\ShortcodeServiceProvider as BaseShortcodeServiceProvider;

class ShortcodeServiceProvider extends BaseShortcodeServiceProvider
{
    protected $shortcodes = [
        'hello-world'
    ];

    public function helloWorldShortcode()
    {
        return 'Hello world!';
    }
}