<?php

namespace LaraPress\Routing;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteCollection extends \Illuminate\Routing\RouteCollection
{

    /**
     * Find the first route matching a given request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Routing\Route
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function match(Request $request)
    {
        $hasWpParams = $request->path() == '/' && ($request->has('p') || $request->has('post_id'));

        if ($hasWpParams && $route = $this->findMatchingWordPressPost($request)) {
            return $route;
        }

        try {
            return parent::match($request);
        } catch (NotFoundHttpException $e) {

            if ($route = $this->findMatchingWordPressPost($request)) {
                return $route;
            }

            throw $e;
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Routing\Route|null
     */
    protected function findMatchingWordPressPost(Request $request)
    {
        if (!is_admin() && !is_404()) {

            $route = null;

            if (app()->isShared('post')) {
                $route = $this->getByName('__catch_' . str_replace('\\', '.', get_class(app('post'))));
            } elseif (app()->isShared('wp_query') && app('wp_query')->is_posts_page) {
                $route = $this->getByName('__catch_' . str_replace('\\', '.', app('posts.types')->get('post')));
            }

            if (!is_null($route)) {
                return $route->bind($request);
            }

        }

        return null;
    }
}
