<?php

namespace LaraPress\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;

class UriValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Illuminate\Routing\Route $route
     * @param  \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        $regex = $route->getCompiled()->getRegex();

        if (str_contains($request->getRequestUri(), '/wp-admin')) {
            return preg_match($regex, rawurldecode($request->getRequestUri()));
        }

        $path = $request->path() == '/' ? '/' : '/' . $request->path();

        return preg_match($regex, rawurldecode($path));
    }
}
