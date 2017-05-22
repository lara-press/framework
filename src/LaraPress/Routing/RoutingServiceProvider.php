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
        $this->app['router'] = $this->app->share(function ($app) {
            return new Router($app['events'], $app['actions'], $app);
        });

        $this->app['actions']->listen('init', function () {
            if (is_admin()) {
                app('url')->forceRootUrl($_SERVER['WP_HOME']);
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
                if ($requestedUrl === url($route->getUri())) {
                    return false;
                }
            }
        }, 10, 2);
    }
}
