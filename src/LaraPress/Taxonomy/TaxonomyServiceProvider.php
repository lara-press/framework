<?php namespace LaraPress\Taxonomy;

use Illuminate\Support\ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
            'taxonomy',
            function ($app)
            {
                return new Manager($app['actions']);
            }
        );
    }

    public function provides()
    {
        return ['taxonomy'];
    }
}
