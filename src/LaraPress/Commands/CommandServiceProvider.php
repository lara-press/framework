<?php

namespace LaraPress\Commands;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    /** @var Application $app */
    protected $app;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FlushRewriteRules::class,
            ]);
        }
    }
}
