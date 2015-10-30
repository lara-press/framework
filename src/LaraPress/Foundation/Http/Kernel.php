<?php

namespace LaraPress\Foundation\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Facade;

class Kernel extends HttpKernel {

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Illuminate\Foundation\Bootstrap\DetectEnvironment',
        'Illuminate\Foundation\Bootstrap\LoadConfiguration',
        'Illuminate\Foundation\Bootstrap\ConfigureLogging',
        'Illuminate\Foundation\Bootstrap\HandleExceptions',
        'Illuminate\Foundation\Bootstrap\RegisterFacades',
        'Illuminate\Foundation\Bootstrap\RegisterProviders',
        'Illuminate\Foundation\Bootstrap\BootProviders',
        'LaraPress\Foundation\Bootstrap\BootstrapWordPress'
    ];

    /**
     * Send the given request through the middleware / router.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function init($request)
    {
        $this->app->instance('request', $request);

        Facade::clearResolvedInstance('request');

        $this->bootstrap();
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendRequestThroughRouter($request)
    {
        return (new Pipeline($this->app))
            ->send($this->app['request'])
            ->through($this->middleware)
            ->then($this->dispatchToRouter());
    }
}
