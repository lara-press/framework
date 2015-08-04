<?php namespace LaraPress\MetaBox;

use Illuminate\Support\ServiceProvider;

class MetaBoxServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('metabox', $metaBoxManager = new Manager($this->app, $this->app['actions']));
    }

    public function provides()
    {
        return ['metabox'];
    }
}
