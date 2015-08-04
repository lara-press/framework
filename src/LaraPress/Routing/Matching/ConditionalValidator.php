<?php namespace LaraPress\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;

class ConditionalValidator implements ValidatorInterface {

    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Illuminate\Routing\Route $route
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        /** @var \LaraPress\Routing\Route $route */
        return $route->wordpressConditional() == null || call_user_func($route->wordpressConditional(), $route->uri());
    }
}
