<?php

namespace LaraPress\Foundation\Providers;

use Illuminate\Support\ServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(dirname(__DIR__, 3) . '/resources/views', 'larapress');
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        foreach (config('supports', []) as $feature => $value) {
            $this->app['actions']->listen('init', function () use ($feature, $value) {
                if ($value === 'automatic-feed-links') {
                    $feature = $value;
                    add_theme_support($feature);
                } else {
                    add_theme_support($feature, $value);
                }
            });
        }
    }
}
