<?php namespace LaraPress\Filters;

use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'filters',
            function ($app)
            {
                return new Dispatcher($app);
            }
        );
    }
}
