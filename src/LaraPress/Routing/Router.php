<?php

namespace LaraPress\Routing;

use App\Http\Kernel;
use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Router as RouterBase;
use LaraPress\Actions\Dispatcher as ActionsDispatcher;

class Router extends RouterBase
{

    /**
     * @var Dispatcher
     */
    private $actions;

    /**
     * Create a new Router instance.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     * @param ActionsDispatcher $actions
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Dispatcher $events, ActionsDispatcher $actions, Container $container = null)
    {
        parent::__construct($events, $container);

        $this->actions = $actions;
        $this->routes = new RouteCollection;
    }

    /**
     * Register a new GET route with the router.
     *
     * @param  string $slug
     * @param  \Closure|array|string $action
     *
     * @return \Illuminate\Routing\Route
     */
    public function page($slug, $action)
    {
        $route = $this->addRoute('GET', $slug, $action);
        $route->setWordPressConditional('is_page');

        return $route;
    }

    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string $methods
     * @param  string $uri
     * @param  \Closure|array|string $action
     *
     * @return Route
     */
    protected function addRoute($methods, $uri, $action)
    {
        return parent::addRoute($methods, $uri, $action);
    }

    public function handle($postType, $action)
    {
        $postType = '__catch_' . str_replace('\\', '.', $postType);

        $route = $this->createRoute('GET', $postType, $action);
        $route->setAction($route->getAction() + ['as' => $postType]);

        $this->routes->add($route);

        return $route;
    }

    public function adminGet($uri, $action)
    {
        return $this->registerAdminRoute(['GET', 'HEAD'], $uri, $action);
    }

    public function adminPost($uri, $action)
    {
        return $this->registerAdminRoute('POST', $uri, $action);
    }

    public function adminPatch($uri, $action)
    {
        return $this->registerAdminRoute(['PUT', 'PATCH'], $uri, $action);
    }

    /**
     * @param $uri
     * @param $route
     */
    protected function addAdminMenuPage($uri, Route $route, $displayInSidebar = true)
    {
        static $registeredPages;

        $uri = explode('/', $uri);

        $response = function () {

            $app = app();

            $this->currentRequest = $request = app('request');

            if (isset($app['wp_admin_response'])) {
                $app['wp_admin_response']->send();
                app(Kernel::class)->terminate($request, $app['wp_admin_response']);
                return;
            }

            $response = $this->callFilter('before', $request);

            if (is_null($response)) {

                $this->current = $route = array_first($this->getRoutes(), function ($i, Route $route) use ($request) {
                    return $route->matches($request, true);
                });

                $this->container->instance('Illuminate\Routing\Route', $route);

                $route->bind($request);

                $this->substituteBindings($route);

                $request->setRouteResolver(function () use ($route) {
                    return $route;
                });

                $this->events->fire('router.matched', [$route, $request]);

                // Once we have successfully matched the incoming request to a given route we
                // can call the before filters on that route. This works similar to global
                // filters in that if a response is returned we will not call the route.
                $response = $this->callRouteBefore($route, $request);

                if (is_null($response)) {
                    $response = $this->runRouteWithinStack($route, $request);
                }
            }

            // Once this route has run and the response has been prepared, we will run the
            // after filter to do any last work on the response or for this application
            // before we will return the response back to the consuming code for use.
            $response = $this->prepareResponse($request, $response);

            $this->callFilter('after', $request, $response);

            if ($response instanceof RedirectResponse) {
                $response->setTargetUrl(str_replace('cms/wp-admin/admin.php/cms', 'cms', $response->getTargetUrl()));
            }

            $response->send();
            app(Kernel::class)->terminate($request, $response);
        };

        $slug = implode('-', $uri);
        array_pop($uri);
        $title = ucwords(str_replace(['-', '_'], ' ', $slug));
        $routeAction = $route->getAction();

        $capability = isset($routeAction['capability']) ? $routeAction['capability'] : 'manage_options';
        $pageTitle = isset($routeAction['pageTitle']) ? $routeAction['pageTitle'] : $title;
        $menuTitle = isset($routeAction['menuTitle']) ? $routeAction['menuTitle'] : $title;
        $icon = isset($routeAction['icon']) ? $routeAction['icon'] : '';
        $position = isset($routeAction['position']) ? $routeAction['position'] : null;

        $slug = str_replace('{id}-', '', $slug);

        if (isset($registeredPages[$slug . '-' . implode('.', $uri)])) {
            return;
        }

        $registeredPages[$slug . '-' . implode('.', $uri)] = true;

        remove_menu_page($slug);

        if (count($uri) == 0) {
            add_menu_page($pageTitle, $menuTitle, $capability, $slug, $response, $icon, $position);
        } else {
            add_submenu_page(array_pop($uri), $pageTitle, $menuTitle, $capability, $slug, $response);
        }
    }

    /**
     * Create a new Route object.
     *
     * @param  array|string $methods
     * @param  string $uri
     * @param  mixed $action
     *
     * @return Route
     */
    protected function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))->setContainer($this->container);
    }

    /**
     * @param $uri
     * @return string
     */
    protected function parseAdminUri($uri)
    {
        $url = '?page=' . str_replace('-{id}', '', str_replace('/', '-', $uri));

        foreach (explode('/', $uri) as $uriPart) {
            if ($uriPart[0] == '{') {
                $url .= '&' . substr($uriPart, 1, -1) . '=' . $uriPart;
            }
        }

        return $url;
    }

    /**
     * @param $methods
     * @param $uri
     * @param $action
     * @return Route
     */
    protected function registerAdminRoute($methods, $uri, $action, $displayInSidebar = true)
    {
        $url = $this->parseAdminUri($uri);

        $route = $this->addRoute($methods, '/admin.php' . $url, $action);

        $uri = str_replace('-{id}', '', $uri);

        $this->actions->listen('admin_menu', function () use ($uri, $route, $displayInSidebar) {
            $this->addAdminMenuPage($uri, $route, $displayInSidebar);
        });

        return $route;
    }
}
