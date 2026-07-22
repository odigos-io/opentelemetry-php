<?php

namespace Odigos\Illuminate\Routing\Matching;

use Odigos\Illuminate\Http\Request;
use Odigos\Illuminate\Routing\Route;
class SchemeValidator implements ValidatorInterface
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
        if ($route->httpOnly()) {
            return !$request->secure();
        } elseif ($route->secure()) {
            return $request->secure();
        }
        return \true;
    }
}
