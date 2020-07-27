<?php

namespace LaraPress\Foundation\Http;

use Exception;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Facade;
use LaraPress\Routing\Matching\UriValidator;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Kernel extends HttpKernel
{

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        'Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables',
        'Illuminate\Foundation\Bootstrap\LoadConfiguration',
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendRequestThroughRouter($request)
    {
        $this->app->instance('request', $request);

        Facade::clearResolvedInstance('request');

        $this->bootstrap();

        return (new Pipeline($this->app))
            ->send($request)
            ->through($this->app->shouldSkipMiddleware() ? [] : $this->middleware)
            ->then($this->dispatchToRouter());
    }

    public function handle($request)
    {
        try {
            $request->enableHttpMethodParameterOverride();

            $response = $this->sendRequestThroughRouter($request);
        } catch (Exception $e) {

            if (is_admin() && $e instanceof NotFoundHttpException) {
                $e = new \Exception(sprintf(
                    'The LaraPress router could not find this route. Admin routes are matched with the %s class.',
                    UriValidator::class
                ));
                $response = $this->renderException($request, $e);
            } else {
                $this->reportException($e);
                $response = $this->renderException($request, $e);
            }

        } catch (Throwable $e) {
            $e = new FatalThrowableError($e);

            $this->reportException($e);

            $response = $this->renderException($request, $e);
        }

        $this->app['events']->dispatch('kernel.handled', [$request, $response]);

        return $response;
    }
}
