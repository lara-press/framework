<?php

namespace LaraPress\Posts;

use Illuminate\Support\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
            'taxonomy',
            function ($app)
            {
                return new TaxonomyManager($app['actions']);
            }
        );
    }

    public function provides()
    {
        return ['taxonomy'];
    }
}