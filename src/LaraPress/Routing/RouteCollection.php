<?php namespace LaraPress\Routing;

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
        try {
            return parent::match($request);
        } catch (NotFoundHttpException $e) {
            $route = $this->findMatchingWordpressPost();

            if ( ! is_null($route)) {
                return $route->bind($request);
            }

            throw $e;
        }
    }

    /**
     * @return \Illuminate\Routing\Route|null
     */
    protected function findMatchingWordpressPost()
    {
        if ( ! is_404()) {
            return $this->getByName('__catch_' . str_replace('\\', '.', get_class(app('post'))));
        }

        return null;
    }

    /**
     * Determine if any routes match on another HTTP verb.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function checkForAlternateVerbs($request)
    {
        $methods = array_diff(Router::$verbs, array($request->getMethod()));

        // Here we will spin through all verbs except for the current request verb and
        // check to see if any routes respond to them. If they do, we will return a
        // proper error response with the correct headers on the response string.
        $others = array();

        foreach ($methods as $method) {
            if ( ! is_null($this->check($this->get($method), $request, false))) {
                $others[] = $method;
            }
        }

        return $others;
    }
}
