<?php

namespace Odigos\Illuminate\Routing\Matching;

use Odigos\Illuminate\Http\Request;
use Odigos\Illuminate\Routing\Route;
class MethodValidator implements ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        return in_array($request->getMethod(), $route->methods());
    }
}
