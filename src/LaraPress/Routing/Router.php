<?php

namespace LaraPress\Routing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
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
     * @param ActionsDispatcher                       $actions
     * @param \Illuminate\Container\Container         $container
     */
    public function __construct(Dispatcher $events, ActionsDispatcher $actions, Container $container = null)
    {
        parent::__construct($events, $container);

        $this->actions = $actions;
        $this->routes  = new RouteCollection;
    }

    /**
     * Register a new GET route with the router.
     *
     * @param  string                $slug
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
     * @param  array|string          $methods
     * @param  string                $uri
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

    public function admin($uri, $action)
    {
        $url = 'admin.php?page=' . str_replace('-{id}', '', str_replace('/', '-', $uri));

        foreach(explode('/', $uri) as $uriPart) {
            if ($uriPart[0] == '{') {
                $url .= '&' . substr($uriPart, 1, -1) . '=' . $uriPart;
            }
        }

        $route = $this->addRoute('admin', $url, $action);

        $uri = str_replace('-{id}', '', $uri);

        $this->actions->listen(
            'admin_menu',
            function () use ($uri, $route) {
                $this->addAdminMenuPage($uri, $route);
            }
        );

        return $route;
    }

    /**
     * @param $uri
     * @param $route
     */
    protected function addAdminMenuPage($uri, Route $route)
    {
        $uri = explode('/', $uri);

        $request = Request::capture();
        $route->bind($request);

        $response = function () use ($route, $request) {
            $response = $this->runRouteWithinStack($route, $request);
            $response->send();
        };

        $slug        = implode('-', $uri);
        array_pop($uri);
        $title       = ucwords(str_replace(['-', '_'], ' ', $slug));
        $routeAction = $route->getAction();

        $capability = isset($routeAction['capability']) ? $routeAction['capability'] : 'manage_options';
        $pageTitle  = isset($routeAction['pageTitle']) ? $routeAction['pageTitle'] : $title;
        $menuTitle  = isset($routeAction['menuTitle']) ? $routeAction['menuTitle'] : $title;
        $icon  = isset($routeAction['icon']) ? $routeAction['icon'] : '';
        $position  = isset($routeAction['position']) ? $routeAction['position'] : null;

        remove_menu_page($slug);


        $slug = str_replace('{id}-', '', $slug);

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
     * @param  string       $uri
     * @param  mixed        $action
     *
     * @return Route
     */
    protected function newRoute($methods, $uri, $action)
    {
        return (new Route($methods, $uri, $action))->setContainer($this->container);
    }
}
