<?php

namespace LaraPress\Routing;

use Illuminate\Routing\RoutingServiceProvider as BaseRoutingServiceProvider;

class RoutingServiceProvider extends BaseRoutingServiceProvider
{
    /**
     * Register the router instance.
     *
     * @return void
     */
    protected function registerRouter()
    {
        $this->app->singleton('router', function ($app) {
            return new Router($app['events'], $app['actions'], $app);
        });

        $this->app['actions']->listen('init', function () {
            if (is_admin()) {
                app('url')->forceRootUrl($_SERVER['APP_URL']);
            }
        });

        $this->disableRedirectionOnRegisteredRoutes();
    }

    private function disableRedirectionOnRegisteredRoutes()
    {
        $this->app['filters']->listen('redirect_canonical', function ($redirectUrl, $requestedUrl) {

            /** @var RouteCollection $routeCollection */
            $routeCollection = $this->app['router']->getRoutes();

            /** @var Route $route */
            foreach ($routeCollection->getRoutes() as $route) {
                if ($requestedUrl === url($route->uri())) {
                    return false;
                }
            }
        }, 10, 2);
    }
}
