<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once app_path('helpers.php');

        $this->app->actions->listen('init', function () {
            acf_add_options_page();
        });

        $this->app->actions->listen('plugins_loaded', function () {
        });

        $this->app->filters->listen('acf/fields/google_map/api', function ($api) {
            $api['key'] = env('GOOGLE_MAPS_API_KEY');
            return $api;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
