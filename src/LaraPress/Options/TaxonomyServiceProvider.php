<?php

namespace LaraPress\Options;

use Illuminate\Support\ServiceProvider;

class OptionServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'options',
            function ($app) {
                return new OptionManager;
            }
        );
    }

    public function provides()
    {
        return ['options'];
    }
}