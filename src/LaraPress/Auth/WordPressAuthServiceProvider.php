<?php

namespace LaraPress\Auth;

use Illuminate\Support\ServiceProvider;

class WordPressAuthServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->extend('wordpress', function ($app) {
            return new Guard(
                new WordPressUserProvider($app['wordpress-hash'], $app['config']['auth.model']),
                $app['session.store']
            );
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wordpress'];
    }
}
