<?php

namespace LaraPress\Actions;

use Illuminate\Contracts\Queue\Queue;
use Illuminate\Support\ServiceProvider;
use LaraPress\Foundation\Application;

class ActionServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('actions', function (Application $app) {
            return (new Dispatcher($app))->setQueueResolver(
                function () use ($app) {
                    return $app->make(Queue::class);
                }
            );
        });
    }
}
