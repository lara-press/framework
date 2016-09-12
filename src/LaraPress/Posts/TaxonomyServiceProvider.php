<?php

namespace LaraPress\Posts;

use Illuminate\Support\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
{
    protected $taxonomies = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('taxonomy', function ($app) {
            return new TaxonomyManager($app['actions']);
        });

        foreach ($this->taxonomies as $taxonomy) {
            $this->app['taxonomy']->register($taxonomy);
        }
    }

    public function provides()
    {
        return ['taxonomy'];
    }
}
