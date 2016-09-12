<?php

namespace LaraPress\Foundation\Bootstrap;

use Illuminate\Contracts\Foundation\Application;

class AddThemeSupports {

    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        foreach ($app['config']->get('supports', []) as $feature => $value)
        {
            if ($value === 'automatic-feed-links')
            {
                add_theme_support($value);
            }
            else
            {
                add_theme_support($feature, $value);
            }
        }
    }
}
